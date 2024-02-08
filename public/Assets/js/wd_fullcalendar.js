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
                    document.getElementById('booking_paid_'+booking_id).innerText = encaissement ;
                    document.getElementById('booking_paid_status_'+booking_id).innerText = 
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
              document.getElementById("ModaleventCustomer_id").focus();
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

