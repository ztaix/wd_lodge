
<script>

import Datepicker from 'flowbite-datepicker/Datepicker';

const datepickerEl = document.getElementById('datepickerId');
new Datepicker(datepickerEl, {
    // options
});

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

<?php echo view('modals/modal_add_event', $data); ?>
<?php echo view('modals/modal_booking_details', $data); ?>
<?php echo view('modals/modal_bookings_list', $data); ?>
<?php echo view('modals/modal_delete_confirm'); ?>
<div tabindex="-1" aria-hidden="true" class="relative inset-0 w-full mb-24">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 ">

        <div id='calendar'></div>

    </div>
</div>