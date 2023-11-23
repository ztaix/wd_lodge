<?php

namespace App\Models;

use CodeIgniter\Model;

class PaidModel extends Model
{
    // Nom de la table
    protected $table = 'wd_paid';

    // Clé primaire
    protected $primaryKey = 'paid_id';

    // Si vous utilisez un auto-increment
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'paid_id', 'booking_id', 'value', 'type_paid', 'deleted_at'
    ]; // les champs autorisés pour l'insertion ou la mise à jour

    protected $validationRules = [

        'booking_id' => 'required|integer',
        'value'      => 'required|integer',
        'type_paid'       => 'required|in_list[VISA,ESPECE,AMEX,VIREMENT,CHEQUE]',

    ]; // les règles de validation

    // Dates
    protected $useTimestamps = true; // pour manipuler automatiquement les champs de date de création et de modification

    // Soft deletes
    protected $useSoftDeletes = true;


    /////////////////////////////////////


    public function getAllPaids($paid_id = false)
    {
        if ($paid_id == false) {
            $this->where('paid_id', $paid_id);
        }
        $this->select('*');
        $result = $this->findAll();

        return $result;
    }


    public function getPaidsFromBookingID($id = false)
    {
        $this->select('*', false);
        if ($id !== false) {
            $this->where("booking_id", $id);
        }
        $result = $this->findAll(); // Utilisez first si vous attendez un seul enregistrement
        return $result;
    }

    public function getPaidsFromCustomer($customer_id)
    {
        // Assurez-vous que le nom de la table est correct
        $this->join('wd_bookings', 'wd_bookings.id = wd_paid.booking_id', 'inner');
        $this->where('wd_bookings.customer_id', $customer_id);
        $this->select('wd_paid.*'); // Utilisez le nom correct de la table
        $result = $this->findAll(); // Ou utilisez getWhere(['wd_bookings.customer_id' => $customer_id]) pour plus d'efficacité
        return $result;
    }


    public function getPaidsFromCustomerAndbooking($customer_id, $booking_id)
    {
        // Assurez-vous que le nom de la table est correct
        $this->join('wd_bookings', 'wd_bookings.id = wd_paid.booking_id', 'inner');
        $this->where('wd_bookings.customer_id', $customer_id);
        $this->where('wd_bookings.id', $booking_id);
        $this->select('wd_paid.*'); // Utilisez le nom correct de la table
        $result = $this->getWhere(['wd_bookings.customer_id' => $customer_id]);
        return $result;
    }



    public function addPaid($data)
    {
        if (count($data) > 1) {
            $results = [];
            foreach ($data as $row) {
                if ($this->validate($row)) {
                    $addResult = $this->insert($row);
                    if ($addResult === false) {
                        // L'insertion a échoué. Gérez l'erreur ici.
                        $errors = $this->errors();
                        return [
                            'success' => false,
                            'errors' => $errors
                        ];
                    } else {
                        // L'insertion a réussi. Continuez avec la récupération de l'ID.
                        $id = $this->insertID();
                        $results[] = ['success' => true, 'id' => $id];
                    }
                } else {
                    // Récupérer et retourner les erreurs de validation
                    $errors = $this->errors();
                    return [
                        'success' => false,
                        'errors' =>  $errors
                    ];
                }
            }
            return $results;
        } else {

            // Effectuer la validation ici si nécessaire
            if ($this->validate($data)) {
                $addResult = $this->insert($data);
                if ($addResult === false) {
                    // L'insertion a échoué. Gérez l'erreur ici.
                    $errors = $this->errors();
                    return [
                        'success' => false,
                        'errors' => $errors
                    ];
                } else {
                    // L'insertion a réussi. Continuez avec la récupération de l'ID.
                    $id = $this->insertID();
                    return ['success' => true, 'id' => $id];
                }
            } else {
                // Récupérer et retourner les erreurs de validation
                $errors = $this->errors();
                return [
                    'success' => false,
                    'errors' =>  $errors
                ];
            }
        }
    }

    public function upsert($data , $existId)
    {

        $results = [];

            if($existId){
                $Paid_ID = $data['id'];
                array_shift($data);
                 // Si l'enregistrement existe
                $existingRecord = $this->where('paid_id', $Paid_ID)->first();
                if ($existingRecord) {

                    // Mise à jour de l'enregistrement existant
                    $result = $this->update($Paid_ID, $data);
                }
            }else {

                /* Si n'existe pas */ 
                // Création d'un nouvel enregistrement
                $Paid_ID = $this->insert($data, true);
                if ($Paid_ID === false) {
                    $error = $this->errors();
                    // Faites quelque chose avec l'erreur, comme la logger ou l'afficher.
                }   else {$result = true; }
            }
            $results[$Paid_ID] = [
                'success' => $result,
                'errors' => $result ? [] : ['message' => 'Echec dans la mise à jour : ' . $error . ' - Ligne:' . $Paid_ID . '/' . print_r($data)]
            ];


        return $results;
    }


    public function deletePaid($ids)
    {
        $result = [];

        // Vérifiez si $ids est défini et non vide
        if (isset($ids) && $ids !== '') {
            // Convertir $ids en tableau si ce n'est pas déjà le cas
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            foreach ($ids as $id) {

                $result[$id] = $this->where('paid_id', $id)->delete();
                
            }
        }
        return $result;
    }
}
