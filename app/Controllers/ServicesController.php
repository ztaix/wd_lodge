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

    public function update()
    {
    
        $id = $this->request->getPost('Service_id');  // Assurez-vous que le nom du champ correspond à celui de votre formulaire HTML
    
        $image = $this->uploadImage();  // Appel à la méthode d'upload
    
        if (!$image) {
            return redirect()->back()->with('error', 'Échec du téléchargement de l\'image');
        }
    
        $data = [
            'Title' => $this->request->getPost('Title'),
            'Price' => $this->request->getPost('Price'),
            'Image_url' => $image,  // Utilisez le nom du fichier retourné par la méthode d'upload
            'Color' => $this->request->getPost('Color'),
            'Comment' => $this->request->getPost('Comment'),
        ];
    
        // Valider les données
        if (!$this->ServiceModel->validate($data)) {
            return redirect()->back()->with('errors', $this->ServiceModel->errors());
        }
    
        // Effectuer la mise à jour
        $updated = $this->ServiceModel->updateService($id, $data);
    
        if ($updated) {
            return redirect()->to('/services');  // Remplacez par la route de votre choix
        } else {
            return redirect()->back()->with('error', 'Échec de la mise à jour');
        }
    }
    

public function uploadImage()
{
    $file = $this->request->getFile('Image_url');  // Assurez-vous que le nom du champ correspond à celui de votre formulaire HTML

    if ($file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $path = WRITEPATH . 'uploads/'.$newName;
        $file->move(WRITEPATH . 'uploads/', $newName); // Remplacez par le chemin où vous souhaitez stocker les images

        return $path;  // Retournez le nom du fichier pour l'enregistrer dans la base de données
    }

    return false;
}

}
