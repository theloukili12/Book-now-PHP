<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:index.php");
}
require "functions.php";
loadClasses();
$profil = new user;
$profil->getUserinfos($_SESSION['user_id']);
$empty = '<span class="empty-value">vide</span>';

$email = ($profil->email == "" ? $empty :  $profil->email);
$password = ($profil->password == "" ? $empty :  $profil->password);
$f_name = ($profil->f_name == "" ? $empty :  $profil->f_name);
$l_name = ($profil->l_name == "" ? $empty :  $profil->l_name);
$date_birth = ($profil->date_birth == "" ? $empty :  $profil->date_birth);
$gender = ($profil->gender == "" ? $empty :  ($profil->gender == "M" ? "Masculin" : "Feminin"));
$phone = ($profil->phone == "" ? $empty :  $profil->phone);
$address = ($profil->address == "" ? $empty :  $profil->address);
$country = ($profil->country == "" ? $empty :  $profil->country);
$picture = ($profil->picture == "" ? "images/user.png" :  $profil->picture);
$date_register = ($profil->date_register == "" ? $empty :  $profil->date_register);
require "elements/doctype.php";
?>

<html>
<head>
    <title>Profil - <?php echo App_Name; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/profilStyle.css" />
</head>

<body class="is-preload">
    <div id="page-wrapper">

        <!-- Header -->
        <?php include_once 'elements/top-bar-normal.php'; ?>

        <!-- Main -->
        <section id="main" class="container">
            <!-- <header>
                <h2></h2>
            </header> -->
            <div class="row">
                <div class="col-12">

                    <!-- Text -->
                    <section class="box">
                        <!-- <div class="container emp-profile"> -->
                        <form method="post">
                            <div class="row gtr-uniform gtr-50">
                                <div class="col-6 col-12-mobilep">
                                    <div class="profile-img">
                                        <img src="<?php echo $picture;  ?>" alt="" />
                                    </div>
                                </div>
                                <div class="col-6 col-12-mobilep center-mobile">
                                    <div class="profile-head">
                                        <h3>
                                            <?php echo $profil->l_name . " " . $profil->f_name; ?>
                                        </h3>
                                    </div>
                                    <a href="modifier_profil.php" class="button special">Modifier votre profil</a>
                                </div>
                            </div>
                            <div class="row gtr-uniform gtr-50">
                                <div class="col-12 col-12-mobilep">
                                    <h3 style="border-bottom: solid 1px #e5e5e5;">Informations personnelles</h3>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <p id="f-name"><span class="profil-label">Nom : </span><?php echo $l_name; ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <p id="f-name"><span class="profil-label">Prénom : </span><?php echo $f_name  ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <p id="f-name"><span class="profil-label">Date de naissance : </span><?php echo $date_birth; ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep" >
                                    <p id="f-name"><span class="profil-label">Sexe : </span><?php echo  $gender; ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep" >
                                    <p id="f-name"><span class="profil-label">Téléphone : </span><?php echo $phone; ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep" >
                                    <p id="f-name"><span class="profil-label">Adresses : </span><?php echo $address; ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep" >
                                    <p id="f-name"><span class="profil-label">pays : </span><?php echo  $country; ?></p>
                                </div>

                               
                            </div>
                            <div class="row gtr-uniform gtr-50">
                                <div class="col-12 col-12-mobilep">
                                    <h3 style="border-bottom: solid 1px #e5e5e5;">Informations du compte</h3>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <p id="f-name"><span class="profil-label">Email : </span><?php echo $email; ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <p id="f-name"><span class="profil-label">Date d'inscription : </span><?php echo  $date_register; ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <p id="f-name"><span class="profil-label">Mot de passes : </span>••••••••</p>
                                </div>
                               

                               
                            </div>
                        </form>
                        <!-- </div> -->

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

    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

</html>