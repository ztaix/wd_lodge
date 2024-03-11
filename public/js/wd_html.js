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

/// A TRAVAILLER POUR AMELIORATION :

async function showBookingDetailsFromID(id) {
  openModal('DetailsEventModal', false);
  document.getElementById('header_DetailsEventModal').innerHTML = header_modal(
    'Détails réservation',
    'DetailsEventModal'
  );
  let b;
  try {
    let response = await ajaxCall(
      'booking/getBookingFromID?id=' + id,
      'GET',
      null
    );
    if (response.success) {
      b = response.data;
    } else {
      showBanner(response.message, false);
      console.error(response.message);
    }
  } catch (error) {
    showBanner(error.message, false);
    console.error('Échec getBookingsFromID: ', error);
  }

  let array_paids_values = b.paids_values
    ? b.paids_values.split(',').map(Number)
    : [0];
  let paids_sum = array_paids_values.reduce(
    (total, currentValue) => total + currentValue,
    0
  );
  let booking_details_h5 = document.getElementById('booking_details_Type_doc');
  booking_details_h5.innerHTML = `<span class="text-md font-bold tracking-tight p-2" >${b.Type_doc} # ${b.id}</span> `;
  // Ajouter des classes qui ne dépendent pas de la condition
  booking_details_h5.classList.add('rounded-md');

  // Ajouter des classes basées sur la condition

  if (b.Type_doc === 'Devis') {
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
  existFile(baseurl + 'uploads/' + b.img).then((fileExists) => {
    if (fileExists) {
      document.getElementById('booking_details_img').src =
        baseurl + 'uploads/' + b.img;
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
    b.service_title;
  let div_fullblocked = document.getElementById(
    'booking_details_fullblocked_div'
  );
  let h5_fullblocked = document.getElementById(
    'booking_details_fullblocked_h5'
  );
  if (b.fullblocked == 1) {
    div_fullblocked.classList.add('border-red-300', 'dark:border-red-500'),
      (h5_fullblocked.style.display = 'block');
    h5_fullblocked.innerText = 'Privatisé';
  } else {
    div_fullblocked.classList.remove('border-red-300', 'dark:border-red-500');
    h5_fullblocked.style.display = 'none';
  }
  document.getElementById('booking_details_qt_span').innerText = b.Qt;
  document.getElementById('booking_details_traveller_span').innerText =
    b.QtTraveller;
  document.getElementById('booking_details_start_span').innerText = format_date(
    b.start
  );
  document.getElementById('booking_details_end_span').innerText = format_date(
    b.end
  );
  document.getElementById('booking_details_price_span').innerHTML =
    totalBookingPriceCal(b.Price, b.QtTraveller, b.Tax, b.Fee, b.nDays) + ' Fr';

  let details_paid_rest_div = document.getElementById(
    'booking_details_progress_rest_div'
  );
  if (
    parseInt(paids_sum) <
    totalBookingPriceCal(b.Price, b.QtTraveller, b.Tax, b.Fee, b.nDays)
  ) {
    details_paid_rest_div.innerText =
      totalBookingPriceCal(b.Price, b.QtTraveller, b.Tax, b.Fee, b.nDays) -
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
          totalBookingPriceCal(b.Price, b.QtTraveller, b.Tax, b.Fee, b.nDays)) *
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
    b.customer_name;
  document.getElementById('booking_details_customer_block_toedit').onclick =
    (function (customerId) {
      return function () {
        showUpdateCustomer(customerId);
        if (!b.customer_comment) {
          document.getElementById('customer_comment').focus();
        }
      };
    })(b.Customer_id);

  document.getElementById('booking_details_customer_phone').innerText =
    b.customer_phone;
  document.getElementById('booking_details_customer_email').innerText =
    b.customer_mail;
  if (b.customer_comment) {
    document.getElementById('booking_details_customer_comment').innerHTML =
      b.customer_comment;
  } else {
    document.getElementById('booking_details_customer_comment').innerHTML =
      '<i>Vous pouvez ajouter un commentaire au client.</i>';
  }

  document.getElementById('booking_details_customer_created').innerText =
    'Client depuis ' +
    new Date(b.customer_created)
      .toLocaleDateString('fr-FR', { year: 'numeric', month: 'long' })
      .replace(/^\w/, (c) => c.toUpperCase());
  document.getElementById('booking_details_created_span').innerHTML =
    'Créé le  ' + format_date(b.Created_at, 0, 'DD/MM/YYYY');
  document.getElementById('booking_details_updated_span').innerHTML =
    'Modifié à ' + format_date(b.Updated_at, 0, 'HH:MM DD/MM/YY');

  let child_Span_Comment = document.getElementById(
    'booking_details_comment_span'
  );
  let parent_Span_Comment = child_Span_Comment.parentElement;
  child_Span_Comment.innerText = b.Comment;
  if (b.Comment.length > 0) {
    parent_Span_Comment.classList.remove('hidden');
  } else {
    parent_Span_Comment.classList.add('hidden');
  }
  document.getElementById('booking_details_pdf').href =
    baseurl + 'generatePDF/booking/' + b.id;
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
      ajaxCall('sendmail/' + b.id, 'GET', null, function (response) {
        console.log(response); // Log la réponse pour débogage

        if (response.success === true) {
          showBanner('Ok envoyé', true);
        } else {
          showBanner("Erreur lors de l'envoi", false);
        }

        loader.style.display = 'none';
      });
    });

  let button_update = document.getElementById('booking_details_update_button');
  button_update.onclick = function () {
    update_add_formEvent(b);
  };
  let button_delete = document.getElementById('booking_details_delete_button');
  button_delete.onclick = function (event) {
    deleteEvent(event, b.id, 'DetailsEventModal');
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
    updateTotalInfo();
    updatePrice();
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
          calendar.refetchEvents();

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

      updateCustomerFields(data); // Utilisez la fonction de mise à jour refactorisée

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

function updateCustomerFields(data) {
  // Refactorisation pour mettre à jour les informations du client
  const updateFieldById = (id, value) => {
    const element = document.getElementById(id);
    if (element) {
      element.innerText = value || ''; // Utiliser une chaîne vide si la valeur est false
    }
  };

  const fieldsToUpdate = [
    { modal: 'CustomerInfoModal', prefix: 'history_customer' },
    { modal: 'DetailsEventModal', prefix: 'booking_details_customer' },
  ];

  fieldsToUpdate.forEach(({ modal, prefix }) => {
    if (ModalInStack(modal)) {
      updateFieldById(`${prefix}_name_span`, data.Name);
      updateFieldById(`${prefix}_phone_span`, data.Phone);
      updateFieldById(`${prefix}_email_span`, data.Email);
      updateFieldById(`${prefix}_comment_span`, data.Comment);
    }
  });
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

//Start FOOTER_TTL, compte à rebourd pour le temps restant de session.
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
