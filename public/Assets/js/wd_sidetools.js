const download_ico = `<svg class="w-4 h-4 text-pink-200 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"/>
</svg>`;
const sendmail_ico = `<svg class="w-4 h-4 mr-1 text-emerald-200 dark:text-white"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
<path d="M14 7h-1.5V4.5a4.5 4.5 0 1 0-9 0V7H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-5 8a1 1 0 1 1-2 0v-3a1 1 0 1 1 2 0v3Zm1.5-8h-5V4.5a2.5 2.5 0 1 1 5 0V7Z"/>
</svg>`;
const lock_ico = `<svg class="w-4 h-4 mr-1 text-gray-500 dark:text-white"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
<path d="M14 7h-1.5V4.5a4.5 4.5 0 1 0-9 0V7H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-5 8a1 1 0 1 1-2 0v-3a1 1 0 1 1 2 0v3Zm1.5-8h-5V4.5a2.5 2.5 0 1 1 5 0V7Z"/>
</svg>`;
const unlock_ico = `<svg class="w-3 h-3 mr-1 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 8V4.5a3.5 3.5 0 1 0-7 0V8M8 12.167v3M2 8h12a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1Z"/>
</svg>`;
const created_ico = `<svg class="w-3 h-3 text-slate-300  dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
<path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z"/>
</svg>`;
const updated_ico = `<svg class="w-3 h-3 text-slate-300  dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
<path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"/>
<path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"/>
</svg>`;



function generateBookingElement(booking) {

 return  `
        <div class="flex space-x-4 mt-" >
          <!-- Colonne 1 -->
          <div class="flex-grow">
            <div class="rounded-md text-white font-bold text-sm px-1 inline" style="background-color: ${
              booking.service_color
            }; ">#${booking.id}</div>
            
            <a href="#" onclick="showBookingDetailsFromID('${booking.id}');" class="text-blue-500 hover:underline ">${
      booking.customer_name +' - '+booking.service_title
    }</a>
            <div class="flex">${getDayOfWeek(format_date(booking.start))} ${format_date(booking.start)} 
                <svg class="w-3 h-3 text-slate-500 dark:text-white" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>${getDayOfWeek(format_date(booking.end))} ${format_date(
      booking.end
    )}</div>
          </div>
          <!-- Colonne 2 -->
          <div class="flex flex-wrap justify-end font-bold">
            <div class="svg-delete text-right">
                <svg onclick="deleteEvent(${
                        booking.id
                    },'ListEventModal')" class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
            </div>
            <div class="flex w-full  justify-end" >
                <svg class="w-4 h-4 dark:text-white" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                </svg> ${booking.Price} Fr
            </div>
          </div>
        </div>
        <hr class="my-2">
      `;
}

// Fonction pour afficher les détails dans la modal
function showBookingList(response, clickedDate) {
  openModal('ListEventModal');
  let container = document.getElementById("bookingListContainer");
  container.style.display = "block";
  container.innerHTML = ""; // Efface les anciennes données

  // Place la date dans le titre
  const dateComponents = clickedDate.split("-"); // ["2023", "10", "27"]
  const newDateStr = [
    dateComponents[2],
    dateComponents[1],
    dateComponents[0],
  ].join("/");
  document.getElementById("modal-title").innerHTML = newDateStr;
  response.forEach((booking) => {
    /*encodeURIComponent(
        JSON.stringify(booking)
        )*/
    let bookingElement = `
        <div class="flex space-x-4 mt-1" >
          <!-- Colonne 1 -->
          <div class="flex-grow">
            <div class="rounded-md text-white font-bold text-sm px-1 inline " style="background-color: ${
              booking.service_color
            }; ">#${booking.id}</div>
            
            <a href="#" onclick="showBookingDetailsFromID('${booking.id}');" class="text-blue-500 hover:underline ">${
      booking.customer_name +' - '+booking.service_title
    }</a>
            <div class="flex">${getDayOfWeek(format_date(booking.start))} ${format_date(booking.start)} 
                <svg class="w-3 h-3 text-slate-500 dark:text-white" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>${getDayOfWeek(format_date(booking.end))} ${format_date(
      booking.end
    )}</div>
          </div>
          <!-- Colonne 2 -->
          <div class="flex flex-wrap justify-end font-bold">
            <div class="svg-delete text-right">
                <svg onclick="deleteEvent(${
                        booking.id
                    },'ListEventModal')" class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
            </div>
            <div class="flex  justify-end" >
                <svg class="w-4 h-4 dark:text-white" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                </svg> ${booking.Price} Fr
            </div>
          </div>
        </div>
        <hr class="my-2">
      `;
      container.innerHTML += bookingElement;
  });
}

async function showUpdateCustomer(id) {
    openModal("updateCustomerModal", false);
    let customer;
    try {
        let response = await $.ajax({
          url: baseurl + `/customer/get_customer_info?customer_id=${id}`,
          method: "GET",
          dataType: "json"
        });
        if (response && response.id == id) {

            customer = {
                customer_id: response.Customer_id,
                name: response.Name,
                phone: response.Phone,
                email: response.Email,
                comment: response.Comment,
            };
        } else {
            console.error(`Échec get_customer_info: aucun enregistrement trouvé pour l'id : ${id}`);
            return;  // Arrête la fonction ici si aucune donnée n'est trouvée
        }
    } catch (error) {
        console.error("Échec get_customer_info: ", error);
        console.error("Status Code:", error.status);
        console.error("Response Text:", error.responseText);

        return;
    }
    // Met à jour les champs du formulaire avec les données récupérées
    document.getElementById('customer_id').value = customer.customer_id;
    document.getElementById('customer_name').value = customer.name;
    document.getElementById('customer_phone').value = customer.phone;
    document.getElementById('customer_email').value = customer.email;
    document.getElementById('customer_comment').value = customer.comment;
    document.getElementById('Update_customer_Modal_title').innerText = `Modifier Client #${customer.customer_id}`;

    let button_update = document.getElementById('update_customer_submit_form');
    button_update.onclick = function() {
        $.ajax({
            url: baseurl + '/customer/update',
            method: 'POST',
            data: {
                customer_info: {
                    Customer_id: document.getElementById('customer_id').value,
                    Name: document.getElementById('customer_name').value,
                    Phone: document.getElementById('customer_phone').value,
                    Email: document.getElementById('customer_email').value,
                    Comment: document.getElementById('customer_comment').value,
                }
            },
            success: function(response) {
                if (response.status === 'success') {
                    showBanner('Modification réalisée avec succès', true);
                    closeModalById('updateCustomerModal');
                    closeModalById('CustomerInfoModal');
                } else {
                    showBanner('Échec de la modification', false);
                }
            }
        });
    };
    let button_delete = document.getElementById('delete_customer_submit_form');
    button_delete.onclick = function() {
        $.ajax({
            url: baseurl + '/customer/update',
            method: 'POST',
            data: {
                customer_info: {
                    Customer_id: document.getElementById('customer_id').value,
                    delete: true
                }
            },
            success: function(response) {
                if (response.status === 'success') {
                    showBanner('Suppression réalisée avec succès', true);
                    closeModalById('updateCustomerModal');
                    closeModalById('CustomerInfoModal');
                } else {
                    showBanner('Échec de la suppression', false);
                }
            }
        });
    };
}


async function showBookingDetailsFromID(id) {
    closeModal(false);
    openModal("DetailsEventModal", false);
    let event;
    try {
        let response = await $.ajax({
          url: baseurl + 'booking/getBookingFromID?id=' + id,
          method: "GET",
        });
        if (response && response.id == id) {  // Assurez-vous que cette condition est correcte
            event = {
                id: response.id,
                Customer_id: response.Customer_id,
                Pdf_url: response.Pdf_url,
                Paid: response.Paid,
                Price: response.Price,
                Service_id: response.Service_id,
                Type_doc: response.Type_doc,
                customer_name: response.customer_name,
                Comment: response.Comment,
                service_color: response.service_color,
                service_title: response.service_title,
                start: format_date(response.start),
                end: format_date(response.end),
                Deleted_at: response.Deleted_at,
                created: response.Created_at,
                updated: response.updated_at,
            };
        } else {
            console.error("Échec getBookingsFromID: aucun enregistrement trouvé pour l'id :" + id);
        }
    } catch (error) {
      console.error("Échec getBookingsFromID: ", error);
    }

  
      document.getElementById('booking_details_title_h5').innerHTML = `<span class="text-sm  text-white rounded-md p-1 mr-1.5" style="background-color: ${event.service_color}"># ${event.id}</span> ` + event.service_title;
      document.getElementById('booking_details_start_span').innerText = event.start;
      document.getElementById('booking_details_end_span').innerText = event.end;
      document.getElementById('booking_details_paid_span').innerText = event.Paid + ' Fr';
      document.getElementById('booking_details_price_mark').innerText = event.Price + ' Fr';
      document.getElementById("booking_details_price_mark").style.backgroundColor  = event.service_color;
      document.getElementById("booking_details_progress_div").style.width  = Math.min(Math.round((event.Paid / event.Price) * 10000) / 100, 100)+'%';
      document.getElementById("booking_details_progress_div").innerText  = Math.min(Math.round((event.Paid / event.Price) * 10000) / 100, 100) +'%';
      document.getElementById('booking_details_customer_name_span').innerText = event.customer_name;
      document.getElementById('booking_details_customer_name_span').innerText = event.customer_name;
      document.getElementById('booking_details_type_doc_div').innerHTML = (event.Type_doc === 'Facture' ? lock_ico : unlock_ico) + ' ' +event.Type_doc;
      document.getElementById('booking_details_created_span').innerHTML = created_ico + event.created;
      document.getElementById('booking_details_updated_span').innerHTML = updated_ico + event.updated;
      document.getElementById('booking_details_comment_span').innerText = event.Comment;
      document.getElementById('booking_details_pdf').href =  baseUrl + "generatePDF/booking/" + event.id;
      document.getElementById('booking_details_pdf').innerHTML =  download_ico + "Télécharger " + event.Type_doc;
      document.getElementById('booking_details_sendmail').innerHTML =  sendmail_ico + "Envoyer " + event.Type_doc;
          
  
      let button_update = document.getElementById('booking_details_update_button');
      button_update.onclick = function() { update_add_formEvent(event); };
      let button_delete = document.getElementById('booking_details_delete_button');
      button_delete.onclick = function() { deleteEvent(event.id,'DetailsEventModal'); };
  }

function update_add_formEvent(data){

        openModal('addEventModal',false);
        // Changer le texte du bouton et son action pour l'ajout
        let submitButton = document.getElementById('add_submit_form');
        submitButton.onclick = function() { updateEventFromDetails(); }; // Ajouter un nouvel événement
        if(data){
            console.log(data);
        document.getElementById('addEventModal_title').innerText = `Modifier #${data.id}`    
        updateDate(data.start);
        let form = document.getElementById('eventForm');
        form.elements['id'].value = data.id;
        form.elements['eventCustomer_id'].value = data.Customer_id;
        form.elements['eventService_id'].value = data.Service_id;
        form.elements['eventPrice'].value = data.Price;
        form.elements['eventPaid'].value = data.Paid;
        form.elements['eventType_doc'].value = data.Type_doc;
        form.elements['eventComment'].value = data.Comment;
        form.elements['startEvent'].value = data.start;
        form.elements['eventEnd'].value = data.end;
        }
}

function showBookingDetails_fromhistory(response) {
  let id = response.getAttribute("data-id");
  let serviceTitle = response.getAttribute("data-service_title");
  let serviceId = response.getAttribute("data-Service_id");
  let start = response.getAttribute("data-start");
  let end = response.getAttribute("data-end");
  let customerId = response.getAttribute("data-Customer_id");
  let customerName = response.getAttribute("data-customer_name");
  let paid = response.getAttribute("data-Paid");
  let price = response.getAttribute("data-Price");
  let typeDoc = response.getAttribute("data-Type_doc");
  let pdfUrl = response.getAttribute("data-Pdf_url");
  let service_color = response.getAttribute("data-service_color");

  openModal("DetailsEventModal");


  // Ajout du titre et de la couleur
  let titleElement = document.getElementById("modal-title_details_booking");
  titleElement.innerHTML = `<span style="border-radius: 10px; background-color:${service_color}">&nbsp;</span>`;
  titleElement.innerHTML += `<a href="#" class="hover:underline;">${customerName}</a>`;
  titleElement.innerHTML += `<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">`;
  titleElement.innerHTML += `${format_date(
    start
  )}<svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg> ${format_date(
    end
  )}</span>`;

  // Créer un nouvel élément div pour contenir les détails de la réservation

  let newRow = document.createElement("tr");
        newRow.classList.add(
          "bg-white",
          "border-b",
          "dark:bg-gray-800",
          "dark:border-gray-700"
        );
        newRow.innerHTML = `
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                    serviceTitle
                }</th>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${format_date(
                    typeDoc
                )} - ${format_date(booking.end)}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                    paid
                }</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                    price
                }</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Action</td>
            `;
        tbody.appendChild(newRow);

}
// SIDEBOX //////

function get_service_list() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: baseurl + '/booking/getServicesBookings', // URL de mise à jour
      method: "GET",
      success: function (response) {
        if (response) {
          resolve(response);
        } else {
          reject("Échec get_service_list::");
        }
      },
    });
  });
}

function findColorServiceById(id) {
  return new Promise((resolve, reject) => {
    get_service_list()
      .then((response) => {
        for (let i = 0; i < response.length; i++) {
          if (response[i].Service_id === id.toString()) {
            // Assurez-vous que les types correspondent

            return resolve(response[i].Color);
          }
        }
        reject("Aucune correspondance trouvée"); // Si aucune correspondance n'est trouvée
      })
      .catch((error) => {
        reject(error); // Propager l'erreur
      });
  });
}

function get_booking_list_from_customer(data) {
  closeModal();
  openModal("CustomerInfoModal");
  let customer_id = data.getAttribute("data-id");
  let Name = data.getAttribute("data-Name");
  let tbody = document.getElementById("CustomerDetailsContainer");
  tbody.innerHTML = "";

  // Variables pour stocker les sommes totales
  let totalPaid = 0;
  let totalPrice = 0;

  $.ajax({
    url: baseurl + 'booking/getBookingsFromCustomer',
    method: "GET",
    data: {
      customer_id: customer_id,
    },
    success: function (response) {
      response.forEach(function (booking) {
        // Mise à jour des sommes totales
        totalPaid += parseFloat(booking.Paid);
        totalPrice += parseFloat(booking.Price);
        let current_pourc_paid = Math.min(Math.round((totalPaid / totalPrice) * 10000) / 100, 100); 
  
        // Mise à jour du titre du modal avec les sommes totales
        //     <a href="#" onclick="showBookingDetailsFromID('${booking.id}');" class="text-blue-500 hover:underline ">${
    
        let customer_finance_total = document.getElementById("modal-title_customer_finance_total");
        customer_finance_total.innerHTML = `<div class="text-center py-4 lg:px-4 w-full">
              <div class="w-full inline-flex items-center justify-between px-1 py-1 pr-4 text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 mb-2">
              <a href="#" onclick="showUpdateCustomer('${customer_id}');" class="text-blue-500 hover:underline ">
                    <span class="text-md flex bg-blue-600 rounded-full text-white px-3 py-1.5 mr-3">
                        <svg class="w-5 h-5 mr-2 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 18">
                            <path d="M7 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm2 1H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                        </svg> 
                        ${Name}
                    </span>
                </a>
                  <span class="text-md font-bold text-blue-700 dark:text-white">Total ${totalPrice} Fr</span>
              </div>
              <div class="flex justify-between font-bold text-xs" >
                <div class="flex flex-grow-0 mr-3 text-slate-500"> 
                <svg class="w-3 h-3 text-slate-700  dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.905 1.316 15.633 6M18 10h-5a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h5m0-5a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1m0-5V7a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h15a1 1 0 0 0 1-1v-3m-6.367-9L7.905 1.316 2.352 6h9.281Z"/>
                </svg>
                    Encaissé 
                </div>
                <div class="grow bg-slate-300 rounded-full dark:bg-gray-700">
                    <div class=" text-white bg-blue-600  rounded-full" style="width: ${current_pourc_paid}%">${totalPaid>0?totalPaid+' Fr':0} </div>
                </div>
              
              </div>
              
            </div>`;
        let newRow = document.createElement("tr");
        newRow.classList.add(
          "bg-white",
          "border-b",
          "dark:bg-gray-800",
          "dark:border-gray-700"
        );
        newRow.innerHTML = `
                <th scope="row" class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                  booking.service_title
                }</th>
                <td class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">${format_date(
                  booking.start
                  ,0,true)} <svg class="w-2 h-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
              </svg> ${format_date(booking.end,0,true)}</td>
                <td class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                  booking.Paid
                }</td>
                <td class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                  booking.Price
                }</td>
            `;
        tbody.appendChild(newRow);
      });

    },
  });


}

function getDayOfWeek(dateString) {
    let [day, month, year] = dateString.split("-");
    let date = new Date(year, month - 1, day);
    let dayOfWeek = date.getDay();
  
    let days = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
  
    return days[dayOfWeek];
  }
  function format_date(input_date, daysToAdd = 0, shorter = false) {
    let result = ``;
    // Convertit la date en un objet Date de JavaScript
    let dateObj = new Date(input_date);
  
    // Ajoute des jours si nécessaire
    if (daysToAdd !== 0) {
      dateObj.setDate(dateObj.getDate() + daysToAdd );
    } else {
      dateObj.setDate(dateObj.getDate() + daysToAdd );
    }
  
    // Récupère le jour, le mois et l'année
    let day = String(dateObj.getDate()).padStart(2, "0");
    let month = String(dateObj.getMonth() + 1).padStart(2, "0"); // Les mois sont de 0 à 11
    let year = dateObj.getFullYear();
    if(shorter == true){
        result =  shortenYearInDate(`${day}-${month}-${year}`);
    }
    else{
        result = `${day}-${month}-${year}`;
    }

    // Formatte la date en JJ-MM-AA'AA'
    return result;
  }
  function format_date_toSql(input_date) {
    // Découpe la date en ses composantes (jour, mois, année)
    let [day, month, year] = input_date.split("-");
  
    // Recompose la date au format souhaité
    return `${year}-${month}-${day} 00:00:00`;
  }
  function shortenYearInDate(date) {
    let parts = date.split('-');
    let yearShort = parts[2].substring(2); // Prend les deux derniers chiffres de l'année
    return `${parts[0]}-${parts[1]}-${yearShort}`;
  }  
  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

