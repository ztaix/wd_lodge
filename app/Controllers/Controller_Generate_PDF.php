<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;


class Controller_Generate_PDF extends BaseController
{
    public function index()
    {
        $dompdf = new Dompdf();
        $data = [
            'imageSrc'    => $this->imageToBase64(ROOTPATH . '/public/img/profile.png'),
            'name'         => 'John Doe',
            'address'      => 'USA',
            'mobileNumber' => '000000000',
            'email'        => 'john.doe@email.com'
        ];
        $html = view('View_Invoice', $data);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('resume.pdf', [ 'Attachment' => false ]);
    }
 
    private function imageToBase64($path) {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
    
}
