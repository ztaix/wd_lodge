<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Email\Email;

class SendMail extends Controller
{
    private $CustomerModel;
    private $BookingModel;
    private $ConfigModel;

    public function __construct()
    {
        $this->CustomerModel = new \App\Models\CustomerModel();
        $this->BookingModel = new \App\Models\BookingModel();
        $this->ConfigModel = new \App\Models\ConfigurationModel();

    }

    public function index($to,$seller,$data)
    {

        // Charger le service de messagerie
        $email = \Config\Services::email();
        
        // Récupérer le contenu de la vue
        $emailView = view('documents/mail', ['data' => $data, 'seller' => $seller]); 

        // Configurer les paramètres de l'e-mail
        $email->setFrom('kaipekalodge@wayz.digital', 'Kaipeka Lodge'); 
        $email->setTo($to); 
        $email->setSubject('Subject of the email');

        // Utilisez le contenu de la vue comme corps de l'e-mail
        $email->setMessage($emailView);
        
        // Envoyer l'e-mail
        if ($email->send()) {
            echo 'Email successfully sent';
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }
}
