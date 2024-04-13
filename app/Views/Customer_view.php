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
<?php echo view('modals/modal_delete_confirm'); ?>


<div id="customers" class="max-w-screen-md bg-gray-50 dark:bg-gray-900">

    <header>Clients</header>

    <div class="mx-auto px-4">

        <div class="bg-white dark:bg-gray-800 border border-slate-100 dark:border-slate-900 relative shadow-md rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <!-- Section de recherche -->
                <div class="flex-grow md:flex-grow-0 flex items-center space-x-3 md:space-x-0 w-full md:w-auto">
                    <form class="flex-grow md:flex-grow-0 w-full md:w-auto flex items-center">
                        <label for="simple-search" class="sr-only">Rechercher</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Rechercher">
                        </div>
                    </form>
                </div>
                <!-- Bouton Ajouter un client -->
                <div class="w-full md:w-auto">
                    <button type="button" onclick="ShowCreateCustomer()" class="w-full flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Ajouter un client
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="history_list" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-3">Nom</th>
                            <th scope="col" class="px-3 py-3">Email</th>
                            <th scope="col" class="px-3 py-3">Téléphone</th>
                            <th scope="col" class="px-3 py-3">Commentaire</th>
                            <th scope="col" class="px-3 py-3"></th>

                        </tr>
                    </thead>
                    <tbody id="items-container">

                        <?php
                        $customers_list_reversed = array_reverse($customers_list);
                        foreach ($customers_list_reversed as $customer) {
                        ?>
                            <tr class="ROW hover:bg-gray-50 hover:dark:bg-gray-900 border-b dark:border-slate-700 cursor-pointer whitespace-nowrap row_customer_<?= $customer['Customer_id']; ?>" data-id="<?= $customer['Customer_id']; ?>" data-Name="<?= $customer['Name']; ?>" data-Comment="<?= $customer['Comment']; ?>" data-Email="<?= $customer['Email']; ?>" data-Phone="<?= $customer['Phone']; ?>" onclick="get_booking_list_from_customer(<?= $customer['Customer_id']; ?>)">

                                <th scope="row" class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white service_<?= $customer['Customer_id']; ?> cursor-pointer"><b><?= $customer['Name']; ?></b></th>
                                <td class="px-3 py-3"><?= $customer['Email']; ?></td>
                                <td class="px-3 py-3"><?= $customer['Phone']; ?></td>
                                <td class="px-3 py-3 max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap customer_comment" id="comment_<?= $customer['Customer_id']; ?>" onclick="toggleComment(event, 'comment_<?= $customer['Customer_id']; ?>')"><?= $customer['Comment']; ?></td>
                                <td class="px-3 py-3 cursor-pointer" onclick="DeleteCustomer(event, '<?= $customer['Customer_id']; ?>')">
                                    <svg class="w-4 h-4 text-red-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
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




    var totalServices = <?= $totalServices; ?>;

    function toggleComment(event, id) {
        event.stopPropagation();
        var element = document.getElementById(id);
        // Ajouter la classe 'blinking'
        element.classList.add('blinking');

        // Supprimer la classe 'blinking' après l'animation
        setTimeout(function() {
            element.classList.remove('blinking');
        }, 500);
        if (element.style.overflow === 'visible') {
            element.style.overflow = 'hidden';
            element.style.whiteSpace = 'nowrap';
            element.style.maxWidth = '150px';

        } else {
            element.style.overflow = 'visible';
            element.style.whiteSpace = 'normal';
            element.style.opacity = '1';
            element.style.maxWidth = '150px';
        }
    }
</script>