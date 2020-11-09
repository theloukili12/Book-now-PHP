<?php
$message = '';
require "functions.php";
require "Properties.php";
if (isset($_GET['activation_code'])) {

	$conn = new mysqli(server, user , password, database);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$query = "select * from users where activation_code = '" . $_GET['activation_code'] . "'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if ($row['status'] == 0) {
				$query = "update users set Status=1 where user_id = " . $row['user_id'];
				if ($conn->query($query) === TRUE) {
					$message = 'Votre adresse e-mail a été bien vérifiée <br />Vous pouvez se connecter ici - <a href="connexion.php">Connectez-vous</a>';
				} 
			}
			else {
				$message = 'Votre adresse e-mail a déjà été vérifiée';
			}
		}
	} else {
		$message = 'Invalid Link';
	}
}
?>


<?php require "elements/doctype.php"; ?>
<html>

<head>
	<title>Verification d'email ... - <?php echo App_Name; ?></title>
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
			<header>
				<h2>Verification d'email</h2>
			</header>
			<div class="row">
				<div class="col-12">

					<section class="box">
						<?php echo "<h3>$message</h3>"; ?>
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