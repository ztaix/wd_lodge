<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MainController extends Controller
{
    private $ConfigurationModel;

    public function __construct()
    {
        $this->ConfigurationModel = new \App\Models\ConfigurationModel();
        
    }

    public function index()
    {
        // Logique pour la page d'accueil (calendrier)
        $calendarController = new \App\Controllers\BookingController();
        return $calendarController->ReturnView();

    }
    public function Calender()
    {
        // Logique pour la page d'accueil (calendrier)
        $calendarController = new \App\Controllers\BookingController();
        return $calendarController->ReturnView();

    }
    public function Customers()
    {
        // Logique pour la page d'accueil (calendrier)
        $customersController = new \App\Controllers\CustomersController();
        return $customersController->ReturnView();
    }

    public function History()
    {
        // Logique pour la page d'accueil (calendrier)
        $historyController = new \App\Controllers\HistoryController();
        return $historyController->ReturnView();
    }

    public function Configuration()
    {
        // Logique pour la page d'accueil (calendrier)
        $configController = new \App\Controllers\ConfigurationController();
        return $configController->ReturnView();
    }

    public function Login()
    {
        // Logique pour la page de login
        $LoginController = new \App\Controllers\LoginController();
        return $LoginController->ReturnView();
    }
}
