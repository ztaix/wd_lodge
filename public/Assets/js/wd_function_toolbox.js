//
//USEFULL 
//
  // AJAX CALL
  /*** Fonction générique pour effectuer des appels AJAX.
  * 
  * Cette fonction simplifie la réalisation d'appels AJAX en encapsulant la méthode jQuery `$.ajax`.
  * Elle peut être utilisée pour envoyer des données à un serveur et gérer la réponse de manière asynchrone.
  *
  * @param {string} url - L'URL de la requête AJAX. Cette URL sera concaténée avec `baseurl` défini globalement.
  * @param {string} method - La méthode HTTP à utiliser pour la requête (ex. "GET", "POST").
  * @param {Object} data - Un objet contenant les données à envoyer avec la requête. Pour les requêtes GET, ceci est ajouté à l'URL.
  * @param {function} successCallback - Une fonction de rappel à exécuter si la requête réussit. La réponse du serveur est passée à cette fonction.
  * 
  * La fonction utilise la méthode `$.ajax` de jQuery pour effectuer la requête. Elle gère automatiquement les succès et les erreurs.
  * En cas de succès, la `successCallback` est appelée avec la réponse du serveur.
  * En cas d'échec, un message d'erreur est loggé dans la console.
  * 
  * Exemple d'utilisation :
  * 
  * ajaxCall("customer/update", "POST", { customer_info: data }, function(response) {
  *     if (response.status === "success") {
  *         // Traiter la réponse en cas de succès
  *     }
  * });
  */

  function ajaxCall(url, method, data, successCallback, errorCallback) {
    return new Promise((resolve, reject) => {
        var token = localStorage.getItem('token');
        
        var processData = true, contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        
        $.ajax({
            url: baseurl + url,
            type: method,
            data: data,
            processData: processData,
            contentType: contentType,
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                if (typeof successCallback === 'function') successCallback(response);
                resolve(response);
                
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) { // NON AUTHORISé
                  if(xhr.responseJSON.reason == 'form-error'){
                    
                    return showBanner(xhr.responseJSON.message, false);
                    
                  }else{
                    console.log('xhr.responseJSON',xhr.responseJSON);
                    var currentPage = window.location.pathname;
                    var loginPath = 'auth';
                    showBanner('Session expirée ou invalide, veuillez vous reconnecter',false);
                    if (currentPage !== loginPath) {
                      setTimeout(() => { window.location.href = baseurl + loginPath; }, 2000);
                    }
                  }
                  } else {
   
                    if (typeof errorCallback === 'function') errorCallback(xhr, status, error);
                    else {
                        // Si aucun errorCallback n'est fourni, affichez le message d'erreur par défaut
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : "Erreur lors de la requête AJAX : " + error;
                        showBanner(errorMessage,false); // Utilisez cette fonction pour afficher les erreurs
                    }
                    reject({xhr: xhr, status: status, error: error});
                }
            }
        });
    });
}
  

  //OBJET manipulation
  function emptyObj(obj) {
    return Object.keys(obj).length === 0;
  }

  // TEXT / STRING manipulation
  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  //Math
  /**
   * Calcule le prix total de la réservation.
   * @param {number} price - Le prix unitaire de la réservation.
   * @param {number} qtTraveller - Quantité de voyageurs.
   * @param {number} fee - Frais supplémentaires.
   * @param {number} tax - Taxe applicable par voyageur et par jour.
   * @param {number} days - Nombre de jours de la réservation.
   * @return {number} Le prix total de la réservation.
   */
  function totalBookingPriceCal(price, qtTraveller, tax, fee, days) {

    let total = parseInt(price) + (parseInt(qtTraveller) * parseInt(tax) * parseInt(days)) + parseInt(fee);
    return total;
  }

  // SUM the ARRRAY
  function sumArray(paids_values){
    let array_paids_values = paids_values ? paids_values.split(",").map(Number) : [0];
    let paids_sum = array_paids_values.reduce((total, currentValue) => total + currentValue,0);

    return paids_sum;
  }

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
  function check_date(input_date){

    // Vérifier si input_date est déjà un objet Date valide
    if (input_date instanceof Date && !isNaN(input_date)) {
      return input_date;
    }
  // Expression régulière pour vérifier les formats de date
  const regexFormats = {
    "YYYY-MM-DD": /^\d{4}-\d{2}-\d{2}$/,
    "DD/MM/YYYY": /^\d{2}\/\d{2}\/\d{4}$/,
    "DD-MM-YYYY": /^\d{2}-\d{2}-\d{4}$/,
    "YYYY-MM-DD HH:MM:SS": /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/
  };
  
  // Trouver le format correspondant
  let dateFormat;
  for (let format in regexFormats) {
    if (regexFormats[format].test(input_date)) {
      dateFormat = format;
      break;
    }
  }
  
  if (!dateFormat) {
    return 'Format de date invalide';
  }
  
  // Convertir la date en format compatible avec l'objet Date de JavaScript
  if (dateFormat === "DD/MM/YYYY") {
    const [day, month, year] = input_date.split("/");
    input_date = `${year}-${month}-${day}`;
  } else if (dateFormat === "DD-MM-YYYY") {
    const [day, month, year] = input_date.split("-");
    input_date = `${year}-${month}-${day}`;
  }
  
  // Convertir la date en format compatible avec l'objet Date de JavaScript
  let dateObj;
  if (dateFormat === "DD/MM/YYYY" || dateFormat === "DD-MM-YYYY" || dateFormat === "YYYY-MM-DD") {
    const [year, month, day] = input_date.split("-");
    dateObj = new Date(year, month - 1, day); // Les mois sont de 0 à 11, traité comme date locale
  } else {
    // Pour les formats avec heure, traiter comme date locale
    const parts = input_date.split(/[- :]/);
    dateObj = new Date(parts[0], parts[1] - 1, parts[2], parts[3] || 0, parts[4] || 0, parts[5] || 0);
  }
  // Vérifier si la date est valide
  if (isNaN(dateObj.getTime())) {
    return 'Date invalide';
  }
  return dateObj;
  }

  function format_date(input_date, daysToAdd = 0, shorter = false) {
    let dateObj = check_date(input_date);
    
    // Ajouter des jours si nécessaire
    dateObj.setDate(dateObj.getDate() + daysToAdd);
    
    // Récupérer le jour, le mois et l'année
    let day = String(dateObj.getDate()).padStart(2, "0");
    let month = String(dateObj.getMonth() + 1).padStart(2, "0"); // Les mois sont de 0 à 11
    let year = dateObj.getFullYear();
    // Formater la date
    if (shorter === true) {
      result = shortenYearInDate(`${day}-${month}-${year}`);
    } 
    else if(shorter == 'DD-MM') {
      result = `${day}-${month}`;
    }
    else if(shorter == 'DD/MM') {
      result = `${day}/${month}`;
    }
    else if(shorter == 'DD') {
      result = `${day}`;
    }
    else if(shorter == 'DD-Mois-YY') {
      result = `${day} ${moisFrancais[month].substring(0, 3)}. ${year}`;
    }
    else if(shorter == 'DD-Mois') {
      result = ` ${day} ${moisFrancais[month]}`;
    }
    else if(shorter == 'Mois') {
      result = moisFrancais[month];
    }
    else {
      result = `${day}-${month}-${year}`;
    }
      return result;
  }
  
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

  function DaysDifferenceStartEnd(start, end){

    let start_obj = check_date(start);
    let end_obj = check_date(end);
  
    let timeDifference = end_obj.getTime() - start_obj.getTime();
    let dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));
    return dayDifference;
  }

  function shortenYearInDate(date) {
    let parts = date.split("-");
    let yearShort = parts[2].substring(2); // Prend les deux derniers chiffres de l'année
    return `${parts[0]}-${parts[1]}-${yearShort}`;
  }
  
  function format_date_toSql(input_date) {
    // Découpe la date en ses composantes (jour, mois, année)
    let [day, month, year] = input_date.split("-");

    // Recompose la date au format souhaité
    return `${year}-${month}-${day} 00:00:00`;
  }

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

// SERVICE Liste
  /**
   * Renvoi une liste de service disponible pour la date sélectionné
   * @param {date} clickedDate - Date du jour
   * @param {array} listService - Liste fixe des services disponible (Array)
   * @param {array} booked - Liste des résa donnée à une date donnée (Array)
   * @return {array} liste des services disponible
   */
function availableListServices(clickedDate,listService,booked){
  let availableServices = [];

  const isFullBlocked = booked.some(reservation => 
    reservation.fullblocked === "1" && format_date(reservation.end) >= clickedDate
  );
  // Vérifier si un service est déjà réservé
  const isAnyServiceBooked = booked.some(reservation => 
    format_date(reservation.end) >= clickedDate
  );

  if (!isFullBlocked) {

      // Convertir la liste des réservations en un ensemble des services non disponibles
      const unavailableServiceIds = booked.reduce((set, reservation) => {
        //te Si la date de fin est strictement supérieure à todayDa, le service est considéré comme indisponible
        if (format_date(reservation.end) > format_date(clickedDate)) {
          set.add(reservation.Service_id);
        }
        return set;
      }, new Set());
      
      availableServices = listService.filter(service => {
        // Si un service est déjà réservé, exclure tous les services avec `fullblocked`
        if (isAnyServiceBooked && service.fullblocked === "1") {
            return false;
        }
        // Sinon, filtrer normalement en se basant sur unavailableServiceIds
        return !unavailableServiceIds.has(service.Service_id) ||
            booked.some(reservation => 
                reservation.Service_id === service.Service_id && format_date(reservation.end) === clickedDate
            );
    });
  }

  return availableServices;

}

// AJAX service
function updatePayments(payments_filtered, updatedData) {
  ajaxCall("paids/upsert", "POST", {payments: payments_filtered}, function(response) {
    if (response.success === true) {
      let allSuccess = true;
      let allErrors = [];

      for (let key in response.data) {
          if (response.data.hasOwnProperty(key)) {
              let res = response.data[key];
              if (!res.success) {
                  allSuccess = false;
              }
              if (res.errors && res.errors.length > 0) {
                  allErrors.push(...res.errors);
              }
          }
      }

      if (allSuccess) {
        var encaissement = 0;
        // Parcourez l'objet reponse
        for (var key in response.data) {
          if (response.data.hasOwnProperty(key)) {
            // Accédez à la valeur "value" de chaque objet
            var value = response.data[key].data.value;
            
            // Checker si c'est bien un chiffre
            if (!isNaN(parseFloat(value))) {
              encaissement += parseFloat(value);
            }
          }
        }  
        // Récupére l'ID de la résa
        let updatedData_encaissement = Object.keys(updatedData);
        //Ajouter au tableau d'update l'encaissement total
        updatedData[updatedData_encaissement[0]].encaissement = encaissement;

        finalizeUpdate(updatedData);
      } else {
          showBanner("Echec de la mise à jour des paiements !", false);
          console.log('Erreurs: ', allErrors);
      }
    }
  });
}
  // Mettre à jour la modale, fermer la modale, mettre à jour le calendrier, etc.
  function finalizeUpdate(updatedData) {
    updateModal(updatedData);
    closeModalById('addEventModal');
    if (calendar) {
        calendar.refetchEvents();
    }
    showBanner("Evènement mis à jour avec succès !", true);
  }