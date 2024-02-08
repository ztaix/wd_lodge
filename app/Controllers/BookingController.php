<?php

namespace App\Controllers;
use CodeIgniter\HTTP\ResponseInterface;

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
    private $PaidModel;
    private $ConfigModel;

    public function __construct()
    {
        $this->CustomerModel = new \App\Models\CustomerModel();
        $this->ServiceModel = new \App\Models\ServiceModel();
        $this->PaidModel = new \App\Models\PaidModel();
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
            'discountRules' => $this->ConfigModel->DiscountRules(),
            'All_config' => $this->ConfigModel->get_all_config(),

        ];



        $view = view('Booking_view', $data);

        $datas['contents_views'] = $view;

        echo view('default_layout', $datas);
    }

    public function getBookings($service_id = false, $fullblocked = false)
    {

        $bookings = $this->BookingModel->getAllBookings($service_id,$fullblocked);
        // Regroupez les réservations par jour
        $grouped = [];
        foreach ($bookings as $booking) {
            if (!isset($booking['start'], $booking['end'])) {
                continue; // Skip if required fields are missing
            }

            $startDate = new DateTime($booking['start']);
            $endDate = new DateTime($booking['end']);
            $nDays = $startDate->diff($endDate)->days;

            while ($startDate <= $endDate) {
                $date = $startDate->format('Y-m-d');

                if (!isset($grouped[$date])) {
                    $grouped[$date] = [
                        'count' => 0,
                        'fullblocked' => [],
                        'colors' => [],
                        'bookings' => []
                        ];
                }

                if (!isset($grouped[$date]['bookings'][$booking['id']])) {
                    
                    $booking_paids = [];
                    $booking_paids_ids = [];
                    if (strlen($booking['paids_ids']) > 1) {
                        $booking_paids_ids = explode(',', $booking['paids_ids']);
                    }
            
                    $types_paids = explode(',', $booking['types_paids']);
                    $paids_values =  explode(',', $booking['paids_values']);
                    $paids_sum = array_sum($paids_values);
                    foreach ($booking_paids_ids as $index => $id) {
                        $booking_paids[$id] = [
                            'type_paid' => $types_paids[$index] ?? null, // Utilisez l'opérateur null coalescent pour éviter les erreurs d'index
                            'value' => $paids_values[$index] ?? null
                        ];
                    }

                    $grouped[$date]['bookings'][$booking['id']] = [
                        'Date' => $date,
                        'nDays' => $nDays,
                        'colors' => $booking['service_color'],
                        'services_titles' => $booking['service_title'],
                        'prices' => $booking['Price'],
                        'QtTraveller' => $booking['QtTraveller'],
                        'paids' => $paids_sum,
                        'FirstDay' => $booking['start'],
                        'LastDay' => $booking['end'],
                        'Fee' => $booking['Fee'],
                        'Tax' => $booking['Tax'],
                        'types_docs' => $booking['Type_doc'],
                        'fullblockeds' => $booking['fullblocked'],
                        'array_paids' => $booking_paids

                    ];
                    $grouped[$date]['count']++; // Incrémente le compteur uniquement lors de l'ajout d'une nouvelle réservation
                } else {
                    // Ajoutez les données uniquement si elles sont uniques pour cette réservation spécifique
                    if (!in_array($booking['service_color'], $grouped[$date]['bookings'][$booking['id']]['colors'])) {
                        $grouped[$date]['bookings'][$booking['id']]['colors'][] = $booking['service_color'];
                    }
                }



                // Ajoutez les couleurs uniques à la liste globale des couleurs pour la date
            if (!in_array($booking['service_color'], $grouped[$date]['colors'])) {
                $grouped[$date]['colors'][] = $booking['service_color'];
            }
                // Ajoutez les couleurs uniques à la liste globale des couleurs pour la date
            if (!in_array($booking['fullblocked'], $grouped[$date]['fullblocked'])) {
                $grouped[$date]['fullblocked'][] = $booking['fullblocked'];
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
                'colors' => $data['colors'],
                'fullblocked' => $data['fullblocked'],
                'bookings' => $data['bookings']
            ];
        }


        return $this->response->setJSON($events);
    }

    public function getBookingsfromDatepicker($service_id = false, $fullblocked = false)
    {

        $bookings = $this->BookingModel->getAllBookingsFromDatepicker($service_id,$fullblocked);
        // Regroupez les réservations par jour
        $grouped = [];
        foreach ($bookings as $booking) {
            if (!isset($booking['start'], $booking['end'])) {
                continue; // Skip if required fields are missing
            }

            $startDate = new DateTime($booking['start']);
            $endDate = new DateTime($booking['end']);
            $firstDay = $startDate->format('Y-m-d');
            $lastDay = $endDate->format('Y-m-d');

            while ($startDate <= $endDate) {
                $date = $startDate->format('Y-m-d');
                $isFirstDay = ($date === $firstDay);
                $isLastDay = ($date === $lastDay);

                if (!isset($grouped[$date])) {
                    $grouped[$date] = [
                        'count' => 0,
                        'fullblocked' => [],
                        'colors' => [],
                        'details_bookings' => [],
                        ];
                }

                if (!isset($grouped[$date]['details_bookings'][$booking['id']])) {
                    
                    $booking_paids = [];
                    $booking_paids_ids = [];
                    if (strlen($booking['paids_ids']) > 1) {
                        $booking_paids_ids = explode(',', $booking['paids_ids']);
                    }
            
                    $paids_values =  explode(',', $booking['paids_values']);
                    $paids_sum = array_sum($paids_values);
                    foreach ($booking_paids_ids as $index => $id) {
                        $booking_paids[$id] = [
                            'value' => $paids_values[$index] ?? null
                        ];
                    }

                    $grouped[$date]['details_bookings'][$booking['id']] = [
                        'colors' => $booking['service_color'], // Initialise avec la première couleur
                        'services_titles' => $booking['service_title'], // Initialise avec le premier titre de service
                        'prices' => $booking['Price'], // Initialise avec le premier prix
                        'paids' => $paids_sum, // Initialise avec le premier paiement
                        'fullblockeds' => $booking['fullblocked'], // Initialise avec le premier statut fullblocked
                        'array_paids' => $booking_paids

                    ];
                    $grouped[$date]['details_bookings'][$booking['id']] = array_merge($grouped[$date]['details_bookings'][$booking['id']], [
                        'is_first_day' => $isFirstDay, // Ajout de l'indicateur pour le premier jour
                        'is_last_day' => $isLastDay, // Ajout de l'indicateur pour le dernier jour
                    ]);
                    $grouped[$date]['count']++; // Incrémente le compteur uniquement lors de l'ajout d'une nouvelle réservation
                } else {
                    // Ajoutez les données uniquement si elles sont uniques pour cette réservation spécifique
                    if (!in_array($booking['service_color'], $grouped[$date]['details_bookings'][$booking['id']]['colors'])) {
                        $grouped[$date]['details_bookings'][$booking['id']]['colors'][] = $booking['service_color'];
                    }
                }



                // Ajoutez les couleurs uniques à la liste globale des couleurs pour la date
            if (!in_array($booking['service_color'], $grouped[$date]['colors'])) {
                $grouped[$date]['colors'][] = $booking['service_color'];
            }
                // Ajoutez les couleurs uniques à la liste globale des couleurs pour la date
            if (!in_array($booking['fullblocked'], $grouped[$date]['fullblocked'])) {
                $grouped[$date]['fullblocked'][] = $booking['fullblocked'];
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
                'colors' => $data['colors'],
                'fullblocked' => $data['fullblocked'],
                'details_bookings' => $data['details_bookings'],
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
            $QtTraveller = $booking['QtTraveller']; // Assurez-vous que la clé 'Paid' est correcte dans votre tableau $booking
            $service_title = $booking['service_title']; // Assurez-vous que la clé 'Paid' est correcte dans votre tableau $booking
            $fullblocked = $booking['fullblocked']; // Assurez-vous que la clé 'fullblocked' est correcte dans votre tableau $booking

            while ($startDate < $endDate) { // Utilisez < au lieu de <= pour exclure la date de fin
                $date = $startDate->format('Y-m-d');

                if (!isset($grouped[$date])) {
                    $grouped[$date] = [
                        'colors' => [],
                        'type_doc' => [],
                        'prices' => [],
                        'paids' => [],
                        'QtTraveller' => [],
                        'fullblocked' => [],
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
                if (!in_array($QtTraveller, $grouped[$date]['QtTraveller'])) {
                    $grouped[$date]['QtTraveller'][] = $QtTraveller; 
                }
                if (!in_array($fullblocked, $grouped[$date]['fullblocked'])) {
                    $grouped[$date]['fullblocked'][] = $fullblocked; // Ajoutez 'fullblocked' s'il n'est pas déjà dans le tableau
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
            $eventPaidPrice = array_sum($data['paids']); // Calculez le total des paiements pour la date
            $eventQtTraveller = array_sum($data['QtTraveller']); // Calculez le total des prix pour la date
            $eventPaid = $eventPaidPrice == $eventPrice ? 'Payé' : 'Impayé'; // Déterminez si un paiement a été effectué

            $events[] = [
                'start' => $date,
                'type_doc' => $data['type_doc'][0], // Utilisez le premier 'type_doc' trouvé
                'backgroundColor' => $color,
                'status' => $eventPaid,
                'price' => $eventPrice,
                'paid' => $eventPaidPrice,
                'QtTraveller' => $eventQtTraveller,
                'service_title' => $service_title,
                'fullblocked' => $fullblocked,
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
        if ($booking_id !== false) {
            $id = $booking_id;
        } else {
            $id = $this->request->getGet('id');
        }
        $response = $this->BookingModel->getBookingFromID($id);
        return $this->response->setJSON($response);
    }

    public function getBookingsFromCustomer()
    {
        $customer_id = $this->request->getGet('customer_id');
        $Type_doc = $this->request->getGet('Type_doc');
        $customer_info = $this->CustomerModel->get_customer_info($customer_id);
        if ($customer_id) {
            $bookings = $this->BookingModel->getBookingsFromCustomer($customer_id,$Type_doc);
            if (!empty($bookings)) {
                return $this->response->setJSON(['success' => true, 'error'=> null, 'bookings' => $bookings, 'customers' => $customer_info]);
            }
            else{
                $error = "Aucune réservation trouvé.";
                return $this->response->setJSON(['success' => true, 'error'=> $error, 'bookings' => $bookings, 'customers' => $customer_info]);
            }
        } else {
            $error = "ERROR, Aucun client n'a été trouvé avec l'ID : " . $customer_id;
            return $this->response->setJSON(['success' => false, 'error'=> $error, 'bookings' => null, 'customers' => $customer_id]);
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
        unset($data['id']);
        $data['Type_doc'] = $data['Type_doc'] == "1"? "Facture" : "Devis";

        if ($this->BookingModel->validate($data)) {  // Utilisez les règles de validation définies dans le modèle
            if ($this->BookingModel->update($id, $data)) {
                return $this->response->setJSON(['status' => 'success', 'id' => $id, 'data' => $data]);
            } else {
                return $this->response->setJSON(['status' => 'fail', 'message' => 'Une erreur dans les données envoyées, vérifier la syntaxe des textes']);
            }
        } else {
            return $this->response->setJSON(['status' => 'fail', 'message' => $this->BookingModel->errors()]);
        }
    }


    public function addBooking()
    {
        header("application/x-www-form-urlencoded; charset=UTF-8");
        // Vérifiez si la requête est une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->response->setJSON(['status' => 'fail', 'error' => 'Only POST requests are allowed']);
        }

        $booking_data = $this->request->getPost();

        // Chargement du modèle

        $result = $this->BookingModel->addBooking($booking_data);

        if ($result['success']) {
            return $this->response->setJSON(['success' => true, 'id' => $result['id'], 'data' => $booking_data]);
        } else {
            $errors = $this->BookingModel->errors() ? $this->BookingModel->errors() : 'Unknown error';
            return $this->response->setJSON(['success' => false, 'error' => $errors, 'data' => $booking_data]);
        }
    }


    public function deleteBooking()
    {
        $booking_id = $this->request->getPost('id'); // Récupérez l'ID de la réservation à supprimer depuis la requête POST

        // Utilisez la fonction deleteBooking pour supprimer la réservation
        $bookingDelete = $this->BookingModel->deleteBooking($booking_id);

        if ($bookingDelete) {
            $paidBookingDelete = $this->PaidModel->deletePaidsFromBooking($booking_id);
            if($paidBookingDelete){
                // La suppression a réussi
                return $this->response->setJSON(['success' => true]);
            }
            else{
                // La suppression a réussi
                return $this->response->setJSON(['success' => true]);
            }
        } else {
            // La suppression a échoué
            $message = "La suppression à échoué"; 
            return $this->response->setJSON(['success' => false, 'error' => $message]);
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

        $entreprise = $this->ConfigModel->get_enteprise_name();

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
            //$fileName = uniqid("pdf_") . ".pdf"; // Générer un nom de fichier unique
            $fileName = $entreprise ."_".$bookingData['Type_doc']."#".$id . ".pdf"; // Générer un nom de fichier unique
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
        $SMTPCredential = $this->ConfigModel->getSMTPCredential(); // Vos données de réservation

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
                'baseurl' => base_url(),
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
        $config['protocol'] = 'smtp';
        $config['SMTPHost'] = 'smtp.hostinger.com';
        $config['SMTPPort'] = 587; // ou 465 pour SSL
        $config['SMTPUser'] = $SMTPCredential['mail'];
        $config['SMTPPass'] = $SMTPCredential['pass'];
        $config['SMTPCrypto'] = 'tls'; // ou 'ssl'
        $config['mailType'] = 'html';
        $config['charset']   = 'utf-8';
        $config['newline']   = "\r\n";

        $email->initialize($config);

        $email->setFrom($SMTPCredential['mail'], $seller[0][0]['Data']); 
        $email->setReplyTo($seller[0][3]['Data'], $seller[0][0]['Data']);
        $email->setTo($customerData['Email']); // Définissez le destinataire
        $email->setSubject($seller[0][0]['Data']. ' - ' . $bookingData['Type_doc']. ' : Information de réservation'); // Définissez le sujet
        $email->setMessage($html); // Ajoutez le corps de l'email
        // Chemin vers le fichier que vous souhaitez joindre
        // Attachez le PDF à l'e-mail
        $email->attach($pdfFilePath);
        if ($email->send()) {
            unlink($pdfFilePath);
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                                  ->setJSON([
                                      'success' => true
                                  ]);
        } else {
            unlink($pdfFilePath);
            $error = $email->printDebugger(['headers']);
            log_message('error', 'Email sending failed: ' . $error);
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                  ->setJSON([
                                      'success' => false,
                                      'message' => 'Échec de l’envoi de l’email. ' . $error . print_r($SMTPCredential['mail'])
                                  ]);
        }
    }
}
