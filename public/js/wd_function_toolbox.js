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

async function ajaxCall(url, method, data, successCallback, errorCallback) {
  // Récupération du token stocké
  var token = localStorage.getItem('token');
  // Définition de l'entête d'autorisation
  var headers = {
    Authorization: 'Bearer ' + token,
    'Content-Type':
      method === 'POST'
        ? 'application/json'
        : 'application/x-www-form-urlencoded; charset=UTF-8',
  };

  // Préparation des données pour la requête si la méthode n'est pas GET
  var body;
  if (method !== 'GET') {
    body = JSON.stringify(data); // Convertit l'objet en chaîne JSON
  } else {
    if (data) {
      let query = new URLSearchParams(data).toString();
      if (query === 'null=') {
        query = '';
      }
      url += '?' + query; // Ajoute les paramètres à l'URL pour une requête GET
    }
  }

  // Exécution de la requête fetch
  return fetch(baseurl + url, {
    method: method,
    headers: headers,
    body: method !== 'GET' ? body : null, // N'ajoutez le corps que pour les méthodes POST, PUT, etc.
  })
    .then(async (response) => {
      if (response.ok) {
        return response.json(); // Renvoie une promesse résolue avec le résultat JSON
      } else {
        // Gestion des erreurs côté serveur
        const error = await response.json();
        throw error; // Propage l'erreur pour être capturée plus loin
      }
    })
    .then((response) => {
      // Appel de la fonction de rappel de succès si tout va bien
      if (typeof successCallback === 'function') {
        successCallback(response);
      }
      return response; // Résout la promesse avec la réponse
    })
    .catch((error) => {
      // Gestion des erreurs réseau ou de réponse
      if (error.status === 401) {
        // Gestion spécifique des erreurs d'autorisation
        showBanner(
          'Session expirée ou invalide, veuillez vous reconnecter',
          false
        );
        var currentPage = window.location.pathname;
        var loginPath = 'auth';
        if (currentPage !== loginPath) {
          setTimeout(() => {
            window.location.href = baseurl + loginPath;
          }, 2000);
        }
      } else {
        // Appel de la fonction de rappel d'erreur si fournie
        if (typeof errorCallback === 'function') {
          errorCallback(error);
        } else {
          // Affiche un message d'erreur générique si aucune fonction de rappel d'erreur n'est fournie
          var errorMessage = error.error
            ? error.error
            : 'Erreur lors de la requête réseau';
          showBanner(errorMessage, false);
        }
      }
      // Rejette la promesse avec l'erreur
      return Promise.reject(error);
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
  let total =
    parseInt(price) +
    parseInt(qtTraveller) * parseInt(tax) * parseInt(days) +
    parseInt(fee);
  return total;
}

// SUM the ARRRAY
function sumArray(paids_values) {
  let array_paids_values = paids_values
    ? paids_values.split(',').map(Number)
    : [0];
  let paids_sum = array_paids_values.reduce(
    (total, currentValue) => total + currentValue,
    0
  );

  return paids_sum;
}

//COLOR
function lightenHexColor(hex, percent) {
  // Convertir le hex en RGB
  let r = parseInt(hex.substring(1, 3), 16);
  let g = parseInt(hex.substring(3, 5), 16);
  let b = parseInt(hex.substring(5, 7), 16);

  // Augmenter chaque composant de couleur par le pourcentage donné
  r = parseInt((r * (100 + percent)) / 100);
  g = parseInt((g * (100 + percent)) / 100);
  b = parseInt((b * (100 + percent)) / 100);

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

//DATES / TIME
function check_date(input_date) {
  // Vérifier si input_date est déjà un objet Date valide
  if (input_date instanceof Date && !isNaN(input_date)) {
    return input_date;
  }
  // Expression régulière pour vérifier les formats de date
  const regexFormats = {
    'YYYY-MM-DD': /^\d{4}-\d{2}-\d{2}$/,
    'DD/MM/YYYY': /^\d{2}\/\d{2}\/\d{4}$/,
    'DD-MM-YYYY': /^\d{2}-\d{2}-\d{4}$/,
    'YYYY-MM-DD HH:MM:SS': /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/,
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
    return console.log('Erreur, Format de date invalide');
  }

  // Convertir la date en format compatible avec l'objet Date de JavaScript
  if (dateFormat === 'DD/MM/YYYY') {
    const [day, month, year] = input_date.split('/');
    input_date = `${year}-${month}-${day}`;
  } else if (dateFormat === 'DD-MM-YYYY') {
    const [day, month, year] = input_date.split('-');
    input_date = `${year}-${month}-${day}`;
  }

  // Convertir la date en format compatible avec l'objet Date de JavaScript
  let dateObj;
  if (
    dateFormat === 'DD/MM/YYYY' ||
    dateFormat === 'DD-MM-YYYY' ||
    dateFormat === 'YYYY-MM-DD'
  ) {
    const [year, month, day] = input_date.split('-');
    dateObj = new Date(year, month - 1, day); // Les mois sont de 0 à 11, traité comme date locale
  } else {
    // Pour les formats avec heure, traiter comme date locale
    const parts = input_date.split(/[- :]/);
    dateObj = new Date(
      parts[0],
      parts[1] - 1,
      parts[2],
      parts[3] || 0,
      parts[4] || 0,
      parts[5] || 0
    );
  }
  if (!(dateObj instanceof Date) || isNaN(dateObj.getTime())) {
    console.log('Erreur, Format de date invalide ou date invalide');
    return null; // Renvoie null pour indiquer une erreur
  }
  return dateObj;
}

function format_date(
  input_date,
  daysToAdd = 0,
  shorter = false,
  returnAsDateObject = false
) {
  let dateObj = check_date(input_date);
  if (!dateObj) {
    return 'Date invalide'; // Ou gérer autrement l'erreur
  }
  // Ajouter des jours si nécessaire
  dateObj.setDate(dateObj.getDate() + daysToAdd);

  // Si l'utilisateur demande un objet Date, le retourner immédiatement
  if (returnAsDateObject) {
    return dateObj;
  }

  // Récupérer le jour, le mois et l'année
  let day = String(dateObj.getDate()).padStart(2, '0');
  let month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Les mois sont de 0 à 11
  let year = dateObj.getFullYear();
  let hours = String(dateObj.getHours()).padStart(2, '0');
  let minutes = String(dateObj.getMinutes()).padStart(2, '0');
  // Formater la date
  if (shorter === true) {
    result = shortenYearInDate(`${day}-${month}-${year}`);
  } else if (shorter == 'HH:MM DD/MM/YY') {
    result = `${hours}h${minutes} ${day}/${month}/${year}`;
  } else if (shorter == 'DD-MM') {
    result = `${day}-${month}`;
  } else if (shorter == 'DD/MM') {
    result = `${day}/${month}`;
  } else if (shorter == 'DD/MM/YYYY') {
    result = `${day}/${month}/${year}`;
  } else if (shorter == 'DD') {
    result = `${day}`;
  } else if (shorter == 'DD-Mois-YY') {
    result = `${day} ${moisFrancais[month].substring(0, 3)}. ${year}`;
  } else if (shorter == 'DD-Mois') {
    result = ` ${day} ${moisFrancais[month]}`;
  } else if (shorter == 'Mois') {
    result = moisFrancais[month];
  } else {
    result = `${day}-${month}-${year}`;
  }
  return result;
}

function parseDate(str) {
  const [day, month, year] = str.split('-');
  return new Date(year, month - 1, day);
}
function nDaysBetween(start, end) {
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

function DaysDifferenceStartEnd(start, end) {
  let start_obj = check_date(start);
  let end_obj = check_date(end);

  let timeDifference = end_obj.getTime() - start_obj.getTime();
  let dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));
  return dayDifference;
}

function shortenYearInDate(date) {
  let parts = date.split('-');
  let yearShort = parts[2].substring(2); // Prend les deux derniers chiffres de l'année
  return `${parts[0]}-${parts[1]}-${yearShort}`;
}

function format_date_toSql(input_date) {
  // Découpe la date en ses composantes (jour, mois, année)
  let [day, month, year] = input_date.split('-');

  // Recompose la date au format souhaité
  return `${year}-${month}-${day} 00:00:00`;
}

function getDayOfWeek(dateString) {
  let [day, month, year] = dateString.split('-');
  let date = new Date(year, month - 1, day);
  let dayOfWeek = date.getDay();
  let days = [
    'Dimanche',
    'Lundi',
    'Mardi',
    'Mercredi',
    'Jeudi',
    'Vendredi',
    'Samedi',
  ];

  return days[dayOfWeek];
}
function formatDate(date, ISO = false) {
  let day = String(date.getDate()).padStart(2, '0');
  let month = String(date.getMonth() + 1).padStart(2, '0');
  let year = date.getFullYear();
  if (ISO === 'ISO 8601') {
    return `${year}-${month}-${day}`;
  } else {
    return `${day}-${month}-${year}`;
  }
}

/**
 * Converts a given period into start and end dates.
 * @param {string} periode - The period to convert.
 * @returns {Object} - An object containing the start and end dates.
 

*/
function periodeToDate(periode) {
  let lowerPeriode = periode.trim().toLowerCase();
  let dates = {};
  let currentDate = new Date();
  let start, end;

  switch (lowerPeriode) {
    case 'today':
      start = end = currentDate;
      break;

    case 'thisweek':
      let firstDayOfWeek =
        currentDate.getDate() -
        currentDate.getDay() +
        (currentDate.getDay() === 0 ? -6 : 1); // Get the first day of the week (Monday)
      let lastDayOfWeek = firstDayOfWeek + 6; // Get the last day of the week (Sunday)
      start = new Date(currentDate.setDate(firstDayOfWeek));
      end = new Date(currentDate.setDate(lastDayOfWeek));
      break;

    case 'thismonth':
      let firstDayOfMonth = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth(),
        1
      );
      let lastDayOfMonth = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth() + 1,
        0
      );
      start = firstDayOfMonth;
      end = lastDayOfMonth;
      break;

    case 'lastmonth':
      let firstDayOfLastMonth = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth() - 1,
        1
      );
      let lastDayOfLastMonth = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth(),
        0
      );
      start = firstDayOfLastMonth;
      end = lastDayOfLastMonth;
      break;

    case 'thisyear':
      let firstDayOfYear = new Date(currentDate.getFullYear(), 0, 1);
      let lastDayOfYear = new Date(currentDate.getFullYear(), 11, 31);
      start = firstDayOfYear;
      end = lastDayOfYear;
      break;

    case 'lastyear':
      let firstDayOfLastYear = new Date(currentDate.getFullYear() - 1, 0, 1);
      let lastDayOfLastYear = new Date(currentDate.getFullYear() - 1, 11, 31);
      start = firstDayOfLastYear;
      end = lastDayOfLastYear;
      break;

    case 'all':
      start = new Date(currentDate.getFullYear() - 50, 0, 1); // Earliest date JavaScript can handle
      end = new Date(currentDate.getFullYear() + 50, 11, 31); // Latest date JavaScript can handle
      break;

    case 'custom':
      start = end = null;
      break;

    default:
      break;
  }

  dates = {
    start: start === null ? null : formatDate(start, 'ISO 8601'),
    end: end === null ? null : formatDate(end, 'ISO 8601'),
  };

  return dates;
}

//
function updateCountdown(ttl) {
  let a_ttl = document.getElementById('extend_ttl');
  countdownInterval = setInterval(function () {
    // Décrémente TTL
    ttl--;

    // Conversion de TTL en jours, heures, minutes et secondes
    const jours = Math.floor(ttl / (3600 * 24));
    const heures = Math.floor((ttl % (3600 * 24)) / 3600);
    const minutes = Math.floor((ttl % 3600) / 60);
    const secondes = Math.floor(ttl % 60);

    // Construction de la chaîne de temps restant
    let tempsRestant;
    if (jours > 0) {
      tempsRestant = `${jours} jours${heures > 0 ? ' - ' + heures + 'h' : ''}`;
    } else if (heures > 0) {
      tempsRestant = `${heures}:${minutes > 0 ? minutes + ':' + secondes : ''}`;
    } else if (minutes > 0) {
      tempsRestant = `00:${minutes}:${secondes > 0 ? secondes : ''}`;
    } else {
      tempsRestant = `${secondes} secondes`;
    }

    // Met à jour l'affichage
    a_ttl.innerHTML = `<div class="relative flex flex-col">
    <div class="justify-normal">Raffraichir la session</div>
    <div class="justify-center font-thin">Temps restant : ${tempsRestant}</div>
    </div>`;

    // Vérifie si le TTL a atteint 0 pour arrêter l'intervalle
    if (ttl <= 0) {
      clearInterval(countdownInterval);
      a_ttl.innerHTML = `<div class="relative flex flex-col">
      <div class="justify-normal">Session de connexion terminé, raffraichir !</div>
      </div>`;
    }
  }, 1000);
}

// SERVICE Liste
/**
 * Renvoi une liste de service disponible pour la date sélectionné
 * @param {date} clickedDate - Date du jour
 * @param {array} listService - Liste fixe des services disponible (Array)
 * @param {array} booked - Liste des résa donnée à une date donnée (Object in Array)
 * @return {array} liste des services disponible
 */
function availableListServices(clickedDate, listService, booked) {
  let availableServices = [];

  const clickedDateFormat = format_date(clickedDate, 0, false, true);

  // Vérifier si un service est complètement bloqué pour la date sélectionnée
  const isFullBlocked = booked.some(
    (b) =>
      b.fullblocked === '1' &&
      clickedDateFormat >= format_date(b.start, 0, false, true) &&
      clickedDateFormat < format_date(b.end, 0, false, true)
  );

  // Vérifier si n'importe quel service est déjà réservé pour cette date
  const isAnyServiceBooked = booked.some(
    (b) =>
      clickedDateFormat >= format_date(b.start, 0, false, true) &&
      clickedDateFormat < format_date(b.end, 0, false, true)
  );

  if (!isFullBlocked) {
    // Convertir la liste des réservations en un ensemble des services non disponibles
    const unavailableServiceIds = booked.reduce((set, b) => {
      if (format_date(b.end, 0, false, true) > clickedDateFormat) {
        set.add(b.Service_id);
      }
      return set;
    }, new Set());

    availableServices = listService.filter((service) => {
      // Si un service est déjà réservé et le service en cours a `fullblocked` à '1', alors ce service n'est pas disponible
      if (isAnyServiceBooked && service.fullblocked === '1') {
        return false;
      }
      // Sinon, filtrer normalement en se basant sur unavailableServiceIds
      return (
        !unavailableServiceIds.has(service.Service_id) ||
        booked.some(
          (b) =>
            b.Service_id === service.Service_id &&
            format_date(b.end, 0, false, true) === clickedDateFormat
        )
      );
    });
  } else {
    // Si isFullBlocked est vrai, tous les services sont considérés comme indisponibles,
    availableServices = []; // Aucun service disponible
  }
  return availableServices;
}

// AJAX service
function updatePayments(payments_filtered, updatedData) {
  ajaxCall(
    'paids/upsert',
    'POST',
    { payments: payments_filtered },
    function (response) {
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
          showBanner('Echec de la mise à jour des paiements !', false);
          console.log('Erreurs: ', allErrors);
        }
      }
    }
  );
}

// Mettre à jour la modale, fermer la modale, mettre à jour le calendrier, etc.
function finalizeUpdate(updatedData) {
  updateModal(updatedData);
  closeModalById('addEventModal');
  if (calendar) {
    calendar.refetchEvents();
  }
  showBanner('Evènement mis à jour avec succès !', true);
}

function showDateCalendarFromClic(dateClicked) {
  // Utilisez la fonction ajaxCall personnalisée pour effectuer la requête
  ajaxCall('booking/getBookingsFromDate', 'GET', { date: dateClicked })
    .then((response) => {
      // Traitement en cas de succès de la requête
      const startdate = format_date(dateClicked);
      const enddate = format_date(dateClicked, 1);

      if (response.success && response.data.events.length > 0) {
        showBookingList(response.data.events, dateClicked);
      } else {
        resetForm('addEventModal', startdate, enddate);
        updateTotalInfo();
        updatePrice();
        openModal('addEventModal');
      }
    })
    .catch(({ xhr, status, error }) => {
      // Traitement en cas d'échec de la requête
      // La gestion d'erreur spécifique est déjà traitée dans ajaxCall, donc pas besoin de dupliquer ici
      console.error('Erreur lors de la requête AJAX: ', error);
    });
}

/**
 * Alterne entre 'Facture' et 'Devis' pour un client et met à jour l'affichage.
 * Change `currentDocType`, met à jour le texte du bouton et rafraîchit la liste affichée.
 *
 * @global currentDocType {string} - Type de document actuel ('Facture' ou 'Devis').
 * @effects Modifie `currentDocType`, texte du bouton, et relance get_booking_list_from_customer avec le type actualisé.
 */
function customerDocType(data) {
  // Changer le type de document
  currentDocType = currentDocType === 'Facture' ? 'Devis' : 'Facture';

  // Mettre à jour le style du bouton de bascule
  var toggleDot = document.getElementById('customerDocType_bgtoggleDot');
  if (currentDocType === 'Devis') {
    toggleDot.classList.add('devis'); // Ajoutez la classe 'devis' pour déplacer le cercle
  } else {
    toggleDot.classList.remove('devis'); // Retirez la classe 'devis' pour remettre le cercle à sa position initiale
  }

  // Appeler la fonction pour rafraîchir les données affichées après un petit délai
  setTimeout(function () {
    get_booking_list_from_customer(data);
  }, 350);
}

function verifyToken(extend = false) {
  return new Promise((resolve, reject) => {
    const extending = extend ? '?extend=true' : '';
    ajaxCall(
      'auth/verifyToken' + extending,
      'GET',
      null,
      (response) => {
        if (response.success) {
          localStorage.setItem('timeLeft', response.timeLeft);
          startTokenCountdown();
          if (extend) {
            resolve(response.jwt);
          } else {
            resolve(true);
          }
        } else {
          showBanner(response.message, false);
          resolve(false);
        }
      },
      (xhr, status, error) => {
        //showBanner(xhr.message, false);
        reject(new Error(xhr.message || 'Echec de la vérifation du token'));
      }
    );
  });
}

// localStorage

// Fonction pour sauvegarder les valeurs dans le localStorage
function saveToLocalStorage(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}

// Fonction pour récupérer les valeurs depuis le localStorage
function getFromLocalStorage(key) {
  const value = localStorage.getItem(key);
  return value ? JSON.parse(value) : null;
}
