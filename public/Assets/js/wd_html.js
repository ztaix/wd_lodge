function applyScrollAnimation() {
  document.querySelectorAll('.scroll-container').forEach(container => {
    const textElement = container.querySelector('.scroll-text_smooth');
    if (textElement && textElement.offsetWidth > container.offsetWidth) {
      textElement.classList.add('animate-text');
    } else {
      textElement.classList.remove('animate-text');
    }
  });
}

function generateSearchRows(booking) {
  // MAX WIDTH 576px
  let startDate = format_date(booking.start.slice(0,10));
  let endDate = format_date(booking.end.slice(0,10));

  let Total_price = totalBookingPriceCal(booking.Price,booking.QtTraveller,booking.Tax,booking.Fee,booking.Qt);
  let status_paidObj = generateStatusPaid(booking.total_paid,Total_price);

  let html =`
  <div class="relative hover:border-l-4 hover:border-l-slate-200 rounded-lg border-b border-slate-200 dark:border-slate-800 border-dashed mx-1 mt-1 cursor-pointer" onclick="showBookingDetailsFromID('${booking.id}');">

    <div class="relative flex justify-between">

      <div class="relative w-auto mx-1 overflow-hidden whitespace-nowrap scroll-container">
        <div class="mx-1 text-lg font-bold scroll-text_smooth">${booking.customer_name}</div>
      </div>  
      
      <div class="flex items-center ml-2 text-slate-300 dark:text-slate-800 font-bold whitespace-nowrap">${booking.Type_doc.charAt(0)} #${booking.id}</div>

    </div>

      
    <div class="flex flex-grow flex-wrap text-slate-500">
    
      <div class="p-1 m-1 inline-flex justify-center items-center bg-slate-200 dark:bg-slate-800 rounded-lg whitespace-nowrap">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
          <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
        </svg>
        <span class="mx-1">${booking.QtTraveller}</span>
      </div>

      <div class="p-1 m-1 inline-flex justify-center items-center bg-slate-200 dark:bg-slate-800 rounded-lg whitespace-nowrap">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd" d="M11.7 2a10 10 0 1 0 9.8 13.3 1 1 0 0 0-1-1.3H20a8 8 0 0 1-7.6-10.6l.1-.4a1 1 0 0 0-.8-1Z" clip-rule="evenodd"/>
        </svg>
        <span class="mx-1">${booking.Qt}</span>
        <div class="flex justify-center items-center w-auto text-slate-400 dark:text-slate-600">
          <div class="px-2 justify-center items-center inline-flex">
            <div class=""> ${startDate}</div>
            <div class="">
              <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
              </svg>
            </div>
            <div class=""> ${endDate}</div>
          </div>
        </div>
      </div>

      <div class="p-1 m-1 inline-flex justify-center items-center ${booking.fullblocked == '0'? 'text-red-600 dark:text-red-200 bg-red-200 dark:bg-red-800':'bg-slate-200 dark:bg-slate-800'} rounded-lg whitespace-nowrap">
        <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
        </svg>
        <span class="mx-1">${booking.service_title}</span>
      </div>

      <div class="ml-auto p-1 m-1 inline-flex justify-center items-center bg-${status_paidObj.color}-200 dark:bg-${status_paidObj.color}-800 rounded-lg whitespace-nowrap">
        <svg class="w-4 h-4 text-${status_paidObj.color}-600 dark:text-${status_paidObj.color}-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17.3a5 5 0 0 0 2.6 1.7c2.2.6 4.5-.5 5-2.3.4-2-1.3-4-3.6-4.5-2.3-.6-4-2.7-3.5-4.5.5-1.9 2.7-3 5-2.3 1 .2 1.8.8 2.5 1.6m-3.9 12v2m0-18v2.2"/>
        </svg>
        <span class="mx-1">${status_paidObj.html} </span>
      </div>
      
    </div>

  </div>
  
  `;
        return html;
  }
  
  function generateStatusPaid(PAIDS,PRICE){
    let html = "";
    let color = "";
    let price = parseInt(PRICE); 
    let paids = parseInt(PAIDS); 
    if(paids >= price){
      html = "<b class='text-green-600 dark:text-green-200'>PAYÉ</b>"; 
      color = "green";
    }
    else if(paids > 0){
      html = "<b class='text-orange-600 dark:text-orange-200'>PARTIEL</b>"
      color = "orange";
    }
    else {
      html = "<b class='text-red-600 dark:text-red-200'>IMPAYÉ</b>";
      color = "red";
    }
    return {html,color};
  }

  function header_modal(title,modal_id){
    return html = `
    <div class="px-2 py-2 lg:px-8 flex justify-between items-center text-slate-500 bg-white border border-gray-200  dark:bg-gray-800 dark:border-gray-700 rounded-b-lg shadow-md " onclick="event.stopPropagation()">
      <div class="flex-grow text-center">
          <h3  class="text-center text-2xl font-bold text-gray-800 dark:text-white">${title}</h3>
      </div> 
      <div>
          <button type="button" class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('${modal_id}')">
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class=" sr-only">Fermer</span>
          </button>
      </div>
    </div>`;
  }

  function generateTable(data){
    //create function to generate html
  }


  

  /// A TRAVAILLER POUR AMELIORATION :

async function showBookingDetailsFromID(id) {
  openModal("DetailsEventModal", false);
  document.getElementById('header_DetailsEventModal').innerHTML = header_modal('Détails réservation','DetailsEventModal');
  let Booking;
  try {
    let response = await $.ajax({
      url: baseurl + "booking/getBookingFromID?id=" + id,
      method: "GET",
    });
    if (response && response.id == id) {

      let nDays = DaysDifferenceStartEnd(response.start,response.end);

      Booking = {
        id: response.id,
        Customer_id: response.Customer_id,
        Pdf_url: response.Pdf_url,
        Qt: response.Qt,
        QtTraveller: response.QtTraveller,
        Paid: response.Paid,
        Paids_ids: response.paids_ids,
        Types_paids: response.types_paids,
        Paids_values: response.paids_values,
        Price: response.Price,
        Tax: response.Tax,
        Fee: response.Fee,
        nDays: nDays,
        Service_id: response.Service_id,
        booking_img: response.img,
        fullblocked: response.fullblocked,
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
  let array_paids_values = Booking.Paids_values
    ? Booking.Paids_values.split(",").map(Number)
    : [0];
  let paids_sum = array_paids_values.reduce(
    (total, currentValue) => total + currentValue,
    0
  );
  let booking_details_h5 = document.getElementById("booking_details_id_h5");
  booking_details_h5.innerHTML = `<span class="text-md font-bold tracking-tight p-2" >${Booking.Type_doc} # ${Booking.id}</span> `;
  // Ajouter des classes qui ne dépendent pas de la condition
  booking_details_h5.classList.add('rounded-md');

  // Ajouter des classes basées sur la condition

  if (Booking.Type_doc === 'Devis') {
    booking_details_h5.classList.add('bg-slate-400','text-slate-800', 'dark:text-slate-500', 'dark:bg-slate-950');
  } else {
    booking_details_h5.classList.add('bg-sky-200', 'dark:bg-sky-800', 'text-sky-800', 'dark:text-sky-400');
  }
  existFile(baseurl + 'uploads/' + Booking.booking_img).then(fileExists => {
    if (fileExists) {
      document.getElementById("booking_details_img").src =  baseurl + 'uploads/' + Booking.booking_img;
    } else {
      document.getElementById("booking_details_div_img").classList.add("bg-gray-200");
      document.getElementById("booking_details_div_img").classList.add("rounded-t-lg");
      document.getElementById("booking_details_div_img").style.height =  "150px";
      document.getElementById("booking_details_div_img").innerHTML =  "<svg class='max-w-full max-h-full h-auto w-auto text-gray-300 dark:text-gray-600' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'><path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m4 12 8-8 8 8M6 10.5V19c0 .6.4 1 1 1h3v-3c0-.6.4-1 1-1h2c.6 0 1 .4 1 1v3h3c.6 0 1-.4 1-1v-8.5'/></svg>";
      }
});

  document.getElementById("booking_details_service_h5").innerText = Booking.service_title;
    let div_fullblocked = document.getElementById("booking_details_fullblocked_div");
    let h5_fullblocked = document.getElementById("booking_details_fullblocked_h5");
  if (Booking.fullblocked == 1) {
    div_fullblocked.classList.add('border-red-300','dark:border-red-500'),
    h5_fullblocked.style.display= "block";
    h5_fullblocked.innerText = "Privatisé";
  } else {
    div_fullblocked.classList.remove('border-red-300','dark:border-red-500');
    h5_fullblocked.style.display = "none";
  }
  document.getElementById("booking_details_qt_span").innerText = Booking.Qt;
  document.getElementById("booking_details_traveller_span").innerText =
    Booking.QtTraveller;
  document.getElementById("booking_details_start_span").innerText = Booking.start;
  document.getElementById("booking_details_end_span").innerText = Booking.end;
  document.getElementById("booking_details_price_span").innerHTML = totalBookingPriceCal(Booking.Price,Booking.QtTraveller,Booking.Tax,Booking.Fee,Booking.nDays) + " Fr";
  
  let details_paid_rest_div = document.getElementById('booking_details_progress_rest_div');
  if(parseInt(paids_sum) < totalBookingPriceCal(Booking.Price,Booking.QtTraveller,Booking.Tax,Booking.Fee,Booking.nDays)){
    details_paid_rest_div.innerText = totalBookingPriceCal(Booking.Price,Booking.QtTraveller,Booking.Tax,Booking.Fee,Booking.nDays)-parseInt(paids_sum) + " Fr";
  }
  else{
    details_paid_rest_div.classList.add('hidden');
  }
 
  let details_paid_div = document.getElementById('booking_details_progress_div');
  details_paid_div.innerText = paids_sum > 0 ? paids_sum + " Fr" : "0";
  if(paids_sum > 0){
      let convert_pourc = Math.min(Math.round((parseInt(paids_sum) / totalBookingPriceCal(Booking.Price,Booking.QtTraveller,Booking.Tax,Booking.Fee,Booking.nDays)) * 10000) / 100, 100);
      details_paid_div.style.width = convert_pourc > 24 ? convert_pourc+"%" : "24px";
  } else {details_paid_div.style.width = "24px"; }

  document.getElementById("booking_details_customer_name_span").innerText =
    Booking.customer_name;
  document.getElementById("booking_details_customer_block_toedit").onclick =
    (function (customerId) {
      return function () {
        showUpdateCustomer(customerId);
        if(!Booking.customer_comment){
        document.getElementById('customer_comment').focus()
        }
      };
    })(Booking.Customer_id);

  document.getElementById("booking_details_customer_phone_span").innerText =
    Booking.customer_phone;
  document.getElementById("booking_details_customer_email_span").innerText =
    Booking.customer_mail;
    if(Booking.customer_comment){
      document.getElementById("booking_details_customer_comment_span").innerHTML = Booking.customer_comment;
    }
    else{
      document.getElementById("booking_details_customer_comment_span").innerHTML = "<i>Vous pouvez ajouter un commentaire au client.</i>";
    }
  
  document.getElementById("booking_details_customer_created_span").innerText =
    "Client depuis " +
    new Date(Booking.customer_created)
      .toLocaleDateString("fr-FR", { year: "numeric", month: "long" })
      .replace(/^\w/, (c) => c.toUpperCase());
  document.getElementById("booking_details_created_span").innerHTML =
    "Créé le: " + format_date(Booking.created);
  document.getElementById("booking_details_updated_span").innerHTML =
    "Modifié le: " + format_date(Booking.updated);
    
    let child_Span_Comment = document.getElementById("booking_details_comment_span");
    let parent_Span_Comment = child_Span_Comment.parentElement;
    child_Span_Comment.innerText = Booking.Comment;
    if(Booking.Comment.length > 0 ){
      parent_Span_Comment.classList.remove('hidden'); 
    }else { 
      parent_Span_Comment.classList.add('hidden'); 
    }
  document.getElementById("booking_details_pdf").href =
    baseurl + "booking/generatePDF/booking/" + Booking.id;
  document.getElementById("booking_details_pdf").innerHTML =
    download_ico + " Télécharger PDF";
  document.getElementById("booking_details_sendmail").innerHTML =
    send_ico + "Envoyer EMAIL";

    document.getElementById("booking_details_sendmail").addEventListener("click", function(event) {
      event.preventDefault(); // Empêche le comportement par défaut du lien
      var loader = document.querySelector('.loader');
      loader.style.display = 'block';
      loader.style.zIndex = 999;
      // Requête AJAX pour envoyer l'e-mail
      $.ajax({
        url: baseurl + "booking/sendmail/" + Booking.id,
        method: "GET",
        success: function (response) {
          if (response.success === true) {
            showBanner('Ok envoyé', true);
            loader.style.display = 'none';
          } 
          else{
            showBanner('Erreur lors de l\'envoi', false);
            loader.style.display = 'none';
          }
        
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Erreur AJAX : ' + textStatus + ', ' + errorThrown);
            showBanner('Erreur lors de la connexion au serveur', false);
        }
        });
      
  });
  

  let button_update = document.getElementById("booking_details_update_button");
  button_update.onclick = function () {
    update_add_formEvent(Booking);
  };
  let button_delete = document.getElementById("booking_details_delete_button");
  button_delete.onclick = function (event) {
    deleteEvent(event, Booking.id, "DetailsEventModal");
  };
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
function deleteEvent(event, booking_id, modal_id = false) {
  event.stopPropagation(); // Empêche la propagation de l'événement au parent
  openModal("ConfirmDeleteModal");
  let modal = document.getElementById("ConfirmDeleteModal");
  modal.style.zIndex = "999";
  let yesconfirmButton = document.getElementById(
    "ConfirmDeleteModal_yes_button"
    );
    
    yesconfirmButton.onclick = function () {

      ajaxCall("booking/deleteBooking", "POST", { id: booking_id }, function(response) {
          if (response.success === true) {
            calendar.refetchEvents();
          
          // GESTIONNAIRE DE RETOUR D'AFFICHAGE
      if (ModalInStack("ListEventModal")) {
        row_type = "booking_list_row_";
        document.getElementById('booking_'+booking_id).classList.add("line-through");
        document.getElementById('badge_id_'+booking_id).style.cssText = 'background-color: gray;';
        document.getElementById('booking_a_'+booking_id).style.cssText = 'cursor : default;';
          
          let svgs = document.querySelectorAll('#booking_a_' + booking_id + ' svg');

          svgs.forEach(function(svg) {svg.style.color = 'gray';});

        document.getElementById('booking_list_row_hr_'+booking_id).classList.add("fade_out");

        
              setTimeout(() => {
                document.getElementById(row_type + booking_id).classList.add("fade_out");
              }, 200);
              setTimeout(() => {
                document.getElementById(row_type + booking_id).style.cssText = "display: none;";
              }, 700);
      } 
      
      showBanner("Suppression réalisée avec succès", true);
      closeModalById("ConfirmDeleteModal");


      if (modal_id) {
        closeModalById(modal_id);
      }
          
          }
      });
    };

    let noconfirmButton = document.getElementById("ConfirmDeleteModal_no_button");
    noconfirmButton.onclick = function () {
      closeModalById("ConfirmDeleteModal");
    };
}