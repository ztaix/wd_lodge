<?php namespace App\Models;

use CodeIgniter\Model;

class ConfigurationModel extends Model
{
    // Nom de la table
    protected $table = 'wd_config';

    // Clé primaire
    protected $primaryKey = 'config_id';

    // Si vous utilisez un auto-increment
    protected $useAutoIncrement = true;

    // Les champs autorisés pour les insertions et les mises à jour
    protected $allowedFields = ['Title', 'Data'];

    // Les règles de validation pour les champs
    protected $validationRules = [
        'Title' => 'required',
        'Data' => 'required'
    ];


    public function get_all_config()
    {
        $result =  $this->findAll();
        return $result;
    }
    
    public function DiscountRules(){
        $discountrules = $this->where('Title', 'Règles de réduction')->first();
        return $discountrules;
    }

}
