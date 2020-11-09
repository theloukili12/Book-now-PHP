<?php require "elements/doctype.php";
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_role'])) {
	header("Location:index.php");
} elseif ($_SESSION['user_role'] != 2) { //si le compte n'est pas manager
	header("Location:index.php");
}
require "functions.php";
require "classes/hotel.php";
if (isset($_POST["deleted-hotel"])) {
	phpAlert("azdadz");
}

$hotel = new hotel;
$hotelsI_id = $hotel->getHotelid_invalide($_SESSION['user_id']);
$hotelsV_id = $hotel->getHotelid_valide($_SESSION['user_id']);
$hotelsV = [];
$hotelsIV = [];

foreach ($hotelsV_id as $value) {
	$hotelsV[$value] = $hotel->getHotelInfos($value);
}

foreach ($hotelsI_id as $value) {
	$hotelsIV[$value] = $hotel->getHotelInfos($value);
}

?>
<html>

<head>
	<title>Mes hôtels -<?php echo App_Name; ?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
	

	<style>
     .hotel-item {
            line-height: 17px;
            background-color: #e6e6e6;
            margin: 10px !important;
            padding: 10px;
            border-radius: 20px;
            -webkit-box-shadow: 6px 3px 18px -2px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 6px 3px 18px -2px rgba(0, 0, 0, 0.75);
            box-shadow: 6px 3px 18px -2px rgba(0, 0, 0, 0.75);



        }


        .item-infos {
            font-size: 11.5px;
        }
		.mySlides {
			display: none;
		}
		p{
			margin: 0 0 0.5em 0;
		}
	</style>
</head>

<body class="is-preload">
	<div id="page-wrapper">

		<!-- Header -->
		<?php include_once 'elements/top-bar-normal.php'; ?>

		<!-- Main -->
		<section id="main" class="container">
			<!-- <header>
				<h2>Page name</h2>
				<p>Description of the page role for example</p>
			</header> -->
			<div class="row">
				<div class="col-12">
					<section class="box">
						<div class="row gtr-uniform gtr-50">
							<form method="post" name="hotels-form" id="hotels-form" action="#">
								<div class="col-12 col-12-mobilep">
									<h3 style="border-bottom: solid 1px #e5e5e5;">Hôtels Validés par l'administration</h3>
								</div>
								<div class="row">
									<?php
									
									if (count($hotelsV) > 0) {

										foreach ($hotelsV as $id => $h) {

											require "elements/hotel_infos.php";
											
											
										}
									}
									else{
										echo '<h4>Pas encore d\'hôtel ajouté.</h4>';
									}

									?>
								</div>
								<div class="col-12 col-12-mobilep">
									<h3 style="border-bottom: solid 1px #e5e5e5;">Hôtels En attente</h3>
								</div>
								<div class="row">
									<?php

									if (count($hotelsIV) > 0) {
										foreach ($hotelsIV as $id => $h) {
											require "elements/hotel_infos.php";
										}
									}
									else{
										echo '<h4>Pas encore d\'hôtel ajouté.</h4>';
									}

									?>
								</div>
								<input type="hidden" name="deletedhotel" id="deletedhotel" value="">
								<input type="submit" style="display:none" name="submit-delete" id="submit-delete" value="">
							</form>
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