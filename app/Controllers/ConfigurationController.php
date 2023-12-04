<?php

namespace App\Controllers;

use CodeIgniter\CLI\Console;
use DateTime;
use CodeIgniter\HTTP\Files\UploadedFile;



class ConfigurationController extends BaseController
{
    /**
     * @var \App\Models\CustomerModel
     */
    private $ServiceModel;
    private $ConfigurationModel;

    public function __construct()
    {
        $this->ServiceModel = new \App\Models\ServiceModel();
        $this->ConfigurationModel = new \App\Models\ConfigurationModel();
    }

    public function ReturnView()
    {

        $data = [
            'title' => 'TITTRE',
            'baseurl' => base_url(),
            'services_list' => ($services_list = $this->ServiceModel->get_services_list()) ? $services_list : [],
            'totalServices' => $this->ServiceModel->getTotalServices(),
            'All_config' => $this->getAll(),
            'discountRules' => $this->DiscountRules(),

        ];


        $view1 = view('Configuration_view', $data);

        $datas['contents_views'] = $view1;

        echo view('default_layout', $datas);
    }

    public function getAll()
    {
        return $this->ConfigurationModel->get_all_config();
    }


    public function DiscountRules()
    {
        return $this->ConfigurationModel->DiscountRules();
    }



    public function saveConfigurations()
    {
        $data_config_to_save = []; 
        $data_service_to_save = []; 
        $serviceId = null; // Initialiser le service_id

        $postData = $this->request->getPost();
        foreach ($postData as $config_id_key => $data_value) {
            if(is_numeric($config_id_key)){  
  
                $data_config_to_save[] = [
                    'config_id' => $config_id_key,
                    'Data' => $data_value
                ];
            }
            else{
              
                    // Extrait le numéro ID à la fin de la chaîne 'Service_id_n'
                    if (preg_match('/Service_id_(\d+)/', $config_id_key, $matches)) {
                        $serviceId = $matches[1];
                        // Pas besoin d'ajouter 'service_id' au tableau
                    } elseif (preg_match('/(\w+)_(\d+)/', $config_id_key, $matches)) {
                        $serviceId = $matches[2];
                        $attribute = strtolower($matches[1]);
                        // Ajoute les autres attributs au tableau de services sous le bon service ID
                        $data_service_to_save[$serviceId][$attribute] = $data_value;
                    }
                }   
            }

        // Vérification et traitement de l'image téléchargée
        $uploadedImage = $this->request->getFile(2);
        $imagePath = '';

        
        if ($uploadedImage->isValid() && !$uploadedImage->hasMoved()) {
            $newName = $uploadedImage->getRandomName();  // Génère un nouveau nom aléatoire
            $uploadedImage->move(WRITEPATH . 'uploads', $newName);  // Déplace le fichier vers le dossier "uploads"

            $imagePath = base_url() . 'uploads/' . $newName;
            $data_config_to_save[] = [
                'config_id' => 2, // Remplacez 'id_pour_image' par l'ID que vous utilisez pour le champ d'image dans la base de données
                'Data' => $imagePath
            ];
        }

       if (!$this->ConfigurationModel->saveConfigurations($data_config_to_save)) {
            // Enregistrement a échoué
            
             return redirect()->to('Config')->with('message', 'Erreur lors de l\'enregistrement de la configuration');
        }
        
        if (!$this->ServiceModel->upsert($data_service_to_save)) {
            // Enregistrement a échoué
            
             return redirect()->to('Config')->with('message', 'Erreur lors de l\'enregistrement de la configuration');
        }
        else{
            var_dump('reussi');
        }

       return redirect()->to('Config')->with('message', 'Configuration enregistrée avec succès');
    }
    
}
