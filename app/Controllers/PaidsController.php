<?php

namespace App\Controllers;

class PaidsController extends BaseController
{
    /**
     * @var \App\Models\CustomerModel
     */
    private $BookingModel;
    private $PaidModel;
    private $ConfigModel;

    public function __construct()
    {
        $this->PaidModel = new \App\Models\PaidModel();
        $this->BookingModel = new \App\Models\BookingModel();
        $this->ConfigModel = new \App\Models\ConfigurationModel();
    }

    public function ReturnView()
    {
        $data = [
            'title' => 'TITTRE',
            'baseurl' => base_url(),
            'bookins_list' => $this->BookingModel->getAllBookings(),
            'discountRules' => $this->ConfigModel->DiscountRules(),
            'All_config' => $this->ConfigModel->get_all_config(),

        ];



        $view = view('Paid_view', $data);

        $datas['contents_views'] = $view;

        echo view('default_layout', $datas);
    }

    public function getAllPaids($paid_id = false)
    {
        $paids = $this->PaidModel->getAllPaids($paid_id);
        return $this->response->setJSON($paids);
    }


    public function getPaidsFromBookingID($booking_id = false)
    {
        $paids = $this->PaidModel->getPaidsFromBookingID($booking_id);
        // Regroupez les réservations par jour

        return $this->response->setJSON($paids);
    }




    public function getPaidsFromCustomer($customer_id)
    {
        $paids = $this->PaidModel->getPaidsFromCustomer($customer_id);

        return $this->response->setJSON($paids);
    }

    public function getPaidsFromCustomerAndbooking($customer_id, $booking_id)
    {
        $paids = $this->PaidModel->getPaidsFromCustomerAndbooking($customer_id, $booking_id);

        return $this->response->setJSON($paids);
    }


    public function upsert() {
        $payments = $this->request->getPost('payments');
        $results = []; // Initialiser le tableau des résultats
        $allSuccess = true; // Pour suivre si toutes les opérations sont réussies
        $globalErrors = []; // Pour collecter les erreurs de toutes les opérations
    
        // Vérifier si les données de paiement sont présentes et valides
        if (empty($payments)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Données manquantes ou invalides', // Description de l'erreur
                'data' => null // Aucune donnée à retourner
            ]);
        }
    
        foreach ($payments as $pay) {
            $existId = array_key_exists('id', $pay); // Vérifier si l'ID existe
            $result = $this->PaidModel->upsert($pay, $existId ? $pay['id'] : false); // Effectuer l'opération de mise à jour ou d'insertion
    
            if (!$result) {
                $allSuccess = false; // Marquer le succès global comme faux si une opération échoue
                $errors = $this->PaidModel->errors(); // Récupérer les erreurs
                $globalErrors[] = $errors; // Ajouter les erreurs à la liste globale
                $payResult = [
                    'success' => false,
                    'message' => 'Échec de l’opération', // Message d'erreur spécifique
                    'data' => $pay, // Données soumises
                    'errors' => $errors // Détail des erreurs
                ];
            } else {
                $payResult = [
                    'success' => true,
                    'message' => 'Opération réussie', // Message de succès
                    'data' => $pay, // Données soumises
                    'errors' => [] // Pas d'erreur
                ];
            }
    
            $results[] = $payResult; // Ajouter le résultat de chaque paiement au tableau des résultats
        }
    
        // Construction de la réponse globale
        $response = [
            'success' => $allSuccess,
            'message' => $allSuccess ? 'Toutes les opérations ont réussi' : 'Certaines opérations ont échoué',
            'data' => $results // Résultats individuels de chaque paiement
        ];
    
        if (!$allSuccess) {
            $response['globalErrors'] = $globalErrors; // Ajouter les erreurs globales si il y en a
        }
    
        // Retourner une réponse globale après avoir traité tous les paiements
        return $this->response->setJSON($response);
    }
    


    public function deletePaid()
    {
        $postData = $this->request->getPost();
        $ids = $postData['ids'] ?? null;


        $listIdDeleted = [];
        $listIdDeleted = $this->PaidModel->deletePaid($ids);
        if ($listIdDeleted) {
            // La suppression a réussi
            return $this->response->setJSON(['success' => true, 'data' => $listIdDeleted]);
        } else {
            // La suppression a échoué
            return $this->response->setJSON(['success' => false, 'data' => $ids]);
        }
    }

    public function deletePaidsFromBooking($bookingid)
    {
        $listIdDeleted = $this->PaidModel->deletePaidsFromBooking($bookingid);
        if ($listIdDeleted) {
            // La suppression a réussi
            return $this->response->setJSON(['success' => true, 'data' => $listIdDeleted]);
        } else {
            // La suppression a échoué
            return $this->response->setJSON(['success' => false, 'data' => $bookingid]);
        }
    }
}
