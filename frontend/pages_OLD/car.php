<?php
include_once $root . '/frontend/modules/cars/view_car.php';
include_once $root . '/frontend/modules/breadcrumb/view_breadcrumb.php';
?>


<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="bg_white">
                <div class="row">
                    <div class="col-md-12">

                        <?php if ($action != '') { ?>

                            <?php echo $breadcrumb; ?>

                            <h1><?php echo $page['h1']; ?></h1>

                            <div class="bl text text-top">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <?php echo $page['car_img']; ?>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <?php echo $page['description']; ?>
                                    </div>
                                </div>

                            </div>

                            <div class="bl text">
                                <h2>Тарифы на грузоперевозки и характеристики</h2>
                                <?php echo $page['features_table']; ?>
                            </div>

                            <div class="bl cars">
                                <h2>Другие автомобили</h2>
                                <div class="row bl">
                                    <?php
                                    $not_show_car_id = $page['car_id'];
                                    include_once $root . "/frontend/modules/cars/view_cars_block.php";
                                    ?>
                                </div>
                            </div>

                        <?php } else { ?>
                            <?php echo $breadcrumb; ?>

                            <h1>Автомобили для грузоперевозки в Москве и Московской области</h1>

                            <div class="bl cars">
                                <div class="row bl">
                                    <?php
                                    include_once $root . "/frontend/modules/cars/view_cars_block.php";
                                    ?>
                                </div>
                            </div>


                        <?php }; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="aside1">
            <?php
            # Настройки для отзывов
            $page_type = '';
            include_once($root . "/frontend/pages/blocks/left.php");
            ?>
        </div>
    </div>
</div>

<style>
    .left {
        text-align: center;
        width: 30%;
        border: 10px solid #fff !important;
        border-left: 0px solid #fff !important;
        background: #EBEBEB !important;

    }

    .right {
        background: #F2FDFF !important;
        border: 10px solid #fff !important;
        font-weight: 600;
        font-family: "Open Sans Bold";
    }

    .right span {
        font-family: 'Open Sans';
        font-weight: 400 !important
    }
</style>
