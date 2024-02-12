var calendar; // Déclaration dans la portée globale
var clickedDate = null; // Défini dans la portée globale

document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("calendar");
  calendar = new FullCalendar.Calendar(calendarEl, {
    locale: "fr",
    firstDay: 1,
    initialView: "multiMonthYear",
    multiMonthMaxColumns: 1, // force a single column
    editable: false,
    eventResizableFromStart: false, // Permet le redimensionnement à partir du début
    timeZone: "Pacific/Tahiti", // Spécifiez le fuseau horaire de Tahiti
    eventSources: [
        function(fetchInfo, successCallback, failureCallback) {
          // Utiliser ajaxCall pour charger les événements
          ajaxCall("booking", "GET", {}, 
            function(response) { // Callback de succès
              // Supposer que 'response' est un tableau d'événements
              successCallback(response);
            }, 
            function(xhr, status, error) { // Callback d'erreur
              console.error("Erreur lors du chargement des événements:", error);
              failureCallback(error); // Signaler l'échec à FullCalendar
            }
          );
        }
      ],
    viewDidMount: function (view, element) {
      var cellWidth = $(".fc-daygrid-day").width();
      $(".fc-daygrid-day").css("height", cellWidth + "px");
      let buttonAddEvent = document.querySelector(".fc-AddEventButton-button");
      let buttonSearchInput = document.querySelector(".fc-SearchIpunt-button");
      buttonAddEvent.innerHTML =
        '<svg viewBox="0 0 16 16" class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3H4.5a.5.5 0 0 1 0-1H7V4.5a.5.5 0 0 1 .5-.5z"/></svg>';
      buttonSearchInput.innerHTML =
        '<svg viewBox="0 0 24 24" class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>';
    },
    windowResize: function (view, element) {
      var cellWidth = $(".fc-daygrid-day").width();
      $(".fc-daygrid-day").css("height", cellWidth + "px");
    },
    datesSet: function(dateInfo) {
      // Trouvez tous les éléments fc-multimonth-title après le rendu/mise à jour du calendrier
      document.querySelectorAll('.fc-multimonth-title').forEach(function(title) {
          // Vérifiez si le div personnalisé n'a pas déjà été ajouté
          if (!title.querySelector('.calendarLegend')) {
              // Créez le div personnalisé
              var customDiv = document.createElement('div');
              title.classList.add('flex','justify-between','text-md','capitalize');
              customDiv.classList.add('inline-flex','items-center');
              customDiv.innerHTML = `
              <div class="flex space-x-2 mr-2 items-center text-sm font-light text-slate-600 dark:text-slate-200">
              <div class="flex items-center">Vide: <span class="w-4 h-4 inline-block bg-white border border-slate-200"></span></div>
              <div class="flex items-center">Disponibilité: <span class="w-4 h-4 inline-block bg-green-500 border border-slate-200"></span></div>
              <div class="flex items-center">Complet: <span class="w-4 h-4 inline-block bg-red-500 border border-slate-200"></span></div>
              </div>
              `;

              title.appendChild(customDiv);
          }
      });
  },
    headerToolbar: {
      left: "prev,next", // Ajoutez ici les boutons personnalisés
      center: "title",
      right: "AddEventButton,SearchIpunt",
    },
    
    customButtons: {
      AddEventButton: {
        text: " ",
        click: function () {
          resetForm("addEventModal");
          updateTotalInfo();
          updatePrice();
          openModal("addEventModal");
        },
      },
      SearchIpunt: {
        text: " ",
        click: function () {
          openModal("SearchListEventModal");

          // Trouver le champ inputSearch et le FOCUS keyboard
          const inputField = document.getElementById("default-search");
          inputField.focus();

          $("#default-search").on("input", function () {
            const searchInput = $(this).val();
            const resultList = $("#searchResults");
            if (!searchInput) {
              resultList.empty();
              resultList.addClass("close-animate"); 
              resultList.removeClass("animate"); 
              resultList.removeClass("bg-white dark:bg-slate-950 shadow-lg"); 
              return; // Arrêter l'exécution de la fonction ici
            }

            ajaxCall("booking/search", "GET", { text: searchInput }, function(response) {
                 if (response.status === "success" && response.data.length > 0) {
                     // Traiter la réponse en cas de succès
                     
                     // Ouvrir la popup si elle n'est pas déjà ouverte
                     resultList.addClass("bg-white dark:bg-slate-950 shadow-lg"); 
                     resultList.removeClass("close-animate"); 
                     resultList.addClass("animate"); 
                     // Mettre à jour le contenu de la popup avec les résultats de la recherche
                     resultList.empty(); // Vider les anciens résultats
        
                    response.data.forEach((booking, index) => {
                      const bgColorClass = index % 2 === 0 ? 'bg-slate-100 hover:bg-yellow-100 dark:bg-slate-900 dark:hover:bg-yellow-400' : 'bg-white hover:bg-yellow-100 dark:bg-slate-950 dark:hover:bg-yellow-400';
                      const bookingElement = generateSearchRows(booking, bgColorClass);

                      resultList.append(bookingElement);
                       // Appliquez l'animation de défilement après l'insertion
                      applyScrollAnimation();
                     });
                   } else {
                     // Gérer l'échec de la requête ici
                     console.log("Échec de la Requête de recherche !");
                     resultList.empty(); // Vider les anciens résultats
                     resultList.addClass("p-4 bg-white dark:bg-slate-700 shadow-lg"); // Retirer le fond noir transparent
                     resultList.removeClass("close-animate"); // Retirer le fond noir transparent
                     resultList.addClass("animate"); // Retirer le fond noir transparent
                     resultList.html("Aucun résultat trouvé avec: <b>" + searchInput + "</b>"); // Ajouter le message
                 }
             });//END AJAX
          });//END $("#default-search").on("input",...
        },//END click: function () 
      },//END SearchIpunt
    },
    buttonText: {
      today: "Aujourd'hui",
      month: "Mois",
      week: "Semaine",
      day: "Jour",
      list: "Liste",
    },
    eventContent: function (args) {
      let bookings = args.event.extendedProps.bookings; 
      let firstdayHtml = "";
      let firstdayHtmlNumber = "";
      let currentdayHtml = "";
      let lastdayHtml = "";
      let lastdayHtmlNumber = "";
      
      let nEventDay = Object.keys(bookings).length; // Vérifier le nom de service loués
      let fullblockedFound = false; // Vérifie si il existe dans chaque jour une privatisation

      const serviceTitlesObj = services_list
      .filter(service => service.fullblocked !== "1")
      .reduce((obj, service) => {
        obj[service.Service_id] = service.Title;
        return obj;
      }, {});
      
      const availableServicesCount = Object.keys(serviceTitlesObj).length;
      
      let availableServices = {...serviceTitlesObj};

      if(bookings){

        for (let id in bookings) {
                      
          if (bookings[id].fullblockeds === "1") {
          fullblockedFound = true;
          break; // Arrête la boucle si une réservation avec fullblockeds = 1 est trouvée
        } 
      } 
    
    }
    
    let html_construct = '';
    let COUNTisBookingStartDay = 0;
    let COUNTisBookingEndDay = 0;
    let service_booked = 0;
    let roomsAvailable = availableServicesCount; // initialiser avec le nombre total de chambres

    for (let bookingId in bookings) {
        if (bookings.hasOwnProperty(bookingId)) {
          let booking = bookings[bookingId];
          let serviceBooked = bookings[bookingId].services_titles;
          Object.entries(availableServices).forEach(([key, value]) => {
            if (value === serviceBooked) {
              foundKey = value;
              delete availableServices[key];
            }
          });
          let NotBookedServicesCount = Object.keys(availableServices).length;
          let isBookingStartDay = booking.Date == booking.FirstDay.substring(0, 10);
          let isCurrentDay = booking.Date;
          let isBookingEndDay = booking.Date == booking.LastDay.substring(0, 10);
          let message = "";
          let color = "";
          
          // Start End Animation
          // Fonction pour créer le HTML de la marque du jour
          function createDayMarker({ position, count, text, additionalClasses = "" }) {
            const baseHtml = `
                <div class="absolute flex justify-${position} w-full z-20 ">
                    <div class="flex flex-col h-full ${additionalClasses} ${position.includes("end")  ? "rounded-l-lg " : position.includes("start") ?"rounded-r-lg ":""} 
                    shadow-inner ${position.includes("end") ? " shadow-gray-800" : position.includes("start") ? "shadow-gray-800": "shadow-inner shadow-gray-800"}" style="background-color: rgba(0, 0, 0, 0.2);">
                        <div class="relative hidden md:flex items-center justify-center mx-auto">
                            ${text}
                        </div>
                        <div class="flex items-center justify-center my-0.5 font-bold mx-auto">
                            ${count > 0 ? count : "&nbsp;"}
                        </div>
                    </div>
                </div>
            `;
            return baseHtml;
          }
          if (isBookingEndDay) {
            COUNTisBookingEndDay++;
            roomsAvailable++; // Une chambre se libère
            lastdayHtml = createDayMarker({ position: "start z-20", count: COUNTisBookingEndDay, text: "OUT", additionalClasses: "w-2/5" });
          }

          if (isBookingStartDay) {
            COUNTisBookingStartDay++;
            fullblockedFound ? service_booked = availableServicesCount : service_booked++;
            roomsAvailable--; // Une chambre est réservée
            firstdayHtml = createDayMarker({ position: "end z-20", count: COUNTisBookingStartDay, text: "IN" , additionalClasses: "w-2/5" });
          }

          if (isCurrentDay && !isBookingStartDay && !isBookingEndDay) {
            currentdayHtml = createDayMarker({ position: "center z-10", count: 0, text: "&nbsp;", additionalClasses: "w-full" });
          }

          if(isCurrentDay && !isBookingEndDay & !isBookingStartDay & !fullblockedFound){
            service_booked++;
          }  
          if(fullblockedFound && !isBookingEndDay){
            service_booked = availableServicesCount;
          }

          // Déterminer la couleur du BG
          let classNameBg = "";
          let classNameDarkBg = "";
          
          if (service_booked < availableServicesCount) {
            classNameBg = "bg-green-300";
            classNameDarkBg = "dark:bg-green-800";
          } else if (service_booked == availableServicesCount) {
            classNameBg = fullblockedFound ? "bg-red-300" : "bg-purple-300";
            classNameDarkBg = fullblockedFound ? "dark:bg-red-800" : "dark:bg-purple-800";
          } else {
            classNameBg = "bg-gray-300";
            classNameDarkBg = "dark:bg-gray-800";
          }
          
          message = service_booked + "/" + availableServicesCount;
          
          html_construct = `
          <div class="absolute w-full h-full">
            <div class="relative h-full pt-2 pl-1 flex justify-start items-start ${classNameBg} ${classNameDarkBg}">
              ${message}
            </div>
          </div>`;
        
        }
      }

   let dotsHtml =  html_construct + lastdayHtml + lastdayHtmlNumber + currentdayHtml + firstdayHtml + firstdayHtmlNumber;
    // Créer un élément HTML pour représenter l'événement
    let eventElement = document.createElement("div");
    eventElement.className = `group relative flex justify-center items-end h-full text-black dark:text-white overflow-hidden
    ${args.isPast?'opacity-30':''}  `;
    eventElement.innerHTML = dotsHtml;
      return {
        domNodes: [eventElement],
      };
    },
    eventClick: function (info) {

      const clickedDate = info.event.startStr; // Récupère la date sur laquelle l'utilisateur a cliqué
      // Faire une requête AJAX pour obtenir les événements de cette date
      ajaxCall("booking/getBookingsFromDate", "GET", { date: clickedDate }, function(response) {
        const startdate = format_date(clickedDate);
        const enddate = format_date(clickedDate, 1);
        if (response.success && response.data.events.length > 0) {
          // Attribution d'office à la modal d'ajout la date cliqué.

            // Si la réponse contient des événements, exécutez votre code ici
            showBookingList(response.data.events, clickedDate);
          } else {
            resetForm("addEventModal",startdate,enddate);
            updateTotalInfo();
            updatePrice();
            // Afficher le popup
            openModal("addEventModal");
          }
      });

    },
    dateClick: function (info) {
      //const clickedDate = info.date;  // Récupère la date cliquée
      const clickedDate = info.dateStr; // Récupère la date sur laquelle l'utilisateur a cliqué
      // Faire une requête AJAX pour obtenir les événements de cette date
      ajaxCall("booking/getBookingsFromDate", "GET", { date: clickedDate }, function(response) {
        const startdate = format_date(clickedDate);
        const enddate = format_date(clickedDate, 1);
        if (response.success && response.data.events.length > 0) {
          // Attribution d'office à la modal d'ajout la date cliqué.

            // Si la réponse contient des événements, exécutez votre code ici
            showBookingList(response.data.events, clickedDate);
          } else {
            resetForm("addEventModal",startdate,enddate);
            updateTotalInfo();
            updatePrice();
            // Afficher le popup
            openModal("addEventModal");
          }
        
        
      });
    },
  });

  calendar.render();
});

// Mettre à jour l'événement depuis la !!! vue détaillé !!! dans la base de données
function updateEventFromDetails() {
  let formData = {};
  let E_Form = Array.from(document.querySelectorAll('[id]')).filter(element => typeof element.id === 'string' && element.id.startsWith('Modalevent') && !element.id.includes('bgtoggle'));
  E_Form.forEach(element => {
    const key = element.id.replace("Modalevent", ""); // Supprime "Modalevent" du début de l'id pour obtenir la clé
    if (element.type === "checkbox" && !element.id.includes('Type_doc')) {
        formData[key] = element.checked ? 1 : 0; // Pour les cases à cocher
    } else if (key ==="Start" || key === 'End' ){
      formData[key.toLowerCase()] = format_date_toSql(element.value); // Pour les champs de texte et les listes déroulantes
     } else if(key ==="Datepicker"){
       var dates_spliting = element.value.split(" - ");
       // Extraire les dates de début et de fin en tant que chaînes
       formData['start'] = format_date_toSql(dates_spliting[0]);
       formData['end'] = format_date_toSql(dates_spliting[1]);

       
    }else {formData[key] = element.value;}
  });
  //UPDATE FORM BOOKING
  console.log('formadata',formData);
  // Étape 1 : Mise à jour de la réservation
  ajaxCall("booking/updateBooking", "POST", { data : formData }, function(response) {
      if (response.success === true) {
        let updatedData = {};
        updatedData[response.id] = response.data;        
       
        // UPDATE FORM PAID
        let payments = []; // Initialise payments comme un tableau vide
        document.querySelectorAll('.payment-row').forEach((row, index) => {
          if(row.id.startsWith('temp_') === true ) {
            // Pour un nouvel enregistrement (id non défini ou vide)
            payments.push({
              'booking_id': formData['id'],
              'type_paid': document.getElementById(`rowPaidType${row.id}`).value,
              'value': document.getElementById(`rowPaid${row.id}`).value
            });
          }
          else{
            let id = document.getElementById(`rowPaidid${index}`).value;
            if (id){
              // Pour un enregistrement existant (avec un id défini)
              payments.push({
                'id': id, // Stocker l'id dans l'objet
                'booking_id': formData['id'],
                'type_paid': document.getElementById(`rowPaidType${index}`).value,
                'value': document.getElementById(`rowPaid${index}`).value
              }); // Ajouter l'objet au tableau
            }
          }
        });
        let payments_filtered  = payments.filter(item => item !== undefined);
        if (payments_filtered.length > 0) {
          // Étape 2 : Mise à jour des paiements
          updatePayments(payments_filtered, updatedData);
      } else {
          // Aucun paiement à traiter, terminer ici
          finalizeUpdate(updatedData);
      }
    } else {
        // Gestion de l'échec de la mise à jour de la réservation
        showBanner("Echec de la mise à jour ! <br>" + response.error, false);
        loader.style.display = 'none';
    }
  });

}

// Fonction pour ajouter un événement
function addEvent() {
  let eventData = {};
  let eventElementDOM = {};
  [
    { id: "ModaleventCustomer_id", key: "Customer_id" },
    { id: "ModaleventService_id", key: "Service_id" },
    { id: "Modaleventfullblocked", key: "fullblocked", isCheckbox: true },
    { id: "ModaleventPrice", key: "Price" },
    { id: "ModaleventQt", key: "Qt" },
    { id: "ModaleventQtTraveller", key: "QtTraveller" },
    { id: "ModaleventType_doc", key: "Type_doc" },
    { id: "ModaleventComment", key: "Comment" },
    { id: "ModaleventFee", key: "Fee" },
    { id: "ModaleventDatepicker", key: "start", isDate: true },
  ].forEach(({ id, key, isCheckbox, isDate }) => {
    let element = document.getElementById(id);
    if (isCheckbox) {
        eventData[key] = element.checked ? 1 : 0;
        eventElementDOM = element;
      } else if (isDate) {
        var dates_spliting = element.value.split(" - ");
        // Extraire les dates de début et de fin en tant que chaînes
        eventData['start'] = format_date_toSql(dates_spliting[0]);
        eventData['end'] = format_date_toSql(dates_spliting[1]);
      } else {
        eventData[key] = element.value;
      }
      eventElementDOM[id] = element;
    });


  if (eventData["start"] && eventData["end"]) {
    // Envoi de la requête AJAX

    ajaxCall("booking/addBooking", "POST", eventData, function(response) {
          if (response.success === true) {

            let booking_id = response.id;
            let ModaleventStart = response.data.start;
            let ModaleventEnd =  response.data.end;


            // ADD PAYMENTS
            let payments = []; // Initialise payments comme un tableau vide
            let payLine = document.querySelectorAll('.payment-row');
            
            if (payLine.length >0){

              payLine.forEach((row, index) => {
                if(row.id.startsWith('temp_') === true ) {
                  // Pour un nouvel enregistrement (id non défini ou vide)
                  payments.push({
                    'booking_id': booking_id,
                    'type_paid': document.getElementById(`rowPaidType${row.id}`).value,
                    'value': document.getElementById(`rowPaid${row.id}`).value
                  });
                }
                else{
                  let id = document.getElementById(`rowPaidid${index}`).value;
                  if (id){
                    // Pour un enregistrement existant (avec un id défini)
                    payments.push({
                      'id': id, // Stocker l'id dans l'objet
                      'booking_id': booking_id,
                      'type_paid': document.getElementById(`rowPaidType${index}`).value,
                      'value': document.getElementById(`rowPaid${index}`).value
                    }); // Ajouter l'objet au tableau
                  }
                }
              });
              let payments_filtred = payments.filter(item => item !== undefined);
              $.ajax({
                url: baseurl + "paids/upsert",
                method: "POST",
                data: { 'payments' : payments_filtred},
                success: function (response_paid) {
                  let allSuccess = true;
                  let allErrors = [];
  
                  for (let key in response_paid) {
                      if (response_paid.hasOwnProperty(key)) {
                          let res = response_paid[key];
                          if (!res.success) {
                              allSuccess = false;
                          }
                          if (res.errors && res.errors.length > 0) {
                              allErrors.push(...res.errors);
                          }
                      }
                  }
  
                  if (allSuccess) {
                    var encaissement = 0;
                    // Parcourez l'objet reponse
                    for (var key in response_paid) {
                      if (response_paid.hasOwnProperty(key)) {
                        // Accédez à la valeur "value" de chaque objet
                        var value = response_paid[key].data.value;
                        
                        // Checker si c'est bien un chiffre
                        if (!isNaN(parseFloat(value))) {
                          encaissement += parseFloat(value);
                        }
                      }
                    }
                    if(booking_id){
  
                      if(ModalInStack('ListEventModal')){ // SI UPDATE PAIEMENT RESPONSE VALIDE
                        let encaissement_div = document.getElementById('booking_paid_'+booking_id);
                        if(encaissement_div !== null){
                          document.getElementById('booking_paid_'+booking_id).innerText = encaissement ;
                          document.getElementById('booking_paid_status_'+booking_id).innerText = 
                          encaissement >=row_price ? "<b class='text-green-500 dark:text-green-100'>PAYE</b>":
                          encaissement < row_price && encaissement > 0 ? "<b class='text-orange-500 dark:text-orange-100'>PARTIEL</b>" : "<b class='text-red-500 dark:text-red-100'>IMPAYE</b>"  ;
                        }
                      }
  
                      if(ModalInStack('DetailsEventModal')){ // SI UPDATE PAIEMENT RESPONSE VALIDE
                        let details_paid_rest_div = document.getElementById('booking_details_progress_rest_div');
                        if(encaissement < row_price){
                          details_paid_rest_div.innerText = row_price-encaissement + " Fr";
                        }
                        else{
                          booking_details_progress_rest_div.classList.add('hidden');
                        }
                        let details_paid_div = document.getElementById('booking_details_progress_div');
                        details_paid_div.innerText = encaissement > 0 ? encaissement + " Fr" : "0";
                        if(encaissement > 0){
                          let convert_pourc = Math.min(Math.round((encaissement / row_price) * 10000) / 100, 100);
                          details_paid_div.style.width = convert_pourc > 24 ? convert_pourc+"%" : "24px";
                        } else {details_paid_div.style.width = "24px"; }
                      }
  
                    }
                  } else {
                    showBanner("Echec de la mise à jour des paiements !", false);
                    console.log('Erreurs: ', allErrors);
                  }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  
                  // En cas d'échec de la requête AJAX
                  showBanner("Échec de la mise à jour des paiements ! Erreur : " + errorThrown, false);
                  console.error("AJAX Error:", errorThrown); // Log the error for debugging
                },
              });

            }
            
          // Traitez la réponse ici
          showBanner(
            `<div class="flex flex-col">Evènement ajouté avec succès !</div>
              <div class="text-center">
                Du <b>${ModaleventStart}</b> au <b>${ ModaleventEnd }</b>
            </div>
            `,
            true
          );
          closeModal();
          setTimeout(() => {
            if (calendar) {
              calendar.refetchEvents();
            }
          }, 200);

        } else {
          // Gestion des erreurs de validation
          let errorMessages = "Erreur(s) lors de l'ajout";
          for (const field in response.error) {
            if (field.toLowerCase().includes('customer')) {
              errorMessages += "<br><h2>Le champ : <u> Client</u> est manquant !</h2>";
              // Sélectionnez l'élément qui aura les classes ajoutées
              let Modalevent_Container_Customer_id = document.getElementById('Modalevent_Container_Customer_id');
              // Ajoutez les classes
              Modalevent_Container_Customer_id.classList.add('border-2', 'border-dashed', 'border-red-500','rounded-lg','blinking');
              document.getElementById("ModaleventCustomer_id").focus();
            }
          }
          showBanner(errorMessages, false);
        }
        
      });
  } else {
    showBanner("Le formulaire est incomplet", false);
  }
}

