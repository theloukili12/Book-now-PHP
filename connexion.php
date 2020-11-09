<?php
require "elements/doctype.php"; 

require "functions.php";
if(isset($_SESSION['user_id'])){
	Redirect("index.php");
}
loadClasses();

$message = '';
$txtemail = '';
if (isset($_POST['connect'])) {

	$email = $_POST['email'];
	$password = $_POST['pwd'];
	
	$user = new user;
	$user_infos = $user->user_login($email, $password);
	
	if ($user_infos == "") {
		$txtemail = $email;
		$message = '<h4 style="color:red;">Email ou mot de passe incorrect.<br>si vous avez oublié votre mot de passe, cliquez sur <U>Mot de passe oublié</U></h4>';
		
	} else
	{
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
		$_SESSION['user_id'] = explode("-",$user_infos)[0];
		$_SESSION['user_role'] = explode("-",$user_infos)[1];
        Redirect("index.php");
	}
		
		
}

?>
<html>

<head>
	<title>Connexion - <?php echo App_Name; ?></title>
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
								<form method="post" action="#">
									<div class="row gtr-uniform gtr-50">

										<h2>Connectez-vous</h2>
										<?php echo $message; ?>
										<div class="col-12">
											<label for="email">E-mail :</label>
											<input type="email" name="email" id="email" class="form-control" value="<?php echo $txtemail;?>" required>
										</div>
										<div class="col-12">
											<label for="pwd">Mot de passe :</label>
											<input type="password" name="pwd" id="pwd" class="form-control" required>
										</div>
										<div class="col-12">
											<ul class="actions fit">
												<li><input type="submit" name="connect" value="Se connecter"></li>
												<li><a href="inscription.php" class="button alt">Inscription</a></li>
											</ul>
										</div>
									</div>
								</form>
							</div>
							<div class="col-6 col-12-mobilep">
								<span class="image fit"><img src="images/pic06.jpg" alt=""></span>
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