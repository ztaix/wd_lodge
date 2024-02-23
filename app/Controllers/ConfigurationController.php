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
        // Initialiser les tableaux pour sauvegarder les configurations et les services.
        $data_config_to_save = [];
        $data_service_to_save = [];

        // Récupérer les données envoyées en JSON.
        $postData = $this->request->getJSON(true); // Assurez-vous que les données sont envoyées en JSON depuis le client.

        // Parcourir les données postées.
        foreach ($postData as $config_id_key => $data_value) {
            if (is_numeric($config_id_key)) {
                // Ajouter les configurations simples.
                $data_config_to_save[] = [
                    'config_id' => $config_id_key,
                    'Data' => $data_value
                ];
            } else {
                // Traiter les données de service.
                if (preg_match('/Service_id_(\d+)/', $config_id_key, $matches)) {
                    $serviceId = $matches[1];
                } elseif (preg_match('/(\w+)_(\d+)/', $config_id_key, $matches)) {
                    $serviceId = $matches[2];
                    $attribute = strtolower($matches[1]);
                    $data_service_to_save[$serviceId][$attribute] = $data_value;
                }
            }
        }

        // Gérer le téléchargement de l'image.
        $uploadedImage = $this->request->getFile('logo'); // Remplacer 'logo' par le nom réel du champ de fichier.
        if ($uploadedImage && $uploadedImage->isValid() && !$uploadedImage->hasMoved()) {
            $newName = $uploadedImage->getRandomName(); // Générer un nouveau nom de fichier aléatoire.
            $uploadedImage->move(WRITEPATH . 'uploads', $newName); // Déplacer l'image téléchargée.
            $imagePath = base_url('/uploads/' . $newName); // Construire le chemin d'accès de l'image.

            // Ajouter le chemin de l'image au tableau des configurations à sauvegarder.
            $data_config_to_save[] = [
                'config_id' => 2, // Assurez-vous que cela correspond à l'ID de votre configuration pour l'image.
                'Data' => $imagePath
            ];
        }

        // Enregistrer les configurations.
        if (!$this->ConfigurationModel->saveConfigurations($data_config_to_save)) {
            // Gérer l'échec de l'enregistrement des configurations.
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de l\'enregistrement des configurations.']);
        }

        // Enregistrer les services.
        if (!empty($data_service_to_save) && !$this->ServiceModel->upsert($data_service_to_save)) {
            // Gérer l'échec de l'enregistrement des services.
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de l\'enregistrement des services.']);
        }

        // Tout s'est bien passé.
        return $this->response->setJSON(['success' => true, 'message' => 'Configuration enregistrée avec succès.']);
    }
}
