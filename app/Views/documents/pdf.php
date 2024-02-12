<?php			
$tax_value = 13;
$currency = '<span style="font-size:10px"> Fr</span>';
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
	$tax_bool = $seller[15]['Data'];

    $s_client_nom = $data['customer_info']['Name'];
    $s_client_telephone = $data['customer_info']['Phone'];
    $s_client_mail = $data['customer_info']['Email'];
    $s_id = $data['booking_info']['id'];
    $s_created = $data['booking_info']['Created_at'];
    $s_start = $data['booking_info']['start'];
    $s_end = $data['booking_info']['end'];

	$start_obj = new DateTime($s_start);
	$start = $start_obj->format('d/m/Y');

	$end_obj = new DateTime($s_end);
	$end = $end_obj->format('d/m/Y');

    $s_type = $data['booking_info']['Type_doc'];
    $s_QtTraveller = $data['booking_info']['QtTraveller'];
    $s_price = $data['booking_info']['Price'];
    $s_service = $data['booking_info']['service_title'];
    $s_comment = $data['booking_info']['Comment'];
    $s_fee = $data['booking_info']['Fee'];
    $s_ndays = $data['booking_info']['nDays'];
    $s_tax = $data['booking_info']['Tax'];
    $s_qt = $data['booking_info']['Qt'] == 0 ? 1: $data['booking_info']['Qt'] ;
	$count_paid =  count(explode(',',trim($data['booking_info']['paids_ids'] ?? '')));
	$types_paids = explode(',', trim($data['booking_info']['types_paids'] ?? ''));
	$paids_values = explode(',', trim($data['booking_info']['paids_values'] ?? ''));	
    $s_paid = array_sum($paids_values);
	$payments = [];
	for ($i = 0; $i < $count_paid; $i++) {$payments[] = array($types_paids[$i] => $paids_values[$i]);}



    $u_price = $s_price/$s_qt;

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
$created_date = $date->format('d/m/Y');

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


			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				font-size: 14px;
				line-height: 5px;
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
				font-size: 10px;
				line-height: 12px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: grey;
			}
            .invoice-footer td p {
                margin : 0;
                }
            .footer_wayzdigital {
			position: absolute;
			width: 100%;
            text-align: center;
			bottom: 0;
            color: #d6dbdf  ;
            }
		</style>
	</head>

	<body>
		<?php //var_dump($paids_values); 
		?>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="5">
						<table class="header">
							<tr>
								<td class="title">
									<img
										src="<?= $logo ?>"
										style="  max-width: 200px;
  max-height: 150px;
  width: auto;
  height: auto;"
									/>
								</td>

								<td>
									<p><?=$s_type?> #: <?=$s_id?></p>
                                  <p>Date: <?=$created_date?></p>
									<p>Valide jusqu'au: <?= $due_date?></p>
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
									<p><b><?= $denomination?></b></p>
									<p><b><?= $info_administrative?></b></p>
									<p><?= $adresse?></p>
                                  <p><?= $telephone?></p>
                                  <p><?= $mail?></p>
								</td>

								<td>
									<p><b><?= $s_client_nom?></b></p>
									<p><?= $s_client_telephone?></p>
                                  <p><?= $s_client_mail?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>


				<tr class="heading">
					<td>Intitulé</td>
					<td style="white-space: nowrap;">Prix unitaire</td>
					<td>Taxe</td>
					<td>Nuits</td>
					<td>Tarif</td>
				</tr>
<?php 	
			$total_tax = ($tax_bool)? ($s_QtTraveller * $s_tax * $s_ndays): 0;
			$plurial= $s_QtTraveller>1?'s':'';
			?>
				<tr class='item'>
					<td>
						<?='<b>'.$s_service.'</b> * '.$s_QtTraveller.' personne'.$plurial?>
						<br> Du <?= substr($start,0,10)?> au <?= substr($end,0,10)?>
						<?php if($s_comment){echo '<br>' . $s_comment; }?>
						<br><span style='text-align: left; color: #aeaeae ;font-size:10px'>
						(Taxe de <?=$s_tax." ".$currency?> / personne/ jour)</span>
						
					</td>
					<td style="white-space: nowrap;"><?=$u_price.$currency?></td>
					<td style="white-space: nowrap;"><?=($s_QtTraveller * $s_tax * $s_ndays) ?></td>
					<td><?=$s_qt?></td>
					<td style="white-space: nowrap;"><?=($s_price + ($s_QtTraveller * $s_tax * $s_ndays) + $s_fee).$currency?></td>
				</tr>    
				<tr class='item'>
					<td><i>Frais de ménage</i></td>
					<td style="white-space: nowrap;"><?= $s_fee . $currency?></td>
					<td style="white-space: nowrap;">-</td>
					<td>-</td>
					<td style="white-space: nowrap;"><?=$s_fee.$currency?></td>
				</tr>            
				<tr class="total" style="white-space: nowrap;">
					<?php if($tax_bool == true){
						echo "<td colspan='4'>
						<p>Taxes</p>
						<p>Total</p>
					</td>	";
					}
					else{
						echo "<td colspan='5'>";
						echo "<p>Total</p>";
						echo "</td";
					
					} ?>	
					<td>
						<p><?= $total_tax.$currency?></p>
						<p><?=($s_price + ($s_QtTraveller * $s_tax * $s_ndays) + $s_fee).$currency?></p>
					</td>
				</tr>
				<tr class="total" style="white-space: nowrap;" >
					<td colspan="2">
                        <table cellpadding="0" cellspacing="0">
                            <tr class="heading">
                                <td colspan="2">Encaissé</td>
                            </tr>
                            <tr><td colspan="2" style="text-align: left;">
							<?php
								foreach($payments as $pay_row){
								foreach($pay_row as $key => $value){
									
									if(strlen($value) !== 0){
										echo $key.':'.$value.$currency.'<br>';
									}
							}
							}
							?>	
							
							</td></tr>
        

                        </table>
					</td>
					<?php if($tax_bool == true){
						echo "<td colspan='2'><p>Payé</p></td>	";
					}
					else{
						echo "<td colspan='2'>";
						echo "<p>Payé</p>";
						echo "</td";
					
					} ?>
					<td>
					<p><?=$s_paid.$currency?></p>
					</td>
				</tr>

				
                <tr class="invoice-footer">
					<td colspan="5"><p><?php 
					if(strtolower($s_type) == "facture"){
						echo $txt_bas_facture;
						}
						else{ echo $txt_bas_devis;} ?>
						</p>
					<p><b>Banque:</b><?= $banque?></p>
					<p><b>RIB:</b><?= $rib?></p>
					<p><b>IBAN:</b><?= $iban?></p></td>
				</tr>

			</table>
		</div>
       <div class="footer_wayzdigital"> wayz.digital, logiciel de gestion pour entreprise et développement personnalisé - <?= date('Y');?></div>
	</body>
</html>