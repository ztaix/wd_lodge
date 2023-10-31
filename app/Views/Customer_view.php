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
<?php echo view('modals/modal_add_event', $data); ?>
<?php echo view('modals/modal_booking_details', $data); ?>
<?php echo view('modals/modal_bookings_list', $data); ?>
<?php echo view('modals/modal_customer_info', $data); ?>

<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5" style="padding-bottom: 7rem;">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">

    <!--  Header -->
        <div class="px-6 py-6 lg:px-8 flex" >            
            <div class="flex-grow">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
            </svg>
            </div>
            <div class="flex-grow-0">
                <h3 class="text-center text-2xl font-bold text-gray-800 dark:text-white">Liste client</h3>
            </div>    
            <div class="flex-grow">
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 relative shadow-md rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
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
                
            </div>
            <div id="pagination-container">      
                  <!-- INJECTION des boutons de pagination -->
            </div>
            <div class="overflow-x-auto">
                <table id="history_list" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-3">Nom</th>
                            <th scope="col" class="px-3 py-3">Email</th>
                            <th scope="col" class="px-3 py-3">Télépone</th>
                            <th scope="col" class="px-3 py-3">Commentaire</th>
                            <th scope="col" class="px-3 py-3">Action</th>

                        </tr>
                    </thead>
                    <div id="items-container">
                        <tbody>
                            
                            <?php
                            
                            foreach($customers_list as $customer){
                            ?>
                            <tr class="border-b dark:border-gray-700 row_booking service_<?= $customer['Customer_id']; ?>"
                                data-id="<?= $customer['Customer_id']; ?>" 
                                data-Name="<?= $customer['Name']; ?>" 
                                data-Email="<?= $customer['Email']; ?>" 
                                data-Phone="<?= $customer['Phone']; ?>" 
                                onclick="get_booking_list_from_customer(this)" >
                                <th scope="row" class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white service_<?= $customer['Customer_id']; ?>"><?= $customer['Name']; ?></th>
                                <td class="px-3 py-3"><?= $customer['Email']; ?></td>
                                <td class="px-3 py-3"><?= sql_date_to_dmY($customer['Phone']); ?></td>
                                <td class="px-3 py-3"><?= sql_date_to_dmY($customer['Comment']); ?></td>
                                <td class="px-3 py-3">Supprimer</td>
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                    </div>
                </table>
            </div>

        </div>
    </div>
    </section>

<script>



//////////////////////////////////////////////////



//pagination système
let currentPage = 1;
const itemsPerPage = 8;
const all_bookings = Array.from(document.querySelectorAll('.row_booking')); // Chaque ligne du tableau a une classe 'row_booking'
const totalPages = Math.ceil(all_bookings.length / itemsPerPage);

function showPage(page) {
  const start = (page - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  
  // Cacher tous les éléments
  all_bookings.forEach(booking => booking.style.display = 'none');
  
  // Afficher les éléments pour la page actuelle
  all_bookings.slice(start, end).forEach(booking => booking.style.display = '');
  
  currentPage = page;
  console.log("CURRENT Pages:", currentPage);
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
