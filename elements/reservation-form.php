<?php
loadClasses();

$message = '';
$chm = new chambre;
$date_arriver = '';
$date_depart = '';
$chambre_type = '';
$adresse = '';
$lat = '';
$lng = '';
if ((isset($_POST['date-arriver']) && isset($_POST['date-depart']) &&
 isset($_POST['chambre-type']) && isset($_POST['adresse'])) || isset($_POST["consulter"])) {
    $date_arriver = $_POST["date-arriver"];
    $date_depart = $_POST["date-depart"];
    $chambre_type = $_POST['chambre-type'];
    $adresse = $_POST['adresse'];
    $lat = $_POST['coords-lat'];
    $lng = $_POST['coords-lng'];
}
?>

<div class="row">
    <div class="col-12">
        <form method="post" action="consulter.php">

            <div class="row gtr-uniform gtr-50">

                <div class="<?php echo ($rows == 1 ? "col-3" : "col-6")   ?> col-12-mobile">
                    <?php echo ($rows == 1 ? "" : '<label for="date-arriver">Date d\'arrivé :</label>'); ?>
                    <input type="date" placeholder="dd-mm-yyyy" name="date-arriver" id="date-arriver" autocomplete="off" value="<?php echo ($date_arriver == "" ? date('Y-m-d') : $date_arriver); ?>" required>
                </div>
                <div class="<?php echo ($rows == 1 ? "col-3" : "col-6")   ?> col-12-mobile">
                    <?php echo ($rows == 1 ? "" : '<label for="date-depart">Date de départ :</label>'); ?>
                    <input type="date" placeholder="dd-mm-yyyy" name="date-depart" id="date-depart" autocomplete="off" value="<?php echo ($date_depart == "" ? "" : $date_depart); ?>" required>
                </div>

                <div class="<?php echo ($rows == 1 ? "col-2" : "col-6")   ?> col-12-mobile">
                    <?php echo ($rows == 1 ? "" : '<label for="type_chambre">Type de chambre:</label>'); ?>
                    <select name="chambre-type">
                        <?php
                        $types = $chm->getChambretypes();
                        echo '<option value="tous" title="Rechercher tous les types">Tous</option>';
                        while ($type = mysqli_fetch_assoc($types))
                            echo '<option value="' . $type['id'] . '" title="' . $type["description"] . '" ' . ($chambre_type ==  $type['id'] ? "selected" : "") . '>' . $type['nom'] . '</option>';
                        ?>
                    </select>
                </div>
                <div class="<?php echo ($rows == 1 ? "col-3" : "col-6")   ?> col-12-mobile">
                    <?php echo ($rows == 1 ? "" : ' <label for="ville">Adresse :</label>'); ?>
                    <div>
                        <input type="text" id="adresse" <?php echo ($rows == 1 ? "" : 'style="float: left;width: 80%;border-top-right-radius: 0;border-bottom-right-radius: 0;"'); ?> name="adresse" value="<?php echo ($adresse == "" ? "" : $adresse); ?>" required>
                        <?php
                        if ($rows == 2) {
                        ?>
                            <a id="getlocaiton" class="button icon solid fa-map-marker-alt"></a>

                        <?php
                        }
                        ?>
                        <input type="hidden" id="coords-lng" name="coords-lng" value="<?php echo ($lng == "" ? "" : $lng); ?>">
                        <input type="hidden" id="coords-lat" name="coords-lat" value="<?php echo ($lat == "" ? "" : $lat); ?>">
                    </div>

                </div>
                <div class="<?php echo ($rows == 1 ? "col-1" : "col-12")   ?> col-12-mobile">
                    <ul class="actions fit">
                        <li><button type="submit" id="btn-consulter" class="button" style="padding:0;height: 50px;" name="consulter"><span class=" fit icon solid fa-search"></span><?php echo ($rows == 1 ? '' : 'Consulter')  ?></button></li>
                        <!-- <li><input type="button" value="" class="button alt fit icon solid fa-search" id="btn-consulter" style="padding:0" name="consulter"/></li> -->
                        <!-- <li><input type="submit" class="button icon solid fa-download" name="consulter" value="></li> -->
                        <?php echo ($rows == 1 ? '' : '<li><a href="index.php" style="height: 50px" class="button alt">Annuler</a></li>') ?>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY_6WJE-GGCeQmxp8BDFaL_lqZBNzJ4AE&libraries=places" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        if($('#coords-lng').val() == "" && $('#coords-lat').val() == "")
            $("#btn-consulter").prop('disabled', true);
        function initialize() {
            var options = {
                types: ['geocode'],
                componentRestrictions: {
                    country: "ma"
                }
            };


            var input = document.getElementById('adresse');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var adr = $("#adresse").val();
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    "address": adr
                }, function(results) {
                    $('#coords-lng').val(results[0].geometry.location.lng());
                    $('#coords-lat').val(results[0].geometry.location.lat());
                    $("#btn-consulter").prop('disabled', false);
                });
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
        var date = new Date().toISOString().split("T")[0];
        $('#date-arriver').attr("min", date);
        $('#date-depart').attr("min", $('#date-arriver').val());

        $('#date-arriver').change(function() {
            $('#date-depart').attr("min", $(this).val());
        });
        function showPosition(position) {
            var latlng = {
                lat: parseFloat(position.coords.latitude),
                lng: parseFloat(position.coords.longitude)
            };
            $('#coords-lng').val(position.coords.longitude);
            $('#coords-lat').val(position.coords.latitude);
            $("#btn-consulter").prop('disabled', false);
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'location': latlng
            }, function(results) {
                $('#adresse').val(results[0].formatted_address);
            });
        }

        $("#getlocaiton").click(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }

        });

    });
</script>