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
            'DiscountRules' => $this->DiscountRules(),

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
        $data_to_save = [];  // Initialisez $data_to_save comme un tableau vide en dehors de la boucle

        $postData = $this->request->getPost();
        
        foreach ($postData as $config_id => $data_value) {     
            $data_to_save[] = [
                'config_id' => $config_id,
                'Data' => $data_value
            ];

        }
        // Vérification et traitement de l'image téléchargée
        $uploadedImage = $this->request->getFile(2);
        $imagePath = '';
        if ($uploadedImage->isValid() && !$uploadedImage->hasMoved()) {
            $newName = $uploadedImage->getRandomName();  // Génère un nouveau nom aléatoire
            $uploadedImage->move(WRITEPATH . 'uploads', $newName);  // Déplace le fichier vers le dossier "uploads"

            $imagePath = base_url() . 'uploads/' . $newName;
            $data_to_save[] = [
                'config_id' => 2, // Remplacez 'id_pour_image' par l'ID que vous utilisez pour le champ d'image dans la base de données
                'Data' => $imagePath
            ];
        }

        if (!$this->ConfigurationModel->saveConfigurations($data_to_save)) {
            // Enregistrement a échoué
             return redirect()->to('Config')->with('message', 'Erreur lors de l\'enregistrement de la configuration');
        }
        var_dump($data_to_save);
       return redirect()->to('Config')->with('message', 'Configuration enregistrée avec succès');
    }
    
}
