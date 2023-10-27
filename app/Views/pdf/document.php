<?php
/*
array(8) { ["Customer_id"]=> string(1) "1" ["Name"]=> string(7) "Antoine" ["Email"]=> string(13)
"mail@mail.com" ["Phone"]=> string(11) "87 37 38 87" ["Comment"]=> string(9) "dddfgsefs"
["Created_at"]=> string(19) "2023-10-09 16:49:40" ["Updated_at"]=> string(19) "2023-10-23 10:13:33"
["Deleted_at"]=> NULL }

array(16) {
	["id"]=>
	string(2) "65"
	["Customer_id"]=>
	string(1) "1"
	["start"]=>
	string(19) "2023-10-19 00:00:00"
	["end"]=>
	string(19) "2023-10-20 00:00:00"
	["Service_id"]=>
	string(1) "1"
	["Price"]=>
	string(3) "100"
	["Paid"]=>
	string(2) "71"
	["Type_doc"]=>
	string(5) "Devis"
	["Pdf_url"]=>
	NULL
	["Comment"]=>
	string(0) ""
	["Created_at"]=>
	string(19) "2023-10-22 13:28:46"
	["Deleted_at"]=>
	NULL
	["updated_at"]=>
	string(19) "2023-10-23 07:23:32"
	["customer_name"]=>
	string(7) "Antoine"
	["service_title"]=>
	string(12) "Service test"
	["service_color"]=>
	string(7) "#FF5733"

	array(1) { 
	["seller"]=> array(13) { 
		[0]=> array(4) { 
			["config_id"]=> string(1) "1" 
			["Title"]=> string(19)"Nom de l'entreprise" 
			["Data"]=> string(23) "Kaipekalodgesss a12356" 
			["data_type"]=> string(5) "input" }
		[1]=> array(4) { 
			["config_id"]=> string(1) "2" 
			["Title"]=> string(4) "Logo" 
			["Data"]=> string(67)
"https://ssl.sitew.org/images/blog/articles/exemples-logos/apple.png" 
			["data_type"]=> string(5) "input" }
[2]=> array(4) { ["config_id"]=> string(1) "3" ["Title"]=> string(11) "Téléphone" ["Data"]=> string(11) "87
87 87 87" ["data_type"]=> string(5) "input" } [3]=> array(4) { ["config_id"]=> string(1) "4" ["Title"]=>
string(5) "Email" ["Data"]=> string(13) "mail@ztaix.me" ["data_type"]=> string(5) "input" } [4]=> array(4)
{ ["config_id"]=> string(1) "5" ["Title"]=> string(6) "Banque" ["Data"]=> string(0) "" ["data_type"]=>
string(5) "input" } 
[5]=> array(4) { 
	["config_id"]=> string(1) "6" 
	["Title"]=> string(3) "Rib" 
	["Data"]=>string(31) "12345 5456879879 45654646546 12" 
	["data_type"]=> string(5) "input" } 
[6]=> array(4) {
	["config_id"]=> string(1) "7" 
	["Title"]=> string(4) "IBAN" 
	["Data"]=> string(27)
"FR7630001007941234567890185" 
	["data_type"]=> string(5) "input" } 
[7]=> array(4) { ["config_id"]=>
string(1) "8" ["Title"]=> string(8) "Checkout" ["Data"]=> string(5) "11h00" ["data_type"]=> string(5) "input"
} [8]=> array(4) { ["config_id"]=> string(1) "9" ["Title"]=> string(7) "Checkin" ["Data"]=> string(5)
"13h00" ["data_type"]=> string(5) "input" } [9]=> array(4) { ["config_id"]=> string(2) "10" ["Title"]=>
string(21) "Texte en bas du devis" ["Data"]=> string(0) "" ["data_type"]=> string(8) "textarea" } [10]=>
array(4) { ["config_id"]=> string(2) "11" ["Title"]=> string(23) "Texte en bas de facture" ["Data"]=>
string(0) "" ["data_type"]=> string(8) "textarea" } [11]=> array(4) { ["config_id"]=> string(2) "12"
["Title"]=> string(28) "Texte de présentation email" ["Data"]=> string(0) "" ["data_type"]=> string(8)
"textarea" } [12]=> array(4) { ["config_id"]=> string(2) "13" ["Title"]=> string(21) "Règles de réduction"
["Data"]=> string(19) "2:10% 3:15% 5:20%" ["data_type"]=> string(8) "textarea" } } }
*/

/*

$sources = [
	"Client" 	=>	["Nom" =>"john Doe", "Téléphone" => "87 70 70 70", "Mail" => "mail@ztaix.me"],
	"ID" 		=>	"POS 12344",
	"Date" 		=>	"14/12/2023",
	"Type" 		=>	"Devis",
	"Paiements" 		=>	
		[ 
		"23/02/2023"	=> ["credit_card", 100],
 		"24/02/2023"	=> ["credit_card", 150],
 		"25/02/2023"	=> ["cheque", 200],
		"24/02/2023"	=> ["espece", 1000]
        ],
	"items"		=> 
		[
			[
			"id" =>"123",
			"item_name"	=>	"Bose",
			"qt"	=>	2,
			"up"	=>	120,
			"tva"	=>	13,
			"description"	=>	"audio trop top",
			],
			[
			"id" =>"4568",
			"item_name"	=>	"Micro",
			"qt"	=>	1,
			"up"	=>	1200,
			"tva"	=>	16,
			"description"	=>	"Micro de top qualité",
			],
		]
	];
	
	
	array(16) { [0]=> array(4) { 
		["config_id"]=> string(1) "1" 
		["Title"]=> string(19) "Nom de l'entreprise" 
		["Data"]=> string(23) "Kaipekalodgesss a12356" 
		["data_type"]=> string(5) "input" } 
	*/

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
/*
function table_sum_pay($sources)
{
  $sum = 0;
  foreach($sources as $key => $data){
  	
  }
    return $sum;
}

function table_items($sources)
{
	if(is_array($sources) and !empty($sources)){
		foreach($sources as $item){
			$item_name = $item['item_name'];
			$price = $item['up'];
			$qt = $item['qt'];
			$tax = round(((100*$item['up'])/(100+$item['tva']))*($item['tva']/100));
			$total = $item['up']*$item['qt'];
			
			echo "<tr class='item'><td>$item_name</td><td>$price</td><td>$qt</td><td>$tax</td><td>$total</td></tr>";
		}
	}
}
*/
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
            justify-content: center;
            margin: 10px 0 0 0;
            color: #d6dbdf  ;
            }
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="5">
						<table class="header">
							<tr>
								<td class="title">
									<img
										src="https://sparksuite.github.io/simple-html-invoice-template/images/logo.png"
										style="width: 100%; max-width: 300px"
									/>
								</td>

								<td>
									<p><?=$s_type?> #: <?=$s_id?></p>
                                  <p>Date: <?=$s_created?></p>
									<p>Validité du document jusqu'au: <?= $due_date?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="5">
						<table>
							<tr>
								<td>
									<p><?= $denomination?></p>
									<p><?= $adresse?></p>
                                  <p><?= $telephone?></p>
                                  <p><?= $mail?></p>
								</td>

								<td>
									<p><?= $s_client_nom?></p>
									<p><?= $s_client_telephone?></p>
                                  <p><?= $s_client_mail?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>


				<tr class="heading">
					<td>Item</td>
					<td>Prix unitaire</td>
					<td>Qt</td>
					<td>Taxe</td>
					<td>Tarif</td>
				</tr>
<?php 		$tax_bool = $seller[15]['Data'];
			$tax_value = 13;
			$tax = ($tax_bool)? round(((100*$s_price)/(100+$tax_value))*($tax_value/100)): 0;
			$total = $s_price*$s_qt;
			?>
				<tr class='item'><td><?=$s_service?></td><td><?=$s_price?></td><td><?=$s_qt?></td><td><?=$tax?></td><td><?=$total?> Fr</td></tr>            
				<tr class="total">
					<?php if($tax_bool == true){
						echo "<td colspan='4'>
						<p>Taxes $tax_value% </p>
						<p>Total</p>
					</td>	";
					}
					else{
						echo "<td colspan='4'>";
						echo "<p>Total</p>";
						echo "</td";
					
					} ?>	
					<td>
						<p><?= $tax?></p>
						<p><?=$total?></p>
					</td>
				</tr>
		
				<tr >
					<td colspan="2">
                        <table cellpadding="0" cellspacing="0">
                            <tr class="heading">
                                <td> Payment Method</td>
                                <td >Check #</td>
                            </tr>
                            <tr><td>Mode paiment</td><td ><?=$s_paid?> Fr</span>
        

                        </table>
                   

				
                <tr class="invoice-footer">
					<td colspan="5"><p>Politque de retour</p></td>
				</tr>

			</table>
		</div>
       <div class="footer_wayzdigital"> wayz.digital, logiciel de gestion pour entreprise et développement personnalisé - <?= date('Y');?></div>
	</body>
</html>