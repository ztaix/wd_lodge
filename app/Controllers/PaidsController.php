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


public function upsert()
{
    $payments = $this->request->getPost('payments');
    $results = []; // Initialiser le tableau des résultats
    $allSuccess = true; // Pour suivre si toutes les opérations sont réussies

    if (empty($payments)) {
        return $this->response->setJSON(['success' => false, 'error' => 'Données manquantes ou invalides', 'data' => null]);
    }

    foreach ($payments as $pay) {
        $existId = array_key_exists('id', $pay);
        $result = $this->PaidModel->upsert($pay, $existId ? $pay['id'] : false);

        if (!$result) {
            $allSuccess = false; // Marquer le succès global comme faux si une opération échoue
            $errors = $this->PaidModel->errors();
            $payResult = [
                'success' => false,
                'data' => $pay,
                'errors' => $errors
            ];
        } else {
            $payResult = [
                'success' => true,
                'data' => $pay,
                'errors' => []
            ];
        }

        $results[] = $payResult; // Ajouter le résultat de chaque paiement au tableau des résultats
    }

    // Retourner une réponse globale après avoir traité tous les paiements
    return $this->response->setJSON(['success' => $allSuccess, 'error' => '', 'data' => $results]);
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
