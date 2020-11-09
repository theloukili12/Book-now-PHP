<?php require "elements/doctype.php";

include "functions.php";
loadClasses();
$email = "";
$message = "";
if (isset($_SESSION['user_id'])) {
	$profil = new user;

	$profil->getUserinfos($_SESSION['user_id']);
}


if (isset($_POST['envoyer'])) {
	$email = Site_mail;
	$name = $_POST['nom'];
	$subject = $_POST["sujet"];
	$message_body = $_POST["message"];
	$header = 'From: ' . $email . '.com' . "\r\n" .
		'MIME-Version: 1.0' . "\r\n" .
		'Content-type: text/html; charset=utf-8';
	mail($email, $subject, $message_body, $header);
	$message = '<h4 style="color:green;">Votre message de contact a été bien envoyer, Merci !</h4>';
}
?>
<html>

<head>
	<title><?php echo App_Name; ?></title>
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
				<div class="row">
					<div class="col-12">

						<!-- Form -->
						<section class="box">
							<h3>Contactez-nous</h3>
							<?php echo $message;  ?>
							<form method="post" action="">
								<div class="row gtr-uniform gtr-50">
									<div class="col-6 col-12-mobilep">
                                    <input type="text" name="nom" value="<?php echo (isset($_POST['envoyer']) ? $profil->l_name . ' ' . $profil->f_name : "") ?>" placeholder="Nom complet" >
									</div>
									<div class="col-6 col-12-mobilep">
										<input type="email" name="email" value="<?php echo (isset($_POST['envoyer']) ?$profil->email : "");  ?>" placeholder="Email">
									</div>
									<div class="col-12">
										<input type="text" name="sujet" value="" placeholder="Sujet" required>
									</div>
									<div class="col-12">
										<textarea name="message" placeholder="Inserer votre message ici" rows="6" required></textarea>
									</div>
									<div class="col-12">
										<ul class="actions fit">
											<li><input type="submit" name="envoyer" value="Envoyer"></li>
										</ul>
									</div>
								</div>
							</form>
						</section>
					</div>
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