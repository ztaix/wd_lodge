<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'wp_users'; // Nom de votre table
    protected $primaryKey = 'id'; // Clé primaire

    protected $useAutoIncrement = true; // Utiliser l'auto-incrémentation pour l'ID
    protected $returnType = 'array'; // Type de retour (array, object, etc.)
    
    protected $allowedFields = ['email', 'password', 'name']; // Champs autorisés pour l'insertion et la mise à jour

    protected $useTimestamps = true; // Utiliser les timestamps
    protected $createdField  = 'created_at'; // Champ pour la date de création
    protected $updatedField  = 'updated_at'; // Champ pour la date de mise à jour

    protected $validationRules    = []; // Règles de validation
    protected $validationMessages = []; // Messages de validation personnalisés
    protected $skipValidation     = false; // Ne pas sauter la validation

    /**
     * Recherche d'un utilisateur par email.
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
    
    /**
     * Insère un nouvel utilisateur dans la base de données.
     * 
     * @param array $data
     * @return bool|int
     */
    public function createUser(array $data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); // Hashage du mot de passe
        return $this->insert($data);
    }
}
