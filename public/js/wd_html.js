//Permet de controler le status d'édition, si en cours ou non
let GlobalEDITING_book = false;

function applyScrollAnimation() {
  document.querySelectorAll('.scroll-container').forEach((container) => {
    const textElement = container.querySelector('.scroll-text_smooth');
    if (textElement && textElement.offsetWidth > container.offsetWidth) {
      textElement.classList.add('animate-text');
    } else {
      textElement.classList.remove('animate-text');
    }
  });
}

// START SEARCH MODULE
function generateSearchRows(booking, index) {
  // MAX WIDTH 576px
  let startDate = format_date(booking.start.slice(0, 10));
  let endDate = format_date(booking.end.slice(0, 10));

  let Total_price = totalBookingPriceCal(
    booking.Price,
    booking.QtTraveller,
    booking.Tax,
    booking.Fee,
    booking.Qt
  );
  let status_paidObj = generateStatusPaid(booking.total_paid, Total_price);

  const bgColorClass =
    index % 2 === 0
      ? 'bg-slate-100 hover:bg-yellow-100 dark:bg-slate-900 dark:hover:bg-yellow-400'
      : 'text-white hover:text-black bg-white hover:bg-yellow-100 dark:bg-slate-950 dark:hover:bg-yellow-400';

  let html = `
  <div class="relative ${bgColorClass} rounded-t-lg border-b dark:border-b-slate-900 p-2 cursor-pointer" onclick="showBookingDetailsFromID('${booking.id}');">

    <div class="relative flex justify-between">

      <div class="relative w-auto mx-1 overflow-hidden whitespace-nowrap scroll-container">
        <div class="mx-1 text-lg font-bold scroll-text_smooth">${booking.customer_name}</div>
      </div>  
      
      <div class="flex items-center ml-2 text-slate-400 dark:text-slate-700 font-bold whitespace-nowrap">${booking.Type_doc.charAt(0)} #${booking.id}</div>

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

      <div class="p-1 m-1 inline-flex justify-center items-center ${booking.fullblocked == '0' ? 'text-red-600 dark:text-red-200 bg-red-200 dark:bg-red-800' : 'bg-slate-200 dark:bg-slate-800'} rounded-lg whitespace-nowrap">
        <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
        </svg>
        <span class="mx-1">${booking.service_title}</span>
      </div>

      <div class="ml-auto p-1 m-1 inline-flex justify-center  items-center bg-${status_paidObj.color}-200 dark:bg-${status_paidObj.color}-800 rounded-lg whitespace-nowrap">
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

function handleSearchInput() {
  const searchInput = document.getElementById('default-search').value.trim(); // Assurez-vous que la valeur n'est pas juste des espaces
  const resultList = document.getElementById('searchResults');
  if (!searchInput) {
    clearSearchResults(resultList);
    return; // Arrêter l'exécution de la fonction ici
  }
  performSearch(searchInput, resultList); // Fonction à définir pour exécuter la recherche
}

function clearSearchResults(resultList) {
  resultList.innerHTML = '';
  updateClassList(
    resultList,
    ['animate', 'bg-white', 'dark:bg-slate-700', 'shadow-lg'],
    ['close-animate']
  );
}

function updateClassList(target, addClasses, removeClasses) {
  target.classList.remove(...removeClasses);
  target.classList.add(...addClasses);
}

function performSearch(searchInput, resultList) {
  ajaxCall('booking/search', 'GET', { text: searchInput }, (response) => {
    resultList.innerHTML = ''; // Vider les résultats avant de les traiter pour éviter le reflow
    if (response.status === 'success' && response.data.length > 0) {
      resultList.innerHTML = response.data
        .map((booking, index) => generateSearchRows(booking, index))
        .join('');
      updateClassList(
        resultList,
        ['animate', 'bg-white', 'dark:bg-slate-950', 'shadow-lg'],
        ['close-animate']
      );
      applyScrollAnimation(); // Supposer que c'est une fonction définie ailleurs
    } else {
      resultList.innerHTML = `<div class='p-4 bg-white dark:bg-slate-700 shadow-lg animate'>Aucun résultat trouvé pour: <b>${searchInput}</b></div>`;
      updateClassList(
        resultList,
        ['animate', 'bg-white', 'dark:bg-slate-700', 'shadow-lg'],
        ['close-animate']
      );
    }
  });
}

// END SEARCH MODULE

function generateStatusPaid(PAIDS, PRICE) {
  let html = '';
  let color = '';
  let price = parseInt(PRICE);
  let paids = parseInt(PAIDS);
  if (paids >= price) {
    html = "<b class='text-green-600 dark:text-green-200'>PAYÉ</b>";
    color = 'green';
  } else if (paids > 0) {
    html = "<b class='text-orange-600 dark:text-orange-200'>PARTIEL</b>";
    color = 'orange';
  } else {
    html = "<b class='text-red-600 dark:text-red-200'>IMPAYÉ</b>";
    color = 'red';
  }
  return { html, color };
}

function header_modal(title, modal_id) {
  return (html = `
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
    </div>`);
}

async function showBookingDetailsFromID(bookingId = 0) {
  let bID = bookingId == 0 ? 0 : bookingId; // trick to fix gulpBuild minifier
  openModal('DetailsEventModal', false);
  document.getElementById('header_DetailsEventModal').innerHTML = header_modal(
    'Détails réservation',
    'DetailsEventModal'
  );
  let bookingResponse;
  try {
    const response = await window.ajaxCall(
      `booking/getBookingFromID?id=${encodeURIComponent(bID)}`,
      'GET',
      null
    );
    if (response.success) {
      bookingResponse = response.data;
    } else {
      showBanner(response.message, false);
      console.error(response.message);
    }
  } catch (responseError) {
    showBanner(responseError.message, false);
    console.error('Échec getBookingsFromID: ', responseError);
  }

  let array_paids_values = bookingResponse.paids_values
    ? bookingResponse.paids_values.split(',').map(Number)
    : [0];
  let paids_sum = array_paids_values.reduce(
    (total, currentValue) => total + currentValue,
    0
  );
  let booking_details_h5 = document.getElementById('booking_details_Type_doc');
  booking_details_h5.innerHTML = `<span class="text-md font-bold tracking-tight p-2" >${bookingResponse.Type_doc} # ${bookingResponse.id}</span> `;
  // Ajouter des classes qui ne dépendent pas de la condition
  booking_details_h5.classList.add('rounded-md');

  // Ajouter des classes basées sur la condition

  if (bookingResponse.Type_doc === 'Devis') {
    booking_details_h5.classList.add(
      'bg-slate-400',
      'text-slate-800',
      'dark:text-slate-500',
      'dark:bg-slate-950'
    );
  } else {
    booking_details_h5.classList.add(
      'bg-sky-200',
      'dark:bg-sky-800',
      'text-sky-800',
      'dark:text-sky-400'
    );
  }
  existFile(baseurl + 'uploads/' + bookingResponse.img).then((fileExists) => {
    if (fileExists) {
      document.getElementById('booking_details_img').src =
        baseurl + 'uploads/' + bookingResponse.img;
    } else {
      document
        .getElementById('booking_details_div_img')
        .classList.add('bg-gray-200');
      document
        .getElementById('booking_details_div_img')
        .classList.add('rounded-t-lg');
      document.getElementById('booking_details_div_img').style.height = '150px';
      document.getElementById('booking_details_div_img').innerHTML =
        "<svg class='max-w-full max-h-full h-auto w-auto text-gray-300 dark:text-gray-600' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'><path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m4 12 8-8 8 8M6 10.5V19c0 .6.4 1 1 1h3v-3c0-.6.4-1 1-1h2c.6 0 1 .4 1 1v3h3c.6 0 1-.4 1-1v-8.5'/></svg>";
    }
  });

  document.getElementById('booking_details_service_h5').innerText =
    bookingResponse.service_title;
  let div_fullblocked = document.getElementById(
    'booking_details_fullblocked_div'
  );
  let h5_fullblocked = document.getElementById(
    'booking_details_fullblocked_h5'
  );
  if (bookingResponse.fullblocked == 1) {
    div_fullblocked.classList.add('border-red-300', 'dark:border-red-500'),
      (h5_fullblocked.style.display = 'block');
    h5_fullblocked.innerText = 'Privatisé';
  } else {
    div_fullblocked.classList.remove('border-red-300', 'dark:border-red-500');
    h5_fullblocked.style.display = 'none';
  }
  document.getElementById('booking_details_qt_span').innerText =
    bookingResponse.Qt;
  document.getElementById('booking_details_traveller_span').innerText =
    bookingResponse.QtTraveller;
  document.getElementById('booking_details_start_span').innerText = format_date(
    bookingResponse.start
  );
  document.getElementById('booking_details_end_span').innerText = format_date(
    bookingResponse.end
  );
  document.getElementById('booking_details_price_span').innerHTML =
    totalBookingPriceCal(
      bookingResponse.Price,
      bookingResponse.QtTraveller,
      bookingResponse.Tax,
      bookingResponse.Fee,
      bookingResponse.nDays
    ) + ' Fr';

  let details_paid_rest_div = document.getElementById(
    'booking_details_progress_rest_div'
  );
  if (
    parseInt(paids_sum) <
    totalBookingPriceCal(
      bookingResponse.Price,
      bookingResponse.QtTraveller,
      bookingResponse.Tax,
      bookingResponse.Fee,
      bookingResponse.nDays
    )
  ) {
    details_paid_rest_div.innerText =
      totalBookingPriceCal(
        bookingResponse.Price,
        bookingResponse.QtTraveller,
        bookingResponse.Tax,
        bookingResponse.Fee,
        bookingResponse.nDays
      ) -
      parseInt(paids_sum) +
      ' Fr';
  } else {
    details_paid_rest_div.classList.add('hidden');
  }

  let details_paid_div = document.getElementById(
    'booking_details_progress_div'
  );
  details_paid_div.innerText = paids_sum > 0 ? paids_sum + ' Fr' : '0';
  if (paids_sum > 0) {
    let convert_pourc = Math.min(
      Math.round(
        (parseInt(paids_sum) /
          totalBookingPriceCal(
            bookingResponse.Price,
            bookingResponse.QtTraveller,
            bookingResponse.Tax,
            bookingResponse.Fee,
            bookingResponse.nDays
          )) *
          10000
      ) / 100,
      100
    );
    details_paid_div.style.width =
      convert_pourc > 24 ? convert_pourc + '%' : '24px';
  } else {
    details_paid_div.style.width = '24px';
  }

  document.getElementById('booking_details_customer_name').innerText =
    bookingResponse.customer_name;
  document.getElementById('booking_details_customer_block_toedit').onclick =
    (function (customerId) {
      return function () {
        showUpdateCustomer(customerId);
        if (!bookingResponse.customer_comment) {
          document.getElementById('customer_comment').focus();
        }
      };
    })(bookingResponse.Customer_id);

  document.getElementById('booking_details_customer_phone').innerText =
    bookingResponse.customer_phone;
  document.getElementById('booking_details_customer_email').innerText =
    bookingResponse.customer_mail;
  if (bookingResponse.customer_comment) {
    document.getElementById('booking_details_customer_comment').innerHTML =
      bookingResponse.customer_comment;
  } else {
    document.getElementById('booking_details_customer_comment').innerHTML =
      '<i>Vous pouvez ajouter un commentaire au client.</i>';
  }

  document.getElementById('booking_details_customer_created').innerText =
    'Client depuis ' +
    new Date(bookingResponse.customer_created)
      .toLocaleDateString('fr-FR', { year: 'numeric', month: 'long' })
      .replace(/^\w/, (c) => c.toUpperCase());
  document.getElementById('booking_details_created_span').innerHTML =
    'Créé le  ' + format_date(bookingResponse.Created_at, 0, 'DD/MM/YYYY');
  document.getElementById('booking_details_updated_span').innerHTML =
    'Modifié à ' + format_date(bookingResponse.Updated_at, 0, 'HH:MM DD/MM/YY');

  let child_Span_Comment = document.getElementById(
    'booking_details_comment_span'
  );
  let parent_Span_Comment = child_Span_Comment.parentElement;
  child_Span_Comment.innerText = bookingResponse.Comment;
  if (bookingResponse.Comment.length > 0) {
    parent_Span_Comment.classList.remove('hidden');
  } else {
    parent_Span_Comment.classList.add('hidden');
  }
  document.getElementById('booking_details_pdf').href =
    baseurl + 'generatePDF/booking/' + bookingResponse.id;
  document.getElementById('booking_details_pdf').innerHTML =
    download_ico + ' Télécharger PDF';
  document.getElementById('booking_details_sendmail').innerHTML =
    send_ico + 'Envoyer EMAIL';

  document
    .getElementById('booking_details_sendmail')
    .addEventListener('click', function (event) {
      event.preventDefault(); // Empêche le comportement par défaut du lien
      var loader = document.querySelector('.loader');
      loader.style.display = 'block';
      loader.style.zIndex = 999;
      // Requête AJAX pour envoyer l'e-mail
      ajaxCall(
        'sendmail/' + bookingResponse.id,
        'GET',
        null,
        function (response) {
          console.log(response); // Log la réponse pour débogage

          if (response.success === true) {
            showBanner('Ok envoyé', true);
          } else {
            showBanner("Erreur lors de l'envoi", false);
          }

          loader.style.display = 'none';
        }
      );
    });

  let button_update = document.getElementById('booking_details_update_button');
  button_update.onclick = function () {
    update_add_formEvent(bookingResponse);
  };
  let button_delete = document.getElementById('booking_details_delete_button');
  button_delete.onclick = function (event) {
    deleteEvent(event, bookingResponse.id, 'DetailsEventModal');
  };
}

async function update_add_formEvent(data) {
  openModal('addEventModal');

  // Changer le texte du bouton et son action pour l'ajout
  let submitButton = document.getElementById('add_submit_form');
  submitButton.onclick = function () {
    updateEventFromDetails();
  }; // Ajouter un nouvel événement

  try {
    let paids = await getPaidFromBookingId(data.id);
    let paymentsContainer = document.getElementById('payments-subcontainer');
    // Effacer les paiements existants avant d'ajouter de nouveaux
    paymentsContainer.innerHTML = '';

    function createPaymentElement(index, data) {
      const fillPaidInput = data ? data.value : '';
      const UniqueId = data.paid_id;
      const newPaymentRow = `
        <div class="flex payment-row mt-1" id="${UniqueId}">
        <div class="inline-flex items-center w-fit bg-red-50 border border-red-300 hover:bg-red-400 dark:bg-red-700 dark:hover:bg-red-900 rounded-lg mx-1 my-0.5 p-2 cursor-pointer" onclick="Deletepaid('${UniqueId}')"> X </div>
        <input type="hidden" id="rowPaidid${index}" name="rowPaidid${index}" value="${UniqueId}">
        <select id="rowPaidType${index}" name="rowPaidType${index}" class="inline-flex rounded-l-lg items-center py-2.5 px-4 text-sm font-bold text-center text-gray-500 bg-gray-100 border border-gray-300 hover:bg-gray-200 dark:bg-slate-800 dark:hover:bg-gray-600 dark:text-white dark:border-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:focus:ring-slate-800">
          <option value="ESPECE">ESPECE</option>
          <option value="VIREMENT">VIREMENT</option>
          <option value="VISA">VISA</option>
          <option value="AMEX">AMEX</option>
          <option value="CHEQUE">CHEQUE</option>
        </select>
        <input type="number" pattern="[0-9]*" value="${fillPaidInput}" inputmode="numeric" id="rowPaid${index}" name="rowPaid${index}" class="block w-full rounded-r-lg py-2 px-3 bg-white border border-gray-200 dark:bg-slate-900 dark:border-gray-700 text-gray-800 dark:text-white focus:ring-4 focus:outline-none focus:ring-gray-100 dark:focus:ring-slate-800">
        </div>
      `;
      const tempContainer = document.createElement('div');
      tempContainer.innerHTML = newPaymentRow;
      return tempContainer.firstElementChild;
    }

    if (paids.length > 0) {
      paids.forEach((paid, index) => {
        const newPaymentElement = createPaymentElement(index, paid);
        paymentsContainer.appendChild(newPaymentElement);
      });
    }
  } catch (error) {
    console.error('Erreur lors de la récupération des paids: ', error);
    // Gérez l'erreur comme vous le souhaitez
  }

  if (data) {
    await loadAndInitDatepicker(data.Service_id, data.start, data.end);

    document.getElementById('addEventModal_title').innerText =
      `Modifier #${data.id}`;
    document.getElementById('Modaleventid').value = data.id;
    document.getElementById('ModaleventCustomer_id').value = data.Customer_id;

    // APPEL de la fonction de mise à jour des informations du client
    $('#ModaleventCustomer_id').trigger('change');

    document.getElementById('ModaleventService_id').value = data.Service_id;
    loadServiceDetails(data.Service_id);
    document.getElementById('Modaleventfullblocked').checked =
      parseInt(data.fullblocked) === 1;

    // APPEL de la fonction de mise à jour du fullblock
    updateFullblocked_RedSwitch(parseInt(data.fullblocked));

    document.getElementById('ModaleventQtTraveller').value = parseInt(
      data.QtTraveller
    );
    document.getElementById('ModaleventQt').value = data.Qt;
    document.getElementById('ModaleventNights').innerText =
      data.Qt + ' Nuit(s)';
    TypeDoc = document.getElementById('ModaleventType_doc');
    TypeDoc.value = data.Type_doc;
    TypeDoc.checked = data.Type_doc === 'Facture';
    updateToggleLabel(TypeDoc.checked);

    document.getElementById('ModaleventPrice').value = data.Price;
    document.getElementById('ModaleventComment').value = data.Comment;
    // APPEL des fonctions de mise à jour du prix total ET des informations
    GlobalEDITING_book = true;
    updateTotalInfo();
    updatePrice(GlobalEDITING_book);
  }
}

// TODO, deleted les paids_id associé aux event_id
function deleteEvent(event, booking_id, modal_id = false) {
  event.stopPropagation(); // Empêche la propagation de l'événement au parent
  openModal('ConfirmDeleteModal');
  let modal = document.getElementById('ConfirmDeleteModal');
  modal.style.zIndex = '999';
  let yesconfirmButton = document.getElementById(
    'ConfirmDeleteModal_yes_button'
  );

  yesconfirmButton.onclick = function () {
    ajaxCall(
      'booking/deleteBooking',
      'POST',
      { id: booking_id },
      function (response) {
        if (response.success === true) {
          if (calendar) {
            calendar.refetchEvents();
          }

          // GESTIONNAIRE DE RETOUR D'AFFICHAGE
          if (ModalInStack('ListEventModal')) {
            document
              .getElementById('booking_' + booking_id)
              .classList.add('line-through');
            document.getElementById('badge_id_' + booking_id).style.cssText =
              'background-color: gray;';
            document.getElementById('booking_a_' + booking_id).style.cssText =
              'cursor : default;';

            let svgs = document.querySelectorAll(
              '#booking_a_' + booking_id + ' svg'
            );

            svgs.forEach(function (svg) {
              svg.style.color = 'gray';
            });
          }
          if (urlLocation() == 'history') {
            let tr = document.querySelector('.row_booking_' + booking_id);
            if (tr) {
              setTimeout(() => {
                tr.classList.add('fade_out');
              }, 200);
              setTimeout(() => {
                tr.classList.add('hidden');
              }, 700);
            }
          }

          showBanner('Suppression réalisée avec succès', true);
          closeModalById('ConfirmDeleteModal');

          if (modal_id) {
            closeModalById(modal_id);
          }
        }
      }
    );
  };

  let noconfirmButton = document.getElementById('ConfirmDeleteModal_no_button');
  noconfirmButton.onclick = function () {
    closeModalById('ConfirmDeleteModal');
  };
}

function updateCustomerinfo(data = null) {
  var formElement = document.getElementById('customerForm'); // Sélectionne le formulaire par son ID
  var formData = new FormData(formElement);
  var object = {};
  formData.forEach(function (value, key) {
    object[key] = value;
  });

  data = object;
  ajaxCall('customer/update', 'POST', data, function (response) {
    if (response.success === true) {
      // Traiter la réponse en cas de succès
      // var newCustomerId = response.id;
      let deleted = response.delete;
      updateCustomerFields(data, deleted); // Utilisez la fonction de mise à jour refactorisée

      if (ModalInStack('updateCustomerModal')) {
        closeModalById('updateCustomerModal');
      }

      showBanner('Modification réalisée avec succès', true);
    } else {
      showBanner('Échec de la modification', false);
    }
  });
}
// Appeler setupButtonAction après avoir configuré votre page ou modale pour s'assurer que le bouton a le bon gestionnaire d'événements.

function updateCustomerFields(data, deleted = false) {
  // Refactorisation pour mettre à jour les informations du client
  const updateFieldById = (id, value) => {
    const element = document.getElementById(id);
    if (element) {
      element.innerText = value || ''; // Utiliser une chaîne vide si la valeur est false
    }
  };

  const modalToUpdate = [
    { modal: 'CustomerInfoModal', prefix: 'history_customer' },
    { modal: 'DetailsEventModal', prefix: 'booking_details_customer' },
  ];

  modalToUpdate.forEach(({ modal, prefix }) => {
    if (ModalInStack(modal)) {
      updateFieldById(`${prefix}_name_span`, data.Name);
      updateFieldById(`${prefix}_phone_span`, data.Phone);
      updateFieldById(`${prefix}_email_span`, data.Email);
      updateFieldById(`${prefix}_comment_span`, data.Comment);
    }
  });
  if (urlLocation() == 'customer') {
    // Mettre à jour les attributs data-*
    let row = document.querySelector('.row_customer_' + data.Customer_id);
    if (row) {
      row.dataset.name = data.Name;
      row.dataset.phone = data.Phone;
      row.dataset.email = data.Email;
      row.dataset.comment = data.Comment;

      // Mettre à jour les textes visibles
      let serviceCell = document.querySelector('.service_' + data.Customer_id);
      if (serviceCell) {
        serviceCell.innerHTML = `<b>${data.Name}</b>`;
      }

      let emailCell = row.querySelector('td:nth-child(2)'); // Assumer que l'email est toujours dans la deuxième colonne
      if (emailCell) {
        emailCell.textContent = data.Email;
      }

      let phoneCell = row.querySelector('td:nth-child(3)'); // Assumer que le téléphone est toujours dans la troisième colonne
      if (phoneCell) {
        phoneCell.textContent = data.Phone;
      }

      let commentCell = document.getElementById('comment_' + data.Customer_id);
      if (commentCell) {
        commentCell.textContent = data.Comment;
      }
    }
  }
}
// CUSTOMER, mets à jours le bouton envoyé
function setupButtonAction(callback) {
  let button = document.getElementById('update_customer_submit_form');
  button.onclick = function () {
    // Déterminez ici si vous devez créer ou mettre à jour, peut-être basé sur une valeur de formulaire
    let isUpdate = document.getElementById('customer_id').value !== '';

    if (isUpdate) {
      updateCustomerInfo(callback);
    } else {
      CreateCustomer(callback);
      // Appeler 'CreateCustomer' avec le 'callback' défini.
    }
  };
}

//Start extend_ttl, compte à rebourd pour le temps restant de session.
let countdownInterval; // Déclaration à l'extérieur pour une portée globale

function startTokenCountdown() {
  if (localStorage.getItem('token')) {
    let ttl = parseInt(localStorage.getItem('timeLeft'), 10); // Assurez-vous de convertir en nombre

    // Arrêtez l'intervalle existant s'il y en a un
    // countdownInterval; // Déclarez dans wd_function_toolbox.js

    if (countdownInterval) {
      clearInterval(countdownInterval);
    }

    // Exécute `updateCountdown` une fois immédiatement puis toutes les secondes
    updateCountdown(ttl);
  }
}
function extendButton() {
  document.getElementById('extend_ttl').addEventListener('click', function (e) {
    e.preventDefault();
    verifyToken(true)
      .then((tokenIsValid) => {
        if (tokenIsValid) {
          localStorage.setItem('token', tokenIsValid);
          showBanner('Token étendu de 12h00', true);
        } else {
          // Gérer le cas où le token n'est pas valide ou ne peut pas être étendu
          showBanner("Impossible d'étendre le token.", false);
        }
      })
      .catch((error) => {
        console.error("Erreur lors de l'extension du token:", error);
        // Gérer l'erreur ici, par exemple, en affichant une bannière d'erreur
        showBanner("Erreur lors de la tentative d'extension du token.", false);
      });
  });
}

// Fullcalendar HTML UTILITIES

// Fonction pour créer le HTML de la marque du jour
function createDayMarker({
  position,
  count,
  customerWay,
  additionalClasses = '',
  isavailable,
}) {
  let markerContainer = document.createElement('div');
  markerContainer.className = `absolute flex justify-${position} w-full z-20`;

  if (customerWay === 'IN' || customerWay === 'OUT') {
    let triangle = document.createElement('div');
    triangle.className = `triangle ${position} ${isavailable} ${additionalClasses}`;
    markerContainer.appendChild(triangle);

    let countDiv = document.createElement('div');
    countDiv.className = `count justify-${position} my-0.5 mx-1 font-bold z-10`;
    countDiv.textContent = count > 0 ? count.toString() : ' '; // Utiliser un espace insécable
    markerContainer.appendChild(countDiv);
  } else {
    markerContainer.className = `absolute flex justify-${position} h-full w-full z-20`;
    let bookedDiv = document.createElement('div');
    bookedDiv.className = `calendar_booked ${isavailable} flex flex-col w-full`;
    bookedDiv.textContent = ' '; // Utiliser un espace insécable
    markerContainer.appendChild(bookedDiv);
  }

  return markerContainer; // Retourner l'élément DOM au lieu de la chaîne HTML
}

//history
if (urlLocation() == 'history') {
  window.addEventListener('DOMContentLoaded', function () {
    //Période to date
    var inputStartDate = document.getElementById('start-date');
    var inputEndDate = document.getElementById('end-date');
    var selectPeriod = document.getElementById('single-choice-list');
    var togglePeriodButton = document.getElementById('toggleButton1');
    var selectedPeriod = getFromLocalStorage('selectedPeriod')
      ? getFromLocalStorage('selectedPeriod')
      : null;
    var startDate = getFromLocalStorage('startDate')
      ? getFromLocalStorage('startDate')
      : null;
    var endDate = getFromLocalStorage('endDate')
      ? getFromLocalStorage('endDate')
      : null;
    // Mettre à jour les champs de date dans le HTML avec les valeurs renvoyées
    function updateDateFields(start, end, periode) {
      inputStartDate.value = start;
      inputStartDate.dispatchEvent(new Event('change'));
      inputEndDate.value = end;
      inputEndDate.dispatchEvent(new Event('change'));
      if (togglePeriodButton) {
        selectPeriod.value = periode;
        togglePeriodButton.innerHTML =
          'Période <br><span class="font-bold text-xs">' +
          (periodeTexts[periode] || 'Non spécifié') +
          '</span>';
      }
    }

    if (selectedPeriod && startDate && endDate) {
      // Mettre à jour les champs de date avec les valeurs récupérées
      updateDateFields(startDate, endDate, selectedPeriod);
    }

    selectPeriod.addEventListener('change', function () {
      // Récupérer la valeur sélectionnée dans le menu déroulant
      let selectedPeriodValue = this.value;

      // Appeler la fonction periodeToDate() avec la valeur sélectionnée
      let dates = periodeToDate(selectedPeriodValue);
      updateDateFields(dates.start, dates.end, selectedPeriodValue);
      // Sauvegarder les valeurs dans le localStorage
      console.log('save localstroage', selectedPeriodValue, dates.start);
      saveToLocalStorage('selectedPeriod', selectedPeriodValue);
      saveToLocalStorage('startDate', dates.start);
      saveToLocalStorage('endDate', dates.end);

      // Mettre à jour les champs de date dans le HTML avec les valeurs renvoyées
      if (dates.start !== null) {
        inputStartDate.setAttribute('value', dates.start);
      } else {
        inputStartDate.removeAttribute('value');
      }

      if (dates.end !== null) {
        inputEndDate.setAttribute('value', dates.end);
      } else {
        inputEndDate.removeAttribute('value');
      }
    });

    // Fonction pour vérifier si un élément est contenu dans un autre élément
    function isDescendant(parent, child) {
      var node = child.parentNode;
      while (node != null) {
        if (node === parent) {
          return true;
        }
        node = node.parentNode;
      }
      return false;
    }

    // Ajouter un écouteur d'événements au document
    document.addEventListener('click', function (event) {
      // Vérifier si le clic a été effectué à l'intérieur du toggleDiv ou sur le bouton de bascule
      var toggleDiv = document.getElementById('toggleDiv1');

      if (
        (!isDescendant(toggleDiv, event.target) &&
          event.target !== togglePeriodButton) ||
        event.target.tagName === 'OPTION'
      ) {
        // Cacher le toggleDiv
        toggleDiv.style.opacity = '0';
        setTimeout(function () {
          toggleDiv.style.maxHeight = '0';
        }, 300); // Attendre la fin de la transition de l'opacité avant de définir la hauteur maximale sur 0
      }
    });
  });

  // loop pour cacher chaque div pour chaque bouton
  var buttons = document.getElementsByClassName('toggleButton');
  var divs = document.getElementsByClassName('toggleDiv');
  for (var i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener('click', function () {
      var divId = this.id.replace('Button', 'Div');
      var div = document.getElementById(divId);
      if (div.style.maxHeight === '0px' || div.style.maxHeight === '') {
        for (var j = 0; j < divs.length; j++) {
          divs[j].style.opacity = '0';
          divs[j].style.maxHeight = '0';
        }
        div.style.maxHeight = div.scrollHeight + 'px';
        setTimeout(function () {
          div.style.opacity = '1';
        }, 50); // Wait for the max-height change to take effect before starting the opacity transition
      } else {
        div.style.opacity = '0';
        setTimeout(function () {
          div.style.maxHeight = '0';
        }, 500); // Wait for the opacity transition to finish before setting max-height to 0
      }
    });
  }

  //////////////////////////////////////////////////

  // Periode filtre
  function filterBookings() {
    // Récupérer les valeurs des champs de date
    let startDateValue = document.getElementById('start-date').value;
    let startParts = startDateValue.split('-');
    let startformattedDate =
      startParts[1] + '/' + startParts[2] + '/' + startParts[0];
    let startDate = new Date(startformattedDate);
    console.log('startDate', startDate);
    let endDateValue = document.getElementById('end-date').value;
    let endParts = endDateValue.split('-');
    let endformattedDate = endParts[1] + '/' + endParts[2] + '/' + endParts[0];
    let endDate = new Date(endformattedDate);
    console.log('endDate', endDate);

    // Parcourir tous les éléments du tableau
    let bookingsRows = document.querySelectorAll('.ROW');
    bookingsRows.forEach(function (row) {
      // TODO METTRE UNE FUNCTION DATE de convertion //
      // Récupérer les valeurs des cellules de date dans la ligne du tableau
      // Séparation de la chaîne en jour, mois et année
      let dateString = row.querySelector('.booking-start-date').innerText;
      let parts = dateString.split('-');
      let day = parseInt(parts[0], 10);
      let month = parseInt(parts[1], 10) - 1; // Mois est 0-indexé (0 = janvier)
      let year = parseInt(parts[2], 10);
      let bookingStartDate = new Date(year, month, day);

      let bookingStartDateObj = new Date(bookingStartDate);
      console.log('bookingStartDate', bookingStartDateObj);

      // Comparer les valeurs des champs de date avec celles du tableau
      if (bookingStartDateObj >= startDate && bookingStartDateObj <= endDate) {
        // Afficher l'élément du tableau s'il correspond aux critères de date
        row.style.display = 'table-row';
      } else {
        // Masquer l'élément du tableau s'il ne correspond pas aux critères de date
        row.style.display = 'none';
      }
    });
  }

  //pagination système
  const itemsPerPage = 8;
  let currentPage = 1;
  let all_bookings = Array.from(document.querySelectorAll('.ROW')); // Chaque ligne du tableau a une classe 'row_booking'
  let totalPages = Math.ceil(all_bookings.length / itemsPerPage);

  function loadPagination() {
    let all_bookings = Array.from(document.querySelectorAll('.ROW')); // Chaque ligne du tableau a une classe 'row_booking'
    let totalPages = Math.ceil(all_bookings.length / itemsPerPage);
  }

  function showPage(page) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    // Cacher tous les éléments
    all_bookings.forEach((booking) => (booking.style.display = 'none'));

    // Afficher les éléments pour la page actuelle
    all_bookings
      .slice(start, end)
      .forEach((booking) => (booking.style.display = ''));

    currentPage = page;
    updatePagination(); // Ajoutez cette ligne
  }

  function updatePagination() {
    let paginationHtml = `<nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
      <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
          Ligne
          <span class="font-semibold text-gray-900 dark:text-white">${currentPage * itemsPerPage - itemsPerPage + 1} à ${Math.min(currentPage * itemsPerPage, all_bookings.length)}</span>
           /
          <span class="font-semibold text-gray-900 dark:text-white">${all_bookings.length}</span>
      </span>
      <ul class="inline-flex items-stretch -space-x-px">
`;

    // Bouton précédent
    paginationHtml += `
  <li>
      <span class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 ${currentPage === 1 ? 'cursor-not-allowed' : 'hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white'}" onclick="${currentPage === 1 ? '' : 'showPage(' + (currentPage - 1) + ')'}">
          <span class="sr-only">Précédent</span>
          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
      </span>
  </li>
`;

    // Boutons de numéro de page
    if (totalPages < 1) {
      paginationHtml = `<div class="flex justify-center items-center p-4" >Aucun résultat trouvé </div>`;
    } else {
      for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `
    <li>
      <span class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 ${currentPage === i ? 'text-primary-600 bg-primary-50 border-primary-300' : 'hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white'}" onclick="showPage(${i})">
        ${i}
      </span>
    </li>
  `;
      }

      // Bouton suivant
      paginationHtml += `
  <li>
      <span class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 ${currentPage === totalPages ? 'cursor-not-allowed' : 'hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white'}" onclick="${currentPage === totalPages ? '' : 'showPage(' + (currentPage + 1) + ')'}">
          <span class="sr-only">Suivant</span>
          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                              </svg>
      </span>
  </li>
`;

      paginationHtml += '</ul></nav>';
    }

    document.getElementById('pagination-container').innerHTML = paginationHtml;
  }

  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('simple-search');
    const table = document.getElementById('history_list');
    const rows = table.querySelectorAll('tbody tr');

    input.addEventListener('input', function () {
      const query = this.value.toLowerCase();

      rows.forEach((row) => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
      });
    });
  });

  function updateTable() {
    const query = document.getElementById('simple-search').value.toLowerCase();
    const all_bookings = Array.from(document.querySelectorAll('.ROW'));

    all_bookings.forEach((row) => {
      let text = row.textContent.toLowerCase();
      const serviceId = row.className
        .split(' ')
        .find((className) => className.startsWith('service-'));

      const isCheckboxChecked = document.querySelector(
        `.filter-checkbox[value="${serviceId}"]`
      ).checked;

      if (isCheckboxChecked && text.includes(query)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  // Fonction pour synchroniser le filtrage par période avec la pagination
  function filterAndPaginate() {
    const itemsPerPage = 8;

    // Appliquer le filtre
    filterBookings();

    // Mettre à jour la liste des réservations visibles après filtrage
    all_bookings = Array.from(document.querySelectorAll('.ROW')).filter(
      (row) => row.style.display !== 'none'
    );

    // Recalculer le nombre total de pages
    totalPages = Math.ceil(all_bookings.length / itemsPerPage);

    // Réinitialiser à la première page si le filtrage change le contenu
    showPage(1);
    updatePagination();
  }

  // Affiche la première page et initialise la pagination
  document.addEventListener('DOMContentLoaded', function () {
    document
      .getElementById('start-date')
      .addEventListener('change', filterAndPaginate);
    document
      .getElementById('end-date')
      .addEventListener('change', filterAndPaginate);

    showPage(1);
    updatePagination();
  });
}
