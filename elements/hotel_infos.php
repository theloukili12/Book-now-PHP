<div class="col-6 col-12-mobile col-12-mobilep">

<div class="row gtr-uniform gtr-50 list-form  hotel-item">
    <div class="col-12">
        <h3 style="text-align:center"><?php echo  $h['hotel_name']; ?></h3>
    </div>
    <div class="col-6">
        <img src="<?php echo $h['hotel_pictures'] ?>" class="hotel-img" style="width:100%;height:200px;">
    </div>
    <div class="col-6">
        <p><span class="hlabel">Adresse : </span><?php echo  $h['hotel_address']; ?></p>
        <p><span class="hlabel">Description : </span><?php echo  $h['hotel_desc']; ?></p>
        <p><span class="hlabel">Télephone : </span><?php echo  $h['hotel_phone']; ?></p>
        <p><span class="hlabel">Date d'ajout : </span><?php echo  $h['hotel_add']; ?></p>
    </div>
    <?php
    if ($h['hotel_status'] == 1) 
        echo '<div class="col-12 align-right">
            <a href="hotel_chambres.php?hid=' . $h['hotel_id'] . '" class="button special small">Chambres</a>
        </div>';
    ?>

</div>

</div>