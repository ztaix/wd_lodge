<?php

namespace App\Filters;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Config\Services;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $key = "votre_cle_secrete"; // La même clé secrète utilisée pour générer le token
            $authHeader = $request->getHeaderLine('Authorization');


            if (!$authHeader) {
                throw new Exception('Token non fourni');
            }

            list($token) = sscanf($authHeader, 'Bearer %s');
            if (!$token) {
                throw new Exception('Token mal formé');
            }

            $arr = explode(' ', $authHeader);

            if ($arr[0] === 'Bearer' && isset($arr[1])) {
                $token = $arr[1];
                JWT::decode($token, new Key($key, 'HS256'));
                // Le token est valide

                return;
            }
        } catch (Exception $e) {
            return Services::response()
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setJSON(['message' => 'Token invalide ou absent', 'redirect' => 'auth']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Méthode après la requête (pas nécessaire pour la validation JWT)
    }
}
