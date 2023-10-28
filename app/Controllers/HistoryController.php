<?php 

namespace App\Controllers;

use CodeIgniter\CLI\Console;
use DateTime;


class HistoryController extends BaseController
{
/**
     * @var \App\Models\CustomerModel
     */
    private $CustomerModel;
    private $ServiceModel;
    private $BookingModel;

    public function __construct()
    {
        $this->CustomerModel = new \App\Models\CustomerModel();
        $this->ServiceModel = new \App\Models\ServiceModel();
        $this->BookingModel = new \App\Models\BookingModel();
    }

    public function ReturnView()
    {
        $data = [
            'title' => 'TITTRE',
            'baseurl' => base_url(),
            'customers_list' => ($customers_list = $this->CustomerModel->get_customer_list()) ? $customers_list : [],
            'services_list' => ($services_list = $this->ServiceModel->get_services_list()) ? $services_list : [],
            'bookings_list' => $this->BookingModel->getAllBookings(),
            'totalServices' => $this->ServiceModel->getTotalServices(),
        ];
        
        
        $view1 = view('History_view', $data);
        
        
        $view_fusion = $view1 ;
        $datas['contents_views'] = $view_fusion;

        echo view('default_layout', $datas);
    }

    
}
