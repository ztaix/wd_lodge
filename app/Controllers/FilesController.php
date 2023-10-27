<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Files\File;

class FilesController extends Controller
{
    public function getFilePath($fileName = null)
    {
        if ($fileName === null) {
            return null; // ou vous pouvez renvoyer une chaîne d'erreur
        }
    
        $filePath = WRITEPATH . 'uploads/' . $fileName;
    
        if (file_exists($filePath)) {
            return base_url('uploads/' . $fileName);
        } else {
            return null; // ou vous pouvez renvoyer une chaîne d'erreur
        }
    }
    public function passthrough($filename)
    {
        $file_path = WRITEPATH . 'uploads/' . $filename;
        
        if (file_exists($file_path)) {
            // Obtenez l'extension du fichier
            $extension = pathinfo($file_path, PATHINFO_EXTENSION);
    
            // Tableau de correspondance entre les extensions et les types MIME
            $mime_types = [
                'jpeg' => 'image/jpeg',
                'jpg'  => 'image/jpeg',
                'png'  => 'image/png',
                'gif'  => 'image/gif',
                'bmp'  => 'image/bmp',
                'webp' => 'image/webp',
                'ico'  => 'image/x-icon',
                'tiff' => 'image/tiff',
                'tif'  => 'image/tiff',
                'svg'  => 'image/svg+xml',
                'heic' => 'image/heic',  // Format High Efficiency Image (HEIF)
                'heif' => 'image/heif',  // Format High Efficiency Image (HEIF)
            ];
            
            // Trouvez le type MIME en fonction de l'extension du fichier
            $mime_type = $mime_types[strtolower($extension)] ?? 'application/octet-stream';
    
            // Envoyer les en-têtes appropriés
            header('Content-Type: ' . $mime_type);
            header('Content-Length: ' . filesize($file_path));
    
            // Envoyer le fichier lui-même
            readfile($file_path);
            exit;
        } else {
            // Gérer l'erreur, par exemple, envoyer une image par défaut
        }
    }
    
}




