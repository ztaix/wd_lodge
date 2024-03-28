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

    public function verifyToken()
    {
        $extend = $this->request->getGet('extend');
        $token = null;

        // Tentez d'obtenir le token du header 'Authorization' (typiquement pour le localStorage)
        $header = $this->request->getHeaderLine('Authorization');
        if (!empty($header)) {
            sscanf($header, 'Bearer %s', $token);
        }

        // Sinon, vérifiez si le token est présent dans les cookies
        if (empty($token)) {
            $token = $this->request->getCookie('token');
        }

        if (!$token) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setJSON(['success' => false, 'message' => 'Token non fourni.']);
        }

        try {
            // Vérifiez le token
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            if ($extend == true) {
                $decoded_array = (array) $decoded;
                $newExpTime = time() + (12 * 60 * 60);
                $decoded_array['exp'] = $newExpTime; // Mise à jour du champ 'exp'
                $renewedToken = JWT::encode($decoded_array, $this->key, 'HS256');

                setcookie('token', $renewedToken, $newExpTime);

                // Calcul de la durée restante avant l'expiration du nouveau token
                $timeLeft = $newExpTime - time(); // Durée restante en secondes pour le nouveau token

                // Renvoyer le nouveau token dans la réponse, avec le temps restant
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON(['success' => true, 'token' => $renewedToken, 'message' => 'Session étendu avec succés + 12h00', 'timeLeft' => $timeLeft, 'extend' => $extend]);
            } else {
                // Si le token n'est pas étendu, calculez simplement la durée restante du token actuel
                $exp = $decoded->exp; // Timestamp d'expiration du token
                $timeLeft = $exp - time(); // Durée restante en secondes

                // Renvoyer l'état du token actuel dans la réponse, sans le renouveler
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON(['success' => true, 'message' => 'Token valide.', 'timeLeft' => $timeLeft]);
            }
        } catch (Exception $e) {
            // Gérez les erreurs liées à un token invalide
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setJSON(['success' => false, 'message' => 'Token invalide.']);
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
        $loginData = $this->request->getJSON(true); // Récupère le corps de la requête JSON comme tableau associatif

        $email = $loginData['email'];
        $password = $loginData['password'];

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();
        $expTime = (60 * 60 * 12); //12h

        if ($loginData == null) {
            return $this->response->setJSON([
                'success' => false, 'reason' => 'not-exist',
                'message' => 'Les identifiants de connexion ne sont pas bons !',
            ])->setStatusCode(401);
        } else if ($user && (hash('sha256', $password) === $user['password'])) {
            // Les identifiants sont corrects, générons le JWT


            $payload = [
                "iss" => "https://wayz.digital", // L'émetteur du token
                "aud" => "USER_wayz.digital",    // L'audience du token
                "iat" => time(),                     // Timestamp de l'émission
                "exp" => time() + $expTime,              // Expiration du token (xx heure)
                "sub" => $user['id'],                // Sujet du token (id de l'utilisateur)
            ];

            $jwt = JWT::encode($payload, $this->key, 'HS256');

            // Maintenant, $jwt contient votre token JWT généré
            $response = service('response');
            $response->setCookie('token', $jwt, $expTime); // Définit un cookie valide pour xx heure
            $logData = ['jwt' => $jwt];
            return $this->response->setJSON($logData);
        } else {
            return $this->response->setJSON([
                'success' => false, 'reason' => 'form-error',
                'message' => 'Email ou mot de passe incorrect.',
                '$user' => $user,
            ])->setStatusCode(401);
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
