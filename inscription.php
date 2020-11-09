<?php
require "elements/doctype.php";
$message = "";
include "functions.php";
loadClasses();




if (isset($_POST['register'])) {
	$f_name = $_POST["prenom"];
	$l_name = $_POST["nom"];
	$email = $_POST["email"];
	$password = $_POST["pwd"];
	$cpassword = $_POST["cpwd"];
	$date_register = date("d/m/Y");
	if ($password == $cpassword) {
		$new_user = new user();
		if ($new_user->new_user($email, $l_name, $f_name, $password,$date_register)) {
			if ($new_user->sendmailConfirmation())
				$message = '<h4 style="color:green;">Un email a été envoyé a votre boite email</h4>';
			else
				$message = '<h4 style="color:red;">Error, Merci de contacter l\'administration</h4>';
		} else
			$message = '<h4 style="color:red;">L\'email saisi est déjà existe.<br>Merci d\'utiliser un autre adresse email.</h4>';
	} else {
		$message = '<h4 style="color:red;">Merci de re-saisir le mot de passe</h4>';
	}
}

?>
<?php require "elements/doctype.php"; ?>
<html>

<head>
	<title>Inscrivez-vous - <?php echo App_Name; ?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload">
	<div id="page-wrapper">

		<!-- Header -->
		<?php include_once 'elements/top-bar-normal.php'; ?>

		<!-- Main -->
		<section id="main" class="container">

			<div class="row">
				<div class="col-12">

					<section class="box">
						<div class="row">
							<div class="col-6 col-12-mobilep">
								<span class="image fit"><img src="images/pic07.jpg" alt=""></span>
							</div>
							<div class="col-6 col-12-mobilep">
								<form method="post" id="registerForm" autocomplete="off">
									<h2>Inscrivez-vous</h2>
									<?php echo $message; ?>
									<div class="row gtr-uniform gtr-50">
										<div class="col-6">
											<label for="prenom">Nom :</label>
											<input type="text" name="nom" id="nom" autocomplete="off" class="form-control" required>
										</div>
										<div class="col-6">
											<label for="prenom">Prénom :</label>
											<input type="text" name="prenom" id="prenom" autocomplete="off" class="form-control" required>
										</div>
										<div class="col-12">
											<label for="email">E-mail :</label>
											<input type="email" name="email" id="email" value="" placeholder="" autocomplete="off" class="form-control" required>
										</div>
										<div class="col-12">
											<label for="pwd">Mot de passe :</label>
											<input type="password" name="pwd" id="pwd" value="" minlength="6" class="form-control pd-password-validation" required>
										</div>
										<div class="col-12">
											<label for="cpwd">Confirmer le Mot de passe :</label>
											<input type="password" name="cpwd" id="cpwd" value="" minlength="6" placeholder="" class="form-control" required>
										</div>
										<div class="col-12-narrower">
											<input type="checkbox" id="check" name="check" class="form-control" required>
											<label for="check">vous acceptez nos Conditions générales, notre Politique d’utilisation des données et notre Politique d’utilisation des cookies.</label>
										</div>
										<div class="col-12">
											<ul class="actions fit">
												<li><input type="submit" name="register" value="S'inscrire"></li>
												<li><a href="connexion.php" class="button alt">Connexion</a></li>
											</ul>
										</div>
									</div>
								</form>
							</div>
						</div>
					</section>

				</div>
			</div>
		</section>

		<!-- Footer -->
		<?php include_once 'elements/footer.php'; ?>

	</div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.dropotron.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>