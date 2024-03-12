<?php
$tax_value = 13;

if (isset($seller[0]) && isset($data)) {
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
	$txt_bas_mail = $seller[13]['Data'];


	$s_client_nom = $data['customer_info']['Name'];
	$s_client_telephone = $data['customer_info']['Phone'];
	$s_client_mail = $data['customer_info']['Email'];
	$s_id = $data['booking_info']['id'];
	$s_img = $data['baseurl'] . 'uploads/' . $data['booking_info']['img'];
	$s_comment = $data['booking_info']['Comment'];
	$s_created = $data['booking_info']['Created_at'];
	$s_start = $data['booking_info']['start'];
	$s_end = $data['booking_info']['end'];
	$s_type = $data['booking_info']['Type_doc'];
	$s_paid = $data['booking_info']['Paid'];
	$s_qttraveller = $data['booking_info']['QtTraveller'];
	$s_tax = $data['booking_info']['Tax'];
	$s_fee = $data['booking_info']['Fee'];
	$s_ndays = $data['booking_info']['nDays'];
	$s_price = $data['booking_info']['Price'] + ($s_qttraveller * $s_tax * $s_ndays) + $s_fee;
	$s_service = $data['booking_info']['service_title'];
	$s_service_color = $data['booking_info']['service_color'];
	$s_qt = $data['booking_info']['Qt'];
	$s_update_at = $data['booking_info']['Updated_at'];


	$s_fullblocked = $data['booking_info']['fullblocked'];

	$count_paid =  count(explode(',', trim($data['booking_info']['paids_ids'])));
	$types_paids = explode(',', trim($data['booking_info']['types_paids']));
	$paids_values = explode(',', trim($data['booking_info']['paids_values']));
	$s_paid = array_sum($paids_values);
	$payments = [];
	for ($i = 0; $i < $count_paid; $i++) {
		$payments[] = array($types_paids[$i] => $paids_values[$i]);
	}

	if (
		isset($denomination) && isset($telephone) && isset($adresse) && isset($mail) &&
		isset($rib) && isset($iban) && isset($logo)
	) {
		$valid = true;
	} else {
		$valid = false;
		echo 'Informations entreprise transmise partiellement:';
		var_dump($info_entreprise);
	}

	if (
		isset($s_client_nom) || isset($s_client_telephone) || isset($s_client_mail) && isset($s_id) &&
		isset($s_date) && isset($s_type) && isset($s_paid) && isset($s_price) && isset($s_service)
	) {
		$valid = true;
	} else {
		$valid = false;
		echo 'Informations client transmise partiellement:';
		var_dump($sources);
	}
} else {
	echo 'Aucun information transmise';
}
$dateOrigine = str_replace('/', '-', $s_created);
$date = new DateTime($dateOrigine);
$date->add(new DateInterval('P1M'));
$due_date = $date->format('d/m/Y');

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Confirmation de Réservation</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			background-color: #f6f6f6;
		}

		.email-container {
			max-width: 600px;
			margin: 0 auto;
			background: #ffffff;
			padding: 20px;
			border-radius: 15px;
		}
	</style>
</head>

<body>
	<div style="max-width: 600px;margin: 0 auto; padding: 20px 0 0 20px; color:#5e5e5e; font-size: 10px;">Dernière mise à jour : <?= $s_update_at ?></div>
	<div class="email-container" style="text-align: center;">
		<!-- En-tête avec logo et image du service en colonne -->
		<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items:start;">
			<!-- Logo de l'entreprise -->
			<img src="<?= $logo ?>" alt="Logo" style="max-height: 150px; margin: 10px 0 0 10px;">

			<!-- Image du service -->
			<img src="<?= $s_img ?>" alt="Service Image" style="max-height:150px; margin: 10px 10px 0 0; border-radius: 15px;">
			<?= $s_img ?>
		</div>


		<!-- Corps de l'email -->
		<div style="padding: 20px; text-align: left;">
			<div style="display: flex; justify-content: space-between; align-items: center;">
				<h1 style="margin: 0;"><?= $denomination ?></h1>
				<span style="background-color: <?= $s_service_color ?>; padding:10px; border-radius: 10px; font-size: 1rem; font-weight: bold;"><?= $s_type ?> #<?= $s_id ?></span>
			</div>
			<?php if ($s_fullblocked !== 0) {
			?>
				<div style="width:50%; color: #78a9eb;  text-align: center; margin: 10px auto;">
					<h2>~ Privatisé ~ </h2>
				</div>
			<?php
			} ?>
			<p style="line-height: 20px; <?= $s_fullblocked !== 0 ? "padding: 10px; background-color:#e0eeff; border-radius: 10px; " : "" ?>;">
				Bonjour <b><?= $s_client_nom ?></b>,<br>
				Nous vous confirmons la réservation du <b><?= sql_date_to_dmY($s_start) ?></b> au <b><?= sql_date_to_dmY($s_end) ?></b> (<?= $s_qt ?> nuits).<br>
				Vous avez réservé: <b><?= $s_service ?></b> pour <?= $s_qttraveller ?> personne<?= $s_qttraveller > 1 ? "s" : ""; ?> = <b><?= $s_price ?> Fr</b>.<br>
				Nous sommes heureux de vous accueillir !</p>
			<p style="text-align: center; border: 1px solid #e3e3e3; color: #5e5e5e; padding: 10px; margin:0 auto; border-radius: 10px; width: 50%;">
				<b>Encaissé :</b> <?= $s_paid ?> / <?= $s_price ?> Fr
			</p>
			<?= $s_comment ? '<p><b>Commentaire de réservation:</b> <br>' . $s_comment . '</p>' : ''; ?>

			<!-- Footer -->
			<div style="margin: 20px 0 0 5px; background-color: #f6f6f6; padding: 10px; text-align: center; font-size: 12px; border-radius: 15px;">
				<?= $txt_bas_mail; ?>
			</div>
		</div>

	</div>

	<div style="text-align: center; padding: 10px 0; font-size: 12px; color: #d6dbdf;">
		wayz.digital, logiciel de gestion pour entreprise et développement personnalisé - <?= date('Y'); ?>
	</div>
</body>

</html>