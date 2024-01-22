<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ServicesController extends BaseController
{
    private $ServiceModel;

    public function __construct()
    {
        $this->ServiceModel = new \App\Models\ServiceModel();
    }

    public function delete($service_id = null)
    {
        if ($service_id === null) {
            // Handle the error, service_id is not provided
            return; // or echo some error message
        }
        $result = $this->ServiceModel->deleteService($service_id);
        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'id' => $service_id]);
        } else {
            return $this->response->setJSON(['status' => 'fail', 'id' => $service_id]);
        }
    }

    public function upsert()
    {
        $id = $this->request->getPost('Service_id');  // Assurez-vous que le nom du champ correspond à celui de votre formulaire HTML

        /* $image = $this->uploadImage();  // Appel à la méthode d'upload
    
        if (!$image) {
            return redirect()->back()->with('error', 'Échec du téléchargement de l\'image');
        }*/

        $data = [
            'Title' => $this->request->getPost('Title'),
            'Price' => $this->request->getPost('Price'),
            //'Image_url' => $image,  // Utilisez le nom du fichier retourné par la méthode d'upload
            'Color' => $this->request->getPost('Color'),
            'Comment' => $this->request->getPost('Comment'),
            'Fee' => $this->request->getPost('Fee'),
            'fullblocked' => $this->request->getPost('fullblocked'),
        ];

        // Valider les données
        if (!$this->ServiceModel->validate($data)) {
            return redirect()->back()->with('errors', $this->ServiceModel->errors());
        }

        // Vérifiez si un enregistrement avec cet ID existe déjà
        $existingService = $this->ServiceModel->find($id);

        if ($existingService) {
            // Mise à jour de l'enregistrement existant
            $updated = $this->ServiceModel->update($id, $data);
        } else {
            // Aucun enregistrement existant avec cet ID, créons-en un nouveau
            $updated = $this->ServiceModel->save($data);
        }

        // Rediriger en fonction du résultat de l'opération
        if ($updated) {
            return redirect()->to('/services');  // Redirige vers la liste des services
        } else {
            return redirect()->back()->with('error', 'Échec de la mise à jour ou de l\'insertion');
        }
    }


    public function uploadImage()
    {
        $file = $this->request->getFile('Image_url');  // Assurez-vous que le nom du champ correspond à celui de votre formulaire HTML

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $path = WRITEPATH . 'uploads/' . $newName;
            $file->move(WRITEPATH . 'uploads/', $newName); // Remplacez par le chemin où vous souhaitez stocker les images

            return $path;  // Retournez le nom du fichier pour l'enregistrer dans la base de données
        }

        return false;
    }
}
