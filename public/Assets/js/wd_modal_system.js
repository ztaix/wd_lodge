
// La pile pour garder une trace des fenêtres modales ouvertes
var modalStack = []; // Pile pour stocker les fenêtres modales ouvertes
var currentZIndex = 50; // Valeur initiale du zIndex
var isClosingModal = false;


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

  if (modalElement) {
    // Augmenter la valeur globale du zIndex
    currentZIndex += 1;

    // Appliquer le zIndex et afficher la fenêtre modale
    modalElement.style.zIndex = currentZIndex;
    modalElement.style.display = "block";
    modalElement.classList.add("animate");

    modalStack.push(modalElement); // Ajoute la fenêtre modale à la pile
  }
}

// Ferme la dernière fenêtre modale ouverte
function closeModal(all = false) {
  if(all === false){
    if (modalStack.length > 0) {
      let lastModal = modalStack.pop(); // Retire la dernière fenêtre modale de la pile
      lastModal.classList.add("close-animate"); // Ajoute la classe 'close-animate' pour animer la fermeture

      // Retire la classe 'close-animate' après l'animation
      setTimeout(() => {
        lastModal.classList.remove("animate");
        lastModal.classList.remove("close-animate");
        lastModal.style.display = "none";
      }, 1000); // Correspond à la durée de l'animation slideDown
    }
  }
  else{
    // Boucle tant qu'il y a des modales dans la pile
    while (modalStack.length > 0) {
      let currentModal = modalStack.pop(); // Retire la dernière fenêtre modale de la pile
      currentModal.classList.add("close-animate"); // Ajoute la classe 'close-animate' pour animer la fermeture

      // Retire la classe 'close-animate' après l'animation
      setTimeout(() => {
          currentModal.classList.remove("animate");
          currentModal.classList.remove("close-animate");
          currentModal.style.display = "none";
      }, 1000); // Correspond à la durée de l'animation slideDown
    }
  }
}
function closeModalById(modalId) {
  let modalElement = document.getElementById(modalId);

  if (modalElement) {
    modalElement.classList.add("close-animate"); // Ajoute la classe 'close-animate' pour animer la fermeture

    // Retire la classe 'close-animate' après l'animation

    modalElement.classList.remove("animate");
    modalElement.classList.remove("close-animate");
    modalElement.style.display = "none";

    // Retire la fenêtre modale spécifiée de la pile
    modalStack = modalStack.filter((modal) => modal.id !== modalId);

    // Si une fenêtre modale est toujours dans la pile, alors la rouvrir
    if (modalStack.length > 0) {
      let previousModal = modalStack[modalStack.length - 1];
      previousModal.style.display = "block";
      previousModal.classList.add("animate");
    }
  }
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
