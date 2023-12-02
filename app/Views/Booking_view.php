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
<?php echo view('banners/banner_search'); ?>
<?php echo view('modals/modal_customer_update', $data); ?>
<?php echo view('modals/modal_add_event', $data); ?>
<?php echo view('modals/modal_booking_details', $data); ?>
<?php echo view('modals/modal_bookings_list', $data); ?>
<?php echo view('modals/modal_delete_confirm'); ?>


<header class="text-gray-900 dark:text-white bg-slate-50 dark:bg-slate-800">
    <?= $All_config[0]['Data']; ?>
</header>
    
        <div id='calendar' class="text-gray-900 dark:text-white  bg-slate-50 dark:bg-slate-800"></div>

