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
    public function get_enteprise_name()
    {
        $result = $this->where('Title', 'Nom de l\'entreprise')->first();
        return $result['Data'];
    }
    
    public function DiscountRules(){
        $discountRules = $this->where('Title', 'Règles de réduction')->first();
        $discountType = $this->where('Title', 'Type de réduction')->first();
        $discountScope = $this->where('Title', 'Portée de réduction')->first();
    
        return [
            'Rules' => $discountRules,
            'Type' => $discountType,
            'Scope' => $discountScope,
        ];
    }

    
    public function saveConfigurations($data_array)
    {
        foreach ($data_array as $data) {
            $this->db->table('wd_config')
                     ->where('config_id', $data['config_id'])
                     ->update(['Data' => $data['Data']]);
        }
    }

    public function getSMTPCredential(){
        $this->select('Data');
        $mail = $this->where('Title', 'SMTPmail')->first();
        $pass = $this->where('Title', 'SMTPpass')->first();
    return [
        'mail' => $mail['Data'],
        'pass' => $pass['Data']
    ];
        
    }

}
