<?php namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use Exception;

class BookingModel extends Model
{
    // Nom de la table
    protected $table = 'wd_bookings';

    // Clé primaire
    protected $primaryKey = 'id';

    // Si vous utilisez un auto-increment
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'Customer_id', 'start', 'end', 'Service_id', 'qt','Price', 
        'Paid', 'Type_doc', 'Pdf_url', 'Comment', 'Created_at', 'Deleted_at'
    ]; // les champs autorisés pour l'insertion ou la mise à jour

    // Pas de champ pour la date de modification, donc on ne définit pas `$updatedField`

    protected $validationRules = [
        'Customer_id'  => 'required|integer',
        'start'   => 'required',
        'end'     => 'required',
        'Service_id'   => 'required|integer',
        'qt'        => 'required|integer',
        'Price'        => 'required|integer',
        'Paid'         => 'permit_empty|integer',
        'Type_doc'     => 'required|in_list[Devis,Facture]',
        'Pdf_url'      => 'permit_empty|max_length[255]',
        'Comment'      => 'permit_empty|max_length[255]',
        'Deleted_at'      => 'permit_empty|in_list[0,1]'
    ]; // les règles de validation

    // Dates
    protected $useTimestamps = true; // pour manipuler automatiquement les champs de date de création et de modification

    // Soft deletes
    protected $useSoftDeletes = true;


/////////////////////////////////////


    public function getAllBookings(){
        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_services.Title as service_title, wd_services.Color as service_color');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $result = $this->findAll();

        return $result;
    }
    public function getAllBookingsFromService($service){
        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_services.Title as service_title, wd_services.Color as service_color');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $this->where('wd_bookings.Service_id', $service);
        $result = $this->findAll();

        return $result;
    }

    public function getBookingsFromDate($date){
        try {
            $dt = new DateTime($date);
            $formattedDate = $dt->format('Y-m-d');
        } catch (Exception $e) {
            // La date est mal formée
            return null;
        }
        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_services.Title as service_title, wd_services.Color as service_color');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        // Condition pour vérifier si la colonne 'end' contient une valeur
        $this->groupStart();
        $this->where("(DATE(start) <= '$formattedDate' AND (DATE(end) >= '$formattedDate' OR end IS NULL))");
        $this->orWhere('end IS NULL');
        $this->groupEnd();
        $result = $this->findAll();
        return $result;
    }

    public function getBookingFromID($id)
    {
        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_customers.Phone as customer_phone, wd_customers.Email as customer_mail, wd_customers.Comment as customer_comment, wd_customers.Created_at as customer_created,  wd_services.Title as service_title, wd_services.Color as service_color', false);
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $this->where("wd_bookings.id", $id);
        $result = $this->first(); // Utilisez first si vous attendez un seul enregistrement
        return $result;
    }

    public function getBookingsFromCustomer($customer_id){

        $this->select('wd_bookings.*,  wd_services.Title as service_title, wd_services.Color as service_color');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');        
        $this->where("wd_bookings.Customer_id", $customer_id);
        $result = $this->findAll();
        return $result;
    }


    public function getBookingCountByDate() {
        $bookings = $this->findAll();
        
        $counts = [];
        foreach ($bookings as $booking) {
            $startDate = new DateTime($booking['start']);
            $endDate = new DateTime($booking['end']);
            while ($startDate <= $endDate) {
                $dateString = $startDate->format('Y-m-d');
                if (isset($counts[$dateString])) {
                    $counts[$dateString]++;
                } else {
                    $counts[$dateString] = 1;
                }
                $startDate->modify('+1 day');
            }
        }
    
        $result = [];
        foreach ($counts as $date => $count) {
            $result[] = ['start' => $date, 'count' => $count];
        }
    
        return $result;
    }
    

    public function addBooking($data)
    {
        // Effectuer la validation ici si nécessaire
        if ($this->validate($data)) {
            $this->insert($data);
            return true;
        } else {
            // Récupérer et retourner les erreurs de validation
            $errors = $this->errors();
            return [
                'success' => false,
                'errors' => $errors
            ];
        }
    }

    public function deleteBooking($data)
    {
            // Utilisez la fonction delete pour supprimer la réservation avec l'ID donné
        $this->delete($data);

        // Vérifiez si la suppression a réussi en vérifiant le nombre de lignes affectées
        return $this->db->affectedRows() > 0;
    }

    public function getBookingsFromSearch($searchInput)
    {
        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_services.Title as service_title, wd_services.Color as service_color');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
    
        // Convertir searchInput en minuscule
        $searchInputLower = strtolower($searchInput);
    
        // Tenter de convertir le searchInput en une date au format YYYY-MM-DD
        $possibleDateFormats = ['d/m/Y', 'd/m/y', 'd-m-Y', 'd-m-y'];
        $searchDate = null;
    
        foreach ($possibleDateFormats as $format) {
            $dateObj = DateTime::createFromFormat($format, $searchInput);
            if ($dateObj !== false && $dateObj->format($format) === $searchInput) {
                $searchDate = $dateObj->format('Y-m-d');
                break;
            }
        }
    
        $this->groupStart(); // Commencer un groupe de conditions
            $this->like("LOWER(wd_customers.Name)", $searchInputLower);
            $this->orLike("LOWER(wd_bookings.id)", $searchInputLower);
            if ($searchDate) {
                $this->orGroupStart();
                    $this->orWhere("wd_bookings.start <= ", $searchDate);
                    $this->where("wd_bookings.end >= ", $searchDate);
                $this->groupEnd();
            }
            $this->orLike("LOWER(wd_services.Title)", $searchInputLower);
            $this->orLike("LOWER(wd_bookings.Comment)", $searchInputLower);
            $this->orLike("LOWER(wd_bookings.Price)", $searchInputLower);
            $this->orLike("LOWER(wd_bookings.Paid)", $searchInputLower);
        $this->groupEnd(); // Finir le groupe de conditions
        
        $result = $this->findAll(); // Utiliser findAll pour récupérer tous les résultats
        
        return $result;
    }
    
    
    
}