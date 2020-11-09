<?php require "elements/doctype.php";
require "functions.php";
loadClasses();

$coords = '';
if (isset($_POST['consulter'])) {
    $date_arriver = $_POST["date-arriver"];
    $date_depart = $_POST["date-depart"];
    $chambre_type = $_POST['chambre-type'];
    $adresse = $_POST['adresse'];
    $lat = $_POST['coords-lat'];
    $lng = $_POST['coords-lng'];
    $coords = '{ lat: ' . $lat . ',lng: ' . $lng . '}';
    $h = new hotel;
    $h_proches = $h->getHotelProches($lat, $lng, $chambre_type);
    asort($h_proches);
} 

?>
<html>

<head>
    <title>Consulter les hôtels - <?php echo App_Name; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyB_NQWYFt5EisGng8xVexVwsuXtB5VuT_s">
	</script> -->
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

        p {
            margin: 0 0 0.5em 0;
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 300px;
            background-color: transparent;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;

            /* Position the tooltip */
            position: absolute;
            z-index: 1;
            right:25%;
        }

        #map {
            width: auto;
            height: 300px;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
    </style>
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
                        <div class="row gtr-uniform gtr-50">
                            <div class="row">
                                <div class="col-12">
                                    <form method="post" id="hotel-list" action="consulter_chambres.php">
                                        <div class="col-12">
                                            <?php getReservation_form(1); ?>
                                        </div>
                                        <div class="row gtr-uniform gtr-50">
                                            <?php
                                            $x = 0;
                                            foreach ($h_proches as $hid => $distance) {
                                                $hotel = $h->getHotelInfos($hid);
                                                if ($distance > 3) {
                                                    $distance = $distance . " Km";
                                                } else {
                                                    $distance = ($distance * 1000) . " m";
                                                }
                                                require "elements/c_hotels.php";
                                                $x++;
                                            }
                                            ?>
                                        </div>
                                    </form>
                                </div>

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
        $(document).ready(function() {
            $('.select-hotel').click(function() {
                var hid = $(this).attr('data-hid');
                var hdistance = $(this).attr('data-hdistance');
                $('#hotel-list').append("<input type='hidden' name='hid' value='" +
                    hid + "' />");
                $('#hotel-list').append("<input type='hidden' name='hdistance' value='" +
                    hdistance + "' />");
                $('#hotel-list').submit();
            });
        });
        var uluru = {
            lat: 33.589886,
            lng: -7.603869
        };

        var myOptions = {
            zoom: 6,
            center: uluru,
            mapTypeId: 'roadmap'
        };
        var maposition = <?php echo $coords;  ?>;
        var mps = [];
        var directionsService = [];
        var directionsRenderer = [];
        var maps = document.getElementsByClassName("map");
        for (let index = 0; index < maps.length; index++) {
            directionsService[index] = new google.maps.DirectionsService();
            directionsRenderer[index] = new google.maps.DirectionsRenderer();
            mps[index] = new google.maps.Map(maps[index], myOptions);
            directionsRenderer[index].setMap(mps[index]);
            var hposition = {
                lat: Number(maps[index].getAttribute('data-lat')),
                lng: Number(maps[index].getAttribute('data-lng'))
            };
            directionsService[index].route({
                    origin: maposition,
                    destination: hposition,
                    travelMode: 'DRIVING'
                },
                function(response, status) {
                    if (status === 'OK') {
                        directionsRenderer[index].setDirections(response);
                    } else {
                        var marker = new google.maps.Marker({
                            position: maposition,
                            map: mps[index],
                            title: 'Votre position'
                        });
                        var marker1 = new google.maps.Marker({
                            position: hposition,
                            map: mps[index],
                            title: 'Hotel position'
                        });
                    }
                });
        }

        // The map, centered at Uluru




        function calculateAndDisplayRoute(directionsService, directionsRenderer, maposition, hposition) {
            directionsService.route({
                    origin: maposition,
                    destination: hposition,
                    travelMode: 'DRIVING'
                },
                function(response, status) {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(response);
                    } else {
                        var marker = new google.maps.Marker({
                            position: maposition,
                            map: map,
                            title: 'Votre position'
                        });
                        var marker1 = new google.maps.Marker({
                            position: hposition,
                            map: map,
                            title: 'Hotel position'
                        });
                    }
                });
        }
    </script>

</body>

</html>