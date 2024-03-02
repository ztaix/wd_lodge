var calendar;
var clickedDate = null;
var currentDocType = 'Facture';

const addButtonHTML =
  '<svg viewBox="0 0 16 16" class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3H4.5a.5.5 0 0 1 0-1H7V4.5a.5.5 0 0 1 .5-.5z"/></svg>';
const searchButtonHTML =
  '<svg viewBox="0 0 24 24" class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>';

var inputField = document.getElementById('default-search');
if (inputField) {
  inputField.addEventListener('input', function () {
    handleSearchInput(); // Assurez-vous que cette fonction est définie quelque part dans votre code
  });
}

document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'fr',
    firstDay: 1,
    initialView: 'multiMonthYear',
    multiMonthMaxColumns: 1, // force a single column
    editable: false,
    dayMaxEventRows: false,
    dayMaxEvents: false,
    timeZone: 'Pacific/Tahiti', // Spécifiez le fuseau horaire de Tahiti
    eventSources: [
      function (fetchInfo, successCallback, failureCallback) {
        // Utiliser ajaxCall pour charger les événements
        ajaxCall(
          'booking',
          'GET',
          {},
          function (response) {
            // Callback de succès
            // Supposer que 'response' est un tableau d'événements
            successCallback(response);
          },
          function (xhr, status, error) {
            // Callback d'erreur
            console.error('Erreur lors du chargement des événements:', error);
            failureCallback(error); // Signaler l'échec à FullCalendar
          }
        );
      },
    ],
    datesSet: function () {
      document
        .querySelectorAll('.fc-multimonth-title')
        .forEach(function (title) {
          // Vérifiez si le div personnalisé n'a pas déjà été ajouté
          if (!title.querySelector('.calendarLegend')) {
            // Créez le div personnalisé
            const customDiv = document.createElement('div');
            title.classList.add(
              'flex',
              'justify-between',
              'text-md',
              'capitalize'
            );
            customDiv.classList.add(
              'inline-flex',
              'items-center',
              'calendarLegend'
            ); // Assurez-vous d'ajouter 'calendarLegend' pour éviter de dupliquer

            const legends = [
              { text: 'Vide', color: 'bg-white' },
              { text: 'Disponibilité', color: 'bg-green-500' },
              { text: 'Complet', color: 'bg-red-500' },
            ];

            let legendsHTML = legends
              .map(
                (legend) => `
            <div class="flex items-center">
              ${legend.text} : <span class="w-4 h-4 inline-block ${legend.color} border border-slate-200 ml-1"></span>
            </div>
          `
              )
              .join(' ');

            customDiv.innerHTML = `<div class="flex space-x-2 mr-2 items-center text-sm font-light text-slate-600 dark:text-slate-200">${legendsHTML}</div>`;

            title.appendChild(customDiv);
          }
        });
    },
    headerToolbar: {
      left: 'prev,next', // Ajoutez ici les boutons personnalisés
      center: 'title',
      right: 'AddEventButton,SearchIpunt',
    },

    customButtons: {
      AddEventButton: {
        text: 'Ajouter',
        click: function () {
          resetForm('addEventModal');
          updateTotalInfo();
          updatePrice();
          openModal('addEventModal');
        },
      },
      SearchIpunt: {
        text: 'Rechercher',
        click: function () {
          openModal('SearchListEventModal');
          // Focus immédiat sur le champ de recherche
          inputField.focus();
        },
      },
    },
    buttonText: {
      today: "Aujourd'hui",
      month: 'Mois',
      week: 'Semaine',
      day: 'Jour',
      list: 'Liste',
    },

    ///START
    eventContent: function (args) {
      let bookings = args.event.extendedProps.bookings;
      //Service list extrat from php service insert (footer page)
      const serviceTitlesObj = services_list.reduce((obj, service) => {
        // Ici, nous utilisons `service.Service_id` comme clé.
        // Et comme valeur, nous créons un nouvel objet contenant à la fois `Title` et `fullblocked`.
        obj[service.Service_id] = {
          Title: service.Title,
          fullblocked: service.fullblocked,
        };
        return obj;
      }, {});

      //Define basic variable
      let firstdayHtml = '';
      let lastdayHtml = '';
      let html_construct = '';
      let COUNTisBookingStartDay = 0;
      let COUNTisBookingEndDay = 0;
      let classNameBg = '';
      let isavailable = '';

      // Création d'un objet temporaire pour manipulation
      let availableServices = { ...serviceTitlesObj };

      // Début de la boucle ----->
      Object.entries(bookings).forEach(([bookingId, booking]) => {
        let isBookingStartDay =
          booking.Date == booking.FirstDay.substring(0, 10);
        let isBookingEndDay = booking.Date == booking.LastDay.substring(0, 10);
        let services_titles = booking.services_titles;

        Object.entries(availableServices).forEach(([key, service]) => {
          if (service.Title === services_titles) {
            // Si le titre du service correspond et que 'fullblocked' est '1',
            // alors on vide tous les services disponibles.
            if (service.fullblocked === '1' && !isBookingEndDay) {
              // Vide complètement availableServices
              Object.keys(availableServices).forEach((serviceKey) => {
                delete availableServices[serviceKey];
              });
            } else {
              if (!isBookingEndDay) {
                // Parcourir toutes les clés de l'objet
                for (let subkey in availableServices) {
                  // Vérifier si 'fullblocked' vaut "1"
                  if (availableServices[subkey].fullblocked === '1') {
                    // Supprimer l'objet si 'fullblocked' vaut "1"
                    delete availableServices[subkey];
                  }
                }
                delete availableServices[key];
              }
            }
          }
        });
        if (isBookingEndDay) {
          COUNTisBookingEndDay++;
        }
        if (isBookingStartDay) {
          COUNTisBookingStartDay++;
        }

        let roomsAvailableByService = Object.keys(availableServices).length;

        // Déterminer la couleur du BG

        if (roomsAvailableByService > 0) {
          classNameBg = 'bg-green-500 dark:bg-green-800';
          isavailable = 'available';
          classBorderColor = '#56DD4F'; //Toxic Green
        } else if (roomsAvailableByService <= 0) {
          classNameBg = 'bg-red-500 dark:bg-red-800';
          isavailable = 'not-available';
          classBorderColor = '#F93333'; //Red Orange
        } else {
          classNameBg = 'bg-purple-500 dark:bg-purple-800';
          classBorderColor = '#DE4EC9'; //Purple Pink
          isavailable = 'not-available';
        }

        if (isBookingEndDay) {
          lastdayHtml = createDayMarker({
            position: 'start',
            count: COUNTisBookingEndDay,
            customerWay: 'OUT',
            additionalClasses: 'w-2/5  z-20',
            isavailable: isavailable,
            classBorderColor,
          });
        }

        if (isBookingStartDay) {
          firstdayHtml = createDayMarker({
            position: 'end',
            count: COUNTisBookingStartDay,
            customerWay: 'IN',
            additionalClasses: 'w-2/5  z-20',
            isavailable: isavailable,
            classBorderColor,
          });
        }

        html_construct = `
        <div class="absolute w-full h-full">
          <div class="relative h-full pt-2 pl-1 flex justify-start items-start ${classNameBg}">
          </div>
        </div>`;
      });
      let dotsHtml = html_construct + lastdayHtml + firstdayHtml;
      // Créer un élément HTML pour représenter l'événement
      let eventElement = document.createElement('div');
      eventElement.className = `group relative flex justify-center items-end w-full h-full text-black dark:text-white overflow-hidden
      ${args.isPast ? 'opacity-30' : ''}  `;
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
  let E_Form = Array.from(document.querySelectorAll('[id]')).filter(
    (element) =>
      typeof element.id === 'string' &&
      element.id.startsWith('Modalevent') &&
      !element.id.includes('bgtoggle')
  );
  E_Form.forEach((element) => {
    const key = element.id.replace('Modalevent', ''); // Supprime "Modalevent" du début de l'id pour obtenir la clé
    if (element.type === 'checkbox' && !element.id.includes('Type_doc')) {
      formData[key] = element.checked ? 1 : 0; // Pour les cases à cocher
    } else if (key === 'Start' || key === 'End') {
      formData[key.toLowerCase()] = format_date_toSql(element.value); // Pour les champs de texte et les listes déroulantes
    } else if (key === 'Datepicker') {
      var dates_spliting = element.value.split(' - ');
      // Extraire les dates de début et de fin en tant que chaînes
      formData['start'] = format_date_toSql(dates_spliting[0]);
      formData['end'] = format_date_toSql(dates_spliting[1]);
    } else {
      formData[key] = element.value;
    }
  });
  //UPDATE FORM BOOKING
  // Étape 1 : Mise à jour de la réservation
  ajaxCall('booking/updateBooking', 'POST', formData, function (response) {
    if (response.success === true) {
      let updatedData = {};
      updatedData[response.id] = response.data;

      // UPDATE FORM PAID
      let payments = []; // Initialise payments comme un tableau vide
      document.querySelectorAll('.payment-row').forEach((row, index) => {
        if (row.id.startsWith('temp_') === true) {
          // Pour un nouvel enregistrement (id non défini ou vide)
          payments.push({
            booking_id: formData['id'],
            type_paid: document.getElementById(`rowPaidType${row.id}`).value,
            value: document.getElementById(`rowPaid${row.id}`).value,
          });
        } else {
          let id = document.getElementById(`rowPaidid${index}`).value;
          if (id) {
            // Pour un enregistrement existant (avec un id défini)
            payments.push({
              id: id, // Stocker l'id dans l'objet
              booking_id: formData['id'],
              type_paid: document.getElementById(`rowPaidType${index}`).value,
              value: document.getElementById(`rowPaid${index}`).value,
            }); // Ajouter l'objet au tableau
          }
        }
      });

      let payments_filtered = payments.filter((item) => item !== undefined);
      if (payments_filtered.length > 0) {
        // Étape 2 : Mise à jour des paiements
        updatePayments(payments_filtered, updatedData);
      } else {
        // Aucun paiement à traiter, terminer ici
        finalizeUpdate(updatedData);
      }
    } else {
      // Gestion de l'échec de la mise à jour de la réservation
      showBanner('Echec de la mise à jour ! <br>' + response.error, false);
    }
  });
}

// Fonction pour ajouter un événement
function addEvent() {
  let eventData = {};
  let eventElementDOM = {};
  [
    { id: 'ModaleventCustomer_id', key: 'Customer_id' },
    { id: 'ModaleventService_id', key: 'Service_id' },
    { id: 'Modaleventfullblocked', key: 'fullblocked', isCheckbox: true },
    { id: 'ModaleventPrice', key: 'Price' },
    { id: 'ModaleventQt', key: 'Qt' },
    { id: 'ModaleventQtTraveller', key: 'QtTraveller' },
    { id: 'ModaleventType_doc', key: 'Type_doc' },
    { id: 'ModaleventComment', key: 'Comment' },
    { id: 'ModaleventFee', key: 'Fee' },
    { id: 'ModaleventTax', key: 'Tax' },
    { id: 'ModaleventDatepicker', key: 'start', isDate: true },
  ].forEach(({ id, key, isCheckbox, isDate }) => {
    let element = document.getElementById(id);
    if (isCheckbox) {
      eventData[key] = element.checked ? 1 : 0;
      eventElementDOM = element;
    } else if (isDate) {
      var dates_spliting = element.value.split(' - ');
      // Extraire les dates de début et de fin en tant que chaînes
      eventData['start'] = format_date_toSql(dates_spliting[0]);
      eventData['end'] = format_date_toSql(dates_spliting[1]);
    } else {
      eventData[key] = element.value;
    }
    eventElementDOM[id] = element;
  });

  if (eventData['start'] && eventData['end']) {
    // Envoi de la requête AJAX

    ajaxCall('booking/addBooking', 'POST', eventData, function (response) {
      if (response.success === true) {
        let Booking_id = response.id;

        // ADD PAYMENTS
        let payments = []; // Initialise payments comme un tableau vide
        let payLine = document.querySelectorAll('.payment-row');

        if (payLine.length > 0) {
          payLine.forEach((row, index) => {
            if (row.id.startsWith('temp_') === true) {
              // Pour un nouvel enregistrement (id non défini ou vide)
              payments.push({
                booking_id: Booking_id,
                type_paid: document.getElementById(`rowPaidType${row.id}`)
                  .value,
                value: document.getElementById(`rowPaid${row.id}`).value,
              });
            } else {
              let id = document.getElementById(`rowPaidid${index}`).value;
              if (id) {
                // Pour un enregistrement existant (avec un id défini)
                payments.push({
                  id: id, // Stocker l'id dans l'objet
                  Booking_id,
                  type_paid: document.getElementById(`rowPaidType${index}`)
                    .value,
                  value: document.getElementById(`rowPaid${index}`).value,
                }); // Ajouter l'objet au tableau
              }
            }
          });
          let payments_filtred = payments.filter((item) => item !== undefined);
          let responseJSON = { booking_data: response.data };
          updatePayments(payments_filtred, responseJSON);
        }
        // Traitez la réponse ici
        showBanner(
          `<div class="flex flex-col">Evènement ajouté avec succès !</div>
              <div class="text-center">
                Du <b>${format_date(response.data.start)}</b> au <b>${format_date(response.data.end)}</b>
            </div>
            `,
          true
        );
        closeModal();
        setTimeout(() => {
          if (calendar) {
            console.log('Calendrier rechargé');
            calendar.refetchEvents();
          }
        }, 200);
      } else {
        // Gestion des erreurs de validation
        let errorMessages = "Erreur(s) lors de l'ajout";
        for (const field in response.error) {
          if (field.toLowerCase().includes('customer')) {
            errorMessages +=
              '<br><h2>Le champ : <u> Client</u> est manquant !</h2>';
            // Sélectionnez l'élément qui aura les classes ajoutées
            let Modalevent_Container_Customer_id = document.getElementById(
              'Modalevent_Container_Customer_id'
            );
            // Ajoutez les classes
            Modalevent_Container_Customer_id.classList.add(
              'border-2',
              'border-dashed',
              'border-red-500',
              'rounded-lg'
            );
            document.getElementById('ModaleventCustomer_id').focus();
          }
        }
        showBanner(errorMessages, false);
      }
    });
  } else {
    showBanner('Le formulaire est incomplet', false);
  }
}
