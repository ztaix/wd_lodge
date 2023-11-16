<?php namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use Exception;

class BookingModel extends Model
{
    // Nom de la table
    protected $table = 'wd_paid';

    // Clé primaire
    protected $primaryKey = 'paid_id';

    // Si vous utilisez un auto-increment
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'paid_id', 'value', 'type_paid', 'Created_at', 'Deleted_at'
    ]; // les champs autorisés pour l'insertion ou la mise à jour

    // Pas de champ pour la date de modification, donc on ne définit pas `$updatedField`

    protected $validationRules = [
 
        'value'           => 'required|integer',
        'type'     => 'required|in_list[VISA,ESPECE,AMEX,VIREMENT,]',

    ]; // les règles de validation

    // Dates
    protected $useTimestamps = true; // pour manipuler automatiquement les champs de date de création et de modification

    // Soft deletes
    protected $useSoftDeletes = true;


/////////////////////////////////////


    public function getAllPaids(){
        $this->select('wd_paids.*');

        $result = $this->findAll();

        return $result;
    }


    public function getBookingFromID($id)
    {
        $this->select('wd_paid.*', false);
        $this->where("wd_bookings.id", $id);
        $result = $this->first(); // Utilisez first si vous attendez un seul enregistrement
        return $result;
    }

    public function getPaidsFromCustomer($customer_id){

        $this->select('wd_paid.*');
        $this->where("wd_bookings.Customer_id", $customer_id);
        $result = $this->findAll();
        return $result;
    }

    

    public function addpaid($data)
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

    public function deletePaid($data)
    {
            // Utilisez la fonction delete pour supprimer la réservation avec l'ID donné
        $this->delete($data);

        // Vérifiez si la suppression a réussi en vérifiant le nombre de lignes affectées
        return $this->db->affectedRows() > 0;
    }

    
    
    
}