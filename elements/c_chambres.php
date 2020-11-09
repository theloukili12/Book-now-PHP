<div class="col-12">
    <div class="row gtr-uniform gtr-50 list-form hotel-item">
        <div class="col-4 col-12-mobile">
            <div class="slideshow-container">
                <div class="col-6 col-12-mobile">
                    <?php
                    $pics = array_filter(explode(',', $chambre['images']));

                    $pic = 0;
                    for ($i = 0; $i < count($pics); $i++) {

                        echo '<div class="mySlides' . ($count + 1) . '">
                                <img src="' . $pics[$i] . '" class="hotel-img item-img" style="width:100%;height:200px;">
                            </div>';
                    }

                    ?>
                </div>
                <?php
                if (count($pics) > 1) {
                ?>
                    <a class="prev" onclick="plusSlides(-1, <?php echo $count ?>)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1, <?php echo $count ?>)">&#10095;</a>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-8 col-12-mobile">
            <p><span class="hlabel">Type de chambre : </span><?php echo  $chambre['nom'] ?></p>
            <p><span class="hlabel">Description : </span><?php echo  $chambre['description'] ?></p>
            <p><span class="hlabel">Chambre disponible : </span><?php echo ($chambre['qte_total'] - $chambre['qte_reserver']) ?></p>
            <p><span class="hlabel">Prix unitaire de chambre : </span><?php echo  $chambre['prix_unitaire'] ?> DH</p>
            <div class="col-12 align-right">
                <a class="button select-chambre" data-hdistance="<?php echo $distance  ?>" data-cid="<?php echo $chambre['chambre_id'] ?>">Selectionner</a>

            </div>
        </div>
    </div>
</div>