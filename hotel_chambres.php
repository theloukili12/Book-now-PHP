<?php require "elements/doctype.php";
require "functions.php";
require "classes/chambre.php";
if (!isset($_GET['hid'])) {
    header("Location:meshotels.php");
} else {
    $chambre = new chambre;
    $chambres = $chambre->GetChambres($_GET['hid']);
}
?>
<html>

<head>
    <title>Chambre d'hôtel <?php echo $chambre->getHotelname($_GET['hid']);  ?> - <?php echo App_Name; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/meshotels.css" />
</head>

<body class="is-preload">
    <div id="page-wrapper">
        <?php include_once 'elements/top-bar-normal.php'; ?>
        <section id="main" class="container">
            <header>
                <h2><?php echo $chambre->getHotelname($_GET['hid']);  ?></h2>
            </header>
            <div class="row">
                <div class="col-12">
                    <section class="box">
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-12 align-right">
                                <a href="ajouter_chambre.php?hid=<?php echo $_GET['hid']; ?>" class="button special small icon solid fa-plus">Ajouter chambre</a>
                            </div>

                            <?php
                            if ($chambres->num_rows == 0)
                                echo "<h4>Pas de chambre encore pour ce hotel</h4>";
                            else {
                                $count = 0;
                                while ($chambre = mysqli_fetch_assoc($chambres)) {
                                    
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
                                                        if(count($pics) > 1){
                                                            echo '<a class="prev" onclick="plusSlides(-1, ' . $count . ')">&#10094;</a>
                                                            <a class="next" onclick="plusSlides(1, ' . $count . ')">&#10095;</a>';
                                                        }
                                                    echo '</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <p><span class="hlabel">Type de chambre : </span>' . $chambre['nom'] . '</p>
                                                        <p><span class="hlabel">Description : </span>' . $chambre['description'] . '.</p>
                                                        <p><span class="hlabel">Nombre total de chambre : </span>' . $chambre['qte_total'] . '</p>
                                                        <p><span class="hlabel">Nombre de chambre réserver : </span>' . $chambre['qte_reserver'] . '</p>
                                                        <p><span class="hlabel">Prix unitaire de chambre : </span>' . $chambre['prix_unitaire'] . ' DH</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="col-12 col-6-mobile">
                                                            <ul class="actions fit">
                                                                <li><input type="submit" value="Modifier" class="button fit"></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-12 col-6-mobile">
                                                            <ul class="actions fit">
                                                                <li><input type="button" class="supprimer_button" name="' . $chambre['chambre_id'] . '" value="Supprimer" class="button fit"></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="chambre_id" value="' . $chambre['chambre_id'] . '"/>
                                            </form>
                                        </div>';
                                    $count++;
                                }
                            }
                            ?>

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
            $('.supprimer_button').click(function() {
                if (confirm("Voulez-vous vraiment supprimer cette chambre ?")) {
                    var hid = $(this).attr("name");
                    $.ajax({
                        url: "supprimer_chambre.php",
                        type: 'POST',
                        data: {
                            hid: hid
                        }
                    });
                    location.reload();
                }

            });

        });
    </script>

</body>

</html>