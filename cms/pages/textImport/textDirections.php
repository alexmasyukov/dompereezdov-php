<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-06-16
 * Time: 18:07
 * @param $service
 * @param $sqlParentId
 * @return string
 */


function getServiceSQL($service, $sqlParentId) {
    //        'sql' => 'select id from pages where name = \'        грузоперевозки\' AND parent_id IN ('.$oneDirections['Москва > округа']->sql.')'
    return "select id from pages where cpu = '" . trim($service) . "' AND parent_id IN ($sqlParentId)";
}


$oneDirections = array(
    'Москва' => (object)array(
        'pagesId' => 10000
    ),
    'Москва > округа' => (object)array(
        'sql' => 'select id from pages where parent_id = 10000 and type = \'okrug\''
    ),
    'Москва > районы' => (object)array(
        'sql' => 'select id from pages where parent_id = 10000 and type = \'raion\''
    ),
    'Москва > города' => (object)array(
        'sql' => 'select id from pages where parent_id = 10000 and type = \'town\''
    ),
    'Московская область' => '',
);

$textDirections = array(
    'Москва > округа > Грузоперевозки' => (object)array(
        'sql' => getServiceSQL('gruzoperevozki', $oneDirections['Москва > округа']->sql),
    ),
    'Москва > округа > Вывоз мебели' => (object)array(
        'sql' => getServiceSQL('vyvoz-mebeli', $oneDirections['Москва > округа']->sql),
    ),
    'Москва > округа > Перевозка пианино' => (object)array(
        'sql' => getServiceSQL('perevozka-pianino', $oneDirections['Москва > округа']->sql),
    ),
    'Москва > округа > Квартирный переезд' => (object)array(
        'sql' => getServiceSQL('kvartirnyj-pereezd', $oneDirections['Москва > округа']->sql),
    ),
    'Москва > округа > Дачный переезд' => (object)array(
        'sql' => getServiceSQL('dachnyj-pereezd', $oneDirections['Москва > округа']->sql),
    ),
    'Москва > округа > Офисный переезд' => (object)array(
        'sql' => getServiceSQL('ofisnyj-pereezd', $oneDirections['Москва > округа']->sql),
    ),
    'Москва > округа > Перевозка мебели' => (object)array(
        'sql' => getServiceSQL('perevozka-mebeli', $oneDirections['Москва > округа']->sql),
    ),
    'Москва > округа > Грузовое такси' => (object)array(
        'sql' => getServiceSQL('gruzovoe-taksi', $oneDirections['Москва > округа']->sql),
    ),


    'end2' => '',


    'Москва > районы > Грузоперевозки' => (object)array(
        'sql' => getServiceSQL('gruzoperevozki', $oneDirections['Москва > районы']->sql),
    ),
    'Москва > районы > Вывоз мебели' => (object)array(
        'sql' => getServiceSQL('vyvoz-mebeli', $oneDirections['Москва > районы']->sql),
    ),
    'Москва > районы > Перевозка пианино' => (object)array(
        'sql' => getServiceSQL('perevozka-pianino', $oneDirections['Москва > районы']->sql),
    ),
    'Москва > районы > Квартирный переезд' => (object)array(
        'sql' => getServiceSQL('kvartirnyj-pereezd', $oneDirections['Москва > районы']->sql),
    ),
    'Москва > районы > Дачный переезд' => (object)array(
        'sql' => getServiceSQL('dachnyj-pereezd', $oneDirections['Москва > районы']->sql),
    ),
    'Москва > районы > Офисный переезд' => (object)array(
        'sql' => getServiceSQL('ofisnyj-pereezd', $oneDirections['Москва > районы']->sql),
    ),
    'Москва > районы > Перевозка мебели' => (object)array(
        'sql' => getServiceSQL('perevozka-mebeli', $oneDirections['Москва > районы']->sql),
    ),
    'Москва > районы > Грузовое такси' => (object)array(
        'sql' => getServiceSQL('gruzovoe-taksi', $oneDirections['Москва > районы']->sql),
    ),



    'end3' => '',



    'Москва > города > Грузоперевозки' => (object)array(
        'sql' => getServiceSQL('gruzoperevozki', $oneDirections['Москва > города']->sql),
    ),
    'Москва > города > Вывоз мебели' => (object)array(
        'sql' => getServiceSQL('vyvoz-mebeli', $oneDirections['Москва > города']->sql),
    ),
    'Москва > города > Перевозка пианино' => (object)array(
        'sql' => getServiceSQL('perevozka-pianino', $oneDirections['Москва > города']->sql),
    ),
    'Москва > города > Квартирный переезд' => (object)array(
        'sql' => getServiceSQL('kvartirnyj-pereezd', $oneDirections['Москва > города']->sql),
    ),
    'Москва > города > Дачный переезд' => (object)array(
        'sql' => getServiceSQL('dachnyj-pereezd', $oneDirections['Москва > города']->sql),
    ),
    'Москва > города > Офисный переезд' => (object)array(
        'sql' => getServiceSQL('ofisnyj-pereezd', $oneDirections['Москва > города']->sql),
    ),
    'Москва > города > Перевозка мебели' => (object)array(
        'sql' => getServiceSQL('perevozka-mebeli', $oneDirections['Москва > города']->sql),
    ),
    'Москва > города > Грузовое такси' => (object)array(
        'sql' => getServiceSQL('gruzovoe-taksi', $oneDirections['Москва > города']->sql),
    ),



    'end4' => '',

//
//
//    'Московская область > районы' => (object)array(
//        'sql' => 'select * from pages where type = "район" AND parent_id >= 1 AND parent_id < 10000'
//    ),
//    'end6' => '',
//    'Московская область > нас. пункты' => (object)array(
//        'sql' => 'select * from pages where page_type = "town" AND parent_id >= 1 AND parent_id < 10000'
//    ),
//    'Московская область > нас. пункты > Грузоперевозки' => '',
//    'Московская область > нас. пункты > Вывоз мебели' => '',
//    'Московская область > нас. пункты > Перевозка пианино' => '',
//    'Московская область > нас. пункты > Квартирный переезд' => '',
//    'Московская область > нас. пункты > Дачный переезд' => '',
//    'Московская область > нас. пункты > Офисный переезд' => '',
//    'Московская область > нас. пункты > Перевозка мебели' => '',
//    'Московская область > нас. пункты > Грузовое такси' => '',
);


$textPostition = array(
    'top_text' => 'Верхний',
    'bottom_text' => 'Нижний'
);

$services = (object)array(
    'Грузоперевозки',
    'Вывоз мебели',
    'Перевозка пианино',
    'Квартирный переезд',
    'Дачный переезд',
    'Офисный переезд',
    'Перевозка мебели',
    'Грузовое такси'
);

/**
 * Москва
 * Московская область
 *
 *      округ
 *      район
 *      населенный пункт
 *
 *          Услуга
 *          сам нас. пункт
 *
 *              верхний текст
 *              нижний текст
 **/