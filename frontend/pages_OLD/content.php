<?php
include_once $root . '/frontend/modules/content/view_page.php';
include_once $root . '/frontend/modules/breadcrumb/view_breadcrumb.php';
?>


<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="bg_white">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $breadcrumb; ?>

                        <h1><?php echo $page['title']; ?></h1>

                        <div class="bl text text-top">
                            <?php echo $page['text']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="aside1">
            <?php
            # Настройки для отзывов
            # Конретно для коренных страниц сайта (лежат в service)
            switch ($url_path) {
                case '/services/transportnye-uslugi/':
                    $page_type = 'moscow';
                    $page_id = 1233;
                    $feedback_usluga = 'Транспортные услуги';
                    break;
                case '/services/perevozka-pianino/':
                    $page_type = 'moscow';
                    $page_id = 1233;
                    $feedback_usluga = 'Перевозка пианино';
                    break;
                case '/services/vyvoz-staroy-mebeli/':
                    $page_type = 'moscow';
                    $page_id = 1233;
                    $feedback_usluga = 'Вывоз мебели';
                    break;
                case '/services/kvartirnyy-pereezd/':
                    $page_type = 'moscow';
                    $page_id = 1233;
                    $feedback_usluga = 'Переезды';
                    $perevozka_sql = " AND (comment LIKE '%кварт%' OR zakazannaya_usluga LIKE '%кварт%') ";
                    break;
                case '/services/ofisnyy-pereezd/':
                    $page_type = 'moscow';
                    $page_id = 1233;
                    $feedback_usluga = 'Переезды';
                    $perevozka_sql = " AND (comment LIKE '%офис%' OR zakazannaya_usluga LIKE '%офис%') ";
                    break;
                case '/services/dachnyy-pereezd/':
                    $page_type = 'moscow';
                    $page_id = 1233;
                    $feedback_usluga = 'Переезды';
                    $perevozka_sql = " AND (comment LIKE '%дач%' OR zakazannaya_usluga LIKE '%дач%') ";
                    break;
                default:
                    $page_type = '';
                    break;
            }
            include_once($root . "/frontend/pages/blocks/left.php");
            ?>
        </div>
    </div>
</div>
