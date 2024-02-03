var calendar; // Déclaration dans la portée globale
var clickedDate = null; // Défini dans la portée globale

document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("calendar");
  calendar = new FullCalendar.Calendar(calendarEl, {
    loading: function(isLoading) {
      if (isLoading) {
          // Afficher le loader
          document.querySelector('.loader').style.display = 'block';
      } else {
          // Cacher le loader
          document.querySelector('.loader').style.display = 'none';
      }
    },
    locale: "fr",
    firstDay: 1,
    initialView: "multiMonthYear",
    multiMonthMaxColumns: 1, // force a single column
    editable: false,
    eventResizableFromStart: false, // Permet le redimensionnement à partir du début
    timeZone: "Pacific/Tahiti", // Spécifiez le fuseau horaire de Tahiti
    eventSources: [
      {
        url: baseurl + "booking", // Votre URL pour récupérer les événements
        method: "GET",
        success: function (response) {
          // Vous pouvez traiter la réponse et afficher un message de succès, si nécessaire
          if (response && response.length === 0) {
            alert("Aucune réservation trouvée pour les dates sélectionnées.");
          } else {
            console.log(
              "Calendrier rechargé: Réservations chargées avec succès"
              );
          }
        },
        failure: function (error) {
          // Affichez une notification plus détaillée en cas d'échec
          console.error("Erreur lors du chargement des réservations:", error);
         /* alert(
            "Il y a eu une erreur lors du chargement des réservations. Veuillez vérifier la console pour plus de détails."
          );*/
        },
      },
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
              resultList.removeClass("bg-white dark:bg-slate-700 shadow-lg"); // Retirer le fond noir transparent
              return; // Arrêter l'exécution de la fonction ici
            }
            $.ajax({
              url: baseurl  + "/booking/search",
              method: "GET",
              data: { text: searchInput },
              success: function (response) {
                if (response.status === "success" && response.data.length > 0) {
                  
                  // Ouvrir la popup si elle n'est pas déjà ouverte
                  resultList.addClass("bg-white dark:bg-slate-700 shadow-lg"); // Retirer le fond noir transparent

                  // Mettre à jour le contenu de la popup avec les résultats de la recherche
                  resultList.empty(); // Vider les anciens résultats

                  response.data.forEach((booking) => {
                    const bookingElement = generateBookingElement(booking);
                    resultList.append(bookingElement);
                  });
                } else {
                  // Gérer l'échec de la requête ici
                  console.log("Échec de la Requête de recherche !");
                  resultList.empty(); // Vider les anciens résultats
                  resultList.addClass("bg-white dark:bg-slate-700 shadow-lg"); // Retirer le fond noir transparent
                  resultList.html("Aucun résultat trouvé avec: " + searchInput); // Ajouter le message
                }
              },
            });
          });
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
    eventContent: function (args) {
      let bookings = args.event.extendedProps.bookings; 
      let shadowDotsHtml = "";
      let nonShadowDotsHtml = "";

      let firstdayHtml = "";
      let firstdayHtmlNumber = "";
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

          /// ALL INSTRUCTIONS DOWN ///

          // Start End Animation
          
          if (isBookingEndDay ) {
            COUNTisBookingEndDay++;

            lastdayHtml = `
            <div class="absolute flex justify-start w-full ">
                <div class="flex flex-col w-1/2 h-full bg-gray-600  dark:bg-white ">
                  <div class="relative group-hover:small-down-OUT flex items-end justify-center text-white dark:text-black font-bold mx-auto">
                    OUT
                  </div>
                  <div class="flex items-end justify-center mb-1 text-white dark:text-black font-bold mx-auto">
                  ${COUNTisBookingEndDay}
                  </div>
                </div>
            </div>
        `;  
          }
          if (isBookingStartDay) {
            COUNTisBookingStartDay++;
            ++service_booked;

            let bg_div = 'bg-white';
            if(fullblockedFound || nEventDay >= availableServicesCount){
              bg_div = 'bg-red-600';
            }
            else if(NotBookedServicesCount < availableServicesCount){
              bg_div = 'bg-green-500';
            }

            firstdayHtml = `
            <div class="absolute flex justify-end h-full w-full">
            <div class="flex flex-col justify-end items-end w-1/2 h-full ${bg_div} dark:bg-white overflow-hidden">
              <div class="relative group-hover:small-down-IN flex items-center justify-center text-white dark:text-black font-bold mx-auto">
                IN
              </div>
              <div class="flex items-center justify-center mb-1 text-white dark:text-black font-bold mx-auto">
                ${COUNTisBookingStartDay}
              </div>
            </div>
          </div>
          
            `;
          }


          if(isCurrentDay && !isBookingEndDay & !isBookingStartDay){
            ++service_booked;
            }  

          // STATUS available
          if(service_booked < availableServicesCount && !fullblockedFound){ // Occupé et disponible
            color = "green";
          }
          else if( NotBookedServicesCount === 0 || (COUNTisBookingStartDay == 1  && fullblockedFound) || (fullblockedFound && nEventDay == 1) ){ // privatisé
            color = "red";
          }

          message = service_booked + "/" + availableServicesCount;

         
          html_construct = `<div class="absolute text-black dark:text-white bg-${color}-300 dark:bg-${color}-700 w-full h-full">
          <div class="relative h-full p-1 flex justify-start items-start">${message}</div></div>`; 
        
        }
    }

   let dotsHtml =  html_construct + lastdayHtml + lastdayHtmlNumber + firstdayHtml + firstdayHtmlNumber;
    // Créer un élément HTML pour représenter l'événement
    let eventElement = document.createElement("div");
    eventElement.className = `group relative flex justify-center items-end h-full overflow-hidden`;
    eventElement.innerHTML = dotsHtml;
      return {
        domNodes: [eventElement],
      };
    },
    eventClick: function (info) {

const clickedDate = info.event.startStr; // Récupère la date sur laquelle l'utilisateur a cliqué
      // Faire une requête AJAX pour obtenir les événements de cette date

      $.ajax({
        url: baseurl + "booking/getBookingsFromDate", // Votre URL pour récupérer les événements
        method: "POST",
        data: { date: clickedDate },
        success: function (response) {
          // $response = [
          //  'events' => $BookingModel,
          //  'clickedDate' => $date

          showBookingList(response.events, clickedDate);
          // Afficher le popup
        },
      });
    },
    dateClick: function (info) {
      //const clickedDate = info.date;  // Récupère la date cliquée
      const clickedDate = info.dateStr; // Récupère la date sur laquelle l'utilisateur a cliqué
      // Faire une requête AJAX pour obtenir les événements de cette date
      $.ajax({
        url: baseurl + "booking/getBookingsFromDate", // Votre URL pour récupérer les événements
        method: "POST",
        data: { date: clickedDate },
        success: function (response) {

          // Attribution d'office à la modal d'ajout la date cliqué.
          const startdate = format_date(response.clickedDate);
          const enddate = format_date(response.clickedDate, 1);


          document.getElementById("ModaleventStart").value = startdate;
          document.getElementById("ModaleventEnd").value = enddate;

          if (response.events.length > 0) {
            // Si la réponse contient des événements, exécutez votre code ici
            showBookingList(response.events, clickedDate);
          } else {
            resetForm("addEventModal",startdate,enddate);
            updateTotalInfo();
            updatePrice();
            // Afficher le popup
            openModal("addEventModal");
          }
        },
        error: function () {
          console.log("date error");
        },
      });
    },
  });

  calendar.render();
});

// Mettre à jour l'événement depuis la !!! vue détaillé !!! dans la base de données
function updateEventFromDetails() {
  let formData = {};
  let E_Form = Array.from(document.querySelectorAll('[id]')).filter(element => typeof element.id === 'string' && element.id.startsWith('Modalevent'));
  E_Form.forEach(element => {
    const key = element.id.replace("Modalevent", ""); // Supprime "Modalevent" du début de l'id pour obtenir la clé
    if (element.type === "checkbox") {
        formData[key] = element.checked ? 1 : 0; // Pour les cases à cocher
    } else if (key ==="Start" || key === 'End' ){
      formData[key.toLowerCase()] = format_date_toSql(element.value); // Pour les champs de texte et les listes déroulantes

    }else {formData[key] = element.value;}
  });
  //UPDATE FORM BOOKING
  $.ajax({
    url: baseurl + "booking/updateBooking", // URL de mise à jour
    method: "POST",
    data: formData,
    success: function (response) {
      if (response.status == "success") {
        let updatedData = {};
        updatedData[response.id] = response.data;
        showBanner("Événement mise à jour avec succès !", true);
        
        if (calendar) {
          calendar.refetchEvents();
        }
       
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
        let payments_filtred = payments.filter(item => item !== undefined);
        $.ajax({
          url: baseurl + "paids/upsert",
          method: "POST",
          data: { 'payments' : payments_filtred},
          success: function (response) {
            let allSuccess = true;
            let allErrors = [];

            for (let key in response) {
                if (response.hasOwnProperty(key)) {
                    let res = response[key];
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
              for (var key in response) {
                if (response.hasOwnProperty(key)) {
                  // Accédez à la valeur "value" de chaque objet
                  var value = response[key].data.value;
                  
                  // Checker si c'est bien un chiffre
                  if (!isNaN(parseFloat(value))) {
                    encaissement += parseFloat(value);
                  }
                }
              }  
              // Récupére l'ID de la résa
              let updatedData_encaissement = Object.keys(updatedData);
              //Ajouter au tableau d'update l'encaissement total
              updatedData[updatedData_encaissement[0]].encaissement = encaissement;

              updateModal(updatedData);

              closeModalById('addEventModal');
                showBanner("Paiements mise à jour avec succès !", true);
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
      } else {
        showBanner("Echec de la mise à jour ! <br>" + response.message.Customer_id, false);
        console.log(response.message.Customer_id);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      
      // En cas d'échec de la requête AJAX
      showBanner("Échec de la mise à jour ! Erreur : " + errorThrown, false);
      console.error("AJAX Error:", errorThrown); // Log the error for debugging
    },
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
    { id: "ModaleventStart", key: "start", isDate: true },
    { id: "ModaleventEnd", key: "end", isDate: true }
  ].forEach(({ id, key, isCheckbox, isDate }) => {
    let element = document.getElementById(id);
    if (isCheckbox) {
        eventData[key] = element.checked ? 1 : 0;
        eventElementDOM = element;
      } else if (isDate) {
        eventData[key] = format_date_toSql(element.value);
      } else {
        eventData[key] = element.value;
      }
      eventElementDOM[id] = element;
    });


  if (eventData["start"] && eventData["end"]) {
    // Envoi de la requête AJAX
    $.ajax({
      url: baseurl + `booking/addBooking`, // URL du contrôleur
      type: "POST", // Méthode HTTP
      data: eventData, // Données à envoyer
      success: function (response) {
        try {
          if (response.success === true) {

            let booking_id = response.id;
            // Traitez la réponse ici
            showBanner(
              `<div class="flex flex-col">Evènement ajouté avec succès !</div>
                <div class="text-center">
                  Du <b>${document.getElementById("ModaleventStart").value}</b> au <b>${
                document.getElementById("ModaleventEnd").value
              }</b>
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


            // ADD PAYMENTS
            let payments = []; // Initialise payments comme un tableau vide
            document.querySelectorAll('.payment-row').forEach((row, index) => {
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
                  
                  if(ModalInStack('ListEventModal')){ // SI UPDATE PAIEMENT RESPONSE VALIDE
                    document.getElementById('booking_paid_'+row_id).innerText = encaissement ;
                    document.getElementById('booking_paid_status_'+row_id).innerText = 
                    encaissement >=row_price ? "<b class='text-green-500 dark:text-green-100'>PAYE</b>":
                    encaissement < row_price && encaissement > 0 ? "<b class='text-orange-500 dark:text-orange-100'>PARTIEL</b>" : "<b class='text-red-500 dark:text-red-100'>IMPAYE</b>"  ;

                  }
                  if(ModalInStack('DetailsEventModal')){ // SI UPDATE PAIEMENT RESPONSE VALIDE
                    let details_paid_rest_div = document.getElementById('booking_details_progress_rest_div');
                    if(encaissement < row_price){
                      details_paid_rest_div.innerText = row_price-encaissement + " Fr";
                    }
                    let details_paid_div = document.getElementById('booking_details_progress_div');
                    details_paid_div.innerText = encaissement > 0 ? encaissement + " Fr" : "0";
                    if(encaissement > 0){
                      let convert_pourc = Math.min(Math.round((encaissement / row_price) * 10000) / 100, 100);
                      details_paid_div.style.width = convert_pourc > 24 ? convert_pourc+"%" : "24px";
                    } else {details_paid_div.style.width = "24px"; }
                    
                  }
                    closeModalById('addEventModal');
                    showBanner("Paiements mise à jour avec succès !", true);
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
            }
          }
          showBanner(errorMessages, false);
        }
        
        } catch (e) {
          console.error("Erreur dans l'ajout de la réservation:", e.message);
          showBanner("Erreur dans l'ajout de la réservation:"+  e.message, false);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // Gestion de l'erreur
        let errorMessage = "Erreur lors de la requête. ";
        if (jqXHR.status) {
          errorMessage += "Statut : " + jqXHR.status + ". ";
        }
        if (textStatus) {
          errorMessage += "Statut du texte : " + textStatus + ". ";
        }
        if (errorThrown) {
          errorMessage += "Erreur jetée : " + errorThrown + ". ";
        }
        if (jqXHR.responseText) {
          errorMessage += "Réponse du texte : " + jqXHR.responseText;
        }
        showBanner(errorMessage, false);
        console.error("Error: ", jqXHR, textStatus, errorThrown);
      },
    });
  } else {
    showBanner("Le formulaire est incomplet", false);
  }
}

async function update_add_formEvent(data) {
  openModal("addEventModal");

  // Changer le texte du bouton et son action pour l'ajout
  let submitButton = document.getElementById("add_submit_form");
  submitButton.onclick = function () {
    updateEventFromDetails();
  }; // Ajouter un nouvel événement
  try {
    let paids = await getPaidFromBookingId(data.id);
    let paymentsHtml = '';
    if(paids.length > 0){
      paids.forEach((paid, index) => {
          paymentsHtml += createPaymentHtml(paid, index, paids.length);
      });
    }
    document.getElementById('payments-subcontainer').innerHTML = paymentsHtml; 

} catch (error) {
    console.error("Erreur lors de la récupération des paids: ", error);
    // Gérez l'erreur comme vous le souhaitez
}

  if (data) {
    await loadAndInitDatepicker(data.Service_id, data.start, data.end);

    document.getElementById("addEventModal_title").innerText = `Modifier #${data.id}`;
    document.getElementById("Modaleventid").value = data.id;
    document.getElementById("ModaleventCustomer_id").value = data.Customer_id;
    $('#ModaleventCustomer_id').trigger('change'); // afin que le module SELECT2 reflète formulaire

    document.getElementById("ModaleventService_id").value = data.Service_id;
    document.getElementById("Modaleventfullblocked").checked = parseInt(data.fullblocked) === 1;
    document.getElementById("ModaleventQtTraveller").value = parseInt(data.QtTraveller);
    document.getElementById("ModaleventQt").value = data.Qt;
    document.getElementById("ModaleventPrice").value = data.Price;
    document.getElementById("ModaleventType_doc").value = data.Type_doc;
    document.getElementById("ModaleventComment").value = data.Comment;

    // APPEL des functions de mise à jours du prix total ET des informations
    updateTotalInfo();
    updatePrice();

  }
}

// TODO, deleted les paids_id associé aux event_id
function deleteEvent(event, event_id, modal_id = false, paids_id = false) {
  event.stopPropagation(); // Empêche la propagation de l'événement au parent
  openModal("ConfirmDeleteModal");
  let modal = document.getElementById("ConfirmDeleteModal");
  modal.style.zIndex = "999";
  let yesconfirmButton = document.getElementById(
    "ConfirmDeleteModal_yes_button"
    );
    console.log('modal',modal);
    
    yesconfirmButton.onclick = function () {
      $.ajax({
        url: baseurl + "booking/deleteBooking", // URL de mise à jour
        method: "POST",
        data: {
          id: event_id,
        },
        success: function (response) {
          if (calendar) {
            calendar.refetchEvents();
          } 
        }
      });

      // GESTIONNAIRE DE RETOUR D'AFFICHAGE
      if (ModalInStack("ListEventModal")) {
        row_type = "booking_list_row_";
        document
          .getElementById('booking_'+event_id)
          .classList.add("line-through");
        document
          .getElementById('badge_id_'+event_id)
          .style.cssText = 'background-color: gray;';
        document
          .getElementById('booking_a_'+event_id)
          .style.cssText = ' cursor : default;';
          
          let svgs = document.querySelectorAll('#booking_a_' + event_id + ' svg');

          svgs.forEach(function(svg) {
            svg.style.color = 'gray';
        });

        document
          .getElementById('booking_list_row_hr_'+event_id)
          .classList.add("fade_out");
        count_row_found--;
        document.getElementById(
          "booking_list_row_found"
        ).innerText = `Réservation trouvé : ${count_row_found}`;
      } else {
        row_type = "row_booking_";
      }
      setTimeout(() => {
        $("." + row_type + event_id).addClass("fade_out");
      }, 200);
      setTimeout(() => {
        $("." + row_type + event_id).css("display", "none");
      }, 700);
      showBanner("Suppression réalisée avec succès", true);
      closeModalById("ConfirmDeleteModal");
      if (modal_id) {
        closeModalById(modal_id);
      }
    };

    let noconfirmButton = document.getElementById("ConfirmDeleteModal_no_button");
    noconfirmButton.onclick = function () {
      closeModalById("ConfirmDeleteModal");
    };
}
