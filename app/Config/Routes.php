<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes accessibles sans authentification JWT
$routes->get('/auth', 'MainController::Login');
$routes->post('auth/verif', 'LoginController::loginAttempt');
$routes->get('/', 'MainController::index');
$routes->get('History', 'MainController::History');
$routes->get('Config', 'MainController::Configuration');
$routes->get('Customers', 'MainController::Customers');

$routes->get('generatePDF/(:any)/(:num)', 'BookingController::generatePDF/$1/$2');
$routes->get('sendmail/(:num)', 'BookingController::Sendmail/$1');
// Appliquer le filtre jwtAuth à toutes les autres routes nécessitant une authentification
$routes->group('', ['filter' => 'jwtAuth'], function($routes) {

    
    $routes->group('customer', function($routes) {
        $routes->get('get_customer_info', 'CustomersController::get_customer_info');
        $routes->post('create', 'CustomersController::create_customer');
        $routes->post('update', 'CustomersController::update_customerFromID');
    });

    $routes->group('booking', function($routes)
    {
        $routes->post('deleteBooking', 'BookingController::deleteBooking');
        $routes->post('updateBooking', 'BookingController::updateBooking');
        $routes->post('addBooking', 'BookingController::addBooking');
        
        $routes->get('getBookingsFromDate', 'BookingController::getBookingsFromDate');
        $routes->get('', 'BookingController::getBookings');
        $routes->get('datepicker/(:num)/(:any)', 'BookingController::getBookingsfromDatepicker/$1/$2');
        $routes->get('service/(:num)/(:any)', 'BookingController::getBookings/$1/$2');
        $routes->get('available/(:num)', 'BookingController::getBookingsFromService/$1');
        $routes->get('search', 'BookingController::getBookingsFromSearch');
        $routes->get('getBookingFromID', 'BookingController::getBookingFromID');
        $routes->get('getBookingsFromCustomer', 'BookingController::getBookingsFromCustomer');
        $routes->get('getServicesBookings', 'BookingController::getServicesBookings');
    
    });

    // Routes PAIDS protégées par JWT
    $routes->group('paids', function($routes)
    {
    $routes->get('', 'PaidsController::getAllPaids');
    $routes->get('(:num)', 'PaidsController::getAllPaids/$1');
    $routes->get('Customer/(:num)', 'PaidsController::getPaidsFromCustomer/$1');
    $routes->get('booking', 'PaidsController::getPaidsFromBookingID');
    $routes->get('bookings/(:num)', 'PaidsController::getPaidsFromBookingID/$1');


    // update / add
    $routes->post('upsert', 'PaidsController::upsert');

    //delete
    $routes->post('delete', 'PaidsController::deletePaid');

    });

    $routes->group('services', function($routes)
    {
        $routes->post('update', 'ServicesController::update');
        $routes->get('drop/(:num)', 'ServicesController::delete/$1');
    });

    $routes->get('file/(:any)', 'FilesController::getFilePath/$1');
    $routes->get('uploads/(:any)', 'FilesController::passthrough/$1');
    
    $routes->post('Config/save', 'ConfigurationController::saveConfigurations');
});
