<?php
function get_texts($id, $table) {
    global $db;
    $sql = "SELECT top_text, bottom_text FROM $table WHERE page_id=$id";
    $smf = $db->query($sql);
    if ($smf->rowCount() > 0) {
        $array = $smf->fetchAll(PDO::FETCH_OBJ);
        foreach ($array as $page) {
            $page_text['top_text'] = $page->top_text;
            $page_text['bottom_text'] = $page->bottom_text;
        }
    }
    return $page_text;
}


function get_list($page_id, $type_list) {
    global $db, $name_p_pr;
    # $name_p_pr из файла read_url_of_catalog_category.php
    $all_uslugi = '';
    if ($type_list == 'uslugi') {
        $order_by = 'id';
    } else {
        $order_by = 'type, name';
    };
    $sql = "
        SELECT 
            name,
            cpu_path
        FROM 
            pages 
        WHERE 
            parent_id = $page_id
            AND public = 1
        ORDER BY
            $order_by
    ";
    $smf = $db->query($sql);
    if ($smf->rowCount() > 0) {
        foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
            switch ($type_list) {
                case 'towns':
                    {
                        $usluga = mb_ucfirst(str_replace([' ', ' '], ' ', $value['name']));
                        $all_uslugi .= '<li><a href="' . $value['cpu_path'] . '" alt="">' . $usluga . '</a></li>';
                        break;
                    }
                case 'uslugi':
                    {
                        $usluga = mb_ucfirst(str_replace([' ', ' '], ' ', $value['name'])) . ' в ' . $name_p_pr;
                        if (strpos($value['name'], 'Требуются водители') !== false) {
                            $usluga = mb_ucfirst('Вакансия: водитель') . ' в ' . $name_p_pr;
                        }
                        if (strpos($value['name'], ' Требуются грузчики') !== false) {
                            $usluga = mb_ucfirst('Вакансия: грузчик') . ' в ' . $name_p_pr;
                        }
                        $all_uslugi .= '<li><h3><a href="' . $value['cpu_path'] . '" alt="">' . $usluga . '</a></h3></li>';
                        break;
                    }
            }
        }
    }
    if ($all_uslugi != '') {
        return '<ul class="uslugi-ul">' . $all_uslugi . '</ul>';
    } else {
        return '';
    }
}


//function similar_uslugi() {
//    global $db, $name_p_pr, $page_parent_id, $page_parent_name_p_pr, $url_path;
//    # $name_p_pr из файла read_url_of_catalog_category.php
//    $all_uslugi = '';
//    $sql = "
//    SELECT
//        name,
//        cpu_path
//    FROM
//        pages
//    WHERE
//        parent_id = $page_parent_id
//        AND public = 1
//    ";
//    $smf = $db->query($sql);
//    if ($smf->rowCount() > 0) {
//        foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
//            # Если это не текущая страница и не вакансия - то добавляем в список
//            if ($url_path != $value['cpu_path'] && strpos($value['name'], 'Требуются') === false) {
//                $usluga = mb_ucfirst(str_replace([' ', ' '], ' ', $value['name'])) . ' в ' . $page_parent_name_p_pr;
//                $all_uslugi .= '<li><a href="' . $value['cpu_path'] . '" alt="">' . $usluga . '</a></li>';
//            }
//        }
//    }
//    if ($all_uslugi != '') {
//        return '<ul class="uslugi-ul">' . $all_uslugi . '</ul>';
//    } else {
//        return '';
//    }
//}


$texts = get_texts($page_id, 'pages_texts'); // ОК
$top_text = trim(html_entity_decode(htmlspecialchars_decode($texts['top_text']), ENT_QUOTES, 'UTF-8'));
$bottom_text = trim(html_entity_decode(htmlspecialchars_decode($texts['bottom_text']), ENT_QUOTES, 'UTF-8'));
$page_type = '';
$gallary_category = 98; // Недороние транспортные услуги ПО УМОЛЧАНИЮ
$show_map = true;
$show_gallary = 'true';


# на текущую страинцу переходят РАЙОНЫ и ОБЛАСТИ
# Поэтому - на района и областях выводим СПИСОК НАСЕЛЕННЫХ ПУНКТОВ - ТОЛЬКО ПРЯМЫЕ ПОТОМКИ
# На всех остальных только список услуг
//echo $page_name;
if (strpos($page_name, 'район') !== false ||
    strpos($page_name, 'область') !== false
) {
    $uslugi = get_list($page_id, 'towns');
    $page_type = 'connecting'; # Связующая страница
} else {
    $uslugi = get_list($page_id, 'uslugi');
    $page_type = 'connecting'; # Связующая страница
}


# Если текущая страница является одной из '       грузоперевозки' и т.д. (то есть дочерней от города
# соответственно и имя у нее будет непонятное, меняем его на имя родителя
if (strpos($name_p_da, '     ') !== false || $name_p_da == '') {
    $name_p_da = $page_parent_name_p_pr;
}


# Определяем тип страницы путем проверки последнего элемента в ссылке
switch ($uri_parts[count($uri_parts) - 1]) {
    case 'gruzoperevozki':
        $page_type = 'usluga';
        $feedback_usluga = 'Грузоперевозки';
        $gallary_category = 91; # Галерея машин из автопарка
        $similar_uslugi = similar_uslugi();
        $title_gallary = '<h2>Фото машин из нашего парка</h2>';
        $title_map = "<h3>Расчет стоимости перевозки в $name_p_da</h3>";
        break;
    case 'vyvoz-mebeli':
        $page_type = 'usluga';
        $feedback_usluga = 'Вывоз мебели';
        $gallary_category = 92;
        $similar_uslugi = similar_uslugi();
        $title_gallary = '<h2>Фото вывоза мебели</h2>';
        $show_map = false;
        break;
    case 'pereezd':
        $page_type = 'usluga';
        $feedback_usluga = 'Переезды';
        $gallary_category = 96;
        $similar_uslugi = similar_uslugi();
        $title_gallary = '<h2>Фото машин из нашего парка</h2>';
        $title_map = "<h3>Расчет стоимости переезда в $name_p_da</h3>";
        break;
    case 'perevozka-pianino':
        $feedback_usluga = 'Перевозка пианино';
        $page_type = 'usluga';
        $gallary_category = 93;
        $similar_uslugi = similar_uslugi();
        $title_gallary = '<h2>Фото перевозки пианино</h2>';
        $title_map = "<h3>Расчет стоимости перевозки пианино в $name_p_da</h3>";
        $show_gallary = 'false';
        break;
    case 'rabota-voditelem':
        $page_type = 'rabota';
        $similar_uslugi = similar_uslugi();
        break;
    case 'rabota-gruzchikom':
        $page_type = 'rabota';
        $similar_uslugi = similar_uslugi();
        break;
    default:
        $title_gallary = '<h2>Фото машин из нашего парка</h2>';
        $title_map = "<h3>Расчет стоимости перевозки по $name_p_da</h3>";
        $gallary_category = 98;
        $show_map = true;
        $feedback_usluga = 'Транспортные услуги';
        break;
}


//                        $text = str_replace('в пределах #где#', 'в пределах ' . $category_name_p_ro_with_type, $text);


?>


<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($page_type == 'usluga') {
                        echo '<nav class="breadcrumb">
                                <a href="http://' . $server . '/">Главная</a>';
                        unset($breadcrumb_text[count($breadcrumb_text) - 1]);
                        unset($breadcrumb_links[count($breadcrumb_links) - 1]);
                        echo '<a href="' . $breadcrumb_links[count($breadcrumb_links) - 1] . '">' . implode(', ', $breadcrumb_text) . '</a>';
                        echo ' » ' . $h1;
                        echo '</nav>';
                    } else {
                        if ($page_type == 'rabota') {
                            echo '<nav class="breadcrumb">
                                        <a href="http://' . $server . '/">Главная</a>';
                            unset($breadcrumb_text[count($breadcrumb_text) - 1]);
                            unset($breadcrumb_links[count($breadcrumb_links) - 1]);
                            echo '<a href="' . $breadcrumb_links[count($breadcrumb_links) - 1] . '">' . implode(', ', $breadcrumb_text) . '</a>';
                            echo ' » ' . $h1;
                            echo '</nav>';
                        } else {
                            echo '<nav class="breadcrumb">
                                <a href="http://' . $server . '/">Главная</a>';
                            unset($mini_breadcumb[count($mini_breadcumb) - 1]);
                            foreach ($mini_breadcumb as $location) {
                                echo $location;
                            }
                            echo ' » ' . $h1;
                            echo '</nav>';
                        }
                    }
                    ?>

                    <h1><?php echo $h1; ?></h1>

                    <div class="bl text text-top">
                        <?php

                        if (!function_exists("mb_str_replace")) {
                            function mb_str_replace($needle, $replace_text, $haystack) {
                                return implode($replace_text, mb_split($needle, $haystack));
                            }
                        }


                        $top_text = mb_str_replace('сотни отзывов реальных клиентов', '<a href="/otzyvy">сотни отзывов реальных клиентов</a>', $top_text);
                        //                        $top_text = mb_str_replace('cотни отзывов<br/> реальных клиентов', '<a href="/otzyvy">cотни отзывов<br/> реальных клиентов</a>', $top_text);
                        $top_text = mb_str_replace('сотни отзывов реальных заказчиков', '<a href="/otzyvy">сотни отзывов реальных заказчиков</a>', $top_text);
                        $top_text = mb_str_replace('рассказали в отзывах', '<a href="/otzyvy">рассказали в отзывах</a>', $top_text);
                        $top_text = mb_str_replace('многочисленными отзывами', '<a href="/otzyvy">многочисленными отзывами</a>', $top_text);

                        echo $top_text; ?>
                    </div>

                    <div class="bl uslugi-list">
                        <?php echo $uslugi; ?>
                    </div>

                    <?php if ($page_type == 'usluga') { ?>
                        <div class="bl cars">
                            <h2>Цены на грузоперевозки</h2>
                            <div class="row bl">
                                <?php
                                include_once $root . "/frontend/modules/cars/view_cars_block.php";
                                ?>
                            </div>
                        </div>
                        <div class="bl gallary">
                            <?php
                            if ($show_gallary != 'false') {
                                echo $title_gallary;
                                $count_of_block_portfolio = 100;
                                require($root . "/frontend/pages/wigets/get_photos_of_portfolio_category.php");
                                echo $product_images_html;
                            }
                            ?>
                        </div>

                        <div class="bl similar-uslugi pohojie_uslugi">
                            <h3>Похожие услуги</h3>
                            <?php echo $similar_uslugi; ?>
                        </div>

                        <div class="bl text text-bottom">
                            <?php echo $bottom_text; ?>
                        </div>

                        <div class="bl mini-breadcumb">
                            <?php
                            unset($mini_breadcumb[count($mini_breadcumb) - 1]);
                            foreach ($mini_breadcumb as $location) {
                                echo $location;
                            }
                            ?>
                        </div>

                        <?php
                        if ($show_map == true) {
                            include_once $root . '/frontend/pages/blocks/map.php';
                        }
                        ?>
                    <?php } // если это странаца услуги ?>

                    <?php if ($page_type == 'connecting' || $page_type == '') {  // Связующая или район, область ?>
                        <div class="bl gallary">
                            <?php
                            echo $title_gallary;
                            $count_of_block_portfolio = 100;
                            require($root . "/frontend/pages/wigets/get_photos_of_portfolio_category.php");
                            echo $product_images_html;
                            ?>
                        </div>
                        <?php
                        if ($show_map == true) {
                            include_once $root . '/frontend/pages/blocks/map.php';
                        } ?>
                    <?php } ?>

                </div>

                <div class="col-lg-12">
                    <?php if ($uri_parts[count($uri_parts) - 1] == 'rabota-voditelem') { ?>
                        <h3>Заявка на вакансию с личным автомобилем</h3>
                        <div class="callback2"
                             data-yandex-reach="Zayavka"
                             data-type="onlineform"
                             data-result-text="Спасибо! Ваша заявка принята!">
                            <span data-type="form-type" data-name="Новая заявка на ВАКАНСИЮ ВОДИТЕЛЯ"></span>
                            <span data-type="site" data-name="ДомПереездов"></span>
                            <span data-type="form-text"
                                  data-name="Название формы ** Заявка на вакансию с личным автомобилем"></span>
                            <span data-type="form-text"
                                  data-name="Где находится ** Страница ТРЕБУЮТСЯ ВОДИТЕЛИ"></span>

                            <div class="form">
                                <p class="from-name">О себе</p>

                                <div class="form-content">
                                    <p class="input-title">ФИО <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id=""
                                           data-unit=""
                                           data-name="О себе - ФИО"/>
                                    <span class="explanation">Например: Петров Сергей Тимофеевич</span>

                                    <p class="input-title">Район проживания <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id=""
                                           data-unit=""
                                           value="<?php
                                           if ($page_id <> 1233 && $page_parent_id <> 1233) {
                                               if (strpos($page_name, '    ') !== false) {
                                                   $select_town = $page_parent_id;
                                               } else {
                                                   $select_town = $page_id;
                                               }
                                           }
                                           include_once $root . '/cms/forms/feedback/get_town_name.php'; ?>"
                                           data-name="О себе - Район проживания"/>
                                    <span class="explanation">Например: Московская область, Раменский район, Быково</span>


                                    <div class="check">
                                        <input id="id9" type="checkbox" class="checkbox"
                                               data-type="form-check" data-text="Готов работать грузчиком"/>
                                        <label for="id9">Готов работать грузчиком</label>
                                    </div>

                                    <p class="input-title">Стаж работы <span>*</span></p>
                                    <select name=""
                                            class="form-control"
                                            id="sel1"
                                            data-type="form-select"
                                            data-name="О себе - Стаж работы">
                                        <option selected="selected">Нет</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5 и более</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form">
                                <p class="from-name">Автомобиль</p>
                                <div class="form-content">
                                    <p class="input-title">Название <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id=""
                                           data-unit=""
                                           data-name="Автомобиль - Название"/>
                                    <span class="explanation">Например: Газель, промтоварный фургон</span>

                                    <p class="input-title">Грузоподъемность <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           placeholder=""
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id=""
                                           data-unit="т"
                                           data-name="Автомобиль - Грузоподъемность (т)"/>
                                    <span class="explanation">Например: 1,5</span>

                                    <p class="input-title">Объем кузова <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           placeholder=""
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id=""
                                           data-unit="м3"
                                           data-name="Автомобиль - Объем кузова (м3)"/>
                                    <span class="explanation">Например: 16</span>

                                </div>

                            </div>

                            <div class="form">
                                <p class="from-name">Контакты</p>
                                <div class="form-content">
                                    <p class="input-title">Телефон <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id="phone_sms"
                                           data-name="Телефон"
                                           class="input partext phone_mask"
                                           placeholder="+7 (___) ___-__-__"/>
                                    <span class="explanation">Например: +79261234567</span>

                                    <p class="input-title">Комментарий</p>
                                    <textarea rows="4"
                                              class="form-control"
                                              data-necessarily="no"
                                              data-type="form-text"
                                              data-id="comments"
                                              data-name="Комментарий"

                                    ></textarea>


                                    <span class="sender">Отправить</span>

                                </div>
                            </div>

                        </div>
                    <? } ?>

                    <?php if ($uri_parts[count($uri_parts) - 1] == 'rabota-gruzchikom') { ?>
                        <h3>Заявка на вакансию грузчик</h3>
                        <div class="callback2"
                             data-yandex-reach="Zayavka"
                             data-type="onlineform"
                             data-result-text="Спасибо! Ваша заявка принята!">
                            <span data-type="form-type" data-name="Новая заявка на ВАКАНСИЮ ГРУЗЧИК"></span>
                            <span data-type="site" data-name="ДомПереездов"></span>
                            <span data-type="form-text"
                                  data-name="Название формы ** Заявка на вакансию грузчик"></span>
                            <span data-type="form-text"
                                  data-name="Где находится ** Страница ТРЕБУЮТСЯ ГРУЗЧИКИ"></span>

                            <div class="form">
                                <p class="from-name">О себе</p>

                                <div class="form-content">
                                    <p class="input-title">ФИО <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id=""
                                           data-unit=""
                                           data-name="О себе - ФИО"/>
                                    <span class="explanation">Например: Петров Сергей Тимофеевич</span>

                                    <p class="input-title">Район проживания <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id=""
                                           data-unit=""
                                           value="<?php
                                           if ($page_id <> 1233 && $page_parent_id <> 1233) {
                                               if (strpos($page_name, '    ') !== false) {
                                                   $select_town = $page_parent_id;
                                               } else {
                                                   $select_town = $page_id;
                                               }
                                           }
                                           include_once $root . '/cms/forms/feedback/get_town_name.php'; ?>"
                                           data-name="О себе - Район проживания"/>
                                    <span class="explanation">Например: Московская область, Раменский район, Быково</span>


                                    <p class="input-title">Стаж работы грузчиком, лет <span>*</span></p>
                                    <select name=""
                                            class="form-control"
                                            id="sel1"
                                            data-type="form-select"
                                            data-name="О себе - Стаж работы">
                                        <option selected="selected">Нет</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5 и более</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form">
                                <p class="from-name">Контакты</p>
                                <div class="form-content">
                                    <p class="input-title">Телефон <span>*</span></p>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           data-necessarily="yes"
                                           data-type="form-val"
                                           data-id="phone_sms"
                                           data-name="Телефон"
                                           class="input partext phone_mask"
                                           placeholder="+7 (___) ___-__-__"/>
                                    <span class="explanation">Например: +79261234567</span>

                                    <p class="input-title">Комментарий</p>
                                    <textarea rows="4"
                                              class="form-control"
                                              data-necessarily="no"
                                              data-type="form-text"
                                              data-id="comments"
                                              data-name="Комментарий"

                                    ></textarea>


                                    <span class="sender">Отправить</span>

                                </div>
                            </div>

                        </div>
                    <? } ?>
                </div>
            </div>

        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="aside1">
            <?php
            include_once($root . "/frontend/pages/blocks/left.php");
            ?>
        </div>
    </div>
</div>