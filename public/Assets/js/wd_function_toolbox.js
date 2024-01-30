//
//USEFULL 
//

  //COLOR
  function lightenHexColor(hex, percent) {
    // Convertir le hex en RGB
    let r = parseInt(hex.substring(1, 3), 16);
    let g = parseInt(hex.substring(3, 5), 16);
    let b = parseInt(hex.substring(5, 7), 16);
  
    // Augmenter chaque composant de couleur par le pourcentage donné
    r = parseInt(r * (100 + percent) / 100);
    g = parseInt(g * (100 + percent) / 100);
    b = parseInt(b * (100 + percent) / 100);
  
    // S'assurer que les valeurs restent dans les limites [0, 255]
    r = r < 255 ? r : 255;
    g = g < 255 ? g : 255;
    b = b < 255 ? b : 255;
  
    // Convertir les composants RGB de nouveau en une couleur hex
    let rr = r.toString(16).padStart(2, '0');
    let gg = g.toString(16).padStart(2, '0');
    let bb = b.toString(16).padStart(2, '0');
  
    return `#${rr}${gg}${bb}`;
  }

  //Files
  async function existFile(url) {
    try {
        const response = await fetch(url);
        const contentType = response.headers.get('Content-Type');
        // Vous pouvez ajuster la vérification ici en fonction de ce que vous attendez
        if (contentType && contentType.includes('image')) {
            return true;
        }
    } catch (error) {
        console.log('Erreur lors de la requête:', error);
        return false;
    } 
  }
  
  //DATES
  function parseDate(str) {
    const [day, month, year] = str.split('-');
    return new Date(year, month - 1, day);
  }
  function nDaysBetween(start,end){
    const startDate = parseDate(start);
    const endDate = parseDate(end);
    const diffTime = Math.abs(endDate - startDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    return parseInt(diffDays);
  }

  function getToday() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // Janvier est 0 !
    var yyyy = today.getFullYear();
  
    return dd + '-' + mm + '-' + yyyy;
  }

//
// MODAL CUSTOMER UPSERT function module
//
  // Met à jour les champs du formulaire avec les données récupérées
  function updateCustomersFormFields(customer) {
    document.getElementById("customer_id").value = customer.customer_id;
    document.getElementById("customer_name").value = customer.name;
    document.getElementById("customer_phone").value = customer.phone;
    document.getElementById("customer_email").value = customer.email;
    document.getElementById("customer_comment").value = customer.comment;
    document.getElementById("Update_customer_Modal_title").innerText = `Modifier Client #${customer.customer_id}`;
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
  let row_price =  totalBookingPriceCal(d.Price,d.QtTraveller,d.Tax,d.Fee,d.nDays);

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
    document.getElementById('booking_paid_status_'+row_id).innerText = 
    d.encaissement >= row_price ? "<b class='text-green-500 dark:text-green-100'>PAYE</b>":
    d.encaissement < row_price && d.encaissement > 0 ? "<b class='text-orange-500 dark:text-orange-100'>PARTIEL</b>" : "<b class='text-red-500 dark:text-red-100'>IMPAYE</b>"  ;

  }

  if(ModalInStack('DetailsEventModal')){ // SI UPDATE PAIEMENT RESPONSE VALIDE
    let details_paid_div = document.getElementById('booking_details_progress_div');
    details_paid_div.innerText = d.encaissement > 0 ? d.encaissement + " Fr" : "0";
    if(encaissement > 0){
      let convert_pourc = Math.min(Math.round((d.encaissement / row_price) * 10000) / 100, 100);
      details_paid_div.style.width = convert_pourc > 24 ? convert_pourc+"%" : "24px";
    } else {details_paid_div.style.width = "24px"; }
     
  }
}