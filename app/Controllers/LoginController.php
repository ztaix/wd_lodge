<?php

namespace App\Controllers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class LoginController extends BaseController
{
/**
     * @var \App\Models\CustomerModel
     */
    private $ServiceModel;
    private $key = "votre_cle_secrete";

    public function __construct()
    {
        $this->ServiceModel = new \App\Models\ServiceModel();
    }

    public function verifyToken($extend = false)
    {
        $token = null;

        // Tentez d'obtenir le token du header 'Authorization' (typiquement pour le localStorage)
        $header = $this->request->getHeaderLine('Authorization');
        if (!empty($header)) {
            sscanf($header, 'Bearer %s', $token);
        }

        // Sinon, vérifiez si le token est présent dans les cookies (pour les cookies)
        if (empty($token)) {
            $token = $this->request->getCookie('token');
        }

        if (!$token) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setJSON(['success' => false ,'message' => 'Token non fourni.']);
        }

        try {
            // Vérifiez le token
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            if ($extend) {
                $decoded_array = (array) $decoded;
                $newExpTime = time() + (60 * 60); // Ajoute 1 heure au champ 'exp'
                $decoded_array['exp'] = $newExpTime; // Mise à jour du champ 'exp'
                $renewedToken = JWT::encode($decoded_array, $this->key, 'HS256');
            
                // Pour un cookie HTTP-only expirant dans 1 heure
                setcookie('token', $renewedToken, $newExpTime, "/", "", false, true);
            
                // Calcul de la durée restante avant l'expiration du nouveau token
                $timeLeft = $newExpTime - time(); // Durée restante en secondes pour le nouveau token
            
                // Renvoyer le nouveau token dans la réponse, avec le temps restant
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON(['success' => true, 'token' => $renewedToken, 'timeLeft' => $timeLeft]);
            } else {
                // Si le token n'est pas étendu, calculez simplement la durée restante du token actuel
                $now = time(); // Timestamp actuel
                $exp = $decoded->exp; // Timestamp d'expiration du token
                $timeLeft = $exp - $now; // Durée restante en secondes
            
                // Renvoyer l'état du token actuel dans la réponse, sans le renouveler
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON(['success' => true, 'message' => 'Token valide.', 'timeLeft' => $timeLeft]);
            }
        } catch (Exception $e) {
            // Gérez les erreurs liées à un token invalide
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setJSON(['success' => false , 'message' => 'Token invalide.']);
        }
    }

    public function logout()
    {
        // Supprime le cookie en définissant sa date d'expiration dans le passé
        return $this->response->deleteCookie('token')
            ->setStatusCode(ResponseInterface::HTTP_OK)
            ->setJSON(['message' => 'Déconnexion réussie.']);
    }

    public function loginAttempt()
    {  
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && hash('sha256', $password) === $user['password']) {
            // Les identifiants sont corrects, générons le JWT

            
            $payload = [
                "iss" => "https://wayz.digital", // L'émetteur du token
                "aud" => "USER_wayz.digital",    // L'audience du token
                "iat" => time(),                     // Timestamp de l'émission
                "exp" => time() + 50,              // Expiration du token (1 heure ici)
                "sub" => $user['id'],                // Sujet du token (id de l'utilisateur)
            ];

            $jwt = JWT::encode($payload, $this->key, 'HS256');

            // Maintenant, $jwt contient votre token JWT généré
            $response = service('response');
            $response->setCookie('token', $jwt, 50); // Définit un cookie valide pour 1 heure
            $logData = ['jwt' => $jwt];
            return $this->response->setJSON($logData);
            
        } else {
            // Gestion des erreurs si les identifiants sont incorrects
            return $this->response->setJSON(['success' => false, 'reason' => 'form-error', 
            'message' => 'Email ou mot de passe incorrect.'])->setStatusCode(401);
        }
    }

    public function ReturnView()
    {

        $data = [
            'title' =>  'Login',
            'baseurl' => base_url(),
            'services_list' => ($services_list = $this->ServiceModel->get_services_list()) ? $services_list : [],
        ];
        
        
        $view = view('View_login', $data);
        
        
        $datas['contents_views'] = $view;

        echo view('default_layout', $datas);
    }
}
