// Liste des mois en français
var moisFrancais = [
  "janvier",
  "février",
  "mars",
  "avril",
  "mai",
  "juin",
  "juillet",
  "août",
  "septembre",
  "octobre",
  "novembre",
  "décembre",
];

let info_ico = `<svg class="w-4 h-4 mt-1 mr-1 text-slate-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
</svg>`;

let send_ico = `<svg class="w-4 h-4 mr-2 text-slate-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9"/>
</svg>`;
let download_ico = `<svg class="w-4 h-4 mr-2 text-slate-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 19">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15h.01M4 12H2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-3M9.5 1v10.93m4-3.93-4 4-4-4"/>
</svg>`;

function generateBookingElement(booking) {
  return `
        <div class="flex space-x-4 mt-" >
          <!-- Colonne 1 -->
          <div class="flex-grow">
            <div class="rounded-md text-white font-bold text-sm px-1 inline" style="background-color: ${
              booking.service_color
            }; ">#${booking.id}</div>
            
            <a href="#" onclick="showBookingDetailsFromID('${
              booking.id
            }');" class="text-blue-500 hover:underline ">${
    booking.customer_name + " - " + booking.service_title
  }</a>
            <div class="flex">${getDayOfWeek(
              format_date(booking.start)
            )} ${format_date(booking.start)} 
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
                },'ListEventModal',event)" class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
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
  openModal("ListEventModal");
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
  count_row_found = 0;
  response.forEach((booking) => {
    count_row_found++;
    /*encodeURIComponent(
        JSON.stringify(booking)
        )*/
    let bookingElement = `
        <div id="booking_list_row_${booking.id}" class="flex space-x-4 mt-1" >
          <!-- Colonne 1 -->
          <div class="flex-grow">
            <div class="rounded-md text-white font-bold text-sm px-1 mx-1 inline " style="background-color: ${
              booking.service_color
            }; ">
              # ${booking.id}
            </div>
            
            <a href="#" onclick="showBookingDetailsFromID('${
              booking.id
            }');" class="text-blue-500 hover:underline ">
              ${booking.customer_name + " - " + booking.service_title}
            </a>
            <div class="flex">
              ${getDayOfWeek(format_date(booking.start))} ${format_date(
      booking.start
    )} 
              <svg class="w-3 h-3 text-slate-500 dark:text-white" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
              </svg>${getDayOfWeek(format_date(booking.end))} ${format_date(
      booking.end
    )}
            </div>
          </div>
          <!-- Colonne 2 -->
          <div class="flex flex-wrap justify-end font-bold">
            <div class=" inline-flex" >
                <svg class="w-4 h-4 dark:text-white" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                </svg> ${booking.Price} Fr
            </div>
          </div>
        </div>
        <hr id="booking_list_row_hr_${booking.id}" class="my-2">
      `;
    container.innerHTML += bookingElement;
  });
  container.innerHTML += `          <div class="flex flex-wrap justify-end font-bold">
  <div id="booking_list_row_found" class="text-slate-400 inline-flex" >Réservation trouvé : ${count_row_found}</div></div>`;
}

function ShowCreateCustomer() {
  openModal("updateCustomerModal");
  document.getElementById("customer_id").value = "";
  document.getElementById("customer_name").value = "";
  document.getElementById("customer_phone").value = "";
  document.getElementById("customer_email").value = "";
  document.getElementById("customer_comment").value = "";
  document.getElementById("update_customer_submit_form").onclick = CreateCustomer;

}

function CreateCustomer() {
  var customerData = {
    Name: $("#customer_name").val(),
    Phone: $("#customer_phone").val(),
    Email: $("#customer_email").val(),
    Comment: $("#customer_comment").val(),
  };

  $.ajax({
    url: baseurl + `customer/create`,
    method: "POST",
    data: customerData,
    success: function (response) {
      try {
        if (response.status === "success") {
          var newCustomerId = response.id;
          $("#eventCustomer_id").append(
            new Option(customerData["Name"], newCustomerId, true, true)
          );

          // Génère la nouvelle ligne HTML
          var newCustomerRow = `<tr class="border-b dark:border-gray-700 row_customer_${newCustomerId}" data-id="${newCustomerId}" data-Name="${
            customerData["Name"]
          }" data-Comment="${customerData["Comment"]}" data-Email="${
            customerData["Email"]
          }" data-Phone="${
            customerData["Phone"]
          }" onclick="get_booking_list_from_customer(this)">
                  <th scope="row" class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white service_${newCustomerId} cursor-pointer"><b>${
            customerData["Name"]
          }</b></th>
                      <td class="px-3 py-3">${customerData["Email"]}</td>
                      <td class="px-3 py-3">${customerData["Phone"]}</td>
                      <td class="px-3 py-3 max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap customer_comment" id="comment_${newCustomerId}" onclick="toggleComment(event,  ${
            "comment_" + newCustomerId
          })">${customerData["Comment"]}</td>
                      <td class="px-3 py-3" onclick="DeleteCustomer(event, ${newCustomerId})">
                          <svg class="w-4 h-4 text-red-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                          </svg>
                      </td>
                  </tr>`;
          // Ajoute la nouvelle ligne au début du tbody
          $(newCustomerRow)
            .addClass("blinking")
            .insertBefore("#items-container tr:first");

          closeModalById('updateCustomerModal');
          showBanner(`Le client ${response.Name} a été créé avec succès`, true);
        } else {
          alert("Erreur : " + response.message);
          console.error("Erreurs de validation de données:", response.errors);
        }
      } catch (e) {
        console.error(
          "Erreur dans la fonction de création de client:",
          e.message
        );
      }
    },
  });
}

async function showUpdateCustomer(id) {
  openModal("updateCustomerModal", false);
  let customer;
  try {
    let response = await $.ajax({
      url: baseurl + `customer/get_customer_info?customer_id=${id}`,
      method: "GET",
      dataType: "json",
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
      console.error(
        `Échec get_customer_info: aucun enregistrement trouvé pour l'id : ${id}`
      );
      return; // Arrête la fonction ici si aucune donnée n'est trouvée
    }
  } catch (error) {
    console.error("Échec get_customer_info: ", error);
    console.error("Status Code:", error.status);
    console.error("Response Text:", error.responseText);

    return;
  }

  // Met à jour les champs du formulaire avec les données récupérées
  document.getElementById("customer_id").value = customer.customer_id;
  document.getElementById("customer_name").value = customer.name;
  document.getElementById("customer_phone").value = customer.phone;
  document.getElementById("customer_email").value = customer.email;
  document.getElementById("customer_comment").value = customer.comment;
  document.getElementById(
    "Update_customer_Modal_title"
  ).innerText = `Modifier Client #${customer.customer_id}`;

  let button_update = document.getElementById("update_customer_submit_form");
  button_update.onclick = function () {
    $.ajax({
      url: baseurl + "customer/update",
      method: "POST",
      data: {
        customer_info: {
          Customer_id: document.getElementById("customer_id").value,
          Name: document.getElementById("customer_name").value,
          Phone: document.getElementById("customer_phone").value,
          Email: document.getElementById("customer_email").value,
          Comment: document.getElementById("customer_comment").value,
        },
      },
      success: function (response) {
        if (response.status === "success") {

          setTimeout(function () {
            window.location.href = baseUrl + "Customers";
          }, 1000);
          showBanner("Modification réalisée avec succès", true);
        } else {
          showBanner("Échec de la modification", false);
        }
      },
    });
  };
  let button_delete = document.getElementById("delete_customer_submit_form");
  var data = {
    Customer_id: document.getElementById("customer_id").value,
    delete: true,
  };
  button_delete.onclick = function () {
    $.ajax({
      url: baseurl + "customer/update",
      method: "POST",
      data: {
        customer_info: data,  // Utilisez la variable locale ici
        },
      success: function (response) {
        if (response.status === "success") {
          showBanner("Suppression réalisée avec succès", true);
          closeModalById("updateCustomerModal");
          closeModalById("CustomerInfoModal");
          setTimeout(() => {
            $(".row_customer_" + data.Customer_id).addClass('fade_out');
            }, 200);
            setTimeout(() => {
              $(".row_customer_" + data.Customer_id).css('display', 'none');
            }, 700);
        } else {
          showBanner("Échec de la suppression", false);
        }
      },
    });
  };
}

function DeleteCustomer(event, id) {
  event.stopPropagation();
  var data = {
    Customer_id: id,
    delete: true,
  };
  $.ajax({
    url: baseurl + "customer/update",
    method: "POST",
    data: {
      customer_info: data,  // Utilisez la variable locale ici

    },
    success: function (response) {
      if (response.status === "success") {
        showBanner("Suppression réalisée avec succès", true);
        closeModalById("updateCustomerModal");
        closeModalById("CustomerInfoModal");
        setTimeout(() => {
          $(".row_customer_" + data.Customer_id).addClass('fade_out');
          }, 200);
          setTimeout(() => {
            $(".row_customer_" + data.Customer_id).css('display', 'none');
          }, 700);
      } else {
        showBanner("Échec de la suppression", false);
      }
    }
  });
}

async function showBookingDetailsFromID(id) {
  closeModal(false);
  openModal("DetailsEventModal", false);
  let event;
  try {
    let response = await $.ajax({
      url: baseurl + "booking/getBookingFromID?id=" + id,
      method: "GET",
    });
    if (response && response.id == id) {
      // Assurez-vous que cette condition est correcte
      event = {
        id: response.id,
        Customer_id: response.Customer_id,
        Pdf_url: response.Pdf_url,
        qt: response.qt,
        Paid: response.Paid,
        Price: response.Price,
        Service_id: response.Service_id,
        Type_doc: response.Type_doc,
        customer_name: response.customer_name,
        customer_phone: response.customer_phone,
        customer_mail: response.customer_mail,
        customer_created: response.customer_created,
        customer_comment: response.customer_comment,
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
      console.error(
        "Échec getBookingsFromID: aucun enregistrement trouvé pour l'id :" + id
      );
    }
  } catch (error) {
    console.error("Échec getBookingsFromID: ", error);
  }

  document.getElementById(
    "booking_details_id_h5"
  ).innerHTML = `<span class="text-sm  text-white rounded-md p-1 mr-1.5" style="background-color: ${event.service_color}">${event.Type_doc} # ${event.id}</span> `;
  document.getElementById("booking_details_service_h5").innerText =
    event.service_title;
  document.getElementById("booking_details_qt_span").innerText = event.qt;
  document.getElementById("booking_details_start_span").innerText = event.start;
  document.getElementById("booking_details_end_span").innerText = event.end;
  document.getElementById("booking_details_price_span").innerText =
    event.Price + " Fr";
  document.getElementById("booking_details_progress_div").style.width =
    event.Paid > 0
      ? Math.min(Math.round((event.Paid / event.Price) * 10000) / 100, 100) +
        "%"
      : "0";
  document.getElementById("booking_details_progress_div").innerText =
    event.Paid > 0 ? event.Paid + " Fr" : "";
  document.getElementById("booking_details_customer_name_span").innerText =
    event.customer_name;
  document.getElementById("booking_details_customer_name_span").onclick =
    function (event) {
      showUpdateCustomer(event.Customer_id);
    };

  document.getElementById("booking_details_customer_phone_span").innerText =
    event.customer_phone;
  document.getElementById("booking_details_customer_mail_span").innerText =
    event.customer_mail;
  document.getElementById("booking_details_customer_comment_span").innerHTML =
    event.customer_comment;
  document.getElementById("booking_details_customer_created_span").innerText =
    "Client depuis " +
    new Date(event.customer_created)
      .toLocaleDateString("fr-FR", { year: "numeric", month: "long" })
      .replace(/^\w/, (c) => c.toUpperCase());
  document.getElementById("booking_details_created_span").innerHTML =
    "Créé le: " + event.created;
  document.getElementById("booking_details_updated_span").innerHTML =
    "Modifié le: " + event.updated;
  document.getElementById("booking_details_comment_span").innerText =
    event.Comment;
  document.getElementById("booking_details_pdf").href =
    baseUrl + "booking/generatePDF/booking/" + event.id;
  document.getElementById("booking_details_pdf").innerHTML =
    download_ico + " Télécharger " + event.Type_doc;
  document.getElementById("booking_details_sendmail").innerHTML =
    send_ico + "Envoyer " + event.Type_doc + "/ EN CONSTRUCTION";
  document.getElementById("booking_details_sendmail").href = 
  baseUrl + "booking/sendmail/" + event.id;
  //baseUrl + "booking/sendmail/" + event.id;

  let button_update = document.getElementById("booking_details_update_button");
  button_update.onclick = function () {
    update_add_formEvent(event);
  };
  let button_delete = document.getElementById("booking_details_delete_button");
  button_delete.onclick = function () {
    deleteEvent(event, "DetailsEventModal");
  };
}

// SIDEBOX //////

function get_service_list() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: baseurl + "booking/getServicesBookings", // URL de mise à jour
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
  let Comment = data.getAttribute("data-Comment");
  let tbody = document.getElementById("CustomerDetailsContainer");
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

  // Variables pour stocker les sommes totales
  let totalPaid = 0;
  let totalPrice = 0;

  $.ajax({
    url: baseurl + "booking/getBookingsFromCustomer",
    method: "GET",
    data: {
      customer_id: customer_id,
    },
    success: function (response) {
      response.forEach(function (booking) {
        // Mise à jour des sommes totales
        totalPaid += parseFloat(booking.Paid);
        totalPrice += parseFloat(booking.Price);

        let newRow = document.createElement("tr");
        newRow.classList.add(
          "bg-white",
          "border-b",
          "dark:bg-gray-800",
          "dark:border-gray-700",
          "booking-row",
          "cursor-pointer" // Ajout de la classe spécifique
        );
        newRow.setAttribute("data-booking-id", booking.id); // Ajout de l'ID de la réservation comme attribut

        newRow.innerHTML = `
                <th scope="row" class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                  booking.service_title
                }</th>
                <td class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">${format_date(
                  booking.start,
                  0,
                  true
                )} <svg class="w-2 h-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
              </svg> ${format_date(booking.end, 0, true)}</td>
                <td class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                  booking.Paid
                }</td>
                <td class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
                  booking.Price
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
      let customer_finance_total = document.getElementById(
        "modal-title_customer_finance_total"
      );
      customer_finance_total.innerHTML = `
        <div class="text-center py-4 lg:px-4 w-full">
        <div class="customer-container w-full inline-flex items-center justify-between px-1 py-1 pr-4 text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 mb-2">
        <a onclick="showUpdateCustomer(${customer_id})" class="customer-link text-blue-500 hover:underline">
            <span class="customer-name text-md flex bg-blue-600 rounded-full text-white px-3 py-1.5 mr-3">
                <span class="mr-2">Modifier</span>
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
              Total encaissé 
              </div>
              <div class="grow bg-slate-300 rounded-full dark:bg-gray-700">
              <div class=" text-white bg-blue-600  rounded-full" style="width: ${current_pourc_paid}%">${
        totalPaid > 0 ? totalPaid + " Fr" : 0
      } </div>
              </div>
              
              </div>
              
              <div class="flex w-full text-slate-400  my-4 text-left">
              ${Comment}</div>
            </div>`;
    },
  });
}
// Fonction pour charger et initialiser le datepicker avec des dates réservées
function loadAndInitDatepicker(service_id) {
  
  $.ajax({
    url: baseurl + 'booking/available/'+service_id,
    method: 'GET',
    success: function (bookings) {
      const bookedDates = bookings.map(booking => {
        const start = booking.start
        const color = booking.backgroundColor
        const type_doc = booking.type_doc
        const status = booking.status
        const paid = booking.paid
        const price = booking.price
        return [start, color, type_doc,status,paid,price];
        
      });
     const bookedDatesFormatted = bookedDates.map(dateArr => {
       const [day, month, year] = dateArr[0].split('-');
       return `${year}-${month}-${day}`;
      });
      // Après avoir reçu les données, initialisez le picker d'Easepick avec ces données
      fromServicepicker = new easepick.create({
        element: document.getElementById('startEvent'),
        css: [
          'css/wd_datepicker.css',
        ],
        firstDay: 1, // 0 - Sunday, 1 - Monday, 2 - Tuesday
        grid: 1, // Number of calendar columns
        calendars: 1, // Number of visible months.
        opens: 'top',
        plugins: ['RangePlugin','LockPlugin'],
        RangePlugin: {        
            elementEnd: "#eventEnd",
          tooltipNumber(num) {
            return num -1;
          },
          locale: {
            one: 'Nuit',
            other: 'Nuits',
          }
        },
        zIndex: 99,
        lang: "fr-FR",
        format: "DD-MM-YYYY",
        LockPlugin: {
          minDate: new Date(), // Les réservations ne peuvent pas être faites dans le passé.
          minDays: 2, // Nombre minimum de jours pouvant être sélectionnés.
          inseparable: true, // Les jours sélectionnés doivent former une plage continue.
          filter(date, picked) {
            return bookedDatesFormatted.includes(date.format('DD-MM-YYYY'));
          },
        },
        setup(fromServicepicker) {
          // Création d'un objet pour stocker le type de document par date
          const status = {};
          bookedDates.forEach(([Date,Color ,TypeDoc ,Status,Paid,Price]) => {
            status[Date] = Status; // Stocker "Devis" ou "Facture"
          });
        
          // Ajouter le type de document à l'élément du jour
          fromServicepicker.on('view', (evt) => {
            const { view, date, target } = evt.detail;
            const formattedDate = date ? date.format('YYYY-MM-DD') : null;
        
            if (view === 'CalendarDay' && status[formattedDate]) {
              const span = target.querySelector('.day-docType') || document.createElement('span');
              span.className = 'day-docType';
              span.innerHTML = status[formattedDate]; // Afficher "Devis" ou "Facture"
              target.append(span);
            }
          });
        }
        
        
        
      });

      fromServicepicker.on('select', function(event) {
        // Récupérer les dates de début et de fin
        const startDate = new Date(event.detail.start); // Adaptez ces lignes en fonction de la structure de `event.detail`
        const endDate = new Date(event.detail.end); // Adaptez ces lignes en fonction de la structure de `event.detail`

        // Calculer la différence en jours
        const timeDifference = endDate.getTime() - startDate.getTime();
        const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));

        // Mettre à jour le champ 'eventQt'
        document.getElementById('eventQt').value = dayDifference;

        // Réinitialiser le flag puisque la mise à jour vient du datepicker et non de l'utilisateur
        userChangedPrice = false;

        updatePrice();
    });

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Erreur lors de la récupération des dates réservées: ' + textStatus, errorThrown);
    }
  });
}

// TOOLBOX
function getDayOfWeek(dateString) {
  let [day, month, year] = dateString.split("-");
  let date = new Date(year, month - 1, day);
  let dayOfWeek = date.getDay();

  let days = [
    "Dimanche",
    "Lundi",
    "Mardi",
    "Mercredi",
    "Jeudi",
    "Vendredi",
    "Samedi",
  ];

  return days[dayOfWeek];
}
function format_date(input_date, daysToAdd = 0, shorter = false) {
  let result = ``;

  // Convertit la date en un objet Date de JavaScript
  let dateObj = new Date(input_date);

  // Ajuste pour le fuseau horaire de la Polynésie française (UTC-10)
  dateObj.setHours(dateObj.getHours() - 10);

  // Ajoute des jours si nécessaire
  dateObj.setDate(dateObj.getDate() + daysToAdd);

  // Récupère le jour, le mois et l'année
  let day = String(dateObj.getDate()).padStart(2, "0");
  let month = String(dateObj.getMonth() + 1).padStart(2, "0"); // Les mois sont de 0 à 11
  let year = dateObj.getFullYear();

  if (shorter == true) {
    result = shortenYearInDate(`${day}-${month}-${year}`);
  } else {
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
  let parts = date.split("-");
  let yearShort = parts[2].substring(2); // Prend les deux derniers chiffres de l'année
  return `${parts[0]}-${parts[1]}-${yearShort}`;
}
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
