
// La pile pour garder une trace des fenêtres modales ouvertes
var modalStack = []; // Pile pour stocker les fenêtres modales ouvertes
var ShadowmodalStack = []; // Pile pour stocker les fenêtres modales ouvertes
var currentZIndex = 50; // Valeur initiale du zIndex
var isClosingModal = false;

function urlLocation(){
   let segments = window.location.href.split('/');
   console.log('baseurl',baseurl);
   let dernierSegment = segments.pop() || segments.pop();
   
   let returnSegment = dernierSegment.toLowerCase().replace(/[^a-z0-9]/g, '');
   returnSegment = returnSegment == '' ||  returnSegment == 'public'  ? "calendar" : returnSegment;
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

  
function resetForm(modalId, start = false , end = false){
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
    ];

    
    form_addEventModal.forEach(input => {
      if(input == "ModaleventType_doc"){
        document.getElementById(input).value = 'Devis';
      }
      else if(input =="ModaleventQtTraveller" || input =="ModaleventQt" ){
        document.getElementById(input).value = 1;
      }
      else if( input == "ModaleventService_id" ){
        document.getElementById(input).value = discountservice[0].Service_id;
      }
      else if( input == "ModaleventCustomer_id"){
        let ModaleventCustomer_id = $('#ModaleventCustomer_id'); // Utilisez jQuery pour sélectionner l'élément
        ModaleventCustomer_id.val(1); // Changez la valeur
        ModaleventCustomer_id.trigger('change'); // Mettez à jour l'affichage de Select2
        
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
    loadAndInitDatepicker(1,date_start,date_end);
  }
}

function openModal(modalId) {
  
  let modalElement = document.getElementById(modalId);
  let shadow_modal = document.getElementById(modalId + '-shadow_modal');
  if (modalElement) {
    // Augmenter la valeur globale du zIndex

    // Appliquer le zIndex et afficher la fenêtre modale
    modalElement.style.zIndex = currentZIndex+2;
    modalElement.classList.add("animate");
    modalElement.classList.remove("close-animate");
    modalElement.classList.remove("hidden");

    shadow_modal.style.zIndex = currentZIndex+1;
    shadow_modal.classList.add("animate_shadow_modal");
    shadow_modal.classList.remove("close-animate_shadow_modal");
    shadow_modal.classList.remove("hidden");
    
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
}

// Ferme la dernière fenêtre modale ouverte
function closeModal() {
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
  }, 500);  

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
    }, 500);  
  }
  if(modalStack.length === 0  ){
       var current_page_DIV = document.getElementById(urlLocation())
       current_page_DIV.classList.remove('blur-lg');
  }
}

function closeModalById(modalId) {
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
  }, 500);
  
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
    return modal.id.includes(modalId);
  });
}
