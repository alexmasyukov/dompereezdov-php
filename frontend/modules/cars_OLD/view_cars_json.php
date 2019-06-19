<?php
//$root = realpath($_SERVER['DOCUMENT_ROOT']);
//$server = $_SERVER['HTTP_HOST'];
//include_once $root . "/frontend/system/base_connect.php";
//include_once $root . '/frontend/system/functions.php';

$select_calculation_car_options = '';


$addit_array = array();
$module_get = $db->query('
        SELECT 
            cars.id AS product_id,
            cars_features_values.value AS feature_value,
            cars_features.title AS feature_title,
            cars_features.in_maket AS in_maket,
            cars_features.prefix AS prefix,
            cars_features_values.row AS row_number,
            cars_features_values.sort
         FROM 
            cars
         INNER JOIN cars_features_values ON 
            cars_features_values.module_item_id = cars.id
         INNER JOIN cars_features ON 
            cars_features.id = cars_features_values.features_id
         WHERE
            cars.public=1
    ');
if ($module_get->rowCount() > 0) {
    $old_product_id = 0;
    foreach ($module_get->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if ($old_product_id == $row['product_id']) {
            $arr[$row['product_id']][][] = $row;
        } else {
            $arr[$row['product_id']][] = array($row);
            $old_product_id = $row['product_id'];
        }
    }
//
//        echo '<pre>';
//         print_r($arr);
//        echo '</pre>';

}

$products_of_cat = $db->query('
            SELECT 
                cars.id, 
                cars.category_id, 
                cars.name, 
                cars.cpu_path,
                cars.article_number,
                cars.price,
                cars.description,
                cars_images.small_img AS img
            FROM 
                cars
            INNER JOIN cars_images ON 
                cars_images.module_item_id = cars.id
            WHERE
                cars.public=1 
            ORDER BY 
                cars.id
            ');
$test = $products_of_cat->fetchAll(PDO::FETCH_ASSOC);

//     echo '<pre>';
//    print_r($test);
//
//exit;

$master_all = '';
$number_car = 0;


foreach ($test as $row) {

    if ($number_car == 0) {
        $sel = "
        state: {
                selected: false
        }";
    } else {
        $sel = '';
    }


    $d_t = 0;
    $m_c = 0;
    $gruzopodemnost = '';
    # Выбераем нужные характеристики
    foreach ($arr[$row['id']] as $attr) {
        foreach ($attr as $item) {
            if ($item['feature_title'] == 'Цена') {
                $m_c = str_replace(' ', '', $item['feature_value']);
            }
            if ($item['feature_title'] == 'Выезд за город') {
                $d_t = str_replace(' ', '', $item['feature_value']);
            }
            if ($item['feature_title'] == 'Грузоподъёмность') {
                $gruzopodemnost = str_replace(' ', '', $item['feature_value']);
            }
        }
    }


    $list_items_items[] = "
    {
        options: {
            selectOnClick: false
        },
        data: {
            content: '" . get_UTF8_text($row['name']) . "',
            img: '".str_replace('../../../', '', $row['img'])."',
            tarif: $d_t,
            minimum_cost: $m_c
        },
        $sel
    }";

    $select_calculation_car_options .= '<option 
        data-tarif="'.$d_t.'"
        data-minimum-cost="'.$m_c.'"
        data-img="'.str_replace('../../../', '', $row['img']).'"
        value="'.$number_car.'">'.get_UTF8_text($row['name']).' (Грузоподъёмность '.$gruzopodemnost.' кг.)</option>';

    $number_car++;
}
$list_items .= '$list_items = [' . implode(',', $list_items_items) . ']; ';
?>