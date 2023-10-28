<?php

namespace App\Controllers;

use CodeIgniter\CLI\Console;
use DateTime;


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
        
        $postData = $this->request->getPost();

        $data_to_save = [];

        foreach ($postData as $config_id => $data_value) {
            $data_to_save = [
                'config_id' => $config_id,
                'Data' => $data_value
            ];
            if ($this->ConfigurationModel->save($data_to_save)) {
                // Enregistrement réussi

                return redirect()->to('Config')->with('message', 'Configuration enregistrée avec succès');
            } else {
                var_dump("Contrôleur perdu"); die;

                // Enregistrement a échoué
                return redirect()->to('Config')->with('message', 'Erreur lors de l\'enregistrement de la configuration');
            }
        }
    }
}
