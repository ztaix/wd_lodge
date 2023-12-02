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
        'Customer_id', 'start', 'end', 'Service_id', 'Qt', 'QtTraveller', 'Price', 
        'Paid', 'Type_doc', 'Pdf_url', 'Comment', 'fullblocked', 'Created_at', 'Deleted_at'
    ]; // les champs autorisés pour l'insertion ou la mise à jour

    // Pas de champ pour la date de modification, donc on ne définit pas `$updatedField`

    protected $validationRules = [
        'Customer_id'  => 'required|integer',
        'start'   => 'required',
        'end'     => 'required',
        'Service_id'   => 'required|integer',
        'fullblocked'   => 'permit_empty|integer',
        'Qt'           => 'required|integer',
        'QtTraveller'  => 'required|integer',
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


    public function getAllBookings($service_id=false,$fullblocked=false){
        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_services.Title as service_title, 
        wd_services.Color as service_color,
        GROUP_CONCAT(wd_paid.paid_id) as paids_ids,
        GROUP_CONCAT(wd_paid.type_paid) as types_paids,
        GROUP_CONCAT(wd_paid.value) as paids_values');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $this->join('wd_paid', 'wd_paid.booking_id = wd_bookings.id AND wd_paid.deleted_at IS NULL', 'left');
        $this->groupBy('wd_bookings.id');
        if($service_id !== false){
            $this->where('wd_bookings.Service_id', $service_id);
        }
        if($fullblocked == "true"){
            $this->orWhere('wd_bookings.fullblocked', 1);
        }
        $result = $this->findAll();

        return $result;
    }

    public function getAllBookingsFromDatepicker($service_id=false,$fullblocked=false){
        $this->select('wd_bookings.id,wd_bookings.Price,wd_bookings.start,wd_bookings.end,wd_bookings.fullblocked, wd_bookings.service_id, wd_bookings.Paid , 
        wd_services.Title as service_title,wd_services.Color as service_color,
        GROUP_CONCAT(wd_paid.paid_id) as paids_ids,
        GROUP_CONCAT(wd_paid.type_paid) as types_paids,
        GROUP_CONCAT(wd_paid.value) as paids_values');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $this->join('wd_paid', 'wd_paid.booking_id = wd_bookings.id AND wd_paid.deleted_at IS NULL', 'left');
        $this->groupBy('wd_bookings.id');
        if($service_id !== false){
            $this->where('wd_bookings.Service_id', $service_id);
        }
        if($fullblocked == "true"){
            $this->orWhere('wd_bookings.fullblocked', 1);
        }
        $result = $this->findAll();

        return $result;
    }
    public function getAllBookingsFromService($service){
        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_services.Title as service_title, 
        wd_services.Color as service_color,
        GROUP_CONCAT(wd_paid.paid_id) as paids_ids,
        GROUP_CONCAT(wd_paid.type_paid) as types_paids,
        GROUP_CONCAT(wd_paid.value) as paids_values');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $this->join('wd_paid', 'wd_paid.booking_id = wd_bookings.id AND wd_paid.deleted_at IS NULL', 'left');
        $this->groupBy('wd_bookings.id');
        // Appliquer le filtre pour les réservations avec le service_id spécifié
        $this->where('wd_bookings.Service_id', $service);
        // OU les réservations qui n'ont pas ce service_id mais avec fullblocked à true
        $this->orWhere('wd_bookings.fullblocked', 1);
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
        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_services.Title as service_title, 
        wd_services.Color as service_color,
        GROUP_CONCAT(wd_paid.paid_id) as paids_ids,
        GROUP_CONCAT(wd_paid.type_paid) as types_paids,
        GROUP_CONCAT(wd_paid.value) as paids_values');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $this->join('wd_paid', 'wd_paid.booking_id = wd_bookings.id AND wd_paid.deleted_at IS NULL', 'left');
        $this->groupBy('wd_bookings.id');
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
        $this->select('wd_bookings.*, 
        wd_customers.Name as customer_name, 
        wd_customers.Phone as customer_phone, 
        wd_customers.Email as customer_mail, 
        wd_customers.Created_at as customer_created, 
        wd_customers.Comment as customer_comment, 
        wd_services.Title as service_title, 
        wd_services.Image_url as img, 
        wd_services.Color as service_color,
        GROUP_CONCAT(wd_paid.paid_id) as paids_ids,
        GROUP_CONCAT(wd_paid.type_paid) as types_paids,
        GROUP_CONCAT(wd_paid.value) as paids_values');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $this->join('wd_paid', 'wd_paid.booking_id = wd_bookings.id AND wd_paid.deleted_at IS NULL', 'left');
        $this->groupBy('wd_bookings.id');
        $this->where("wd_bookings.id", $id);
        $result = $this->first(); 
        return $result;
    }

    public function getBookingsFromCustomer($customer_id){

        $this->select('wd_bookings.*, wd_customers.Name as customer_name, wd_services.Title as service_title, 
        wd_services.Color as service_color,
        GROUP_CONCAT(wd_paid.paid_id) as paids_ids,
        GROUP_CONCAT(wd_paid.type_paid) as types_paids,
        GROUP_CONCAT(wd_paid.value) as paids_values');
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
        $this->join('wd_paid', 'wd_paid.booking_id = wd_bookings.id AND wd_paid.deleted_at IS NULL', 'left');
        $this->groupBy('wd_bookings.id');    
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
        $id = null; // Initialisez $id en dehors du bloc conditionnel

        if ($this->validate($data)) {
            $inserted = $this->insert($data);
            if ($inserted) {
                $id = $this->insertID(); // Récupérer le nouvel ID si nécessaire
                return ['success' => true, 'id' => $id];
            } else {
                // Gérer le cas où l'insertion échoue
                $error = $this->errors();
                return ['success' => false, 'error' => $error];
            }
        } else {
            // Gérer le cas où la validation échoue
            $validationErrors = $this->validation->getErrors();
            return ['success' => false, 'validationErrors' => $validationErrors];
        }
        return ['success' => isset($id), 'id' => $id];

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
        $this->select('wd_bookings.*');
        $this->select('wd_customers.Name as customer_name');
        $this->select('wd_services.Title as service_title, wd_services.Color as service_color');
       
        if(is_numeric($searchInput)){
        $this->select('wd_bookings.Price + (wd_bookings.QtTraveller * 200) AS Total');
        }
    
        $this->join('wd_customers', 'wd_customers.Customer_id = wd_bookings.Customer_id', 'left');
        $this->join('wd_services', 'wd_services.Service_id = wd_bookings.Service_id', 'left');
    

    
        
        if(is_numeric($searchInput)){
            $this->having('Total', $searchInput);
        }else{
                $this->groupStart(); // Commencer un groupe de conditions
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
                $this->groupEnd(); // Finir le groupe de conditions
            }
        
        $result = $this->findAll(); // Utiliser findAll pour récupérer tous les résultats
        
        return $result;
    }
    
    
    
}