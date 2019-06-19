<?php
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
    //$addit_array = $module_get->fetchAll(PDO::FETCH_ASSOC);


    # Приводим массив к виду (Все эти столбцы должны быть отсортированы в SQL заранее !!! )
    /*

    product_id ---- | features_row ---   | - in_maket
                    |                    | - Цена
                    |                    | - Количество
                    |
                    | features_row ---   | - in_maket
                    |                    | - Цена
                    |                    | - Количество
                    |
                    | features_row ---   | - in_maket
                    |                    | - Цена
                    |                    | - Количество

    product_id ---- | features_row ---   | - in_maket
                    |                    | - Цена
                    |                    | - Количество
                    |
                    | features_row ---   | - in_maket
                    |                    | - Цена
                    |                    | - Количество
                    |
                    | features_row ---   | - in_maket
                    |                    | - Цена
                    |                    | - Количество
    */


    $old_product_id = 0;
    foreach ($module_get->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if ($old_product_id == $row['product_id']) {
            $arr[$row['product_id']][][] = $row;
        } else {
            $arr[$row['product_id']][] = array($row);
            $old_product_id = $row['product_id'];
        }
    }

    //        echo '<pre>';
    //         print_r($arr);
    //        echo '</pre>';
    //        exit;
}


if ($not_show_car_id <> '') {
    $not_show_car_id = " AND cars.id <> $not_show_car_id ";
    $limit = ' LIMIT 6';
}

$products_of_cat = $db->query('
            SELECT 
                cars.id, 
                cars.category_id, 
                cars.name, 
                cars.cpu_path,
                cars.article_number,
                cars.price,
                cars.description
            FROM 
                cars
            WHERE
                cars.public=1 
                ' . $not_show_car_id . '
            ORDER BY 
                cars.id
            ' . $limit . '
            ');
$test = $products_of_cat->fetchAll(PDO::FETCH_ASSOC);

//     echo '<pre>';
//     var_dump($test);
//
//exit;

$master_all = '';
$number_car = 0;


foreach ($test as $row) {
    $master = new templateController_return();
    // Указываем новый файл шаблона:
    $master->templateName = $root . "/frontend/templates/car.tpl";
    $product_id = $row['id'];
    $master->content["car_link"] = 'http://' . $server . '' . $row['cpu_path'];

    $images_arr = get_img($product_id);
    $master->content["small_img"] = $images_arr[0];
    $master->content["big_img"] = $images_arr[1];

    //        echo $master->content["small_img"].' '.$cars_images_matrix[$number_car].' id-'.$product_id.'<br/>';

    $master->content["car_name"] = get_UTF8_text($row['name']);


    # Выбераем нужные характеристики
    $master->content["car_attributes"] = '<table>';
    foreach ($arr[$product_id] as $attr) {
        foreach ($attr as $attr_row) {

            $prefix = '';
            if ($attr_row['feature_value'] == 'Бесплатно' || $attr_row['feature_value'] == 'бесплатно') {
                $prefix = '';
            } else {
                $attr_row['prefix'] = str_replace('м3', 'м<sup>3</sup>', $attr_row['prefix']);
                $prefix = ' <span>' . $attr_row['prefix'] . '</span>';
            }
            $master->content["car_attributes"] .= '<tr><td>' . $attr_row['feature_title'] . ':</td><td>  ' . $attr_row['feature_value'] . $prefix . '</td></tr>';
        }
    }
    $master->content["car_attributes"] .= '</table>';

    $number_car++;

    $master_all .= $master->Fill();

}
echo $master_all;


function get_img($car_id) {
    global $db;


    $images = $db->query("
            SELECT 
                cars_images.small_img AS small_img,
                cars_images.big_img AS big_img
            FROM 
                cars_images
            WHERE
                module_item_id = $car_id
            ORDER BY
                general DESC
        ");
    $test = $images->fetchAll(PDO::FETCH_ASSOC);

    foreach ($test as $row) {
        return ['/sync/' . $row['small_img'], '/sync/' . $row['big_img']];
    }
}


?>





