<?php

if ($url_path != '/cars/') {

    $sql = "
    SELECT 
        cars.id,
        cars.name,
        cars.description,
        cars.h1,
        cars_images.big_img as big_img,
        cars_images.small_img as small_img
    FROM 
        cars 
    INNER JOIN cars_images ON 
               cars_images.module_item_id = cars.id
    WHERE 
        cpu_path = '$url_path' 
    ORDER BY
        cars_images.general = 1";
    $smf = $db->query($sql);
    if ($smf->rowCount() > 0) {
        $page = array();
        foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $page['h1'] = trim(html_entity_decode(htmlspecialchars_decode($value['h1']), ENT_QUOTES, 'UTF-8'));
            $page['title'] = trim(html_entity_decode(htmlspecialchars_decode($value['name']), ENT_QUOTES, 'UTF-8'));
            $page['description'] = trim(html_entity_decode(htmlspecialchars_decode($value['description']), ENT_QUOTES, 'UTF-8'));
            $page['car_img'] = '<img src="' . $value['big_img'] . '" alt="' . trim(html_entity_decode(htmlspecialchars_decode($value['name']), ENT_QUOTES, 'UTF-8')) . '" class="img-responsive" />';
            $page['features_table'] = get_car_features($value['id']);
            $page['car_id'] = $value['id'];
        }
    } else {
        view_404();
    }
} else {
    $page = array();
    $page['title'] = "Автомобили для грузоперевозки в Москве и Московской области";
}


function get_car_features($car_id)
{
    global $db;
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
            cars.id = ' . $car_id . ' AND
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

//        echo '<pre>';
//         print_r($arr);
//        echo '</pre>';
//        exit;
    }


    # Выбераем нужные характеристики
    $html = '<table>';
    foreach ($arr[$car_id] as $attr) {
        foreach ($attr as $attr_row) {
            if ($attr_row['feature_value'] == 'Бесплатно' || $attr_row['feature_value'] == 'бесплатно') {
                $prefix = '';
            } else {
                $attr_row['prefix'] = str_replace('м3', 'м<sup>3</sup>', $attr_row['prefix']);
                $prefix = ' <span>' . $attr_row['prefix'] . '</span>';
            }
            $html .= '<tr><td class="left">' . $attr_row['feature_title'] . '</td><td class="right">  ' . $attr_row['feature_value'] . $prefix . '</td></tr>';
        }
    }
    $html .= '</table>';
    return $html;
}

?>