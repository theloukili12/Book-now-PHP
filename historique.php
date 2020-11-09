<?php require "elements/doctype.php";
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_role'])) {
    header("Location:index.php");
}
require "functions.php";
loadClasses();

$resr = new reservation;
$results = $resr->getUser_historique($_SESSION['user_id']);
$columns = $resr->db->getColumnArray($results);
$reservations_active = array();
$reservations_inactive = array();

while ($r = mysqli_fetch_assoc($results)) {

    $r['Mode de paiement'] = ($r['Mode de paiement'] == 1 ? "Paypal" : "Cash");
    $r["Paiement status"] = ($r["Paiement status"] == 1 ? "bien payé" : "non payé");
    if ((strtotime(date("Y-m-d")) < strtotime($r["Date d'arriver"]))) {
        array_push($reservations_active, $r);
    } else {
        array_push($reservations_inactive, $r);
    }
}

?>
<html>

<head>
    <title>Reservations d'hôtels<?php echo App_Name; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/meshotels.css" />
</head>

<body class="is-preload">
    <div id="page-wrapper">

        <?php include_once 'elements/top-bar-normal.php'; ?>
        <section id="main" class="container">
            <div class="row">
                <div class="col-12">
                    <section class="box">
                        <form method="post" id="reservation-list" action="consulter_reservation.php">
                            <div class="col-12">
                                <h3>Liste des reservations :</h3>
                            </div>
                            <div class="col-12">
                                <?php
                                showReservation_table($reservations_active, $columns);
                                ?>
                            </div>
                            <div class="col-12">
                                <h3>Liste des reservations expirées :</h3>
                            </div>
                            <div class="col-12">
                                <?php
                                showReservation_table($reservations_inactive, $columns);
                                ?>
                            </div>
                        </form>

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
    <script src="assets/js/main.js"></script>7
    <script>
        $(document).ready(function() {
            $('.select-reservation').click(function() {
                var rid = $(this).attr('data-rid');
                $('#reservation-list').append("<input type='hidden' name='rid' value='" +
                    rid + "' />");
                    
                $('#reservation-list').submit();
            });
        });
    </script>
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