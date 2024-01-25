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
        $existId = true;
        $payments = $this->request->getPost('payments');

        if (is_array($payments) && (empty($payments[0]) || (is_array($payments[0]) && count($payments[0]) == 0))) {
            $firstKey = key($payments); // Récupère la clé du premier élément
            unset($payments[$firstKey]); // Supprime le premier élément sans réinitialiser les clés
        }

        // Validation des données
        if (empty($payments)) {
            return [
                'success' => false,
                'errors' => ['message' => 'Données manquantes ou invalides']
            ];
        }
        foreach ($payments as $pay) {
            if ($existId = array_key_exists('id', $pay)) {
    
                if ($result = $this->PaidModel->upsert($pay, $pay['id'] )) {

                    $results[$pay['id']] = [
                        'success' => $result[$pay['id']]['success'],
                        'data' => $pay,
                        'errors' => $result[$pay['id']]['errors']
                    ];
                } else {
                    $errors = $this->PaidModel->errors();
                    $results[$pay['id']] = [
                        'success' => false,
                        'data' => $pay,
                        'errors' => [$errors, ['message'] => 'Erreur dans le ModelPaid']
                    ];
                }
            } else {
                $existId = false;
                
                if ($result = $this->PaidModel->upsert($pay, $existId)) {
                    $results[] = [
                        'success' =>  $result,
                        'data' => $pay
                    ];
                } else {
                    $errors = $this->PaidModel->errors();
                    $results = [
                        'success' => false,
                        'data' => $pay,
                        'errors' => [$errors, ['message'] => 'Les paiements n\'ont pas été reçus.Le POST est vide.']
                    ];
                }
            }
        }

        return $this->response->setJSON($results);
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
