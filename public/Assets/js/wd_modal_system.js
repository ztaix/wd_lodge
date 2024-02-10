
// La pile pour garder une trace des fenêtres modales ouvertes
var modalStack = []; // Pile pour stocker les fenêtres modales ouvertes
var ShadowmodalStack = []; // Pile pour stocker les fenêtres modales ouvertes
var currentZIndex = 50; // Valeur initiale du zIndex
var isClosingModal = false;
let isAnimating = false; // Indicateur pour suivre l'état de l'animation

function urlLocation(){
   let segments = window.location.href.split('?')[0].split('/');
   let dernierSegment = segments.pop() || segments.pop();
   
   let returnSegment = dernierSegment.toLowerCase().replace(/[^a-z0-9]/g, '');
   returnSegment = returnSegment == '' || returnSegment == 'public' ||  baseurl == window.location.href ? "calendar" : returnSegment;
   return returnSegment;
}

function showBanner(message, isSuccess) {
    const banner = document.getElementById("banner_update");
    const banner_txt = document.getElementById("banner_update-text");
  
    banner_txt.innerHTML += '<p>' + message + '</p>';
  
    if (isSuccess) {
      banner.style.backgroundColor = "rgba(0, 128, 0, 0.9)"; //green 50%
    } else {
      banner.style.backgroundColor = "rgba(255, 0, 0, 0.9)";
    }
  
    banner.classList.remove("banner_update-exit");
    banner.classList.add("banner_update-visible");
  
    setTimeout(() => {
      banner.classList.remove("banner_update-visible");
      banner.classList.add("banner_update-exit");
      banner_txt.innerHTML = '';
    }, 3500);
  }

  
function showSearch() {
    const banner = document.getElementById("SearchListEventModal");
    banner.classList.add("banner_search-visible");
    banner.classList.remove("hidden"); // Supprimer la classe "hidden"
    banner.style.display = "flex"; // Modifier la propriété "display"
  }

  
async function resetForm(modalId, start = false , end = false, service_id = false){
  if(modalId == "addEventModal"){
    const form_addEventModal = [
      "Modaleventid",
      "ModaleventType_doc",
      "ModaleventCustomer_id",
      "ModaleventQtTraveller",
      "ModaleventService_id",
      "Modaleventfullblocked",
      "ModaleventQt",
      "ModaleventPrice",
      "ModaleventComment",
      "payments-subcontainer",
    ];

    
    form_addEventModal.forEach(input => {
      if(input == "ModaleventType_doc"){
        document.getElementById(input).value = 'Devis';
      }
      else if(input =="ModaleventQtTraveller" || input =="ModaleventQt" ){
        document.getElementById(input).value = 1;
      }
      else if(input =="payments-subcontainer" ){
        document.getElementById(input).innerText = "";
      }
      else if(input =="Modaleventfullblocked" || document.getElementById(input).value == 1 ){
        document.getElementById(modalId).classList.remove('border', 'border-dashed', 'border-4', 'border-red-400');
        document.getElementById('container_eventfullblocked').classList.remove('dark:border-red-900', 'bg-red-500');
        document.getElementById(input).checked = false;
      }
      else if( input == "ModaleventService_id" ){
        if(service_id){
          document.getElementById(input).value = service_id;
        }
        else{
          service_id = discountservice[0].Service_id;
          document.getElementById(input).value = discountservice[0].Service_id;
        }
      }
      else if( input == "ModaleventCustomer_id"){
        let ModaleventCustomer_id = $('#ModaleventCustomer_id'); // Utilisez jQuery pour sélectionner l'élément
        ModaleventCustomer_id.val(1); // Changez la valeur
        ModaleventCustomer_id.trigger('change'); // Mettez à jour l'affichage de Select2
        ModaleventCustomer_id.focus();
        document.getElementById('Modalevent_Container_Customer_id').classList.add('blinking');        
      }
      else {
        document.getElementById(input).value = '';
      }
    });
    discountIndicator.innerText = '';
    document.getElementById("addEventModal_title").innerText = 'Ajouter';
    let date_start = '';
    let date_end = '';
    if(start){
      start_date = format_date(start);
      date_end = end ? format_date(end) : format_date(start,1);
    }else {
      date_start = format_date(getToday());
      date_end = format_date(date_start,1);
    }

    //RESET PAYMENT ROW
    let temp_payments_row = document.querySelectorAll('div[id^="temp_"]');
    if(temp_payments_row.length > 0){
      // Parcourir et supprimer chaque div
      temp_payments_row.forEach(div => {
        div.parentNode.removeChild(div);
      });
    } 

    await loadAndInitDatepicker(service_id,date_start,date_end);

  }
}

function openModal(modalId) {
  if (isAnimating) return; // Sort si une animation est déjà en cours
  isAnimating = true; // Active l'indicateur d'animation
  let modalElement = document.getElementById(modalId);
  let shadow_modal = document.getElementById(modalId + '-shadow_modal');

  if (modalElement) {

    shadow_modal.style.zIndex = currentZIndex+1;
    shadow_modal.classList.add("animate_shadow_modal");
    shadow_modal.classList.remove("close-animate_shadow_modal");
    shadow_modal.classList.remove("hidden");
    modalElement.style.zIndex = currentZIndex+2;
    modalElement.classList.add("animate");
    modalElement.classList.remove("close-animate");
    modalElement.classList.remove("hidden");
    if(modalStack.length > 0){
      let previousModal = modalStack[modalStack.length - 1];
      previousModal.classList.add('blur-lg');
    }

    currentZIndex +=1;
    //Ajoute à la pile
    modalStack.push(modalElement); 
    ShadowmodalStack.push(shadow_modal); 
  }  
  

  var current_page_DIV = document.getElementById(urlLocation());
    current_page_DIV.classList.add('blur-lg');

  setTimeout(function() {
    isAnimating = false; // Désactive l'indicateur d'animation une fois la modale fermée
  }, 350); // Assurez-vous que cette durée correspond à la durée de votre animation
}

// Ferme la dernière fenêtre modale ouverte
function closeModal() {
  if (isAnimating) return; // Sort si une animation est déjà en cours
  isAnimating = true; // Active l'indicateur d'animation

  if(modalStack.length > 1 ){

  var currentModal = modalStack.pop(); // Retire la dernière fenêtre modale de la pile
  var lastShadowModal = ShadowmodalStack.pop(); // Retire la dernière fenêtre modale de la pile
  var lastModal = modalStack[modalStack.length -1]; // Retire la dernière fenêtre modale de la pile

  currentModal.classList.add("close-animate"); // Ajoute la classe 'close-animate' pour animer la fermeture
  currentModal.classList.remove("animate");
  
  lastShadowModal.classList.add("close-animate_shadow_modal");
  lastShadowModal.classList.remove("animate_shadow_modal");

  lastModal.classList.remove("blur-lg");
  
  setTimeout(() => {
    currentModal.classList.add("hidden");
    lastShadowModal.classList.add("hidden");
  }, 300);  

  }
  else if(modalStack.length === 1 ){  
    var currentModal = modalStack.pop(); // Retire la dernière fenêtre modale de la pile
    var lastShadowModal = ShadowmodalStack.pop(); // Retire la dernière fenêtre modale de la pile

    currentModal.classList.add("close-animate"); // Ajoute la classe 'close-animate' pour animer la fermeture
    currentModal.classList.remove("animate");
    lastShadowModal.classList.add("close-animate_shadow_modal");
    lastShadowModal.classList.remove("animate_shadow_modal");
  
    setTimeout(() => {
      currentModal.classList.add("hidden");
      lastShadowModal.classList.add("hidden");
    }, 300);  
  }
  if(modalStack.length === 0  ){
       var current_page_DIV = document.getElementById(urlLocation())
       current_page_DIV.classList.remove('blur-lg');
  }

  setTimeout(function() {
    isAnimating = false; // Désactive l'indicateur d'animation une fois la modale fermée
  }, 350); // Assurez-vous que cette durée correspond à la durée de votre animation
}

function closeModalById(modalId) {
  if (isAnimating) return; // Sort si une animation est déjà en cours
  isAnimating = true; // Active l'indicateur d'animation

  let modalElement = document.getElementById(modalId);
  let shadow_modal = document.getElementById(modalId + '-shadow_modal');

  if (modalElement) {
    
    modalElement.classList.add("close-animate"); 
    modalElement.classList.remove("animate");

    shadow_modal.classList.add("close-animate_shadow_modal"); 
    shadow_modal.classList.remove("animate_shadow_modal");

    setTimeout(function() {
      modalElement.classList.add("hidden");
      shadow_modal.classList.add("hidden");
  }, 300);
  
    // Si une fenêtre modale est toujours dans la pile, alors la rouvrir
    if (modalStack.length > 1) {
      let previousModal = modalStack[modalStack.length - 2]; // 2 car l'indexation commence à 0
      previousModal.classList.remove("blur-lg");
    }
    else {
      var current_page_DIV = document.getElementById(urlLocation())
      current_page_DIV.classList.remove('blur-lg');
    }
}
  
  // Retire la fenêtre modale spécifiée de la pile
  modalStack = modalStack.filter((modal) => modal.id !== modalId);
  
  setTimeout(function() {
    isAnimating = false; // Désactive l'indicateur d'animation une fois la modale fermée
  }, 350); // Assurez-vous que cette durée correspond à la durée de votre animation
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

  return modalStack.some(function (modal) {
    return modal.id === modalId;
  });
}

function shadowUndermodal(modal_id){
  return `<div id="${modal_id}-shadow_modal" class="fixed inset-0 bg-black opacity-50 hidden" onclick="closeModalById('${modal_id}')"></div>`;
}

function handleAddEventClick(date =false, service_id = false) {
  resetForm('addEventModal',date,false,service_id);

  openModal('addEventModal');
}


// MODAL CUSTOMER UPSERT function module
//
  // Met à jour les champs du formulaire avec les données récupérées
  function updateCustomersFormFields(customer) {
    document.getElementById("customer_id").value = customer.customer_id;
    document.getElementById("customer_name").value = customer.name;
    document.getElementById("customer_phone").value = customer.phone;
    document.getElementById("customer_email").value = customer.email;
    document.getElementById("customer_comment").value = customer.comment;
  }

  function getCustomerFormData() {
    return {
      Customer_id: document.getElementById("customer_id").value,
      Name: document.getElementById("customer_name").value,
      Phone: document.getElementById("customer_phone").value,
      Email: document.getElementById("customer_email").value,
      Comment: document.getElementById("customer_comment").value,
    };
  }

  function updateModal(data){
    let row_id = Object.keys(data);
    let d = data[row_id];
    let row_price = totalBookingPriceCal(d.Price,d.QtTraveller,d.Tax,d.Fee,d.Qt);

    /*Comment: "coucoucoucou ouzopd opsdjqpsd qsd qsdqsd qsdqsd"
    Customer_id: "8"
    Fee: "0"
    Price: "12000"
    Qt: "1"
    QtTraveller: "3"
    Service_id: "2"
    Tax: "0"​​
    Type_doc: "Devis"
    end: "2024-01-27 00:00:00"​
    fullblocked: "0"
    start: "2024-01-26 00:00:00"*/

    if(ModalInStack('ListEventModal')){  // UPDATE BOOKING
      document.getElementById('booking_total_'+row_id).innerText =  row_price;
      document.getElementById('booking_Comment_'+row_id).innerText = d.Comment;
      document.getElementById('booking_startDay_'+row_id).innerText = getDayOfWeek(format_date(d.start));
      document.getElementById('booking_start_'+row_id).innerText = format_date(d.start,0,'DD/MM');
      document.getElementById('booking_endDay_'+row_id).innerText = getDayOfWeek(format_date(d.end));
      document.getElementById('booking_end_'+row_id).innerText = format_date(d.end,0,'DD/MM');

      //Recherche dans le tableau services_list (déclaré dans le footer) et affiche le titre correspondant
      document.getElementById('booking_title_'+row_id).innerHTML = (services_list.find(item => item.Service_id === d.Service_id) || {}).Title + ' (' + DaysDifferenceStartEnd(d.start, d.end) + ' nuits)';
      document.getElementById("badge_id_"+row_id).innerText = row_id;
      document.getElementById("badge_type_"+row_id).innerText = d.Type_doc;

      document.getElementById('booking_paid_'+row_id).innerText = d.encaissement ;
      document.getElementById('booking_paid_status_'+row_id).innerHTML = 
      d.encaissement >= row_price ? "<b class='text-green-500 dark:text-green-100'>PAYE</b>":
      d.encaissement < row_price && d.encaissement > 0 ? "<b class='text-orange-500 dark:text-orange-100'>PARTIEL</b>" : "<b class='text-red-500 dark:text-red-100'>IMPAYE</b>"  ;

    }

    if(ModalInStack('DetailsEventModal')){ // SI UPDATE PAIEMENT RESPONSE VALIDE
      let details_paid_rest_div = document.getElementById('booking_details_progress_rest_div');
      //PAIEMENT PARTIEL = RESTE à payer sinon VIDE
      d.encaissement < row_price ? details_paid_rest_div.innerText = (row_price-d.encaissement) + " Fr" : details_paid_rest_div.classList.add('hidden');

      let details_paid_div = document.getElementById('booking_details_progress_div');
      //PAIEMENT Encaissement
      details_paid_div.innerText = d.encaissement > 0 ? d.encaissement + " Fr" : "0";
      if(d.encaissement > 0){
        let convert_pourc = Math.min(Math.round((d.encaissement / row_price) * 10000) / 100, 100);
        details_paid_div.style.width = convert_pourc > 24 ? convert_pourc+"%" : "24px";
      } else {details_paid_div.style.width = "24px"; }
      
    }
  }

  