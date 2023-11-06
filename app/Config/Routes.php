<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'MainController::index');
$routes->get('/Customers', 'MainController::Customers');
$routes->group('/customer', function($routes)
{
    $routes->get('get_customer_info', 'CustomersController::get_customer_info');
    
    $routes->post('create', 'CustomersController::create_customer');
    $routes->post('update', 'CustomersController::update_customerFromID');
});

$routes->get('/History', 'MainController::History');
$routes->get('/Config', 'MainController::Configuration');
//$routes->get('/Phpinfo', 'Phpinfo::index');

$routes->group('/booking', function($routes)
{
    $routes->post('getBookingsFromDate', 'BookingController::getBookingsFromDate');
    $routes->post('deleteBooking', 'BookingController::deleteBooking');
    $routes->post('updateBooking', 'BookingController::updateBooking');
    $routes->post('addBooking', 'BookingController::addBooking');
    
    $routes->get('/', 'BookingController::getBookings');
    $routes->get('available/(:num)', 'BookingController::getBookingsFromService/$1');
    $routes->get('search', 'BookingController::getBookingsFromSearch');
    $routes->get('getBookingFromID', 'BookingController::getBookingFromID');
    $routes->get('getBookingsFromCustomer', 'BookingController::getBookingsFromCustomer');
    $routes->get('getServicesBookings', 'BookingController::getServicesBookings');
    $routes->get('generatePDF/(:any)/(:num)', 'BookingController::generatePDF/$1/$2');
    $routes->get('sendmail/(:num)', 'BookingController::Sendmail/$1');

});

/// OTHER NON PAGES ROUTES
$routes->group('/services', function($routes)
{
    $routes->post('update', 'ServicesController::update');
});

$routes->get('/file/(:any)', 'FilesController::getFilePath/$1');
$routes->get('/uploads/(:any)', 'FilesController::passthrough/$1');

$routes->post('/Config/save', 'ConfigurationController::saveConfigurations');


