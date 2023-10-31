<?php			
$tax_value = 13;

if(isset($seller[0]) && isset($data)){
	$seller = $seller[0];
    $denomination = $seller[0]['Data'];
    $logo = $seller[1]['Data'];
    $telephone = $seller[2]['Data'];
    $mail = $seller[3]['Data'];
    $adresse = $seller[4]['Data'];
    $info_administrative = $seller[5]['Data'];
    $banque = $seller[6]['Data'];
    $rib = $seller[7]['Data'];
    $iban = $seller[8]['Data'];
    $checkin = $seller[9]['Data'];
    $checkout = $seller[10]['Data'];
    $txt_bas_devis = $seller[11]['Data'];
    $txt_bas_facture = $seller[12]['Data'];


    $s_client_nom = $data['customer_info']['Name'];
    $s_client_telephone = $data['customer_info']['Phone'];
    $s_client_mail = $data['customer_info']['Email'];
    $s_id = $data['booking_info']['id'];
    $s_created = $data['booking_info']['Created_at'];
    $s_start = $data['booking_info']['start'];
    $s_end = $data['booking_info']['end'];
    $s_type = $data['booking_info']['Type_doc'];
    $s_paid = $data['booking_info']['Paid'];
    $s_price = $data['booking_info']['Price'];
    $s_service = $data['booking_info']['service_title'];
    $s_qt = $data['booking_info']['qt'];

    if(isset($denomination) && isset($telephone) && isset($adresse) && isset($mail) &&
    isset($rib) && isset($iban) && isset($logo)){
        $valid = true;
    }
    else {
        $valid = false;
        echo 'Informations entreprise transmise partiellement:';
        var_dump($info_entreprise);
    }
    
    if(isset($s_client_nom) || isset($s_client_telephone) || isset($s_client_mail) && isset($s_id) &&
    isset($s_date) && isset($s_type) && isset($s_paid) && isset($s_price) && isset($s_service)){
        $valid = true;
    }
    else {
        $valid = false;
        echo 'Informations client transmise partiellement:';
        var_dump($sources);
    }
}
else{
    echo 'Aucun information transmise';
}
$dateOrigine = str_replace('/', '-', $s_created);
$date = new DateTime($dateOrigine);
$date->add(new DateInterval('P1M'));
$due_date = $date->format('d/m/Y');

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Facture/Devis KAIPEKA LODGE PDF</title>


		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
                line-height: 0.8;
			}
            .invoice-box table .header p{
                margin: 0;
            }
            .invoice-box table .header p:first-child{
                font-weight: bold;
            }

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
				text-align:right;
			}		
			.invoice-box table tr.heading td:first-child {
				text-align:left;
			}
			invoice-box table tr.payments td:last-child{
          		text-align:right;

          }
          
			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}	
			.invoice-box table tr.item td:first-child {
				text-align:left;
			}
			.invoice-box table tr.item td {
				text-align:right;
			}
			

			.invoice-box table tr.item:last-child {
				border-bottom: none;
			}


			.invoice-box table tr.total td{
				border-top: 2px solid #eee;
				text-align: right;

			}			
			.invoice-box table tr.total td p{
				padding: 0;
				margin: 0;
			}
			.invoice-box table tr.total td p:last-child{
				font-weight: bold;
			}			


			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
            .invoice-footer td {
				width: 100%;
				border: 1px solid #eee;
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: grey;
			}
            .invoice-footer td p {
                margin : 0;
                }
            .footer_wayzdigital {
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                align-items: center;
                min-height: 100vh; /* Assure que le conteneur prend au moins toute la hauteur de la fenêtre */
                margin: 10px 0 0 0;
                color: #d6dbdf  ;
            }
		</style>
	</head>

	<body>
		<div class="invoice-box">

        </div>	
       <div class="footer_wayzdigital"> wayz.digital, logiciel de gestion pour entreprise et développement personnalisé - <?= date('Y');?></div>
	</body>
</html>