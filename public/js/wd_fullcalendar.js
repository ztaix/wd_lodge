var calendar; // Déclaration dans la portée globale
var clickedDate = null; // Défini dans la portée globale


document.addEventListener("DOMContentLoaded", function () {
  const addButtonHTML = '<svg viewBox="0 0 16 16" class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3H4.5a.5.5 0 0 1 0-1H7V4.5a.5.5 0 0 1 .5-.5z"/></svg>';
  const searchButtonHTML = '<svg viewBox="0 0 24 24" class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>';
  var inputField = document.getElementById("default-search");

  if (inputField) {
    inputField.addEventListener("input", function() {
      handleSearchInput(); // Assurez-vous que cette fonction est définie quelque part dans votre code
    });
  }


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

    viewDidMount : function(view, element) {
      // Utiliser les APIs DOM natives pour améliorer les performances
      const cellWidth = document.querySelector(".fc-daygrid-day").offsetWidth;
      document.querySelectorAll(".fc-daygrid-day").forEach(cell => {
        cell.style.height = `${cellWidth}px`;
      });
  
      // Appliquer le HTML pré-défini pour les boutons
      const buttonAddEvent = document.querySelector(".fc-AddEventButton-button");
      const buttonSearchInput = document.querySelector(".fc-SearchIpunt-button");
      if (buttonAddEvent) buttonAddEvent.innerHTML = addButtonHTML;
      if (buttonSearchInput) buttonSearchInput.innerHTML = searchButtonHTML;
    },

    windowResize: function(view, element) {
      // Utilisez les API DOM natives pour obtenir la largeur
      const cellWidth = document.querySelector(".fc-daygrid-day") ? document.querySelector(".fc-daygrid-day").offsetWidth : 0;
      // Appliquez la hauteur à toutes les cellules, si une cellule existe
      if (cellWidth > 0) {
        document.querySelectorAll(".fc-daygrid-day").forEach(cell => {
          cell.style.height = `${cellWidth}px`;
        });
      }
    },
    datesSet: function(dateInfo) {
      document.querySelectorAll('.fc-multimonth-title').forEach(function(title) {
        // Vérifiez si le div personnalisé n'a pas déjà été ajouté
        if (!title.querySelector('.calendarLegend')) {
          // Créez le div personnalisé
          const customDiv = document.createElement('div');
          title.classList.add('flex', 'justify-between', 'text-md', 'capitalize');
          customDiv.classList.add('inline-flex', 'items-center', 'calendarLegend'); // Assurez-vous d'ajouter 'calendarLegend' pour éviter de dupliquer
    
          const legends = [
            {text: 'Vide', color: 'bg-white'},
            {text: 'Disponibilité', color: 'bg-green-500'},
            {text: 'Complet', color: 'bg-red-500'}
          ];
    
          let legendsHTML = legends.map(legend => `
            <div class="flex items-center">
              ${legend.text}: <span class="w-4 h-4 inline-block ${legend.color} border border-slate-200"></span>
            </div>
          `).join(' ');
    
          customDiv.innerHTML = `<div class="flex space-x-2 mr-2 items-center text-sm font-light text-slate-600 dark:text-slate-200">${legendsHTML}</div>`;
    
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
        click: function() {
          resetForm("addEventModal");
          updateTotalInfo();
          updatePrice();
          openModal("addEventModal");
        },
      },
      SearchIpunt: {
        text: " ",
        click: function() {
          openModal("SearchListEventModal");
          // Focus immédiat sur le champ de recherche
          inputField.focus();
        },
      },
    },
    buttonText: {
      today: "Aujourd'hui",
      month: "Mois",
      week: "Semaine",
      day: "Jour",
      list: "Liste",
    },

    ///START
    eventContent: function (args) {
      let bookings = args.event.extendedProps.bookings; 

      //Service list extrat from php service insert (footer page)
      const serviceTitlesObj = services_list
      .filter(service => service.fullblocked !== "1")
      .reduce((obj, service) => {
        obj[service.Service_id] = service.Title;
        return obj;
      }, {});


    const availableServicesCount = Object.keys(serviceTitlesObj).length;
    // Création d'un objet temporaire pour manipulation
    let availableServices = {...serviceTitlesObj};

    let fullblockedFound = Object.values(bookings).some(booking => booking.fullblockeds === "1");

    //Define basic variable
    let firstdayHtml = "";
    let firstdayHtmlNumber = "";
    let currentdayHtml = "";
    let lastdayHtml = "";
    let lastdayHtmlNumber = "";
    let html_construct = '';
    let COUNTisBookingStartDay = 0;
    let COUNTisBookingEndDay = 0;
    let service_booked = 0;
    let roomsAvailable = availableServicesCount; // initialiser avec le nombre total de chambres


    Object.entries(bookings).forEach(([bookingId, booking]) => {
      let serviceBooked = booking.services_titles;
      Object.entries(availableServices).forEach(([key, value]) => {
        if (value === serviceBooked) {
          // Supposant que vous vouliez faire quelque chose avec `foundKey` ici.
          // Néanmoins, soyez prudent : Si `foundKey` est utilisé en dehors de cette boucle,
          // sa valeur sera celle de la dernière correspondance trouvée dans cette boucle.
          let foundKey = value; 
          delete availableServices[key];
        }
      });
 
          let isBookingStartDay = booking.Date == booking.FirstDay.substring(0, 10);
          let isCurrentDay = booking.Date;
          let isBookingEndDay = booking.Date == booking.LastDay.substring(0, 10);
          let message = "";
          
          // Start End Animation
          // Fonction pour créer le HTML de la marque du jour
          function createDayMarker({ position, count, customerWay, additionalClasses = "" , isavailable}) {
            let baseHtml = '';
            if(customerWay === 'IN' ||customerWay === 'OUT'){
              baseHtml = `
              <div class="absolute flex justify-${position} w-full z-20">
              
              <div class="triangle ${position} ${isavailable} ${additionalClasses} ">
              </div>
              <div class="count justify-${position} my-0.5 mx-1 font-bold">
                  ${count > 0 ? count : "&nbsp;"}
              </div>
          </div>
          `;
            }
            else{
            baseHtml = `
                <div class="absolute flex justify-${position} h-full w-full z-20 ">
                    <div class=" calendar_booked ${isavailable}  flex flex-col w-full">
                             &nbsp;
                    </div>
                </div>
            `;}
            return baseHtml;
          }
          if (isBookingEndDay) {
            COUNTisBookingEndDay++;
            roomsAvailable++; // Une chambre se libère
          }

          if (isBookingStartDay) {
            COUNTisBookingStartDay++;
            fullblockedFound ? service_booked = availableServicesCount : service_booked++;
            roomsAvailable--; // Une chambre est réservée
          }

          if (isCurrentDay && !isBookingStartDay && !isBookingEndDay) {
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
          let isavailable ="";
          if (service_booked < availableServicesCount && !(isBookingEndDay && service_booked == 0) && !(isBookingStartDay && service_booked == 1)) {
            classNameBg = "bg-green-500";
            classNameDarkBg = "dark:bg-green-800";
            isavailable = "available";
            
          } else if (service_booked == availableServicesCount) {
            classNameBg = "bg-red-500";
            classNameDarkBg = "dark:bg-red-800";
            isavailable = "not-available";
          }else {
            classNameBg = "";
            classNameDarkBg = "";
            isavailable = "available";

          }
          if (isBookingEndDay) {
            lastdayHtml = createDayMarker({ position: "start", count: COUNTisBookingEndDay, customerWay: "OUT", additionalClasses: "w-2/5  z-20", isavailable : isavailable });
          }

          if (isBookingStartDay) {
            firstdayHtml = createDayMarker({ position: "end", count: COUNTisBookingStartDay, customerWay: "IN" , additionalClasses: "w-2/5  z-20", isavailable : isavailable });
          }

          
          html_construct = `
          <div class="absolute w-full h-full">
            <div class="relative h-full pt-2 pl-1 flex justify-start items-start ${classNameBg} ${classNameDarkBg}">
          
            </div>
          </div>`;
        
    });
  

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
    /// END /////
    eventClick: function (info) {
      const clickedDate = info.event.startStr;
      showDateCalendarFromClic(clickedDate);
    },
    dateClick: function (info) {
      const clickedDate = info.dateStr; 
      showDateCalendarFromClic(clickedDate);
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

