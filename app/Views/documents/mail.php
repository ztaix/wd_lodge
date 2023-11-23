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
	$s_qt = $data['booking_info']['Qt'];

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
<html>

<head>
	<meta charset="utf-8" />
	<title>Facture/Devis KAIPEKA LODGE PDF</title>

	<link href="css/wd_composed_style.css?" rel="stylesheet">
	<style>
		.footer_wayzdigital {
			display: flex;
			flex-direction: column;
			justify-content: flex-end;
			align-items: center;
			min-height: 100vh;
			/* Assure que le conteneur prend au moins toute la hauteur de la fenêtre */
			margin: 10px 0 0 0;
			color: #d6dbdf;
		}
	</style>
</head>

<body>
<?php 

?>
	<div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
		<a href="#">
			<img class="rounded-t-lg" style="max-width: 100px ;" src="<?=$seller[1]['Data'] ?>" alt="" />
		</a>
		<div class="p-5">
			<a href="#">
				<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?=$seller[0]['Data'] ?></h5>
			</a>
			<p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Bonjour <b><?=$data['customer_info']['Name'] ?></b>,</p>
			<p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nous vous confirmons la réservation du <?= sql_date_to_dmY($data['booking_info']['start']) ?> au <?= sql_date_to_dmY($data['booking_info']['end']) ?> (<?=$data['booking_info']['Qt'] ?> nuits).</p>
			<p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Vous avez réserver la chambre <?=$data['booking_info']['service_title'] ?> pour un total de <?=$data['booking_info']['Price'] ?> Fr</p>
			<p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nous sommes très impatient de vous accueillir !</p>
			<a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
				Statut du paiement : <?=$data['booking_info']['Paid'] ?> / <?=$data['booking_info']['Price'] ?> Fr
			</a>
			<?=$data['booking_info']['Comment']? '<p><b>Commentaire de réservation:</b> <br>'.$data['booking_info']['Comment'].'</p>':'';?>
		</div>
	</div>

	<div class="footer_wayzdigital"> wayz.digital, logiciel de gestion pour entreprise et développement personnalisé - <?= date('Y'); ?></div>
</body>

</html>