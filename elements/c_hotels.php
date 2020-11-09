<div class="col-6 col-12-mobile col-12-mobile">
    <div class="row hotel-item">
        <div class="col-12">
            <h3 style="text-align:center"><?php echo $hotel['hotel_name'] ?></h3>
        </div>
        <div class="col-6">
            <img src="<?php echo  $hotel['hotel_pictures'] ?>" class="hotel-img item-img" style="width:100%;height:200px;">
        </div>
        <div class="col-6 item-infos">
            <p><span class="hlabel">Adresse : </span><?php echo $hotel['hotel_address'] ?></p>
            <p><span class="hlabel">Description : </span><?php echo $hotel['hotel_desc'] ?>.</p>
            <p><span class="hlabel">Télephone : </span><?php echo $hotel['hotel_phone'] ?></p>
            <p><span class="hlabel">Distance : </span><?php echo $distance ?></p>
            <div class="tooltip">
                <p><span class="hlabel">Route : </span><i class="fas fa-map-marked-alt"></i></p>
                <div class="tooltiptext">
                    <div id="map" class="map" data-lng="<?php echo $hotel['lng'] ?>" data-lat="<?php echo $hotel['lat'] ?>"></div>
                </div>
            </div>
            <div class="col-12 align-right">
                <a class="icon solid fa-arrow-right button select-hotel" data-hdistance="<?php echo $distance  ?>" data-hid="<?php echo $hotel['hotel_id'] ?>">Lire la suite ...</a>
            </div>
        </div>
    </div>
</div>