<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MainController extends Controller
{
    public function index()
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
}
