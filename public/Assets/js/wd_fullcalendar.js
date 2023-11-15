var count_row_found = 0;


function lightenHexColor(hex, percent) {
  // Convertir le hex en RGB
  let r = parseInt(hex.substring(1, 3), 16);
  let g = parseInt(hex.substring(3, 5), 16);
  let b = parseInt(hex.substring(5, 7), 16);

  // Augmenter chaque composant de couleur par le pourcentage donné
  r = parseInt(r * (100 + percent) / 100);
  g = parseInt(g * (100 + percent) / 100);
  b = parseInt(b * (100 + percent) / 100);

  // S'assurer que les valeurs restent dans les limites [0, 255]
  r = r < 255 ? r : 255;
  g = g < 255 ? g : 255;
  b = b < 255 ? b : 255;

  // Convertir les composants RGB de nouveau en une couleur hex
  let rr = r.toString(16).padStart(2, '0');
  let gg = g.toString(16).padStart(2, '0');
  let bb = b.toString(16).padStart(2, '0');

  return `#${rr}${gg}${bb}`;
}

function showBanner(message, isSuccess) {
  const banner = document.getElementById("banner_update");
  const banner_txt = document.getElementById("banner_update-text");

  banner_txt.innerHTML = message;

  if (isSuccess) {
    banner.style.backgroundColor = "rgba(0, 128, 0)"; //green 50%
  } else {
    banner.style.backgroundColor = "rgba(255, 0, 0)";
  }

  banner.classList.remove("banner_update-exit");
  banner.classList.add("banner_update-visible");

  setTimeout(() => {
    banner.classList.remove("banner_update-visible");
    banner.classList.add("banner_update-exit");
  }, 4000);
}

function showSearch() {
  const banner = document.getElementById("SearchListEventModal");
  banner.classList.add("banner_search-visible");
  banner.classList.remove("hidden"); // Supprimer la classe "hidden"
  banner.style.display = "flex"; // Modifier la propriété "display"
}
// La pile pour garder une trace des fenêtres modales ouvertes
var modalStack = []; // Pile pour stocker les fenêtres modales ouvertes
var currentZIndex = 50; // Valeur initiale du zIndex

function openModal(modalId) {
  let modalElement = document.getElementById(modalId);

  if (modalElement) {
    // Augmenter la valeur globale du zIndex
    currentZIndex += 1;

    // Appliquer le zIndex et afficher la fenêtre modale
    modalElement.style.zIndex = currentZIndex;
    modalElement.style.display = "block";
    modalElement.classList.add("animate");

    modalStack.push(modalElement); // Ajoute la fenêtre modale à la pile
  }
}

// Ferme la dernière fenêtre modale ouverte
function closeModal(all = false) {
  if(all === false){
    if (modalStack.length > 0) {
      let lastModal = modalStack.pop(); // Retire la dernière fenêtre modale de la pile
      lastModal.classList.add("close-animate"); // Ajoute la classe 'close-animate' pour animer la fermeture

      // Retire la classe 'close-animate' après l'animation
      setTimeout(() => {
        lastModal.classList.remove("animate");
        lastModal.classList.remove("close-animate");
        lastModal.style.display = "none";
      }, 2000); // Correspond à la durée de l'animation slideDown
    }
  }
  else{
    // Boucle tant qu'il y a des modales dans la pile
    while (modalStack.length > 0) {
      let currentModal = modalStack.pop(); // Retire la dernière fenêtre modale de la pile
      currentModal.classList.add("close-animate"); // Ajoute la classe 'close-animate' pour animer la fermeture

      // Retire la classe 'close-animate' après l'animation
      setTimeout(() => {
          currentModal.classList.remove("animate");
          currentModal.classList.remove("close-animate");
          currentModal.style.display = "none";
      }, 2000); // Correspond à la durée de l'animation slideDown
    }
  }
}
function closeModalById(modalId) {
  let modalElement = document.getElementById(modalId);

  if (modalElement) {
    modalElement.classList.add("close-animate"); // Ajoute la classe 'close-animate' pour animer la fermeture

    // Retire la classe 'close-animate' après l'animation

    modalElement.classList.remove("animate");
    modalElement.classList.remove("close-animate");
    modalElement.style.display = "none";

    // Retire la fenêtre modale spécifiée de la pile
    modalStack = modalStack.filter((modal) => modal.id !== modalId);

    // Si une fenêtre modale est toujours dans la pile, alors la rouvrir
    if (modalStack.length > 0) {
      let previousModal = modalStack[modalStack.length - 1];
      previousModal.style.display = "block";
      previousModal.classList.add("animate");
    }
  }
}

function closex(modalId) {
  let modalElement = document.getElementById(modalId);
  modalElement.classList.remove("banner_update-visible");
  modalElement.classList.add("banner_update-exit"); // Ajoutez cette ligne

  // Écouter l'événement 'animationend' pour enlever la classe 'banner_update-exit'
  modalElement.addEventListener(modalId, function () {
    modalElement.classList.remove("banner_update-exit");
  });
}

function ModalInStack(modalId) {
  // Vérifie si une fenêtre modale contenant 'booking' est dans la pile
  return modalStack.some(function (modal) {
    return modal.id.includes(modalId);
  });
}

var calendar; // Déclaration dans la portée globale
var clickedDate = null; // Défini dans la portée globale
var isClosingModal = false;

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
      let buttonAddEvent = document.querySelector(".fc-AddEventButton-button"); // Assurez-vous que la classe correspond à votre bouton
      let buttonSearchInput = document.querySelector(".fc-SearchIpunt-button"); // Assurez-vous que la classe correspond à votre bouton
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
              resultList.removeClass("bg-slate-200 shadow-lg"); // Retirer le fond noir transparent
              return; // Arrêter l'exécution de la fonction ici
            }
            $.ajax({
              url: "/kkl/public/booking/search",
              method: "GET",
              data: { text: searchInput },
              success: function (response, data) {
                if (response.status === "success" && response.data.length > 0) {
                  // Ouvrir la popup si elle n'est pas déjà ouverte
                  resultList.addClass("bg-slate-200 shadow-lg"); // Retirer le fond noir transparent

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
                  resultList.addClass("bg-slate-200 shadow-lg"); // Retirer le fond noir transparent
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
      let margin_init = 0;
      // Ajouter une pastille pour chaque réservation avec la couleur du service
      /*colors.forEach(function (colors) {
        dotsHtml += `<span class="event-dot" style="background-color: ${colors};margin-left: ${margin_init}px"></span>`;
        margin_init+= 7;
      });*/
      
      for (let bookingId in bookings) {
        if (bookings.hasOwnProperty(bookingId)) {
            let booking = bookings[bookingId];
            let status = "";
            let facture = booking.types_docs.charAt(0)=="F"?booking.types_docs.charAt(0):"";

            if(booking.paids == booking.prices){

                // PAID
                status = `
                <b class="flex justify-center items-center " style="color: ${lightenHexColor(booking.colors,40)};margin-top: 0px;font-size:8px">${booking.types_docs.charAt(0)=="F"?booking.types_docs.charAt(0):""}</b>
                <div class="relative ${facture!=="F"?"-top-0.5":"-top-2.5"} left-0.5" style="margin-top: 2px;"><svg class=" w-4 h-4" style=" color: ${lightenHexColor(booking.colors,70)}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg></div>`;
                class_paid = "paid"; 
                margin_init = '2';
            } else {
                // UNPAID
                status = `<b class="flex justify-center items-center" style="color: ${lightenHexColor(booking.colors,-50)};margin-top: 1px;font-size:8px">${booking.types_docs.charAt(0)=="F"?booking.types_docs.charAt(0):""}</b>`;
                class_paid = "unpaid";            

            }

            let dotHtml = `<span id="event-dot" class="event-dot ${class_paid}" style="background-color: ${booking.colors}; margin-left: ${margin_init}px">${status}</span>`;

            if (class_paid === "unpaid") {
                shadowDotsHtml += dotHtml;
            } else {
                nonShadowDotsHtml += dotHtml;
            }
        }
    }

    // Concaténer les deux groupes de spans
   let dotsHtml = shadowDotsHtml + nonShadowDotsHtml;

    // Créer un élément HTML pour représenter l'événement
    let eventElement = document.createElement("div");
    eventElement.className = "flex justify-center items-center";
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

          openModal("ListEventModal");
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
          //  $response = [
          //  'events' => $BookingModel,
          //  'clickedDate' => $date            

          // Attribution d'office à la modal d'ajout la date cliqué.
          const startdate = format_date(response.clickedDate);
          const enddate = format_date(response.clickedDate, 1);
          document.getElementById("startEvent").value = startdate;
          document.getElementById("eventEnd").value = enddate;

          if (response.events.length > 0) {
            // Si la réponse contient des événements, exécutez votre code ici
            showBookingList(response.events, clickedDate);
            // Afficher le popup
            openModal("ListEventModal");
            console.log('date',clickedDate);
          } else {
            document.getElementById("eventCustomer_id").value;
            document.getElementById("eventComment").value = "";
            fromServicepicker.setStartDate(startdate);
            fromServicepicker.setEndDate(enddate);

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
  let formData = {
    id: document.getElementById("id").value,
    Customer_id: document.getElementById("eventCustomer_id").value,
    Service_id: document.getElementById("eventService_id").value,
    fullblocked: document.getElementById("eventFull_Blocked").checked ===true ? 1 : 0,
    qt: document.getElementById("eventQt").value,
    Price: document.getElementById("eventPrice").value,
    Paid: document.getElementById("eventPaid").value,
    Type_doc: document.getElementById("eventType_doc").value,
    Comment: document.getElementById("eventComment").value,
    start: format_date_toSql(document.getElementById("startEvent").value),
    end: format_date_toSql(document.getElementById("eventEnd").value),
  };
  $.ajax({
    url: baseurl + "booking/updateBooking", // URL de mise à jour
    method: "POST",
    data: formData,
    success: function (response) {
      if (response.status == "success") {

        showBanner("Événement mise à jour avec succès !", true);
        closeModalById('addEventModal');
        showBookingDetailsFromID(response.id);

        if (calendar) {
          calendar.refetchEvents();
        }
      } else {
        showBanner("Echec de la mise à jour !", false);
        console.log(response);
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
    { id: "eventCustomer_id", key: "Customer_id" },
    { id: "eventService_id", key: "Service_id" },
    { id: "eventFull_Blocked", key: "fullblocked", isCheckbox: true },
    { id: "eventPrice", key: "Price" },
    { id: "eventPaid", key: "Paid" },
    { id: "eventQt", key: "qt" },
    { id: "eventQtTraveller", key: "QtTraveller" },
    { id: "eventType_doc", key: "Type_doc" },
    { id: "eventComment", key: "Comment" },
    { id: "startEvent", key: "start", isDate: true },
    { id: "eventEnd", key: "end", isDate: true }
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
          if (response.status == "success") {
            // Traitez la réponse ici
            showBanner(
              `<div class="flex flex-col">Evènement ajouté avec succès !</div>
                <div class="text-center">
                  Du <b>${document.getElementById("startEvent").value}</b> au <b>${
                document.getElementById("eventEnd").value
              }</b>
              </div>
              `,
              true
            );
            closeModal(true);
            setTimeout(() => {
              if (calendar) {
                calendar.refetchEvents();
              }
            }, 200);
          } else {
            // Gestion des erreurs de validation
            let errorMessages = "Erreur(s) lors de l'ajout :<ul>";
            for (let field in response.errors) {
              errorMessages += `<li>${response.errors[field]}</li>`;
            }
            errorMessages += "</ul>";
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
  if (data) {
    await loadAndInitDatepicker(data.Service_id, data.start, data.end);

    document.getElementById(
      "addEventModal_title"
    ).innerText = `Modifier #${data.id}`;
    document.getElementById("id").value = data.id;
    document.getElementById("eventCustomer_id").value = data.Customer_id;
    document.getElementById("eventService_id").value = data.Service_id;
    eventFull_Blocked.checked = parseInt(data.fullblocked) === 1;

    var container_full_blocked = document.getElementById("container_eventFull_Blocked");
      if (parseInt(data.fullblocked) === 1) {
        // Appliquer un style lorsque la checkbox est cochée
        container_full_blocked.style.backgroundColor = "red"; // Exemple : Fond vert
        // Vous pouvez également changer le style d'autres éléments ici
    } else {
        // Appliquer un style différent lorsque la checkbox n'est pas cochée
        container_full_blocked.style.backgroundColor = "transparent"; // Exemple : Fond rouge
        // Vous pouvez également réinitialiser le style d'autres éléments ici
    }            
    document.getElementById("eventQtTraveller").value = data.QtTraveller;
    document.getElementById("eventQt").value = data.qt;
    document.getElementById("eventPrice").value = data.Price;
    document.getElementById("eventPaid").value = data.Paid;
    document.getElementById("eventType_doc").value = data.Type_doc;
    document.getElementById("eventComment").value = data.Comment;

  }
}

// Fonction pour ajouter un événement
function deleteEvent(event_id, modal_id = false, event = false) {
  openModal("ConfirmDeleteModal", true, false);

  // Changer le texte du bouton et son action pour l'ajout
  let modal = document.getElementById("ConfirmDeleteModal");
  modal.style.zIndex = "999";
  let yesconfirmButton = document.getElementById(
    "ConfirmDeleteModal_yes_button"
  );

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
