<?php require "elements/doctype.php";

if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_role'])) {
	header("Location:index.php");
} elseif ($_SESSION['user_role'] != 2) { //si le compte n'est pas manager
	header("Location:index.php");
}
require "functions.php";
require "classes/hotel.php";

$message = '';

if (isset($_POST['add_hotel'])) {
	if (!isset($_FILES['hotel_images']))
		$message = '<h4 style="color:green;">Merci d\'ajouter des Images.</h4>';
	else
	if (!isset($_POST['hotel_lat']) || !isset($_POST['hotel_lon']))
		$message = '<h4 style="color:green;">Merci de localiser votre hôtel dans la carte</h4>';
	else {

		$hotel_name = $_POST["hotel_name"];
		$stars = $_POST["stars"];
		$hotel_desc = $_POST["hotel_desc"];
		$hotel_phone = $_POST["hotel_phone"];
		$hotel_address = $_POST["hotel_address"];
		$hotel_lat = $_POST["hotel_lat"];
		$hotel_lon = $_POST["hotel_lon"];
		$hotel_pictures = "";
		$hotel_folder = getRandomString(6);
		$img = "hotel_images";
		$structure = './images/hotels/' . $hotel_folder . '/';
		if (mkdir($structure, 0777, true)) {
			
			if ((($_FILES[$img]["type"] == "image/jpeg")
					|| ($_FILES[$img]["type"] == "image/pjpeg")
					|| ($_FILES[$img]["type"] == "image/jpg")
					|| ($_FILES[$img]["type"] == "image/png"))
				&& ($_FILES[$img]["size"] < 5000000)
				&& (strlen($_FILES[$img]["name"]) < 51)
			) {

				$file_name = $_FILES[$img]['name'];
				$file_type = pathinfo($file_name, PATHINFO_EXTENSION);

				$newfile_path = 'images/hotels/' . $hotel_folder . '/' . md5(rand()) . "." . $file_type;
				
				move_uploaded_file($_FILES[$img]['tmp_name'], $newfile_path);
				$hotel_pictures = $newfile_path;
			}
		} else {
			$message = '<h4 style="color:green;">Erreur d\'upload l\'image</h4>';
		}

		$hotel = new hotel;
		$hotel->new_hotel(
			$hotel_name,
			$hotel_desc,
			$stars,
			$hotel_phone,
			$hotel_address,
			$hotel_lat,
			$hotel_lon,
			$hotel_pictures,
			$_SESSION['user_id']
        );
        $message = '<h4 style="color:green;">Demande d\'ajout d\'hôtel a été envoyé a l\'addministration.<br>Merci de patienter.</h4>';
	}
}


?>
<html>

<head>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.dropotron.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyCY_6WJE-GGCeQmxp8BDFaL_lqZBNzJ4AE">
	</script>

	<title><?php echo App_Name; ?></title>
	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<style>
		#map {
			width: auto;
			height: 400px;
		}
	</style>
	<script>
		$(document).ready(function() {
			var uluru = {
				lat: 33.589886,
				lng: -7.603869
			};

			var myOptions = {
				zoom: 6,
				center: uluru,
				mapTypeId: 'roadmap'
			};
			// The map, centered at Uluru
			var map = new google.maps.Map(document.getElementById('map'), myOptions);
			// The marker, positioned at Uluru

			var markers = {};

			var infowindow;
			var map;
			var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
			var purple_icon = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';

			var getMarkerUniqueId = function(lat, lng) {
				return lat + '_' + lng;
			};
			var getLatLng = function(lat, lng) {
				return new google.maps.LatLng(lat, lng);
			};


			var addMarker = google.maps.event.addListener(map, 'click', function(e) {

				newmarker(e.latLng.lat(), e.latLng.lng());
			});


			function newmarker(lat, lng) {
				if (!isEmpty(markers)) {
					for (var key in markers) {
						mark = markers[key];
						removeMarker(mark, key);
					}
				}
				var geocoder = new google.maps.Geocoder;
				var infowindow = new google.maps.InfoWindow;
				var latlng = {
					lat: parseFloat(lat),
					lng: parseFloat(lng)
				};

				geocoder.geocode({
					'location': latlng
				}, function(results, status) {
					if (status === 'OK') {
						if (results[0]) {
							map.setZoom(15);
							marker = new google.maps.Marker({
								position: latlng,
								map: map,
								animation: google.maps.Animation.DROP
							});
							infowindow.setContent(results[0].formatted_address);
							$("#hotel_address").val(results[0].formatted_address)
							infowindow.open(map, marker);
							var markerId = getMarkerUniqueId(lat, lng);
							markers[markerId] = marker; // cache marker in markers object
							bindMarkerEvents(marker);
						} else {
							window.alert('No results found');
						}
					} else {
						window.alert('Geocoder failed due to: ' + status);
					}
				});
				$("#hotel_lon").val(lng);
				$("#hotel_lat").val(lat);
			}


			function showPosition(position) {
				newmarker(position.coords.latitude, position.coords.longitude);
			}

			function isEmpty(obj) {
				for (var key in obj) {
					if (obj.hasOwnProperty(key))
						return false;
				}
				return true;
			}
			var bindMarkerEvents = function(marker) {
				google.maps.event.addListener(marker, "rightclick", function(point) {
					var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
					var marker = markers[markerId]; // find marker
					removeMarker(marker, markerId); // remove it
				});
			};
			var removeMarker = function(marker, markerId) {
				marker.setMap(null); // set markers setMap to null to remove it from map
				delete markers[markerId]; // delete marker instance from markers object
			};
			$("#getlocaiton").click(function() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition);
				}

			});
		});
	</script>

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

					<!-- Text -->
					<section class="box">
						<div class="row">
							<!-- <div class="col-4 col-12-mobilep">
								<span class="image fit"><img src="images/pic07.jpg" alt=""></span>
							</div> -->
							<div class="col-12 col-12-mobilep">
								<form method="post" id="registerForm" enctype="multipart/form-data">
									<h2>Ajouter hôtel</h2>
                                    <h4><strong>N.B : </strong>Après validation du formulaire, une demande d'ajout sera envoyée à l'administration</h4>
									<?php echo $message; ?>
									<div class="row gtr-uniform gtr-50">
										<div class="col-8 col-12-mobilep">
											<label for="hotel_name">Nom d'hôtel:</label>
											<input type="text" name="hotel_name" id="hotel_name" autocomplete="off" class="form-control" required>
										</div>
										<div class="col-4 col-12-mobilep">
											<label for="stars">Etoiles :</label>
											<input type="number" name="stars" id="stars" min="1" max="5" value="1">
										</div>

										<div class="col-12">
											<label for="hotel_desc">Description dur l'hôtel :</label>
											<textarea name="hotel_desc" id="hotel_desc"></textarea>
										</div>

										<div class="col-5 col-12-mobilep">
											<label for="hotel_phone">Telephone :</label>
											<input type="text" name="hotel_phone" id="hotel_phone" autocomplete="off" class="form-control" required>
										</div>
										<div class="col-7 col-12-mobilep">
											<label for="hotel_address">Adressed d'hôtel :</label>
											<textarea name="hotel_address" id="hotel_address" placeholder="localiser votre hotel dans la carte" required></textarea>
										</div>
										<div class="col-12">
											<div class="row">
												<div class="col-6 col-12-mobilep">
													<ul class="actions">
														<li><label for="map">Marquer la localisation : </label></li>

														<li><a id="getlocaiton" class="button  solid"><i class="fas fa-map-marker-alt"></i></a></li>
													</ul>
												</div>
												<div class="col-6 col-12-mobilep">
													<ul class="actions">
														<li><label for="hotel_images">Images d'hôtel :</label></li>
														<li><input type="file" id="hotel_images" name="hotel_images" required></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="col-12">
											<div id="map" class="map"></div>
											<input type="hidden" id="hotel_lon" name="hotel_lon">
											<input type="hidden" id="hotel_lat" name="hotel_lat">
										</div>
										<div class="col-12-narrower">
											<input type="checkbox" id="check" name="check" class="form-control" required>
											<label for="check">vous acceptez nos Conditions générales, notre Politique d’utilisation des données et notre Politique d’utilisation des cookies.</label>
										</div>
										<div class="col-12">
											<ul class="actions fit">
												<li><input type="submit" name="add_hotel" value="Ajouter l'hôtel"></li>
												<li><a href="index.php" class="button alt">Annuler</a></li>
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



</body>

</html>