<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    // Nom de la table
    protected $table = 'wd_customers';

    // Clé primaire
    protected $primaryKey = 'Customer_id';

    // Si vous utilisez un auto-increment
    protected $useAutoIncrement = true;

    // Les champs autorisés pour les insertions et les mises à jour
    protected $allowedFields = ['Customer_id','Name', 'Email', 'Phone', 'Comment', 'Deleted_at'];

    // Les règles de validation pour les champs
    protected $validationRules = [
        'Name' => 'required',
        'Email' => 'permit_empty|valid_email',
        'Phone' => 'permit_empty',
        'Comment' => 'permit_empty',
    ];

    // Dates
    protected $useTimestamps = true;
    // Soft deletes
    protected $useSoftDeletes = true;


    public function get_customer_info($customer_id)
    {
        $result = $this->find($customer_id);
        if (empty($result)) {
            // Aucun résultat trouvé
            echo "Aucun client trouvé avec l'ID : " . $customer_id;
        }
        return $result;
    }

    public function get_customer_list()
    {
        $result = $this->select('Customer_id, Name,Email, Phone, Comment')
            ->findAll();
        // print_r($this->db->error());

        return $result;
    }

    public function get_customer_search($search)
    {
        return $this->like('Name', $search)
            ->orWhereLike('Email', $search)
            ->orWhereLike('Phone', $search)
            ->findAll();
    }

    public function get_customers_unpaid($customers_id = null, $booking_id = null, bool $sum = true)
    {
        $builder = $this->db->table('wd_booking');

        // Joindre la table wd_customers pour récupérer des informations sur les clients
        $builder->join('wd_customers', 'wd_booking.Customer_id = wd_customers.Customer_id');

        // Condition pour récupérer les paiements partiels
        $builder->where('wd_booking.Price >', 'wd_booking.Paid', false);

        // Gestion des paramètres
        if ($customers_id !== null) {
            if (is_array($customers_id)) {
                $builder->whereIn('wd_customers.Customer_id', $customers_id);
            } else {
                $builder->where('wd_customers.Customer_id', $customers_id);
            }
        }

        if ($booking_id !== null) {
            if (is_array($booking_id)) {
                $builder->whereIn('wd_booking.Booking_id', $booking_id);
            } else {
                $builder->where('wd_booking.Booking_id', $booking_id);
            }
        }

        if ($sum === true) {
            // Calculer la somme de la différence entre le prix et le montant payé
            $builder->selectSum('wd_booking.Price - wd_booking.Paid', 'partial_paid');

            // Exécuter la requête et récupérer les résultats
            $query = $builder->get();
            $result = $query->getRow();  // Utilisez getRow() parce qu'une seule ligne de résultat est attendue
            // Retourne un int

            return $result->partial_paid;
        } else {
            // Exécuter la requête et récupérer les résultats
            $query = $builder->get();
            return $query->getResult();
            // Retourne un array
        }
    }

    public function get_customer_paid($customer_ids)
    {
        // Code pour obtenir la somme totale payée par un groupe de clients
        // Retourne un int
        // À compléter en fonction de votre base de données
        return 0;
    }

    public function get_customer_best($limit = 1, $service_id = null)
    {
        // Code pour trouver le meilleur client
        // Retourne un tableau
        // À compléter en fonction de votre base de données
        return [];
    }


    public function update_customer($id, $modify = null, $delete = null)
    {
        if ($modify && is_array($modify) && isset($modify['Customer_id']) and $delete == false) {
            $this->update($id, $modify);
            return true;
        } elseif ($modify) {
            // Gérer l'erreur, car $modify n'est pas au format attendu
        }

        if ($delete == true) {
            $this->delete($id);
        }
    }
}
