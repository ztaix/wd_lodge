// Liste des mois en français
const moisFrancais = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin","Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];

let info_ico = `<svg class="w-4 h-4 mt-1 mr-1 text-slate-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
</svg>`;

let send_ico = `<svg class="w-4 h-4 mr-2 text-slate-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9"/>
</svg>`;
let download_ico = `<svg class="w-4 h-4 mr-2 text-slate-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 19">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15h.01M4 12H2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-3M9.5 1v10.93m4-3.93-4 4-4-4"/>
</svg>`;

//Ferme dernière modal sur l'appui du ESC
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeModal(); // ferme la dernière fenêtre modale ouverte
  }
});

document.addEventListener("DOMContentLoaded", function() {
  
  // Vérifie si l'utilisateur est sur la page de connexion
  var onLoginPage = window.location.pathname.endsWith('/auth') || window.location.href.includes('/auth');
  var token = localStorage.getItem('token');

  // Stocker l'URL courante comme la dernière page visitée avant de quitter la page
  window.addEventListener('beforeunload', () => {
    localStorage.setItem('lastPage', window.location.href);
  });
    // Si l'utilisateur n'est pas sur la page de connexion et qu'aucun token n'est trouvé
    if (!onLoginPage && !token) {
      // Rediriger vers la page de connexion
      window.location.href = baseurl + 'auth';
      return; // Stopper l'exécution supplémentaire du script
  }

  // Code spécifique pour la page de connexion
  if (onLoginPage) {
      var loginForm = document.getElementById('loginForm');
      
      if (loginForm) {
          loginForm.addEventListener('submit', function(e) {
              e.preventDefault();

              // Création d'un objet JavaScript à partir des données du formulaire
              var formDataObj = {};
              var formData = new FormData(loginForm);
              formData.forEach(function(value, key) {
                  formDataObj[key] = value;
              });

              // Appel de la fonction ajaxCall pour se connecter
              ajaxCall('auth/verif', 'POST', formDataObj, function(response) {
                  // Parsez la réponse JSON reçue
                  if (response.jwt) {
                      // Stockez le JWT dans le localStorage ou les cookies
                      localStorage.setItem('token', response.jwt);
                      // Redirigez l'utilisateur vers la page d'accueil ou le tableau de bord
                      showBanner('Connexion réussi',true);
                      setTimeout(() => { window.location.href = baseurl; }, 1500);

                  } else {
                      // Gérez les erreurs, par exemple en affichant un message à l'utilisateur
                      alert(response.error ? response.error : 'Échec de la connexion');
                  }
                  
              }, function(xhr, status, error) {
               
                if (typeof errorCallback === 'function') {
                  errorCallback(xhr, status, error ? error : "Erreur inconnue");
                } else {
                  console.error("Erreur lors de la requête AJAX :", status, error ? error : "Erreur inconnue");
                  reject(xhr);
                }
                alert('Échec de la requete de connexion : ' + error);
              });
          });
      }
  }
  else{
    let extend ='';
    document.getElementById('footer_ttl').addEventListener('click', function(e) {
      e.preventDefault();
      extend = "?extend=true";
  });
    ajaxCall('auth/verifyToken'+extend, 'GET', null, function(response) {
      console.log('response',response);
      if(response.success){
        localStorage.setItem('timeLeft',response.timeLeft);
        //TTL Token

        // Démarrer le compte à rebours lors du chargement de la page ou après la mise à jour du token
        startTokenCountdown();
      }
      else{
        showBanner(response.message,false);
      }
        // Traiter la réponse positive (le token est valide)
      }, function(xhr, status, error) {

        console.error('Token invalide ou erreur lors de la vérification:', error);
        // Traiter la réponse négative (le token est invalide ou autre erreur)
    });

  }
});

  
function logout() {
  // Supprimer le token du localStorage
  localStorage.removeItem('token');
    // Faites un appel AJAX pour informer le serveur de supprimer le cookie
    ajaxCall('auth/logout', 'GET', null, function(response) {
      console.log(response.message);
      // Redirigez l'utilisateur vers la page de login ou la page d'accueil après la déconnexion
      window.location.href = baseurl + 'auth';
  }, function(xhr, status, error) {
      console.error('Erreur lors de la déconnexion:', error);
      // Traitez l'erreur éventuelle ici
  });
}


// Fonction pour afficher les détails dans la modal
function showBookingList(response, clickedDate) {
  const dateComponents = clickedDate.split("-"); // ["2023", "10", "27"]
  const newDateStr = [
    dateComponents[2],
    dateComponents[1],
    dateComponents[0],
  ].join("/");
  
  let modalTitle = document.getElementById("modal-title")
  let container = document.getElementById("bookingListContainer");
  
  container.innerHTML = ""; 
  modalTitle.innerHTML = getDayOfWeek(format_date(newDateStr)) + ' ' + newDateStr;
  
// Supposons que newDateStr contienne la date du jour au format "YYYY-MM-DD"
const newDateStr2 = new Date().toISOString().split('T')[0];

response.sort((a, b) => {
  // Extraire les dates de début et de fin, et les convertir au format "YYYY-MM-DD"
  let startA = a.start.split(' ')[0];
  let startB = b.start.split(' ')[0];
  let endA = a.end.split(' ')[0];
  let endB = b.end.split(' ')[0];
  
  // Comparer les dates de début avec la date du jour
  let isStartTodayA = startA === newDateStr2;
  let isStartTodayB = startB === newDateStr2;
  
  if (isStartTodayA && !isStartTodayB) return -1; // a commence aujourd'hui, b non
  if (!isStartTodayA && isStartTodayB) return 1;  // b commence aujourd'hui, a non
  
  // Si les deux commencent ou ne commencent pas aujourd'hui, comparer les dates de fin
  let isEndTodayA = endA === newDateStr2;
    let isEndTodayB = endB === newDateStr2;

    if (isEndTodayA && !isEndTodayB) return -1; // a se termine aujourd'hui, b non
    if (!isEndTodayA && isEndTodayB) return 1;  // b se termine aujourd'hui, a non
    
    // Si les deux se terminent ou ne se terminent pas aujourd'hui, comparer les titres de service
    let serviceTitleA = a.service_title.toLowerCase();
    let serviceTitleB = b.service_title.toLowerCase();
    
    if (serviceTitleA < serviceTitleB) return -1; // a vient avant b dans l'ordre alphabétique
    if (serviceTitleA > serviceTitleB) return 1;  // a vient après b dans l'ordre alphabétique
    
    return 0; // a et b sont équivalents
  });
  
    
  let count_row_found = 0;
  response.forEach((booking) => {
    count_row_found++;
    let Checkin = clickedDate == booking.start.slice(0,10);
    let Checkout = clickedDate == booking.end.slice(0,10);

    let array_paids_values = booking.paids_values
    ? booking.paids_values.split(",").map(Number)
    : [0];

  let paids_sum = array_paids_values.reduce(
    (total, currentValue) => total + currentValue,
    0
  );
  let TOTALprice = totalBookingPriceCal(booking.Price,booking.QtTraveller,booking.Tax,booking.Fee,booking.nDays);  


  let status_paidObj = generateStatusPaid(paids_sum,TOTALprice);

    let bookingElement = `
        <div id="booking_list_row_${booking.id}" class="group flex flex-col px-4 rounded-t-lg text-slate-700 dark:text-white hover:bg-white-50 dark:hover:bg-black-50 border-b-2 hover:rounded-none border-slate-300 dark:border-slate-700" >
          <!-- Colonne 1 -->
          ${booking.fullblocked == 1 ? '<span class="relative text-red-400 dark:text-red-700 px-2 mx-auto capitalize">Privatisé</span>':''}

          <div class="w-full flex-col group ${booking.fullblocked == 1 ? 'p-1 border-t-2 border-red-400 dark:border-red-700 rounded-lg':''}">
            
            <div class="flex justify-between">
              <div id='booking_${booking.id}' onclick="showBookingDetailsFromID('${booking.id}');" class="flex flex-wrap cursor-pointer font-bold">
              
                <div id="booking_title_${booking.id}" class="flex flex-initial transition-margin hover:mx-2 text-slate-800 dark:text-white">
                ${booking.service_title }
                ${ Checkin == true ? '&nbsp;<b class="blink text-cyan-700">CHECK-IN </b>': ''} 
                ${ Checkout == true ? '&nbsp;<b class="blink text-amber-800 ">CHECK-OUT </b> ': ''} 
                </div>

              </div>
              <div class="font-bold ">
                <span id='badge_type_${booking.id}'>${booking.Type_doc}</span>
                # 
                <span id='badge_id_${booking.id}'>${booking.id}</span>
              </div>
            </div>
            <div class="w-full inline-flex">
              <div class="w-full flex flex-wrap items-center justify-between cursor-pointer" onclick="showBookingDetailsFromID('${booking.id}');">
                <div class="flex-col">
                  <div class="text-base "><span class="font-semibold text-slate-500 ">Client:</span> <span id="booking_customer_${booking.id}">${booking.customer_name}</span></div>
                  <div class="text-base"><span class="font-semibold text-slate-500 ">Nb personne:</span> <span id="booking_QtTraveller_${booking.id}">${booking.QtTraveller}</span></div>
                </div>
                <div class="m-1">
                  <div class="w-full inline-flex items-center justify-between text-xs text-slate-500 ">
                    <span class="items-center" id="booking_startDay_${booking.id}">${getDayOfWeek(format_date(booking.start))}</span>
                    <span class="items-center">${'<b>'+DaysDifferenceStartEnd(booking.start,booking.end) + ' nuit(s) </b>'}</span>
                    <span class="items-center" id="booking_endDay_${booking.id}">${getDayOfWeek(format_date(booking.end))}</span>
                  </div>
                  <div class="w-full inline-flex items-center justify-between ">
                    <span class="items-center" id="booking_start_${booking.id}"> ${format_date(booking.start,0,'DD/MM')}</span>
                    <svg class="w-3 h-3" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                    <span class="items-center" id="booking_end_${booking.id}">${format_date(booking.end,0,'DD/MM')}</span>
                  </div>
                </div>
              </div>

              <div class="flex flex-col grow items-end text-right font-bold ml-2">
                
                <div class="flex flex-col justify-end rounded-lg px-1">
                  <div class="inline-flex justify-end items-center" >
                      <span class="mr-1 text-xs text-slate-500">Tarif</span> 
                      <span id="booking_total_${booking.id}">${TOTALprice }</span>
                      <span class="ml-1 text-xs">Fr</span>

                  </div>
                  <div class="inline-flex justify-end items-center" >
                    <span class="mr-1 text-xs text-slate-500">Encaissé</span>   
                    <span class="font-bold" id="booking_paid_${booking.id}">${paids_sum}</span>
                    <span class="ml-1 text-xs">Fr</span>
                  </div>
                  <div class="inline-flex justify-end items-center" >
                    <span class="font-bold" id="booking_paid_status_${booking.id}">${status_paidObj.html}</span>
                  </div>
                </div>

                <div class="relative mt-1 group">
                  <a id="booking_a_${
                    booking.id
                  }" href="#" class="text-red-400 hover:text-red-600 dark:text-red-500 hover:dark:text-red-800" 
                  onclick="deleteEvent(event, '${booking.id}','ListEventModal')" >
                    <span class="absolute opacity-0 mt-1 right-10 group-hover:opacity-100 group-hover:right-6 transition-all ease-in-out duration-300 text-xs ">Supprimer</span>
                    <svg  class="flex justify-center items-center  w-6 h-6  transition-transform duration-300 scale-100 group-hover:scale-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                  </a>
                </div>

              </div>
            </div>
          `;
          // Partie Commentaire
          let comment_display = 'hidden';
          if(booking.Comment){
            comment_display = 'block';
          }
            bookingElement += `
              <div class="flex ${comment_display} flex-col text-xs bg-slate-50 group-hover:bg-slate-100 dark:bg-slate-900 dark:group-hover:bg-slate-800 rounded-xl border border-dashed border-slate-200 group-hover:border-slate-100 dark:border-slate-950 dark:group-hover:border-slate-900 mt-1 p-2">
                <span class="mr-1 text-xs text-slate-400 dark:text-slate-500">Commentaire: </span>   
                <span id="booking_Comment_${booking.id}">${booking.Comment} </span>
              </div>`;

          bookingElement += `
              </div>
            </div>
          `;
    container.innerHTML += bookingElement;
  });
  container.innerHTML += `          
    <div class="flex flex-wrap justify-end font-bold rounded-b-lg border-b-2 dark:bg-black-50 border-slate-300 dark:border-slate-900 text-slate-400 dark:text-slate-600">
      <div id="booking_list_row_found" class="inline-flex p-2" >Réservation trouvé : ${count_row_found}</div>
    </div>`;
 
    let availableServices = availableListServices(newDateStr,services_list,response); 
    

  let h1 = document.getElementById('ListEventModal').querySelector('h1');
  let parentH1 = h1.parentElement;
  // Si il existe encore des service de disponible
  if(availableServices.length > 0){
    container.innerHTML += `          
    <div class="p-2 flex flex-wrap justify-start font-bold text-slate-400 dark:text-slate-500">
      <div id="booking_list_row_found" class="inline-flex " >Disponible: </div>
    </div>`;
    availableServices.forEach((service, index) => {
        container.innerHTML += `
        <div class="px-2 flex justify-between">
            <div class="flex flex-grow">
                ${service.Title}
            </div>  
            <div class="flex">
                <a href="#" class="add-event-link" data-index="${index}" data-date="${format_date(newDateStr)}" data-service-id="${service.Service_id}">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4.2a1 1 0 1 0-2 0V11H7.8a1 1 0 1 0 0 2H11v3.2a1 1 0 1 0 2 0V13h3.2a1 1 0 1 0 0-2H13V7.8Z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
    `;
      });


    document.querySelectorAll('.add-event-link').forEach(link => {
      link.addEventListener('click', (event) => {
          event.preventDefault(); // Empêche le lien de naviguer
          const index = link.getAttribute('data-index');
          const date = link.getAttribute('data-date');
          const serviceId = link.getAttribute('data-service-id');
          handleAddEventClick(date, serviceId);
      });
    });

    h1.innerHTML  = "<b>Ajouter une réservation</b>";
    parentH1.classList.add('cursor-pointer');
    parentH1.onclick = () => handleAddEventClick(newDateStr,availableServices[0].Service_id);

    // Si aucun services disponible
  }else{
      h1.innerHTML  = "<b>Complet</b>";
      parentH1.classList.remove('cursor-pointer');
      parentH1.onclick = null;
    }
      
    openModal("ListEventModal");
}

function ShowCreateCustomer(customerName ="" , callback) {

  document.getElementById('header_updateCustomerModal').innerHTML = header_modal('Client','updateCustomerModal');
  document.getElementById("customer_id").value = "";
  document.getElementById("customer_name").value = customerName; // Préremplit le nom du client
  document.getElementById("customer_phone").value = "";
  document.getElementById("customer_email").value = "";
  document.getElementById("customer_comment").value = "";

  openModal("updateCustomerModal");
  // Modifie l'action du bouton de soumission pour appeler CreateCustomer avec un callback
  document.getElementById("customer_name").focus(); // Préremplit le nom du client
  
  setupButtonAction(callback);
}

function CreateCustomer(callback) {
  var customerData = {
    Name: $("#customer_name").val(),
    Phone: $("#customer_phone").val(),
    Email: $("#customer_email").val(),
    Comment: $("#customer_comment").val(),
  };
   ajaxCall("customer/create", "POST", { data: customerData }, function(response) {
     if (response.success === true) {
          let d = response.data;
          /* d : {
            Comment: STRING
            Email: STRING
            Name: STRING
            Phone: STRING
            id: INT
          }*/
          // Appelle le callback avec la réponse pour créer la nouvelle option dans le select
          if(callback && typeof callback === "function") {
          callback(d); // Passez l'objet de réponse au callback
          }
          if(window.location.href.includes('Customers')){
              // Génère la nouvelle ligne HTML
              var newCustomerRow = `<tr class="border-b dark:border-gray-700 row_customer_${d.id}" data-id="${d.id}" data-Name="${
                  customerData["Name"]
                }" data-Comment="${customerData["Comment"]}" data-Email="${
                  customerData["Email"]
                }" data-Phone="${
                  customerData["Phone"]
                }" onclick="get_booking_list_from_customer(this)">
                        <th scope="row" class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white service_${d.id} cursor-pointer"><b>${
                  customerData["Name"]
                }</b></th>
                <td class="px-3 py-3">${d.Email}</td>
                <td class="px-3 py-3">${d.Phone}</td>
                            <td class="px-3 py-3 max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap customer_comment" id="comment_${d.id}" onclick="toggleComment(event,  ${
                  "comment_" + d.id
                })">${d.Comment}</td>
                      <td class="px-3 py-3" onclick="DeleteCustomer(event, ${d.id})">
                          <svg class="w-4 h-4 text-red-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                          </svg>
                      </td>
                  </tr>`;
          
            // Ajoute la nouvelle ligne au début du tbody
            $(newCustomerRow)
              .addClass("blinking")
              .insertBefore("#items-container tr:first");
          }

          if(ModalInStack('updateCustomerModal')){
            closeModalById("updateCustomerModal");
          }

          showBanner(`Le client ${d.Name} a été créé avec succès`, true);
        } else {
          showBanner(response.error,false);
          console.error("Erreurs de validation de données:", response.errors);
        }
      });
  }

function showUpdateCustomer(id) {
  openModal("updateCustomerModal", false);
  document.getElementById('header_updateCustomerModal').innerHTML = header_modal('Client','updateCustomerModal');

  let customer;

    ajaxCall(`customer/get_customer_info?customer_id=${id}`, "GET", null, function(response) {
        if (response.success === true) {
          customer = {
            customer_id: response.data.Customer_id,
            name: response.data.Name,
            phone: response.data.Phone,
            email: response.data.Email,
            comment: response.data.Comment,
          };
          updateCustomersFormFields(customer);
          return customer;
        }
        else{
          console.error(
            `Échec get_customer_info: aucun enregistrement trouvé pour l'id : ${id}`
          );
          return;
        }
    });
  
}





function Deletepaid(ids) {
  let idsArray = Array.isArray(ids) ? ids : [ids];

  // Supprimer les éléments avec un ID commençant par 'temp'
  idsArray.forEach((id) => {
    if (typeof id === 'string' && id.startsWith('temp')) {
      var element = document.getElementById(id);
      if (element) {
        element.remove(); // Supprimer directement l'élément
      }
    }
  });
  // Filtrer les IDs pour ne conserver que ceux ne commençant pas par 'temp'
  let nonTempIds = idsArray.filter(id => typeof id === 'string' && !id.startsWith('temp'));

  // Continuer avec la requête AJAX uniquement si il reste des IDs à traiter
  if (nonTempIds.length > 0) {

    ajaxCall("paids/delete", "POST", { ids: nonTempIds }, function(response) {
        if (response.success === true) {
          showBanner("Suppression réussi", true);
          Object.keys(response.data).forEach((key) => {
            if (response.data[key]) {
              var element = document.getElementById(key);
              if (element) {
                element.remove(); // Supprimer directement l'élément
              }
            }
          });
        } else {
          showBanner("Échec de la suppression", false);
        }
    });
    
  }
}

function DeleteCustomer(event, id) {
 event.stopPropagation();
  openModal("ConfirmDeleteModal");

  let modal = document.getElementById("ConfirmDeleteModal");
  modal.style.zIndex = "999";
  let yesconfirmButton = document.getElementById(
    "ConfirmDeleteModal_yes_button"
  );

  yesconfirmButton.onclick = function () {
    var data = {
      Customer_id: id,
      delete: true,
    };

    ajaxCall("customer/update", "POST", { customer_info: data }, function(response) {
        if (response.success === true) {
          showBanner("Suppression réalisée avec succès", true);
          if(ModalInStack('updateCustomerModal')){
            closeModalById("updateCustomerModal");
          }
          if(ModalInStack('CustomerInfoModal')){
            closeModalById("CustomerInfoModal");
          }

          closeModalById("ConfirmDeleteModal");

          setTimeout(() => {
            $(".row_customer_" + data.Customer_id).addClass("fade_out");
          }, 200);
          setTimeout(() => {
            $(".row_customer_" + data.Customer_id).css("display", "none");
          }, 700);
        }
        else {
          showBanner("Échec de la suppression", false);
        }
    });
  }

  let noconfirmButton = document.getElementById("ConfirmDeleteModal_no_button");
  noconfirmButton.onclick = function () {
    closeModalById("ConfirmDeleteModal");
  };

}

// SIDEBOX //////

function get_booking_list_from_customer(data) {
  openModal("CustomerInfoModal");
  document.getElementById('header_CustomerInfoModal').innerHTML = header_modal('Client','CustomerInfoModal');

  let customer_id = data.getAttribute("data-id");
  let table_th = document.getElementById("CustomerInfoModal_th");
  let tbody = document.getElementById("CustomerInfoModal_tbody");

  // Gestionnaire d'événements délégués pour les lignes de tableau avec la classe "booking-row"
  tbody.addEventListener("click", function (event) {
    if (event.target.classList.contains("booking-row")) {
      // Récupérer l'ID de la réservation depuis l'attribut data-booking-id
      const bookingId = event.target.getAttribute("data-booking-id");

      // Appeler la fonction showBookingDetailsFromID avec l'ID de la réservation
      showBookingDetailsFromID(bookingId);
    }
  });
  tbody.innerHTML = "";

  let totalPaid = 0;
  let totalPrice = 0;
  ajaxCall("booking/getBookingsFromCustomer", "GET", {customer_id: customer_id, Type_doc: "Facture"}, function(response) {

    if (!emptyObj(response.customers) && response.success) {
      table_th.style.visibility = 'visible';

    // Traiter la réponse
      let bookings = response.bookings; // Les réservations
      let customerInfo = response.customers; // Les informations du client

      bookings.forEach(function (booking) {
        // Mise à jour des sommes totales
        let array_paids_values = booking.paids_values
        ? booking.paids_values.split(",").map(Number)
        : [0];
      let paids_sum = array_paids_values.reduce(
        (total, currentValue) => total + currentValue,
        0
      );
      
      totalPaid += paids_sum;
      totalPrice += totalBookingPriceCal(booking.Price,booking.QtTraveller,booking.Tax,booking.Fee,booking.Qt);
      let rowPaid = paids_sum
      let rowPrice = totalBookingPriceCal(booking.Price,booking.QtTraveller,booking.Tax,booking.Fee,booking.Qt);
        let newRow = document.createElement("tr");
        newRow.classList.add(
          "hover:bg-slate-50",
          "dark:shover:bg-slate-700",
          "booking-row",
          "cursor-pointer" // Ajout de la classe spécifique
        );
        // Ensuite, ajouter la classe conditionnelle
        if (response.bookings.length > 1) {
          newRow.classList.add("border-b");
        }
        newRow.setAttribute("data-booking-id", booking.id); // Ajout de l'ID de la réservation comme attribut

        newRow.innerHTML = `
                <td scope="row" class="pl-3 py-3 text-center whitespace-nowrap">
                  ${booking.Type_doc.charAt(0)} #${booking.id}
                </td>
                <th scope="row" class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  ${booking.service_title}
                </th>
                <td class="whitespace-nowrap overflow-hidden flex flex-col justify-center items-center" >
                <div>${booking.Qt} Nuit(s)</div>  
                  <div class="scroll-text inline-flex">
                      <div clas="flex">${format_date(booking.start,0,true)}</div>
                      <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                        </svg>
                      </div>
                      <div clas="flex">${format_date(booking.end,0,true)}</div>
                  </div>
                  </td>
                <td class="px-3 py-3 text-center ">${
                  rowPaid
                }</td>
                <td class="px-3 py-3 text-center">${
                  rowPrice
                }</td>
            `;

        // Ajouter un événement onclick
        newRow.onclick = function () {
          showBookingDetailsFromID(booking.id);
        };
        tbody.appendChild(newRow);
      });

      let current_pourc_paid = Math.min(
        Math.round((totalPaid / totalPrice) * 10000) / 100,
        100
      );

      document.getElementById("history_customer_block_toedit").onclick = (function (customer_id) {
        return function () {
            showUpdateCustomer(customer_id);
        };
    })(customer_id); // Assurez-vous que 'customer_id' est défini et accessible ici
    
        document.getElementById('history_customer_name_span').innerText = customerInfo.Name;
        document.getElementById('history_customer_email_span').innerText = customerInfo.Email;
        document.getElementById('history_customer_phone_span').innerText = customerInfo.Phone;
        document.getElementById('history_customer_comment_span').innerText = customerInfo.Comment;
        document.getElementById('history_customer_created_span').innerText = customerInfo.Created_at;

      let customer_finance_total = document.getElementById(
        "modal-title_customer_finance_total"
      );
      customer_finance_total.innerHTML = `
        <div class="text-center py-4 lg:px-4 w-full">
          <div class="customer-container w-full inline-flex items-center justify-center flex-wrap px-1 py-1 pr-4 text-gray-700  dark:text-white mb-2">
            <span class="text-md font-bold text-blue-700 dark:text-white">Total Facture : ${totalPrice.toLocaleString('fr-FR')} Fr</span>
          </div>

    
              <div class="flex justify-between font-bold text-xs mx-4" >
              <div class="flex flex-grow-0 mr-3 text-slate-500"> 
              <svg class="w-3 h-3 text-slate-700  dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.905 1.316 15.633 6M18 10h-5a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h5m0-5a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1m0-5V7a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h15a1 1 0 0 0 1-1v-3m-6.367-9L7.905 1.316 2.352 6h9.281Z"/>
              </svg>
              Total encaissé 
              </div>
              <div class="grow bg-slate-300 rounded-full dark:bg-gray-700">
              <div class=" text-white bg-blue-600  rounded-full" style="width: ${current_pourc_paid}%">${
        totalPaid > 0 ? totalPaid.toLocaleString('fr-FR') + " Fr" : 0
      } </div>
              </div>
              
              </div>
              
            </div>`;

      if(response.error){
        table_th.style.visibility = 'hidden';
        let thElements = table_th.querySelectorAll('th');
        let thcount = thElements.length;
        let newRow = document.createElement("tr");
        newRow.classList.add(
          "booking-row",
          "text-center",
          "font-bold"
        );
        newRow.innerHTML = 
        `<td  colspan="${thcount}">
          <div class="flex justify-center items-center">
              <svg class="w-10 h-10 text-gray-400 dark:text-slate-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 4h-13m13 16h-13M8 20v-3.3c0-.5.1-.9.4-1.2l1.6-2.9a1 1 0 0 0 0-1.2L8.4 8.5A2 2 0 0 1 8 7.3V4h8v3.3c0 .5-.1.9-.4 1.2L14 11.4a1 1 0 0 0 0 1.2l1.6 2.9c.3.3.4.7.4 1.2V20H8Z"/>
              </svg>
          </div>
          <div class="flex justify-center items-center my-2">
            ${response.error}
          </div>
        </td>`;
        tbody.appendChild(newRow);

      }
    }
    else{
      showBanner(response.error,false);
    }
  });

}


function getPaidFromBookingId(booking_id) {
  // Utilisez directement ajaxCall avec les paramètres nécessaires
  return ajaxCall("paids/bookings/" + booking_id, "GET", null)
    .then(paids => {
      return paids; // Cette ligne est en fait optionnelle ici, car `.then(paids => paids)` est redondant
    })
    .catch(error => {
      // Logique en cas d'erreur
      console.error("Erreur lors de la récupération des paids: ", error);
      throw error; // Propager l'erreur pour une gestion ultérieure
    });
}




function createPaymentHtml(paid, index, lenght) {
  let payements_class = "";
  if (lenght === 1) {
    payements_class = [
      "rounded-tl-lg rounded-bl-lg",
      "rounded-tr-lg rounded-br-lg",
    ];
  } else if (lenght === 2) {
    if (index === 0) {
      payements_class = ["rounded-tl-lg", "rounded-tr-lg"];
    } else {
      payements_class = ["rounded-bl-lg", "rounded-br-lg "];
    }
  } else {
    if (index === 0) {
      payements_class = ["rounded-tl-lg", "rounded-tr-lg "];
    } else if (index === lenght - 1) {
      payements_class = ["rounded-bl-lg", "rounded-br-lg"];
    } else {
      payements_class = ["", ""];
    }
  }
  return `
  <div id="${paid.paid_id}" class="flex payment-row mt-2">
      <input type="hidden" id="rowPaidid${index}" value="${
    paid.paid_id
  }" name="rowPaidid${index}">
      <div class=" inline-flex  items-center w-fit bg-red-50 border border-red-300 hover:bg-red-400  dark:bg-red-700 dark:hover:bg-red-900 rounded-lg mx-1 my-0.5 p-2 cursor-pointer" onclick="Deletepaid('${
        paid.paid_id
      }')"> X </div>
      <select id="rowPaidType${index}" name="rowPaidType${index}" class="${
    payements_class[0]
  } inline-flex items-center py-2.5 px-4 text-sm font-bold text-center text-gray-500 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600">
          <option value="ESPECE" ${
            paid.type_paid === "ESPECE" ? "selected" : ""
          }>ESPECE</option>
          <option value="VIREMENT" ${
            paid.type_paid === "VIREMENT" ? "selected" : ""
          }>VIREMENT</option>
          <option value="VISA" ${
            paid.type_paid === "VISA" ? "selected" : ""
          }>VISA</option>
          <option value="AMEX" ${
            paid.type_paid === "AMEX" ? "selected" : ""
          }>AMEX</option>
          <option value="CHEQUE" ${
            paid.type_paid === "CHEQUE" ? "selected" : ""
          }>CHEQUE</option>
      </select>
      <input type="number" pattern="[0-9]*" value="${
        paid.value
      }" inputmode="numeric" id="rowPaid${index}" name="rowPaid${index}" class="${
    payements_class[1]
  }  block w-full text-md text-gray-900 bg-transparent border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
      <label for="rowPaid${index}" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 translate-x-40 top-0 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-5 left-1">Encaissement </label>
  </div>
`;
}


// Fonction pour charger et initialiser le datepicker avec des dates réservées
function loadAndInitDatepicker(service_id, start_date = false, end_date = false) {
  return new Promise((resolve, reject) => {
    var loader = document.querySelector('.loader');
    loader.style.display = 'block';
    loader.style.zIndex = 99;
    // Si un datepicker existe déjà, retirez-le avant de créer un nouveau
    if (fromServicepicker) {
      fromServicepicker.destroy();
    }
    ajaxCall("booking/datepicker/" + service_id + "/true", "GET", null, function(bookings) {
        if (bookings.success === true) {
          let d = bookings.data;
            // Traiter la réponse en cas de succès

          let bookedDates = Object.keys(d).map((key) => {
          let booking = d[key];
          let hasFirstDay = Object.values(booking.details_bookings).some(obj => obj.is_first_day === true);
          let hasLastDay = Object.values(booking.details_bookings).some(obj => obj.is_last_day === true);
          let date = booking.start;
          let fullblocked = booking.fullblocked;

          return [date, fullblocked, hasFirstDay, hasLastDay];
          });


          let filteredBookedDates = bookedDates.filter(([date, fullblocked, hasFirstDay, hasLastDay]) => !hasFirstDay && !hasLastDay);

          let bookedDatesFormatted = filteredBookedDates.map((dateArr) => {
            let [day, month, year] = dateArr[0].split("-");
            return `${year}-${month}-${day}`;
          });

          // Après avoir reçu les données, initialisez le picker d'Easepick avec ces données
          fromServicepicker = new easepick.create({
            element: document.getElementById("ModaleventDatepicker"),
            css: ["css/wd_datepicker.css"],
            firstDay: 1, // 0 - Sunday, 1 - Monday, 2 - Tuesday
            grid: 1, // Number of calendar columns
            calendars: 1, // Number of visible months.
            opens: "top",
            autoApply: true,
            header:
              `<b>
              ${document.getElementById("ModaleventService_id").options[
                document.getElementById("ModaleventService_id").selectedIndex
              ].textContent}
              </b>         
              <!-- <span id="toggleLockIcon" style="cursor: pointer;">🔒</span>-->

              `,
              zIndex: 99,
            lang: "fr-FR",
            format: "DD-MM-YYYY",
            
            plugins: ["RangePlugin", "LockPlugin"],
            
            LockPlugin: {
              minDate: new Date(), // Les réservations ne peuvent pas être faites dans le passé.
              minDays: 1, // Nombre minimum de jours pouvant être sélectionnés.
              inseparable: false, // Les jours sélectionnés doivent former une plage continue.
              filter(date, picked) {
                //TRAVAIL de selection à faire car pour éviter la surréservation
                return bookedDatesFormatted.includes(date.format("DD-MM-YYYY"));
              },
            },
            RangePlugin: {
              tooltipNumber(num) {
                return num - 1;
              },
              locale: {
                one: "Nuit",
                other: "Nuits",
              },
              
            },

            onShow(instance) {
              let header = document.getElementById("datepicker-header");
              let pickerElem = instance.picker.outerNode;
              pickerElem.insertBefore(header, pickerElem.firstChild);

            },
            setup(fromServicepicker) {
              let daytoShow = {};

              bookedDates.forEach(([Date, Fullblocked, hasFirstDay, hasLastDay]) => {
                if (!daytoShow[Date]) {
                  daytoShow[Date] = {};
                }
                daytoShow[Date]["fullblocked"] = Fullblocked;
                daytoShow[Date]["FirstDay"] = hasFirstDay;
                daytoShow[Date]["LastDay"] = hasLastDay;
              });
              
              
              // Ajouter le type de document à l'élément du jour
              fromServicepicker.on("view", (evt) => {
                let { view, date, target } = evt.detail;
                let formattedDate = date ? date.format("YYYY-MM-DD") : null;
                
                if (view === "CalendarDay" && daytoShow[formattedDate]) {
                  let span1;
                  let span2;
                  let FirstDay = daytoShow[formattedDate]['FirstDay'];
                  let LastDay = daytoShow[formattedDate]['LastDay'];
                  let existingSpan;

                  if (FirstDay && !LastDay) {       
                    existingSpan = target.querySelector(".start-date-triangle");
                    if (!existingSpan) {
                      span1 = document.createElement("span");
                      span1.className = "day-unavailable start-date-triangle";
                      span1.innerHTML += `<svg class="w-2 h-2 text-slate-500 dark:text-white"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>`;
                      target.append(span1);
                    }
                  }
                  else if(!FirstDay && LastDay){
                    existingSpan = target.querySelector(".end-date-triangle");
                    if (!existingSpan) {
                      span1 = document.createElement("span");
                      span1.className = "day-unavailable end-date-triangle";
                      span1.innerHTML += `<svg class="w-2 h-2 text-slate-500 dark:text-white"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>`;

                      target.append(span1);
                    }
                  }
                  else if(FirstDay && LastDay){
                    existingSpan = target.querySelector(".start-date-triangle .end-date-triangle");
                    if (!existingSpan) {
                      span1 = document.createElement("span");
                      span1.className = "day-unavailable start-date-triangle";
                      span1.innerHTML = `<svg class="w-2 h-2 text-slate-500 dark:text-white"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>`;
                      target.append(span1);
                      span2 = document.createElement("span");
                      span2.className = "day-unavailable end-date-triangle";
                      span2.innerHTML = `<svg class="w-2 h-2 text-slate-500 dark:text-white"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>`;
                      target.append(span2);
                    }else{
                      alert('existingSpan FirstDay && LastDay');
                    }
                  }
                  
                }
              });


            },
          });

          if (start_date && end_date) {
            fromServicepicker.setStartDate(start_date);
            fromServicepicker.setEndDate(end_date);
          }
  
          fromServicepicker.on("select", function (event) {
            // Récupérer les dates de début et de fin
            //const startDate = new Date(event.detail.start); 
            //const endDate = new Date(event.detail.end);

            // Calculer la différence en jours
            let dayDifference = DaysDifferenceStartEnd(event.detail.start,event.detail.end);

            // Mettre à jour le champ 'eventQt'
            document.getElementById("ModaleventQt").value = dayDifference;
            document.getElementById("ModaleventNights").innerText = dayDifference + ' Nuit(s)';

            // Réinitialiser le flag puisque la mise à jour vient du datepicker et non de l'utilisateur
            userChangedPrice = false;

            updateTotalInfo();
            updatePrice();

          });

          updateTotalInfo();
          updatePrice();
          
          loader.style.display = 'none';
          resolve(fromServicepicker); 
      }
    }); //End ajaxCall

  });
}
