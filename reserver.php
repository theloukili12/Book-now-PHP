<?php require "elements/doctype.php";
require "functions.php";

?>
<html>

<head>
	<title>Reservation - <?php echo App_Name; ?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

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
						
						<?php
							getReservation_form(2);
						?>	
						
						
					</section>
				</div>
			</div>
		</section>

		<!-- Footer -->
		<?php include_once 'elements/footer.php'; ?>

	</div>

	<!-- Scripts -->
	
	<script src="assets/js/jquery.dropotron.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>
	
</body>

</html>