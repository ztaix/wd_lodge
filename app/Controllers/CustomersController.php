<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

use CodeIgniter\CLI\Console;
use DateTime;


class CustomersController extends BaseController
{
/**
     * @var \App\Models\CustomerModel
     */
    private $CustomerModel;
    private $ServiceModel;
    private $BookingModel;
    private $ConfigModel;

    public function __construct()
    {
        $this->CustomerModel = new \App\Models\CustomerModel();
        $this->ServiceModel = new \App\Models\ServiceModel();
        $this->BookingModel = new \App\Models\BookingModel();
        $this->ConfigModel = new \App\Models\ConfigurationModel();

    }

    public function ReturnView()
    {
        $data = [
            'title' => 'TITTRE',
            'baseurl' => base_url(),
            'customers_list' => ($customers_list = $this->CustomerModel->get_customer_list()) ? $customers_list : [],
            'services_list' => ($services_list = $this->ServiceModel->get_services_list()) ? $services_list : [],
            'bookins_list' => $this->BookingModel->getAllBookings(),
            'totalServices' => $this->ServiceModel->getTotalServices(),
            'discountRules' => ($rule = $this->ConfigModel->DiscountRules())? DiscountToArray($rule['Data']): '' ,

        ];
        
        
        $view1 = view('Customer_view', $data);

        $datas['contents_views'] = $view1;

        echo view('default_layout', $datas);
    }

    public function get_customer_info()
    {
        $customer_id = $this->request->getGet('customer_id'); 
    
        if ($customer_id) {
            $customer_info = $this->CustomerModel->get_customer_info($customer_id);
    
            return $this->response->setJSON([
                'status' => 'success',
                'id' => $customer_id,
                'Customer_id' => $customer_info['Customer_id'],
                'Name' => $customer_info['Name'],
                'Phone' => $customer_info['Phone'],
                'Email' => $customer_info['Email'],
                'Comment' => $customer_info['Comment']
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Paramètre manquant']);
        }
    }
    
    public function create_customer() {
        $customer_info = $this->request->getPost(); 
        if($this->CustomerModel->validate($customer_info)){
            $this->CustomerModel->create_customer($customer_info);
            $inserted_id = $this->CustomerModel->insertID();  // Récupère l'ID de la dernière ligne insérée
            return $this->response->setJSON([
                'status' => 'success', 
                'id' => $inserted_id,
                'Name' => $customer_info['Name'],
                'Phone' => $customer_info['Phone'],
                'Email' => $customer_info['Email'],
                'Comment' => $customer_info['Comment']
            ]); 
        } else {
            $errors = $this->CustomerModel->errors();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Les données envoyées ne correspondent pas aux exigences. Vérifiez les champs.', 'errors' => $errors]);
        }
    }
    

    public function update_customerFromID()
    {
        $customer_info = $this->request->getPost('customer_info'); 
    
        if ($customer_info && isset($customer_info['Customer_id'])) {
            $id = $customer_info['Customer_id'];
    
            try {
                // Si delete est true, on passe NULL comme deuxième argument pour indiquer la suppression
                $delete = (isset($customer_info['delete']) && $customer_info['delete'] == 'true') ? true : false;
                
                // Tentative de mise à jour ou de suppression
                $updated = $this->CustomerModel->update_customer($id, $delete ? null : $customer_info, $delete);
                
                if ($updated === false) {
                    // Utilisez la méthode errors() pour obtenir les messages d'erreur
                    $errors = $this->errors();
                    log_message('error', 'Erreur de mise à jour: ' . json_encode($errors));
                    return $this->response->setJSON(['status' => 'error', 'errors' => $errors]);
                }
                
                return $this->response->setJSON(['status' => 'success']);
                
            } catch (\Exception $e) {
                log_message('error', "Exception lors de la mise à jour: Message: " . $e->getMessage() .
                                    ", Code: " . $e->getCode() .
                                    ", File: " . $e->getFile() .
                                    ", Line: " . $e->getLine() .
                                    ", Trace: " . $e->getTraceAsString()
                );
                return $this->response->setJSON(['status' => 'error', 'message' => 'Une erreur est survenue lors de la mise à jour.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Paramètre manquant ou incorrect.']);
        }
    }
    

}
