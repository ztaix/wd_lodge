<script>
    var totalServices = <?= $totalServices; ?>;
</script>

<?php
$periodeName = [
    "today" => "Aujourd'hui",
    "thisweek" => "Cette semaine",
    "thismonth" => "Ce mois",
    "lastmonth" => "Dernier mois",
    "thisyear" => "Cette année",
    "lastyear" => "Année passée",
    "all" => "En tout temps",
    "custom" => "Personnalisé"
];
$jsonPeriodeNames = json_encode($periodeName);

$options_customers_id = [];
foreach ($customers_list as $customer) {
    $options_customers_id[$customer['Customer_id']] = $customer['Name'];
}

$options_services_id = [];
$prices = [];

foreach ($services_list as $service) {
    $options_services_id[$service['Service_id']] = $service['Title'];
    $prices[$service['Service_id']] = $service['Price'];
}
$data['options_services_id'] = $options_services_id;
$data['options_customers_id'] = $options_customers_id;

?>

<script>
    var prices = <?php echo json_encode($prices); ?>;
</script>

<?php echo view('modals/modal_customer_update', $data); ?>
<?php echo view('modals/modal_delete_confirm', $data); ?>
<?php echo view('modals/modal_add_event', $data); ?>
<?php echo view('modals/modal_booking_details', $data); ?>
<?php echo view('modals/modal_bookings_list', $data); ?>

<div id="history" class="max-w-screen-lg bg-gray-50 dark:bg-gray-900">

    <header>Historique</header>

    <div class="mx-auto px-4">
        <!-- Start Container -->
        <div class="relative bg-white dark:bg-gray-800 border border-slate-100 dark:border-slate-900 shadow-md rounded-lg ">
            <div class="flex flex-col items-center space-y-3 p-4">

                <div class="w-full ">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Rechercher</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Rechercher" required="">
                        </div>
                    </form>
                </div>

                <div class="w-full ">
                    <div class="relative">
                        <div class="flex">
                            <button name="periode" id="toggleButton1" class="toggleButton text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-xl">Période</button>
                            <button id="toggleButton2" disabled class="toggleButton text-gray-500 bg-gray-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600  focus:outline-none dark:focus:ring-gray-800 shadow-xl">Filtrer</button>
                            <button id="toggleButton3" disabled class="toggleButton text-gray-500 bg-gray-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600  focus:outline-none dark:focus:ring-gray-800 shadow-xl">Exporter</button>
                        </div>
                        <div id="toggleDiv1" class="toggleDiv absolute z-50 w-full bg-white dark:bg-gray-800 border border-slate-100 dark:border-slate-900 shadow-md rounded-lg  mt-2 overflow-hidden" style="max-height: 0; transition: max-height 0.3s ease-out; opacity: 0; transition: opacity 0.3s;">
                            <div class="flex flex-col p-4">
                                <div class="flex flex-col md:flex-row">
                                    <div class="w-full md:w-1/2 px-4">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-400 text-xs font-bold mb-2" for="start-date">
                                            Date de début
                                        </label>
                                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="start-date" type="date" placeholder="JJ/MM/AAAA">
                                    </div>
                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-400 text-xs font-bold mb-2" for="end-date">
                                            Date de fin
                                        </label>
                                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="end-date" type="date" placeholder="JJ/MM/AAAA">
                                    </div>
                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-400 text-xs font-bold mb-2" for="single-choice-list">
                                            Période
                                        </label>
                                        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="single-choice-list">
                                            <?php foreach ($periodeName as $key => $value) { ?>
                                                <option value="<?= $key; ?>"><?= $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <script>
                                var periodeTexts = <?php echo $jsonPeriodeNames; ?>;

                                window.addEventListener('DOMContentLoaded', function() {
                                    //Période to date
                                    var inputStartDate = document.getElementById('start-date');
                                    var inputEndDate = document.getElementById('end-date');
                                    var selectPeriod = document.getElementById('single-choice-list');
                                    var togglePeriodButton = document.getElementById('toggleButton1');
                                    var selectedPeriod = getFromLocalStorage('selectedPeriod') ? getFromLocalStorage('selectedPeriod') : null;
                                    var startDate = getFromLocalStorage('startDate') ? getFromLocalStorage('startDate') : null;
                                    var endDate = getFromLocalStorage('endDate') ? getFromLocalStorage('endDate') : null;
                                    // Mettre à jour les champs de date dans le HTML avec les valeurs renvoyées
                                    function updateDateFields(start, end, periode) {
                                        inputStartDate.value = start;
                                        inputStartDate.dispatchEvent(new Event('change'));
                                        inputEndDate.value = end;
                                        inputEndDate.dispatchEvent(new Event('change'));
                                        if (togglePeriodButton) {
                                            selectPeriod.value = periode;
                                            togglePeriodButton.innerHTML = 'Période <br><span class="font-bold text-xs">' + (periodeTexts[periode] || "Non spécifié") + '</span>';
                                        }
                                    }

                                    if (selectedPeriod && startDate && endDate) {
                                        // Mettre à jour les champs de date avec les valeurs récupérées
                                        updateDateFields(startDate, endDate, selectedPeriod);
                                    }

                                    selectPeriod.addEventListener('change', function() {
                                        // Récupérer la valeur sélectionnée dans le menu déroulant
                                        let selectedPeriodValue = this.value;

                                        // Appeler la fonction periodeToDate() avec la valeur sélectionnée
                                        let dates = periodeToDate(selectedPeriodValue);
                                        updateDateFields(dates.start, dates.end, selectedPeriodValue);
                                        // Sauvegarder les valeurs dans le localStorage
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
                                    document.addEventListener('click', function(event) {

                                        // Vérifier si le clic a été effectué à l'intérieur du toggleDiv ou sur le bouton de bascule
                                        var toggleDiv = document.getElementById('toggleDiv1');

                                        if (!isDescendant(toggleDiv, event.target) && event.target !== togglePeriodButton || event.target.tagName === 'OPTION') {
                                            // Cacher le toggleDiv
                                            toggleDiv.style.opacity = '0';
                                            setTimeout(function() {
                                                toggleDiv.style.maxHeight = '0';
                                            }, 300); // Attendre la fin de la transition de l'opacité avant de définir la hauteur maximale sur 0
                                        }
                                    });

                                });
                            </script>
                        </div>
                        <!--
                        <div id="toggleDiv2" class="toggleDiv absolute z-10 w-full bg-white dark:bg-gray-800 border border-slate-100 dark:border-slate-900 shadow-md rounded-lg overflow-hidden mt-2" style="max-height: 0; transition: max-height 0.3s ease-out; opacity: 0; transition: opacity 0.3s;">
                            <div class="flex flex-col p-4">
                                <div class="flex items">item2</div>
                            </div>
                        </div>
                        <div id="toggleDiv3" class="toggleDiv absolute z-10 w-full bg-white dark:bg-gray-800 border border-slate-100 dark:border-slate-900 shadow-md rounded-lg overflow-hidden mt-2" style="max-height: 0; transition: max-height 0.3s ease-out; opacity: 0; transition: opacity 0.3s;">
                            <div class="flex flex-col p-4">
                                <div class="flex items">item3</div>
                            </div>
                        </div>-->
                    </div>
                </div>

                <script>
                    // loop pour cacher chaque div pour chaque bouton
                    var buttons = document.getElementsByClassName('toggleButton');
                    var divs = document.getElementsByClassName('toggleDiv');
                    for (var i = 0; i < buttons.length; i++) {
                        buttons[i].addEventListener('click', function() {
                            var divId = this.id.replace('Button', 'Div');
                            var div = document.getElementById(divId);
                            if (div.style.maxHeight === '0px' || div.style.maxHeight === '') {
                                for (var j = 0; j < divs.length; j++) {
                                    divs[j].style.opacity = '0';
                                    divs[j].style.maxHeight = '0';
                                }
                                div.style.maxHeight = (div.scrollHeight) + 'px';
                                setTimeout(function() {
                                    div.style.opacity = '1';
                                }, 50); // Wait for the max-height change to take effect before starting the opacity transition
                            } else {
                                div.style.opacity = '0';
                                setTimeout(function() {
                                    div.style.maxHeight = '0';
                                }, 500); // Wait for the opacity transition to finish before setting max-height to 0
                            }
                        });
                    }
                </script>

            </div>

            <div class="overflow-x-auto">
                <table id="history_list" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Type</th>
                            <th scope="col" class="px-2 py-3"></th>
                            <th scope="col" class="px-4 py-3">Client</th>
                            <th scope="col" class="px-4 py-3">Voyageurs</th>
                            <th scope="col" class="px-4 py-3">Service</th>
                            <th scope="col" class="px-4 py-3">Nuits</th>
                            <th scope="col" class="px-4 py-3">Période</th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <div id="items-container">
                        <tbody>

                            <?php $reversed_array = array_reverse($bookings_list);
                            foreach ($reversed_array as $booking) {
                            ?>
                                <tr class="ROW row_booking_<?= $booking['id']; ?> service_<?= $booking['Service_id']; ?> hover:bg-gray-50 hover:dark:bg-gray-900 border-b dark:border-slate-700 cursor-pointer whitespace-nowrap" onclick="showBookingDetailsFromID('<?= $booking['id']; ?>')">
                                    <td class="px-4 py-3"><?= $booking['Type_doc']; ?></td>
                                    <td class="py-3 text-xs"># <?= $booking['id']; ?></td>
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $booking['customer_name']; ?></th>
                                    <th scope="row" class="px-4 py-3"><?= $booking['QtTraveller']; ?></th>
                                    <td class="px-4 py-3"> <?= $booking['service_title']; ?></td>
                                    <td class="px-4 py-3 text-center"> <?= countNights(sql_date_to_dmY($booking['start']), sql_date_to_dmY($booking['end'])) ?></td>
                                    <td class="px-4 py-3 inline-flex">
                                        <span class="booking-start-date"><?= sql_date_to_dmY($booking['start']); ?></span>
                                        <svg class="w-3 h-3 mx-1 my-1 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                        <span class="booking-end-date"><?= sql_date_to_dmY($booking['end']); ?></span>
                                    </td>
                                    <td class="px-3 py-3" onclick="deleteEvent(event, '<?= $booking['id']; ?>')">
                                        <svg class="w-4 h-4 text-red-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </div>
                </table>
            </div>
            <div id="pagination-container">
                <!-- INJECTION des boutons de pagination -->
            </div>
        </div>
    </div>
</div>

<script>
    //////////////////////////////////////////////////

    // Periode filtre
    function filterBookings() {
        // Récupérer les valeurs des champs de date
        let startDateValue = document.getElementById('start-date').value;
        let startParts = startDateValue.split('-');
        let startformattedDate = startParts[1] + '/' + startParts[2] + '/' + startParts[0];
        let startDate = new Date(startformattedDate);

        let endDateValue = document.getElementById('end-date').value;
        let endParts = endDateValue.split('-');
        let endformattedDate = endParts[1] + '/' + endParts[2] + '/' + endParts[0];
        let endDate = new Date(endformattedDate);

        // Parcourir tous les éléments du tableau
        let bookingsRows = document.querySelectorAll('.ROW');
        bookingsRows.forEach(function(row) {
            // Récupérer les valeurs des cellules de date dans la ligne du tableau
            let bookingStartDate = new Date(row.querySelector('.booking-start-date').innerText);

            // Comparer les valeurs des champs de date avec celles du tableau
            if (bookingStartDate >= startDate && bookingStartDate <= endDate) {
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
        all_bookings.forEach(booking => booking.style.display = 'none');

        // Afficher les éléments pour la page actuelle
        all_bookings.slice(start, end).forEach(booking => booking.style.display = '');

        currentPage = page;
        updatePagination(); // Ajoutez cette ligne

    }

    function updatePagination() {
        let paginationHtml = `
    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
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


    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('simple-search');
        const table = document.getElementById('history_list');
        const rows = table.querySelectorAll('tbody tr');

        input.addEventListener('input', function() {
            const query = this.value.toLowerCase();

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });


    function updateTable() {
        const query = document.getElementById('simple-search').value.toLowerCase();
        const all_bookings = Array.from(document.querySelectorAll('.ROW'));

        all_bookings.forEach(row => {
            let text = row.textContent.toLowerCase();
            const serviceId = row.className.split(' ').find(className => className.startsWith('service-'));

            const isCheckboxChecked = document.querySelector(`.filter-checkbox[value="${serviceId}"]`).checked;

            if (isCheckboxChecked && text.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Fonction pour synchroniser le filtrage par période avec la pagination
    function filterAndPaginate() {
        // Appliquer le filtre
        filterBookings();

        // Mettre à jour la liste des réservations visibles après filtrage
        all_bookings = Array.from(document.querySelectorAll('.ROW')).filter(row => row.style.display !== 'none');

        // Recalculer le nombre total de pages
        totalPages = Math.ceil(all_bookings.length / itemsPerPage);

        // Réinitialiser à la première page si le filtrage change le contenu
        showPage(1);
        updatePagination();
    }

    // Affiche la première page et initialise la pagination
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('start-date').addEventListener('change', filterAndPaginate);
        document.getElementById('end-date').addEventListener('change', filterAndPaginate);

        showPage(1);
        updatePagination();
    });



    var totalServices = <?= $totalServices; ?>;
</script>