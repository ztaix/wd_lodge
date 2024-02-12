<?php 

namespace App\Controllers;

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
            'discountRules' => $this->ConfigModel->DiscountRules(),

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
            $data = [   'Customer_id' => $customer_info['Customer_id'],
                        'Name' => $customer_info['Name'],
                        'Phone' => $customer_info['Phone'],
                        'Email' => $customer_info['Email'],
                        'Comment' => $customer_info['Comment']];

            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON(['succes' => false, 'message' => 'Paramètre du client manquant']);
        }
    }
    
    public function create_customer() {
        $data = $this->request->getPost();
   
        if ($row = $data['data']) {

            $result = $this->CustomerModel->save($row);
            // Vérifiez si l'insertion a réussi
            if ($result == true) {
                $data = ['id' => $this->CustomerModel->insertID(),
                        'Name' => $row['Name'],
                        'Phone' => $row['Phone'],
                        'Email' => $row['Email'],
                        'Comment' => $row['Comment'],
                ];
            return $this->response->setJSON([ 'success' => true, 'error'=> null, 'data'=> $data]); 
            }
            else{
                $errors = $this->CustomerModel->errors();
                $error = 'Erreur lors de l\'insertion des données.';
                foreach ($errors as $key => $value) {
                    $error .= '<br>Le champs: '. $key.'<br> CODE: '.$value;
                }
                return $this->response->setJSON(['success' => false, 'error'=> $error, 'errors' => $row]);
            }
        } else {
            $error = 'Requète ne retourne aucune données:'. $row ;
            return $this->response->setJSON(['success' => false, 'error' =>  $error]);
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
                    $message = 'Erreur dans la mise à jour de l\'utilisateur avec l\'ID: '. $id ;
                    log_message('error', 'Erreur de mise à jour: ' . json_encode($errors));
                    return $this->response->setJSON(['success' => false, 'error' => $message,  'errors' => $errors]);
                }
                $message = $delete ? 'Suppression du client avec l\'ID: '.$id : 'Mise à jours du client avec l\'ID: '. $id;
                return $this->response->setJSON(['success' => true, 'error' => $message, 'id' => $customer_info['Customer_id']]);
                
            } catch (\Exception $e) {
                log_message('error', "Exception lors de la mise à jour: Message: " . $e->getMessage() .
                                    ", Code: " . $e->getCode() .
                                    ", File: " . $e->getFile() .
                                    ", Line: " . $e->getLine() .
                                    ", Trace: " . $e->getTraceAsString()
                );
                $message = 'Une erreur est survenue lors de la mise à jour.';
                return $this->response->setJSON(['success' => false, 'error' => $message]);
            }
        } else {
            $message = 'Aucune informations reçu par le serveur, paramètre du client manquant ou incorrect.';
            return $this->response->setJSON(['success' => false, 'error' => $message]);
        }
    }
    

}
