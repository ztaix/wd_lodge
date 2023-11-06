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
            'discountRules' => ($rule = $this->ConfigModel->DiscountRules()) ? DiscountToArray($rule['Data']) : '',
            'All_config' => $this->ConfigModel->get_all_config(),

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
                        'colors' => [] // Ceci stockera toutes les couleurs de la journée
                    ];
                }
                $grouped[$date]['count']++;
                // Assurez-vous que la couleur est unique pour la date donnée
                if (!in_array($booking['service_color'], $grouped[$date]['colors'])) {
                    $grouped[$date]['colors'][] = $booking['service_color'];
                }

                $startDate->modify('+1 day'); // Passer au jour suivant
            }
        }

        // Générer les événements
        $events = [];
        foreach ($grouped as $date => $data) {
            $events[] = [
                'title' => $data['count'] . ' réservations',
                'start' => $date,
                'bookings' => array_map(function ($color) {
                    return ['color' => $color, 'title' => 'Réservation']; // Le titre pourrait être plus descriptif
                }, $data['colors'])
            ];
        }

        return $this->response->setJSON($events);
    }


    public function getBookingsFromService($service_id)
    {
        $bookings = $this->BookingModel->getAllBookingsFromService($service_id);
        // Regroupez les réservations par jour
        $grouped = [];
        foreach ($bookings as $booking) {
            $startDate = new DateTime($booking['start']);
            $endDate = (new DateTime($booking['end']))->modify('+1 day'); // Inclure le jour de fin
            $type_doc = $booking['Type_doc']; // Assurez-vous que la clé 'type_doc' est correcte dans votre tableau $booking
            $price = $booking['Price']; // Assurez-vous que la clé 'Price' est correcte dans votre tableau $booking
            $paid = $booking['Paid']; // Assurez-vous que la clé 'Paid' est correcte dans votre tableau $booking

            while ($startDate < $endDate) { // Utilisez < au lieu de <= pour exclure la date de fin
                $date = $startDate->format('Y-m-d');

                if (!isset($grouped[$date])) {
                    $grouped[$date] = [
                        'colors' => [], // Peut-être prévoir un tableau pour toutes les couleurs
                        'type_doc' => [], // Stockez 'type_doc' dans un tableau
                        'prices' => [], // Stockez 'Price' dans un tableau
                        'paids' => [], // Stockez 'Paid' dans un tableau
                    ];
                }

                if (!in_array($booking['service_color'], $grouped[$date]['colors'])) {
                    $grouped[$date]['colors'][] = $booking['service_color'] ?: '#bcbcbc'; // Couleur par défaut si null
                }
                if (!in_array($type_doc, $grouped[$date]['type_doc'])) {
                    $grouped[$date]['type_doc'][] = $type_doc; // Ajoutez 'type_doc' s'il n'est pas déjà dans le tableau
                }
                if (!in_array($price, $grouped[$date]['prices'])) {
                    $grouped[$date]['prices'][] = $price; // Ajoutez 'Price' s'il n'est pas déjà dans le tableau
                }
                if (!in_array($paid, $grouped[$date]['paids'])) {
                    $grouped[$date]['paids'][] = $paid; // Ajoutez 'Paid' s'il n'est pas déjà dans le tableau
                }

                $startDate->modify('+1 day'); // Passer au jour suivant
            }
        }

        // Générer les événements
        $events = [];
        foreach ($grouped as $date => $data) {
            // Gérer ici la logique pour déterminer la couleur à afficher si plusieurs couleurs pour une date
            $color = count($data['colors']) === 1 ? $data['colors'][0] : '#bcbcbc'; // Exemple : couleur par défaut si plusieurs couleurs
            $eventPrice = array_sum($data['prices']); // Calculez le total des prix pour la date
            $eventPaidPrice = array_sum($data['paids']); // Calculez le total des prix pour la date
            $eventPaid = $eventPaidPrice == $eventPrice ? '<b>Payé</b>' : 'Impayé'; // Déterminez si un paiement a été effectué

            $events[] = [
                'start' => $date,
                'type_doc' => $data['type_doc'][0], // Utilisez le premier 'type_doc' trouvé
                'backgroundColor' => $color, // Utilisez la couleur déterminée ci-dessus
                'status' => $eventPaid, // 'Paid' si payé, sinon 'Unpaid'
                'price' => $eventPrice, // Le total des prix pour la date
                'paid' => $eventPaidPrice, // 'Paid' si payé, sinon 'Unpaid'
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

    public function getBookingFromID($booking_id = false)
    {
        if($booking_id!== false){
            $id = $booking_id;
        }
        else{ 
            $id = $this->request->getGet('id');
        }
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

        $data = $this->request->getPost();

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


    public function generatePDF($origine = 'booking', $id = 1, $show = true)
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

        $seller = [$this->ConfigModel->get_all_config()];
        // Charger la vue et passer les données de réservation
        $html = view('documents/pdf', ['data' => $data, 'seller' => $seller]);

        $contxt = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('HttpContext', $contxt);

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

        if ($show === true) {
            // Envoyer le PDF au navigateur
            $dompdf->stream("$origine-$id.pdf", array("Attachment" => false, 'mime' => 'application/pdf'));
            $pdfOutput = $dompdf->output();
            return $this->response->setStatusCode(200)
                ->setContentType('application/pdf')
                ->setBody($pdfOutput);
        } else {
            // Sauvegarder le PDF dans un fichier temporaire
            $output = $dompdf->output();
            $tempDir = WRITEPATH . 'uploads/temp/';
            $fileName = uniqid("pdf_") . ".pdf"; // Générer un nom de fichier unique
            $filePath = $tempDir . $fileName;

            // Assurez-vous que le répertoire temporaire existe
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            file_put_contents($filePath, $output); // Sauvegarde le PDF
            return $filePath; // Retourne le chemin du fichier
        }
    }

    public function Sendmail($booking_id)
    {
        helper(['text', 'email']); // Chargement des helpers nécessaires

        $bookingData = $this->BookingModel->getBookingFromID($booking_id); // Vos données de réservation

        if (!$bookingData) {
            return [
                'success' => false,
                'message' => 'Réservation non trouvée.'
            ];

        }

        if (isset($bookingData['Customer_id'])) {
            $customerData = $this->CustomerModel->get_customer_info($bookingData['Customer_id']);
            if (!$customerData) {
                return [
                    'success' => false,
                    'message' => 'Informations client non trouvées.'
                ];
            }

            $data = [
                'booking_info' => $bookingData,
                'customer_info' => $customerData
            ];
        } else {
            log_message('non success', 'customer data = 0');

            return [
                'success' => false,
                'message' => 'ID client non défini dans les données de réservation.'
            ];
        }

        $seller = [$this->ConfigModel->get_all_config()];
        // Générez le PDF et obtenez le chemin du fichier
        $pdfFilePath = $this->generatePDF('booking', $booking_id, false);

        $html = view('documents/mail', ['data' => $data, 'seller' => $seller]);
        $email = \Config\Services::email(); // Charge la bibliothèque d'emails
        $email->setFrom($seller[0][3]['Data'], $seller[0][0]['Data']); // Définissez l'adresse de l'expéditeur
        $email->setTo($customerData['Email']); // Définissez le destinataire
        $email->setSubject('Information de réservation : '.$bookingData['Type_doc']); // Définissez le sujet
        $email->setMessage($html); // Ajoutez le corps de l'email
        // Chemin vers le fichier que vous souhaitez joindre
        // Attachez le PDF à l'e-mail
        $email->attach($pdfFilePath);
        if ($email->send()) {
            unlink($pdfFilePath);
            return redirect()->to('/')->with('message', 'Email envoyé avec succès.');
            return [
                'success' => true
            ];
        } else {
            unlink($pdfFilePath);
            return redirect()->to('/')->with('message', 'Email non envoyé.');
            $error = $email->printDebugger(['headers']); // Récupérez les informations d'erreur
            log_message('error', 'Email sending failed: ' . $error);
            return [
                'success' => false,
                'message' => 'Échec de l’envoi de l’email. ' . $error
            ];
        }
    }
}
