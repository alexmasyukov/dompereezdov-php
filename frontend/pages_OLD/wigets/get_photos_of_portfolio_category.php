<?php
$images_array = array();
$img_get = $db->query('
            SELECT 
                my_works.id,
                my_works.name as names_work,
                my_works_images.small_img,
                my_works_images.big_img,
                my_works_images.name as name,
                my_works_images.id,
                my_works_images.general
            FROM 
                my_works
            INNER JOIN my_works_images ON
                my_works_images.module_item_id = my_works.id
            WHERE
                my_works.category_id = ' . $gallary_category . '
            ORDER BY
                my_works_images.id,
                my_works_images.general DESC
         
                
        '); //my_works_images.general DESC
$c_p = $img_get->rowCount();
if ($c_p > 0) {
    $images_array = $img_get->fetchAll();
    $images_arr = array_chunk($images_array, 4);

    $num = 0;
    foreach ($images_arr as $group_image) {
        $num == 0 ? $active = 'active' : $active = '';
        $images_carousel_html .= '
            <div class="item ' . $active . '">
                <div class="row">';
        foreach ($group_image as $image) {
            $big = str_replace('../../..//', '/', $image['big_img']);
            $small = str_replace('../../..//', '/', $image['small_img']);
            $images_carousel_html .= '
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <a data-fancybox-group="img_gallary" class="fancybox car-img" href="' . $big . '" />
                        <img class="img-responsive" alt="' . $image['name'] . '" src="' . $small . '" /> 
                        <span class="car-name">' . $image['name'] . '</span>
                    </a>
                </div>';
        }
        $images_carousel_html .= '
                </div>
            </div>';
        $num++;
    }
    ?>


    <div id="carousel-cars" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <?php echo $images_carousel_html; ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-cars" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-cars" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>

    <?php

}

?>
