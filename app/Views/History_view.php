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
    var periodeTexts = <?php echo $jsonPeriodeNames; ?>;
    var totalServices = <?= $totalServices; ?>;
</script>