<?php require "elements/doctype.php";
require "functions.php";
loadClasses();
$message = '';
$chambre = new chambre;

if (isset($_POST['ajouter_chambre'])) {
	if (!isset($_FILES['chambre_images']))
		$message = '<h4 style="color:red;">Merci d\'ajouter des Images.</h4>';
	else {

		$chambre_type = $_POST['hotel_type'];
		$chambre_desc = $_POST['chambre_desc'];
		$chambre_Qte = $_POST['chambre_Qte'];
		$chambre_prix = $_POST['chambre_prix'];
		$chambre_folder = getRandomString(6);
		$chambre_images = "";
		$OK = false;

		$img = "chambre_images";
		$structure = './images/chambres/' . $chambre_folder . '/';
		if (mkdir($structure, 0777, true)) {

			for ($i = 0; $i < count($_FILES[$img]["name"]); $i++) {
				if ((($_FILES[$img]["type"][$i] == "image/jpeg")
						|| ($_FILES[$img]["type"][$i] == "image/pjpeg")
						|| ($_FILES[$img]["type"][$i] == "image/jpg")
						|| ($_FILES[$img]["type"][$i] == "image/png"))
					&& ($_FILES[$img]["size"][$i] < 5000000)
					&& (strlen($_FILES[$img]["name"][$i]) < 51)
				) {
					$file_name = $_FILES[$img]['name'][$i];
					$file_type = pathinfo($file_name, PATHINFO_EXTENSION);

					$newfile_path = 'images/chambres/' . $chambre_folder . '/' . md5(rand()) . "." . $file_type;
					move_uploaded_file($_FILES[$img]['tmp_name'][$i], $newfile_path);
					$chambre_images .= $newfile_path . ",";
					$OK = true;
				} else {
					$message = '<h4 style="color:red;">La taille du fichier ne doit pas dépasser <strong>5Mb</strong>.<br> ou le type de fichier est incompatible
        			</h4>';
					$OK = false;
				}
			}
			if ($OK) {
                $message = '<h4 style="color:green;">Votre chambre a été bien ajouter.</h4>';
				$chambre->ajouterChambre($_GET['hid'], $chambre_type, $chambre_Qte, 0, $chambre_desc, $chambre_images, $chambre_prix);
				
			}
		}
	}
}
?>
<html>

<head>
	<title>Ajouter une chambre - <?php echo App_Name; ?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
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
								<h2>Ajouter chambre</h2>
								<?php echo $message; ?>
								<div class="row gtr-uniform gtr-50">
									<div class="col-8 col-12-mobilep">
										<label for="type_chambre">Type de chambre:</label>
										<!-- <input type="text" name="type_chambre" autocomplete="off" class="form-control" placeholder="Chambre régulière, Chambre familiale" required> -->
										<select name="hotel_type">
											<?php
											$types = $chambre->getChambretypes();
											while ($type = mysqli_fetch_assoc($types))
												echo '<option value="' . $type['id'] . '" title="' . $type["description"] . '">' . $type['nom'] . '</option>';

											?>
										</select>
									</div>
									
									<div class="col-4 col-12-mobilep">
										<label for="chambre_prix">Prix unitaire (DH):</label>
										<input type="number" name="chambre_prix" id="chambre_prix" min="0.01" step="0.01" value="100.00">
									</div>

									<div class="col-12">
										<label for="chambre_desc">Description du chambre :</label>
										<textarea name="chambre_desc" id="chambre_desc" placeholder="Les équipements, la taille du chamber, etc..."></textarea>
									</div>

									<div class="col-6 col-12-mobilep">
										<label for="chambre_Qte">Nombre de chambre :</label>
										<input type="number" name="chambre_Qte" id="chambre_Qte" min="1" value="1">
									</div>
									<div class="col-6 col-12-mobilep">
										<label for="chambre_images">Images du chambre :</label>
										<input type="file" id="chambre_images" name="chambre_images[]" multiple required>
									</div>
									<div class="col-12-narrower">
										<input type="checkbox" id="check" name="check" class="form-control" required>
										<label for="check">vous acceptez nos Conditions générales, notre Politique d’utilisation des données et notre Politique d’utilisation des cookies.</label>
									</div>
									<div class="col-12">
										<ul class="actions fit">
											<li><input type="submit" name="ajouter_chambre" value="Ajouter chambre"></li>
											<li><a href="meshotels.php" class="button alt">Annuler</a></li>
										</ul>
									</div>
								</div>
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