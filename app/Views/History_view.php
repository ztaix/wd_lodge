<script>
    var totalServices = <?= $totalServices; ?>;
</script>

<?php

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

<div id='calendar' class="hidden text-gray-900 dark:text-white  bg-slate-50 dark:bg-slate-800"></div>

<header>Historique</header>

<div id="history" class="max-w-screen-md bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto px-4">
        <!-- Start Container -->
        <div class="bg-white dark:bg-gray-800 border border-slate-100 dark:border-slate-900 relative shadow-md rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Rechercher</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                        </div>
                    </form>
                </div>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

                    <div class="flex items-center space-x-3 w-full md:w-auto">

                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filter
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="filterDropdown" class="z-10 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 hidden" style="position: absolute; margin-top: 6rem; right: 10px">
                            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="filterDropdownButton">
                                <?php foreach ($services_list as $service) { ?>
                                    <li class="flex items-center">
                                        <input id="service_<?= $service['Service_id']; ?>" checked type="checkbox" value="service_<?= $service['Service_id']; ?>" class="filter-checkbox w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="service_<?= $service['Service_id']; ?>" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            <span style="display: inline-block;width: 8px;height: 8px; background-color: <?= $service['Color']; ?>; border-radius: 50%;"></span> <?= $service['Title']; ?></label>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="history_list" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Type</th>
                            <th scope="col" class="px-2 py-3"></th>
                            <th scope="col" class="px-4 py-3">Client</th>
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
                                <tr class="ROW row_booking_<?= $booking['id']; ?> service_<?= $booking['Service_id']; ?> hover:bg-gray-50 border-b dark:border-gray-700 cursor-pointer whitespace-nowrap" onclick="showBookingDetailsFromID(<?= $booking['id']; ?>)">
                                    <td class="px-4 py-3"><?= $booking['Type_doc']; ?></td>
                                    <td class=" py-3 text-xs"># <?= $booking['id']; ?></td>
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $booking['customer_name']; ?></th>
                                    <td class="px-4 py-3"> <?= $booking['service_title']; ?></td>
                                    <td class="px-4 py-3 text-center"> <?= countNights(sql_date_to_dmY($booking['start']),sql_date_to_dmY($booking['end'])) ?></td>
                                    <td class="px-4 py-3 inline-flex">
                                        <?= sql_date_to_dmY($booking['start']); ?>
                                        <svg class="w-3 h-3 mx-1 my-1 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                        </svg>
                                        <?= sql_date_to_dmY($booking['end']); ?>
                                    </td>
                                    <td class="px-3 py-3" onclick="deleteEvent('<?= $booking['id']; ?>')">
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
    document.addEventListener("DOMContentLoaded", function() {
        // Trouver le bouton et le sous-menu
        const button = document.getElementById('filterDropdownButton');
        const dropdown = document.getElementById('filterDropdown');

        // Ajouter un écouteur d'événements pour le clic
        button.addEventListener('click', function() {
            dropdown.classList.toggle('hidden');
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('.filter-checkbox');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const serviceId = this.value;
                const rows = document.querySelectorAll('.' + serviceId); // Remarque: "." ajouté devant serviceId pour la recherche de classe

                if (this.checked) {
                    // Afficher les lignes
                    rows.forEach(function(row) {
                        row.style.display = '';
                    });
                } else {
                    // Masquer les lignes
                    rows.forEach(function(row) {
                        row.style.display = 'none';
                    });
                }
            });
        });
    });


    //pagination système
    let currentPage = 1;
    const itemsPerPage = 6;
    const all_bookings = Array.from(document.querySelectorAll('.ROW')); // Chaque ligne du tableau a une classe 'row_booking'
    const totalPages = Math.ceil(all_bookings.length / itemsPerPage);

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
        const all_bookings = Array.from(document.querySelectorAll('.row_booking'));

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

    // Affiche la première page et initialise la pagination
    showPage(1);
    updatePagination();



    var totalServices = <?= $totalServices; ?>;
</script>