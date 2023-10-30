<?php

namespace App\Controllers;

use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;

class BookingController extends BaseController
{
    /**
     * @var \App\Models\CustomerModel
     */
    private $CustomerModel;
    private $ServiceModel;
    private $BookingModel;
    private $ConfigModel;

    public function __construct()
    {
        $this->CustomerModel = new \App\Models\CustomerModel();
        $this->ServiceModel = new \App\Models\ServiceModel();
        $this->BookingModel = new \App\Models\BookingModel();
        $this->ConfigModel = new \App\Models\ConfigurationModel();
    }

    public function ReturnView()
    {
        $data = [
            'title' => 'TITTRE',
            'baseurl' => base_url(),
            'customers_list' => ($customers_list = $this->CustomerModel->get_customer_list()) ? $customers_list : [],
            'services_list' => ($services_list = $this->ServiceModel->get_services_list()) ? $services_list : [],
            'bookins_list' => $this->BookingModel->getAllBookings(),
            'totalServices' => $this->ServiceModel->getTotalServices(),
        ];



        $view = view('Booking_view', $data);

        $datas['contents_views'] = $view;

        echo view('default_layout', $datas);
    }

    public function getBookings()
    {
        $bookings = $this->BookingModel->getAllBookings();
        // Regroupez les réservations par jour
        $grouped = [];
        foreach ($bookings as $booking) {
            $startDate = new DateTime($booking['start']);
            $endDate = new DateTime($booking['end']);

            while ($startDate <= $endDate) {
                $date = $startDate->format('Y-m-d');

                if (!isset($grouped[$date])) {
                    $grouped[$date] = [
                        'count' => 0,
                        'colors' => []
                    ];
                }
                $grouped[$date]['count']++;
                $grouped[$date]['colors'][] = $booking['service_color'];

                $startDate->modify('+1 day'); // Passer au jour suivant
            }
        }

        // Générer les événements
        $events = [];
        foreach ($grouped as $date => $data) {
            if ($data['colors'] == null) {
                $data['colors'] = '#bcbcbc';
            } elseif (count($data['colors']) > 1) {
                $data['colors'] = $data['colors'][0];
            }
            $events[] = [
                'title' => '',
                'start' => $date,
                'count' => $data['count'],
                'backgroundColor' => $data['colors']
            ];
        }

        return $this->response->setJSON($events);
    }


    public function getBookingsFromDate()
    {
        $date = $this->request->getPost('date');
        $BookingModel = $this->BookingModel->getBookingsFromDate($date);

        $response = [
            'events' => $BookingModel,
            'clickedDate' => $date
        ];

        return $this->response->setJSON($response);
        // Créez un tableau associatif contenant à la fois les événements et la date cliquée
    }

    public function getBookingFromID()
    {
        $id = $this->request->getGet('id');
        $response = $this->BookingModel->getBookingFromID($id);
        return $this->response->setJSON($response);
    }

    public function getBookingsFromCustomer()
    {
        $customer_id = $this->request->getGet('customer_id');

        if ($customer_id) {
            // Votre logique pour récupérer les réservations        
            $data = $this->BookingModel->getBookingsFromCustomer($customer_id);
            return $this->response->setJSON($data);
        } else {
            var_dump('ERROR, paramètre manquant: ', $customer_id);
        }
    }



    public function getServicesBookings()
    {
        $ServiceModel = $this->ServiceModel->get_services_list();
        return $this->response->setJSON($ServiceModel);
    }

    public function updateBooking()
    {

        $data = [
            'Customer_id' => $this->request->getPost('Customer_id'),
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('end'),
            'Service_id' => $this->request->getPost('Service_id'),
            'qt' => $this->request->getPost('qt'),
            'Price' => $this->request->getPost('Price'),
            'Paid' => $this->request->getPost('Paid'),
            'Type_doc' => $this->request->getPost('Type_doc'),
            'Comment' => $this->request->getPost('Comment')
        ];

        $id = $this->request->getPost('id');

        if ($this->BookingModel->validate($data)) {  // Utilisez les règles de validation définies dans le modèle
            if ($this->BookingModel->update($id, $data)) {
                return $this->response->setJSON(['status' => 'success', 'id' => $id]);
            } else {
                return $this->response->setJSON(['status' => 'fail', 'message' => 'Une erreur inconnue s\'est produite']);
            }
        } else {
            return $this->response->setJSON(['status' => 'fail', 'message' => $this->BookingModel->errors()]);
        }
    }


    public function addBooking()
    {
        // Vérifiez si la requête est une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->response->setJSON(['status' => 'fail', 'error' => 'Only POST requests are allowed']);
        }

        $booking_data = $this->request->getPost();

        // Chargement du modèle

        $result = $this->BookingModel->addBooking($booking_data);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'data' => $booking_data]);
        } else {
            $errors = $this->BookingModel->errors() ? $this->BookingModel->errors() : 'Unknown error';
            return $this->response->setJSON(['status' => 'fail', 'error' => $errors, 'booking_data' => $booking_data]);
        }
    }


    public function deleteBooking()
    {
        $booking_id = $this->request->getPost('id'); // Récupérez l'ID de la réservation à supprimer depuis la requête POST

        // Utilisez la fonction deleteBooking pour supprimer la réservation
        $result = $this->BookingModel->deleteBooking($booking_id);

        if ($result) {
            // La suppression a réussi
            echo 'La réservation a été supprimée avec succès.';
        } else {
            // La suppression a échoué
            echo 'La suppression de la réservation a échoué.';
        }
    }

    public function getBookingsFromSearch()
    {
        $searchInput = $this->request->getGet('text'); // Récupérez le texte de recherche depuis la requête GET
        if ($searchInput !== NULL) {
            $result = $this->BookingModel->getBookingsFromSearch($searchInput);

            if ($result) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Requête de recherche correcte.',
                    'data' => $result
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'fail',
                    'message' => 'Échec de la Requête de recherche !',
                    'data' => null
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => 'fail',
                'message' => 'Champs de recherche vide.',
                'data' => null
            ]);
        }
    }


    public function generatePDF($origine = 'booking', $id = 1)
    {
        if ($origine == 'booking') {
            $bookingData = $this->BookingModel->getBookingFromID($id); // Vos données de réservation
            if (isset($bookingData['Customer_id'])) {
                $customerData = $this->CustomerModel->get_customer_info($bookingData['Customer_id']);
                $data = [
                    'booking_info' => $bookingData,
                    'customer_info' => $customerData
                ];
            }
        } else {
            $data = $this->BookingModel->getBookingsFromCustomer($id); // Vos données de réservation
        }

        $seller = [ $this->ConfigModel->get_all_config()
        ];
        // Charger la vue et passer les données de réservation
        $html = view('pdf/document', ['data' => $data, 'seller' => $seller]);
        
        $contxt = stream_context_create([ 
            'ssl' => [ 
                'verify_peer' => false, 
                'verify_peer_name' => false,
                'allow_self_signed'=> true
            ] 
        ]);
        $options = new Options();
        $options->set('isRemoteEnabled',true);
        $options->set('HttpContext',$contxt);
         
        $dompdf = new Dompdf($options);

        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Paramétrer le papier et l'orientation
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du PDF (génère le PDF en mémoire)
        $dompdf->render();
        
        // Envoyer les en-têtes HTTP appropriés
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . "$origine-$id.pdf" . '"');

        // Envoyer le PDF au navigateur
        $dompdf->stream("$origine-$id.pdf", array("Attachment" => false, 'mime' => 'application/pdf'));
    }
}
