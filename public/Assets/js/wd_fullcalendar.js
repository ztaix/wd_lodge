

document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
      closeModal(); // ferme la dernière fenêtre modale ouverte
    }
  });

function showBanner(message, isSuccess) {
  const banner = document.getElementById('banner_update');
  const banner_txt = document.getElementById('banner_update-text');

  banner_txt.textContent = message;

  if (isSuccess) {
    banner.style.backgroundColor = 'rgba(0, 128, 0)'; //green 50%
  } else {
    banner.style.backgroundColor = 'rgba(255, 0, 0)';
  }

  banner.classList.remove('banner_update-exit');
  banner.classList.add('banner_update-visible');

  setTimeout(() => {
    banner.classList.remove('banner_update-visible');
    banner.classList.add('banner_update-exit');
  }, 3000); 
}

function showSearch() {
  const banner = document.getElementById('SearchListEventModal');
  banner.classList.add('banner_search-visible');
  banner.classList.remove('hidden');  // Supprimer la classe "hidden"
  banner.style.display = 'flex';  // Modifier la propriété "display"

}
// La pile pour garder une trace des fenêtres modales ouvertes
let modalStack = [];

// Ouvre une nouvelle fenêtre modale
function openModal(modalId,overlay = true, lastoff = true) {

  let modalElement = document.getElementById(modalId);
  // Vérifie si la pile modalStack a déjà des éléments
  if (modalStack.length > 0 && lastoff == true) {
    // Prend la dernière fenêtre modale de la pile et la cache
    let lastModal = modalStack[modalStack.length - 1];
    lastModal.style.display = "none";
  }

    if (modalElement) {
        modalElement.style.display = "block";
        modalElement.classList.add('animate');  

        modalStack.push(modalElement); // Ajoute la fenêtre modale à la pile
    }

}

// Ferme la dernière fenêtre modale ouverte
function closeModal(overlay_off = true) {

  if (modalStack.length > 0) {

    let lastModal = modalStack.pop(); // Retire la dernière fenêtre modale de la pile
    lastModal.classList.add('close-animate');  // Ajoute la classe 'close-animate' pour animer la fermeture

    // Retire la classe 'close-animate' après l'animation
    setTimeout(() => {
        lastModal.classList.remove('animate');
        lastModal.classList.remove('close-animate');
        lastModal.style.display = "none";


    },300); // Correspond à la durée de l'animation slideDown
  }
}
function closeModalById(modalId) {
  let modalElement = document.getElementById(modalId);

  if (modalElement) {
    modalElement.classList.add('close-animate');  // Ajoute la classe 'close-animate' pour animer la fermeture

    // Retire la classe 'close-animate' après l'animation

      modalElement.classList.remove('animate');
      modalElement.classList.remove('close-animate');
      modalElement.style.display = "none";
      
      // Retire la fenêtre modale spécifiée de la pile
      modalStack = modalStack.filter(modal => modal.id !== modalId);

      // Si une fenêtre modale est toujours dans la pile, alors la rouvrir
      if (modalStack.length > 0) {
        let previousModal = modalStack[modalStack.length - 1];
        previousModal.style.display = "block";
        previousModal.classList.add('animate');
      }

  }

      
}

function closex(modalId) {
  let modalElement = document.getElementById(modalId);
  modalElement.classList.remove('banner_update-visible');
  modalElement.classList.add('banner_update-exit');  // Ajoutez cette ligne

  // Écouter l'événement 'animationend' pour enlever la classe 'banner_update-exit'
  modalElement.addEventListener(modalId, function() {
    modalElement.classList.remove('banner_update-exit');
  });
}



var calendar;  // Déclaration dans la portée globale
var clickedDate = null;  // Défini dans la portée globale
var isClosingModal = false;


document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'fr',
      firstDay: 1,
      initialView: 'multiMonthYear',
      multiMonthMaxColumns: 1, // force a single column
      editable: false,
      eventResizableFromStart: false,  // Permet le redimensionnement à partir du début
      timeZone: 'Pacific/Tahiti', // Spécifiez le fuseau horaire de Tahiti
      eventSources: [
          {
              url: baseurl+'/booking/', // Votre URL pour récupérer les événements
              method: 'GET',
              failure: function() {
                  alert('Il y a eu une erreur lors du chargement des événements.');
              }
          }
      ],
      viewDidMount: function(view, element) {
          var cellWidth = $('.fc-daygrid-day').width();
          $('.fc-daygrid-day').css('height', cellWidth + 'px');
          let buttonAddEvent = document.querySelector('.fc-AddEventButton-button');  // Assurez-vous que la classe correspond à votre bouton
          let buttonSearchInput = document.querySelector('.fc-SearchIpunt-button');  // Assurez-vous que la classe correspond à votre bouton
          buttonAddEvent.innerHTML = '<svg viewBox="0 0 16 16" class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3H4.5a.5.5 0 0 1 0-1H7V4.5a.5.5 0 0 1 .5-.5z"/></svg>';
          buttonSearchInput.innerHTML = '<svg viewBox="0 0 24 24" class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>';
        
      },
      windowResize: function(view, element) {
          var cellWidth = $('.fc-daygrid-day').width();
          $('.fc-daygrid-day').css('height', cellWidth + 'px');
      },
        headerToolbar: {
          left: 'prev,next', // Ajoutez ici les boutons personnalisés
          center: 'title',
          right: 'AddEventButton,SearchIpunt'
      },
      customButtons: {
        AddEventButton: {
              text: ' ',
              click: function() {
                  openModal('addEventModal', false);
              }
          },
          SearchIpunt: {
              text: ' ',
              click: function() {
                openModal('SearchListEventModal', false);

                 // Trouver le champ inputSearch et le FOCUS keyboard
                  const inputField = document.getElementById("default-search");
                  inputField.focus();

                $("#default-search").on("input", function() {
                  const searchInput = $(this).val();
                  const resultList = $("#searchResults");
                  if (!searchInput) {
                    resultList.empty();
                    resultList.removeClass('bg-slate-200 shadow-lg'); // Retirer le fond noir transparent
                    return; // Arrêter l'exécution de la fonction ici
                  }
                  $.ajax({
                    url: '/kkl/public/booking/search',
                    method: 'GET',
                    data: { text: searchInput },
                    success: function(response,data) {
                        if (response.status === 'success' && response.data.length > 0){
                            // Ouvrir la popup si elle n'est pas déjà ouverte
                            resultList.addClass('bg-slate-200 shadow-lg'); // Retirer le fond noir transparent

                            // Mettre à jour le contenu de la popup avec les résultats de la recherche
                            resultList.empty(); // Vider les anciens résultats
                
                            response.data.forEach(booking => {
                                const bookingElement = generateBookingElement(booking);
                                resultList.append(bookingElement);
                            });
                        } else {
                            // Gérer l'échec de la requête ici
                            console.log('Échec de la Requête de recherche !');
                            resultList.empty(); // Vider les anciens résultats
                            resultList.addClass('bg-slate-200 shadow-lg'); // Retirer le fond noir transparent
                            resultList.html("Aucun résultat trouvé avec: " + searchInput); // Ajouter le message
                            
                        }
                    }
                  });
                
                });
              }
          }
      },
        buttonText: {
            today:    'Aujourd\'hui',
            month:    'Mois',
            week:     'Semaine',
            day:      'Jour',
            list:     'Liste'
        },
        eventContent: function(args) {
            let count = args.event.extendedProps.count;
            let colors = args.event.extendedProps.colors;
            let dotsHtml = '';
            // Ajoutez la première pastille avec le count
            dotsHtml += `<span class="event-dot" title="${count}"></span>`;

            // Créez un élément HTML pour représenter l'événement
            let eventElement = document.createElement("div");
            eventElement.className = "custom-event"; // Ajoutez une classe personnalisée
            eventElement.innerHTML = dotsHtml;
            //args.el.style.backgroundColor = colors;
        
            return {
                domNodes: [eventElement] // Retournez l'élément HTML dans un tableau
            };

 
        },
        eventClick: function(info) {
            const clickedDate = info.event.startStr; // Récupère la date sur laquelle l'utilisateur a cliqué
            // Faire une requête AJAX pour obtenir les événements de cette date
            $.ajax({
                url: baseurl + '/booking/getBookingsFromDate', // Votre URL pour récupérer les événements
                method: 'POST',
                data: { date: clickedDate },
                success: function(response) {
                    // $response = [
                    //  'events' => $BookingModel,
                    //  'clickedDate' => $date
                    showBookingList(response.events,clickedDate);
                    // Afficher le popup
                    
                    openModal('ListEventModal',false,false);
                    
                }
            });
        },
        dateClick: function(info) {
            //const clickedDate = info.date;  // Récupère la date cliquée
            const clickedDate = info.dateStr; // Récupère la date sur laquelle l'utilisateur a cliqué
            // Faire une requête AJAX pour obtenir les événements de cette date
            $.ajax({
            url: baseurl + '/booking/getBookingsFromDate', // Votre URL pour récupérer les événements
            method: 'POST',
            data: { date: clickedDate },
            success: function(response) {

                    //  $response = [
                    //  'events' => $BookingModel,
                    //  'clickedDate' => $date
                if (response.events.length > 0) {

                // Si la réponse contient des événements, exécutez votre code ici
                showBookingList(response.events,clickedDate);
                // Afficher le popup
                openModal('ListEventModal',false);

                } else {

                const startdate = format_date(response.clickedDate);
                const enddate = format_date(response.clickedDate,1);
            
                document.getElementById('startEvent').value = startdate;
                document.getElementById('eventEnd').value = enddate;
                document.getElementById('eventCustomer_id').value;
                document.getElementById('eventComment').value = '';

                // Changer le texte du bouton et son action pour l'ajout
                let cancelButton = document.getElementById('cancel_submit_form');
                cancelButton.onclick = function() { closeModalById('addEventModal'); }; // Ajouter un nouvel événement
                let submitButton = document.getElementById('add_submit_form');
                submitButton.onclick = function() { addEvent(); }; // Ajouter un nouvel événement
                // Afficher le popup
                openModal('addEventModal',false);

                }
            },
            error: function() {
                console.log("date error");

            }
            });
            
        }

        
    });

    calendar.render();

});

  

// Mettre à jour l'événement depuis la !!! vue détaillé !!! dans la base de données
function updateEventFromDetails() {
   
    let formData = {
        id:  document.getElementById('id').value,
        Customer_id: document.getElementById('eventCustomer_id').value,
        Service_id:  document.getElementById('eventService_id').value,
        qt:  document.getElementById('eventQt').value,
        Price:  document.getElementById('eventPrice').value,
        Paid:  document.getElementById('eventPaid').value,
        Type_doc:  document.getElementById('eventType_doc').value,
        Comment:  document.getElementById('eventComment').value,
        start:  format_date_toSql(document.getElementById('startEvent').value),
        end:  format_date_toSql(document.getElementById('eventEnd').value),
    };
    $.ajax({
        url: baseurl + '/booking/updateBooking', // URL de mise à jour
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
              showBanner('Événement mise à jour avec succès !', true);
                //closeModalById('addEventModal');
                showBookingDetailsFromID(response.id);
                if(calendar) {calendar.refetchEvents();}
            } else {
              showBanner('Echec de la mise à jour !', false);
              console.log(response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // En cas d'échec de la requête AJAX
            showBanner('Échec de la mise à jour ! Erreur : ' + errorThrown, false);
            console.error('AJAX Error:', errorThrown); // Log the error for debugging
        }
    });
}

// Fonction pour ajouter un événement
function addEvent() {

  let eventCustomer_id = document.getElementById('eventCustomer_id').value;
  let eventService_id = document.getElementById('eventService_id').value;
  let eventPrice = document.getElementById('eventPrice').value;
  let eventPaid = document.getElementById('eventPaid').value;
  let eventType_doc = document.getElementById('eventType_doc').value;
  let eventComment = document.getElementById('eventComment').value;
  let eventStart = format_date_toSql(document.getElementById('startEvent').value);
  let eventEnd = format_date_toSql(document.getElementById('eventEnd').value);
 let eventData = {
  'Customer_id': eventCustomer_id,
  'Service_id': eventService_id,
  'Price': eventPrice,
  'Paid': eventPaid,
  'Type_doc': eventType_doc,
  'Comment': eventComment,
  'start': eventStart,
  'end': eventEnd
};
if(eventData['start'] && eventData['end']){
    // Envoi de la requête AJAX
  $.ajax({
    url: baseurl + '/booking/addBooking',  // URL du contrôleur
    type: 'POST',  // Méthode HTTP
    data: eventData,  // Données à envoyer
    success: function(response) {
      // Traitez la réponse ici
      showBanner('Evènement ajouté avec succés',true);
      closeModalById('addEventModal')
      console.log("Success:", response);
      if(calendar){calendar.refetchEvents();}    
    },
    error: function(error) {
      // Traitez l'erreur ici
      showBanner('Evènement n\'a pu être ajouter',false);
      console.log("Error:", error);
    }
  });
}
else{
  showBanner('Le formulaire est incomplet',false);

}

}

function update_add_formEvent(data){

  openModal('addEventModal',false);
  // Changer le texte du bouton et son action pour l'ajout
  let submitButton = document.getElementById('add_submit_form');
  submitButton.onclick = function() { updateEventFromDetails(); }; // Ajouter un nouvel événement
  if(data){
      document.getElementById('addEventModal_title').innerText = `Modifier #${data.id}`    
      document.getElementById('id').value = data.id;
      document.getElementById('eventCustomer_id').value = data.Customer_id;
      document.getElementById('eventService_id').value = data.Service_id;
      document.getElementById('eventQt').value = data.qt;
      document.getElementById('eventPrice').value = data.Price;
      document.getElementById('eventPaid').value = data.Paid;
      document.getElementById('eventType_doc').value = data.Type_doc;
      document.getElementById('eventComment').value = data.Comment;
      document.getElementById('startEvent').value = data.start;
      document.getElementById('eventEnd').value = data.end;
  }
}



// Fonction pour ajouter un événement
function deleteEvent(event_id,modal_id) {
    openModal('ConfirmDeleteModal',true,false);

    // Changer le texte du bouton et son action pour l'ajout
    let modal = document.getElementById('ConfirmDeleteModal');
    modal.style.zIndex = "60";
    let yesconfirmButton = document.getElementById('ConfirmDeleteModal_yes_button');

    yesconfirmButton.onclick = function() { 
      $.ajax({
                  url: baseurl + '/booking/deleteBooking', // URL de mise à jour
                  method: 'POST',
                  data: {
                      id: event_id
                  }
              });
              if(calendar){calendar.refetchEvents();   }
              closeModalById('ConfirmDeleteModal');
              closeModalById(modal_id );    
     }; // Ajouter un nouvel événement
     let noconfirmButton = document.getElementById('ConfirmDeleteModal_no_button');
     noconfirmButton.onclick = function() { closeModalById('ConfirmDeleteModal'); };
    };


