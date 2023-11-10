<?php namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    // Nom de la table
    protected $table = 'wd_services';

    // Clé primaire
    protected $primaryKey = 'Service_id';

    // Si vous utilisez un auto-increment
    protected $useAutoIncrement = true;

    // Les champs autorisés pour les insertions et les mises à jour
    protected $allowedFields = ['Title', 'Price', 'Image_url','Color', 'Comment','fullblocked'];

    // Les règles de validation pour les champs
    protected $validationRules = [
        'Title' => 'required',
        'Price' => 'required|integer',
        'Image_url' => 'permit_empty',
        'Color' => 'permit_empty',
        'Comment' => 'permit_empty',
        'fullblocked' => 'permit_empty',
    ];

    // Dates
    protected $useTimestamps = true;
    // Soft deletes
    protected $useSoftDeletes = true;

    public function get_service_info($service_id)
    {
        return $this->find($service_id);
    }

    public function get_services_list()
    {
        $results = $this->select('Service_id, Title, Price, Image_url, Comment, Color,fullblocked')->findAll();
    
        $AccessFile = new \App\Controllers\FilesController();
    
        foreach($results as &$result){
            $result['Image_url'] = $AccessFile->getFilePath($result['Image_url']);
        }
    
        return $results;
    }
    
    public function getTotalServices()
    {
        return $this->db->table('wd_services')->countAllResults();
    }
    public function get_service_price($id)
    {
        $result = $this->selectSum('Price')
                    ->where('Service_id', $id)
                    ->first();

        return $result['Price'] ?? 0;  // Retourne la somme ou 0 si aucun résultat
    }
    public function get_service_title($id)
    {
        $result = $this->select('Title')
                    ->where('Service_id', $id)
                    ->first();

        return $result['Title'] ?? Null;  // Retourne la somme ou 0 si aucun résultat
    }
    public function updateService($id, $data)
    {
        return $this->update($id, $data);
    }
    public function deleteService($id){
        return $this->delete($id);

    }
    
}
