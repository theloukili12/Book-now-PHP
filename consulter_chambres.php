<?php require "elements/doctype.php";
require "functions.php";
loadClasses();
if (!isset($_POST['hid'])) {
    Redirect("/");
    die;
} else {
    $date_arriver = $_POST["date-arriver"];
    $date_depart = $_POST["date-depart"];

    $chambre_type = $_POST['chambre-type'];
    $adresse = $_POST['adresse'];
    $lat = $_POST['coords-lat'];
    $lng = $_POST['coords-lng'];
    $distance = $_POST['hdistance'];
    $chambre_type = $_POST['chambre-type'];
    $hotel_id = $_POST['hid'];
    $chambre = new chambre;
    $chambres = $chambre->GetChambres_types($hotel_id, $chambre_type);
}
?>
<html>

<head>
    <title>Chambre d'hôtel <?php echo $chambre->getHotelname($_POST['hid']);  ?> - <?php echo App_Name; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/meshotels.css" />
    <style>
        .hotel-item {
            line-height: 17px;
            background-color: #e6e6e6;
            margin: 20px;
            padding: 20px;
            border-radius: 20px;
            -webkit-box-shadow: 6px 3px 18px -2px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 6px 3px 18px -2px rgba(0, 0, 0, 0.75);
            box-shadow: 6px 3px 18px -2px rgba(0, 0, 0, 0.75);



        }

        .item-infos {
            font-size: 11.5px;
        }
    </style>
</head>

<body class="is-preload">
    <div id="page-wrapper">
        <?php include_once 'elements/top-bar-normal.php'; ?>
        <section id="main" class="container">
            <header>
                <h2><?php echo $chambre->getHotelname($_POST['hid']);  ?></h2>
            </header>
            <div class="row">
                <div class="col-12">
                    <section class="box">
                        <div class="row gtr-uniform gtr-50">
                            <div class="row">
                                <div class="col-12">
                                    <form method="post" id="chambre-list" action="reservation_infos.php">
                                        <div class="col-12">
                                            <?php getReservation_form(1); ?>
                                        </div>
                                        <?php

                                        $count = 0;
                                        while ($chambre = mysqli_fetch_assoc($chambres)) {


                                            require "elements/c_chambres.php";
                                            $count++;
                                        }
                                        ?>
                                        <input type="hidden" name="hdistance" value="<?php echo $distance; ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
        <?php include_once 'elements/footer.php'; ?>
    </div>
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
        for (let index = 0; index < <?php echo ($chambres->num_rows) ?>; index++) {
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

        $(document).ready(function() {
            $('.select-chambre').click(function() {
                var cid = $(this).attr('data-cid');
                var hdistance = $(this).attr('data-hdistance');
                $('#chambre-list').append("<input type='hidden' name='cid' value='" +
                    cid + "' />");
                $('#chambre-list').append("<input type='hidden' name='hdistance' value='" +
                    hdistance + "' />");
                $('#chambre-list').submit();
            });
        });
    </script>

</body>

</html>