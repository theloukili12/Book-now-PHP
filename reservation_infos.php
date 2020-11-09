<?php require "elements/doctype.php";
require "functions.php";
loadClasses();
if (isset($_POST['cid'])) {
	$chbre = new chambre;
	$date_arriver = $_POST["date-arriver"];
	$date_depart = $_POST["date-depart"];
	$chambre_type = $_POST['chambre-type'];
	$adresse = $_POST['adresse'];
	$distance = $_POST['hdistance'];
	$lat = $_POST['coords-lat'];
	$lng = $_POST['coords-lng'];
	$chambre_type = $_POST['chambre-type'];
	if (isset($_SESSION['user_id'])) {
		$paypal_url = 'lat=' . $lat . '&lng=' . $lng . '&tp=1&adresse=' . $adresse . '&cid=' . $_POST["cid"] . '&uid=' . $_SESSION["user_id"] . '&da=' . $date_arriver . '&dt=' . $date_arriver . '';
	}

	$df = dateDiff($date_arriver, $date_depart);
	$price  = $df;


	// $datetime1 = date_create_from_format('Y-m-d',$date_arriver);
	// $datetime2 = date_create_from_format('Y-m-d',$date_depart);

	// $datediff  = $datetime2->diff($datetime1);
	// phpAlert($datediff);

	$confirmation_code = md5(rand());
	$result = $chbre->getChambreinfos2($_POST['cid']);
	$count = 0;
	$chambre = mysqli_fetch_assoc($result);
} else {
	Redirect("/");
	die;
}
?>
<html>

<head>
	<title>Mes informations personnelles - <?php echo App_Name; ?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<link rel="stylesheet" href="assets/css/meshotels.css" />
	<style>
		.paiement-forms {
			margin-top: 20px !important;

		}
	</style>
</head>

<body class="is-preload">
	<div id="page-wrapper">
		<?php include_once 'elements/top-bar-normal.php'; ?>
		<section id="main" class="container">
			<div class="row">
				<div class="col-12">
					<section class="box">
						<div class="col-12 col-12-mobilep">
							<form method="post" id="registerForm" enctype="multipart/form-data">
								<div class="col-12">

									<div class="row gtr-uniform gtr-50">
										<div class="col-12">
											<h3>Informations du réservation :</h3>
										</div>
										<div class="col-4 col-12-mobile">
											<label for="date-arriver">Date d'arriver :</label>
											<input type="date" name="date-arriver" value="<?php echo $date_arriver; ?>" class="form-control" required disabled>
										</div>
										<div class="col-4 col-12-mobile">
											<label for="date-depart">Date départ :</label>
											<input type="date" name="date-depart" value="<?php echo $date_depart; ?>" class="form-control" required disabled>
										</div>
										<div class="col-4 col-12-mobile">
											<label for="chambre-type">Type de chambre:</label>
											<select name="chambre-type" disabled>
												<?php
												$types = $chbre->getChambretypes();
												echo '<option value="tous" title="Rechercher tous les types">Tous</option>';
												while ($type = mysqli_fetch_assoc($types))
													echo '<option value="' . $type['id'] . '" title="' . $type["description"] . '" ' . ($chambre_type ==  $type['id'] ? "selected" : "") . '>' . $type['nom'] . '</option>';
												?>
											</select>
										</div>

									</div>
									<hr>
									<div class="col-12">
										<h3>Informations du chambre réservé :</h3>
										<?php

										$pics = array_filter(explode(',', $chambre['images']));
										$pic = 0;
										echo '
												<div class="col-12">
													<form method="post" action="modifier_chambre.php">
														<div class="row gtr-uniform gtr-50 list-form">
															<div class="col-4">
																<div class="slideshow-container">
																	<div class="col-6">';
										for ($i = 0; $i < count($pics); $i++) {

											echo '<div class="mySlides' . ($count + 1) . '">
																				<img  src="' . $pics[$i] . '" class="hotel-img item-img" style="width:100%;height:200px;">
																			</div>';
										}
										echo '</div>';
										if (count($pics) > 1) {
											echo '<a class="prev" onclick="plusSlides(-1, ' . $count . ')">&#10094;</a>
																			<a class="next" onclick="plusSlides(1, ' . $count . ')">&#10095;</a>';
										}
										echo '</div>
															</div>
															<div class="col-8">
																<p><span class="hlabel">Hôtel : </span>' . $chbre->getHotelname($chambre['hotel_id']) . '</p>
																<p><span class="hlabel">Type de chambre : </span>' . $chambre['nom'] . '</p>
																<p><span class="hlabel">Description : </span>' . $chambre['description'] . '.</p>
																<p><span class="hlabel">Prix unitaire de chambre : </span>' . $chambre['prix_unitaire'] . ' DH</p>
																<p><span class="hlabel">Distance : </span>' . $distance . '.</p>
															</div>
														</div>
														<input type="hidden" name="chambre_id" value="' . $chambre['chambre_id'] . '"/>
													</form>
												</div>';
										$count++;
										$price = $price *  $chambre['prix_unitaire'];

										?>

									</div>
									<hr>
									<div class="col-12">
										<h3>Informations du client :</h3>
										<?php
										if (!isset($_SESSION['user_id'])) {
										?>
											<div class="col-2 col-12-mobilep">
												<div class="login-form">
													<form method="post" action="#">
														<div class="row gtr-uniform gtr-50">
															<div class="col-12">
																<h3>Connecter-vous</h3>
															</div>
															<div class="col-4">
																<input type="email" placeholder="Email" name="email" id="email" class="form-control" value="" required>
															</div>
															<div class="col-4">
																<input type="password" placeholder="Mot de passe" name="pwd" id="pwd" class="form-control" required>
															</div>
															<div class="col-4">
																<ul class="actions fit">
																	<li><a class="button" id="Connecter">Se connecter</a></li>
																	<li><a href="inscription.php" class="button alt">Inscription</a></li>
																</ul>
															</div>
														</div>
													</form>
												</div>
											</div>
										<?php
										} else {
											$profil = new user;
											$profil->getUserinfos($_SESSION['user_id']);
											$empty = '<span class="empty-value">vide</span>';
											$f_name = ($profil->f_name == "" ? $empty :  $profil->f_name);
											$l_name = ($profil->l_name == "" ? $empty :  $profil->l_name);
											$date_birth = ($profil->date_birth == "" ? $empty :  $profil->date_birth);
											$gender = ($profil->gender == "" ? $empty : ($profil->gender == "M" ? "Masculin" : "Feminin"));
											$phone = ($profil->phone == "" ? $empty :  $profil->phone);
											$address = ($profil->address == "" ? $empty :  $profil->address);
										?>
											<div class="col-12">
												<div class="row gtr-uniform gtr-50">
													<div class="col-4 col-12-mobilep">
														<p id="f-name"><span class="profil-label hlabel">Nom : </span><?php echo $l_name; ?></p>
													</div>
													<div class="col-4 col-12-mobilep">
														<p id="f-name"><span class="profil-label hlabel">Prénom : </span><?php echo $f_name ?></p>
													</div>
													<div class="col-4 col-12-mobilep">
														<p id="f-name"><span class="profil-label hlabel">Date de naissance : </span><?php echo $date_birth; ?></p>
													</div>
													<div class="col-4 col-12-mobilep">
														<p id="f-name"><span class="profil-label hlabel">Sexe : </span><?php echo  $gender; ?></p>
													</div>
													<div class="col-4 col-12-mobilep">
														<p id="f-name"><span class="profil-label hlabel">Téléphone : </span><?php echo $phone; ?></p>
													</div>
													<div class="col-4 col-12-mobilep">
														<p id="f-name"><span class="profil-label hlabel">Adresses : </span><?php echo $address; ?></p>
													</div>
													<div class="col-12">
														<h4 title="Tu vas perdu les informations de reservation">Si vous souhaitez modifier vos informations personnelles clique <a href="modifier_profil.php">Ici</a> </h4>
													</div>

												</div>
											</div>

										<?php
										}
										?>
									</div>
									<?php
									if (isset($_SESSION['user_id'])) {
									?>
										<hr>
										<div class="col-12">
											<h3>Paiement :</h3>
											<div class="row ">
												<div class="col-4 col-12-narrower">
													<input type="radio" value="1" class="paiement-radio" id="paiement-paypal" name="paiement-mode" onchange="displaydiv(this)" checked>
													<label for="paiement-paypal">Paiement par PayPal</label>
												</div>
												<div class="col-4 col-12-narrower">
													<input type="radio" value="2" id="paiement-carte" class="paiement-radio" name="paiement-mode" onchange="displaydiv(this)">
													<label for="paiement-carte">Paiement avec carte bancaire</label>
												</div>
												<div class="col-4 col-12-narrower">
													<input type="radio" value="3" id="paiement-cash" class="paiement-radio" name="paiement-mode" onchange="displaydiv(this)">
													<label for="paiement-cash">Paiement sur place</label>
												</div>
											</div>
											<div id="paiement-forms">
												<div id="paiement-paypal-form">
													<div class="row ">
														<div class="col-8">
															<h4>Vous pouvez payer la réservation en utilisant <strong>Paypal</strong>.</h4>
															<h4>le montant a payer est : <?php echo $price   ?> DH <strong> ( <?php echo ($price * 0.10)   ?> USD) </strong>.</h4>
															<h4>Nombre de nuits : <?php echo $df;  ?>.</h4>
														</div>
														<div class="col-4 align-right">
															<form id="paypal-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
																<input type="hidden" name="cmd" value="_xclick">
																<input type="hidden" name="business" value="S2PU4Q8SPPJ56">
																<input type="hidden" name="lc" value="FR">
																<input type="hidden" name="item_name" value="<?php echo $confirmation_code; ?>">
																<input type="hidden" name="button_subtype" value="services">
																<input type="hidden" name="no_note" value="1">
																<input type="hidden" name="no_shipping" value="1">
																<input type="hidden" name="currency_code" value="USD">
																<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHosted">
																<input type="hidden" name="notify_url" value="<?php echo Full_URL; ?>/listener.php">
																<input type="hidden" name="return" value="<?php echo Full_URL; ?>/listener.php">
																<input type="hidden" name="return" value="<?php echo Full_URL; ?>/Annuler.php">
																<input type="hidden" name="amount" value="<?php echo $price * 0.10;  ?>">
																<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
																<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
															</form>

														</div>
													</div>
												</div>
												<div id="paiement-carte-form">
													<h4>Nous sommes désolés, ce service n'est pas encore disponible, vérifiez le paiement par paypal.
														En cas de problème, contactez l'administration</h4>
												</div>
												<div id="paiement-cash-form">
													<div class="row ">
														<div class="col-8">
															<h4>Cette option vous permez d'enregistrer votre reservation dans le system,
																a condition de finir le paiement avec la</h4>
														</div>
														<div class="col-4">
															<ul class="actions fit">
																<li><a class="button" id="enregistrer">Enregistrer</a></li>
																<li><a href="reserver.php" class="button alt">Annuler</a></li>
															</ul>

														</div>
													</div>

												</div>
											</div>

										</div>

									<?php
									}
									?>
								</div>
						</div>
						</form>
				</div>
		</section>
	</div>
	</div>
	</section>
	<?php include_once 'elements/footer.php'; ?>
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.dropotron.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

	<script>
		var slideIndex = [];
		var slideId = "mySlides";
		for (let index = 0; index < 1; index++) {
			slideIndex[index] = 1;
			showSlides(1, index);

		}

		function plusSlides(n, no) {
			showSlides(slideIndex[no] += n, no);
		}

		function showSlides(n, no) {
			var i;
			var selectedSlide = slideId + (no + 1);
			var x = document.getElementsByClassName(selectedSlide);
			if (n > x.length) {
				slideIndex[no] = 1
			}
			if (n < 1) {
				slideIndex[no] = x.length
			}
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";
			}
			x[slideIndex[no] - 1].style.display = "block";
		}

		function displaydiv(elem) {
			var checked = $(elem).attr('id');
			var radios = document.getElementsByClassName("paiement-radio");
			for (let index = 0; index < radios.length; index++) {
				var formid = $(radios[index]).attr('id') + "-form";
				if ($(radios[index]).attr('id') == checked) {

					$('#' + formid).show();
				} else {
					$('#' + formid).hide();
				}


			}
		}

		$(document).ready(function() {

			$("#enregistrer").click(function() {
				$.ajax({

					url: "ajouter_reservation.php",
					type: 'POST',
					data: {
						da: "<?php echo  $date_arriver ?>",
						dt: "<?php echo  $date_depart ?>",
						lat: <?php echo  $lat ?>,
						tp: document.querySelector('input[name="paiement-mode"]:checked').value,
						lng: <?php echo  $lng ?>,
						cid: <?php echo  $_POST['cid'] ?>,
						uid: <?php echo (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "nothing") ?>,
						adresse: "<?php echo $adresse  ?>",
						cc: "<?php echo $confirmation_code ?>"
					},
					success: function(msg) {
						if (msg == 'true') {
							alert("Votre reservation est bien enregistrer!!!");
							document.location.href = "/";
						} else {
							alert("error de serveur! merci de resseryer!!!");
						}
					}
				});
			});
			$('#paypal-form').click(function(event) {
				var go = false;
				event.preventDefault();
				$.ajax({

					url: "ajouter_reservation.php",
					type: 'POST',
					data: {
						da: "<?php echo  $date_arriver ?>",
						dt: "<?php echo  $date_depart ?>",
						lat: <?php echo  $lat ?>,
						tp: document.querySelector('input[name="paiement-mode"]:checked').value,
						lng: <?php echo  $lng ?>,
						cid: <?php echo  $_POST['cid'] ?>,
						uid: <?php echo (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "nothing") ?>,
						adresse: "<?php echo $adresse  ?>",
						cc: "<?php echo $confirmation_code ?>"
					},
					success: function(msg) {
						if (msg == 'true') {
							$("#paypal-form").submit();
						} else {
							alert("error de serveur! merci de resseryer!!!");
						}
					}
				});

			});
			$("#paiement-cash-form").hide();
			$("#paiement-carte-form").hide();
			$('#Connecter').click(function() {
				var email = $("#email").val();
				var pwd = $("#pwd").val();
				$.ajax({
					url: "ajax_login.php",
					type: 'POST',
					data: {
						email: email,
						pwd: pwd
					},
					success: function(message) {
						if (message == 'true')
							location.reload();
						else
							alert("mot de passe ou email incorrect");
					}
				});

			});

		});
	</script>

</body>

</html>