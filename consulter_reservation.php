<?php require "elements/doctype.php";
require "functions.php";
loadClasses();
if (isset($_POST['rid'])) {
    $rid = $_POST['rid'];
    $res = new reservation;
    $rr = $res->getReservationInfos($rid);
    $r = mysqli_fetch_assoc($rr);
    $chbre = new chambre;
    $htl = new hotel;
    $urlOrigin = getOriginURL();
} else {
    phpAlert('missing parameters');
}
?>
<html>

<head>
    <title><?php echo App_Name; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/meshotels.css" />
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
                        <div class="col-12">
                        <div class="col-12 align-right">
                                <a href="<?php echo $urlOrigin ?>" class="button special small icon solid fa-chevron-circle-left">Retour</a>
                            </div>
                            <div class="row gtr-uniform gtr-50">
                                <div class="col-12">
                                    <h3>Informations du chambre réservé :</h3>
                                    <?php
                                    $result = $chbre->getChambreinfos2($r['chambre_id']);
                                    $count = 0;

                                    $chambre = mysqli_fetch_assoc($result);
                                    $hotel = $htl->getHotelInfos($chambre['hotel_id']);
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
																				<img src="' . $pics[$i] . '" class="hotel-img" style="width:100%;height:200px;">
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
                                                                <p><span class="hlabel">Description du chambre : </span>' . $chambre['description'] . '.</p>
                                                                <p><span class="hlabel">Prix unitaire de chambre : </span>' . $chambre['prix_unitaire'] . ' DH</p>
                                                                <p><span class="hlabel">Adresse d\'hôtel : </span>' . $hotel['hotel_address'] . '</p>
															</div>
														</div>
														<input type="hidden" name="chambre_id" value="' . $chambre['chambre_id'] . '"/>
													</form>
												</div>';
                                    $count++;

                                    ?>

                                </div>
                            </div>
                            <hr>
                            <?php
                            $profil = new user;
                            $profil->getUserinfos($r['user_id']);
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
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">

                                <div class="col-12">
                                    <h3>Informations du Paiement :</h3>
                                </div>

                                <?php
                                if ($r['type_paiement'] == 1) {
                                    if ($r['paiement_details'] != "") {
                                        $pd = $res->getPaiementDetails($r['paiement_details']);
                                        $pd = mysqli_fetch_assoc($pd);
                                ?>
                                        <div class="row gtr-uniform gtr-50">
                                            <div class="col-4 col-12-mobilep">
                                                <p id="f-name"><span class="profil-label hlabel">Payeur email : </span><?php echo $pd['payer_email']; ?></p>
                                            </div>
                                            <div class="col-4 col-12-mobilep">
                                                <p id="f-name"><span class="profil-label hlabel">Payeur ID : </span><?php echo $pd['payer_id'] ?></p>
                                            </div>
                                            <div class="col-4 col-12-mobilep">
                                                <p id="f-name"><span class="profil-label hlabel">Prénom : </span><?php echo $pd['first_name']; ?></p>
                                            </div>
                                            <div class="col-4 col-12-mobilep">
                                                <p id="f-name"><span class="profil-label hlabel">Nom : </span><?php echo  $pd['last_name']; ?></p>
                                            </div>
                                            <div class="col-4 col-12-mobilep">
                                                <p id="f-name"><span class="profil-label hlabel">Date de paiement : </span><?php echo $pd['payment_date']; ?></p>
                                            </div>
                                            <div class="col-4 col-12-mobilep">
                                                <p id="f-name"><span class="profil-label hlabel">montant : </span><?php echo ($pd['montant'] * 9.86880 ) ?> DH</p>
                                            </div>
                                        </div>
                                <?php
                                    } else {
                                        echo "<h4>Paiement pas encore complet</h4>";
                                    }
                                }
                                else{
                                    echo "<h4>Pas d'information pour le paiement en espece .</h4>";
                                }
                                ?>

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
    </script>
</body>

</html>