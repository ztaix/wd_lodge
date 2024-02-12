<?php

namespace App\Controllers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController extends BaseController
{
/**
     * @var \App\Models\CustomerModel
     */
    private $ServiceModel;

    public function __construct()
    {
        $this->ServiceModel = new \App\Models\ServiceModel();
    }
    public function loginAttempt()
    {
        
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        log_message('debug', 'mail : loginAttempt: ' . print_r($email, true));

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && hash('sha256', $password) === $user['password']) {
            // Les identifiants sont corrects, générons le JWT

            $key = "votre_cle_secrete"; // Utilisez une clé secrète forte ici
            $payload = [
                "iss" => "https://wayz.digital", // L'émetteur du token
                "aud" => "USER_wayz.digital",    // L'audience du token
                "iat" => time(),                     // Timestamp de l'émission
                "exp" => time() + 3600,              // Expiration du token (1 heure ici)
                "sub" => $user['id'],                // Sujet du token (id de l'utilisateur)
            ];

            $jwt = JWT::encode($payload, $key, 'HS256');

            // Maintenant, $jwt contient votre token JWT généré
            $response = service('response');
            $response->setCookie('token', $jwt, 3600); // Définit un cookie valide pour 1 heure
            return $this->response->setJSON(['jwt' => $jwt]);

            $logData = ['jwt' => $jwt];
            return $this->response->setJSON($logData);
        } else {
            // Gestion des erreurs si les identifiants sont incorrects
            return $this->response->setJSON(['error' => 'Email ou mot de passe incorrect.'])->setStatusCode(401);
        }
   
    }

    public function ReturnView()
    {

        $data = [
            'title' =>  'Login',
            'baseurl' => base_url(),
            'services_list' => ($services_list = $this->ServiceModel->get_services_list()) ? $services_list : [],
        ];
        
        
        $view = view('View_Login', $data);
        
        
        $datas['contents_views'] = $view;

        echo view('default_layout', $datas);
    }
}
