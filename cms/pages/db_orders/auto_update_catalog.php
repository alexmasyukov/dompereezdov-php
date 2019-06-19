<?php

ini_set('html_errors', 'On');

$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root . "/cms/system/base_connect.php";
include_once $root . "/cms/system/functions.php";


//    http://epool75.ru/cms/pages/db_orders/auto_update_catalog.php?catalog_file=/uploads/test.xls
$catalog_file = $_REQUEST["catalog_file"];
//$catalog_file = $root . "/cms/pages/db_orders/new.xls";
require_once ('Excel/reader.php');

if ($catalog_file != '') {

    $catalog_file = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $catalog_file);

    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('UTF-8');
    $data->read($root . '/uploads/' . $catalog_file);
    //$data->read($catalog_file);

//    echo '<pre>';
//    print_r($data->sheets); 
//$html = '<table border="1">';
//for ($row = 1; $row <= $data->sheets[0]['numRows']; $row++) {
//    $html_row = '<tr>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][1]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][2]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][3]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][4]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][5]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][6]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][7]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][8]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][9]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][10]), ENT_QUOTES, 'UTF-8') . '</td>';
//    $html_row .= '</tr>';
//    $datas = '';
//    for ($col = 1; $col <= 50; $col++) {
//        $datas .= trim($data->sheets[0]['cells'][$row][$col]);
//    }
//    if ($datas <> '') {
//        $html .= $html_row;
//    }
//}
//$html .= '</table>';
//echo $html;





    mysql_set_charset('utf8', $link_db);

    try {
        $dbh = new PDO('mysql:host=' . $db_server . ';dbname=' . $db_name, $db_login, $db_password, array());
        $dbh->exec("set names utf8");
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

// Удаляем все данные и обнуляем AUTO_INCREMENT
    $sql = "TRUNCATE catalog_category";
    $smf = $dbh->query($sql);
    $e = $smf;

    $sql = "TRUNCATE catalog_products";
    $smf = $dbh->query($sql);
    $e = $smf;

    $sql = "TRUNCATE catalog_products_images";
    $smf = $dbh->query($sql);
    $e = $smf;

    $start_row = $_REQUEST['start_row'];
    $end_row = $_REQUEST['end_row'];
    $start_cols = $_REQUEST['start_cols'];
    $end_cols = $_REQUEST['end_cols'];

    $start_row = 2;
    $end_row = 500;
    $start_cols = 6; //Характеристики
    $end_cols = 50; //Характеристики
    $atributes = '';
    $sql = '';

    if (is_numeric($start_row) === false || is_numeric($end_row) === false || is_numeric($start_cols) === false || is_numeric($end_cols) === false) {
        echo '<h3>Ошибка! Проверьте введенные данные!</h3>';
        exit;
    };



    $now_date = date('d.m.Y');
    $sort = 0;
    $cat_sort = 0;
    $cat_id = '';
    $iteration = 0;
    $id = 1;

    for ($row = $start_row; $row <= $end_row; $row++) {
        $images = '';
        $product_id = '';

        $name = trim(html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][2]), ENT_QUOTES, 'UTF-8'));
        $images = html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][5]), ENT_QUOTES, 'UTF-8');
        $article = html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][1]), ENT_QUOTES, 'UTF-8');
        $desk = html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][3]), ENT_QUOTES, 'UTF-8');
        $template = html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][4]), ENT_QUOTES, 'UTF-8');
        $cpu = eng_name($name);
        //$price = html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][5]), ENT_QUOTES, 'UTF-8');
        //echo $name.'</br>';
        

        //Проход по строкам доп. характеристик  
        $atributes = '';
        $number_feature_row = -1;
        for ($row_feature = $row; $row_feature <= $row + 50; $row_feature++) { 
            $realname = trim(html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row_feature][2]), ENT_QUOTES, 'UTF-8'));
            if ($name != $realname && $realname != '') {
                //echo 'its next row</br>';
                $row = $row_feature - 1;
                break;
            }
            $number_feature_row++;
            for ($col = $start_cols; $col <= $end_cols; $col++) { //Проход по столбцам
                $atribute_name = '';
                $atribute_name = html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][1][$col]), ENT_QUOTES, 'UTF-8');
                if ($atribute_name == '') {
                    break;
                }
                $atr_value = '';
                $atr_value = html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row_feature][$col]), ENT_QUOTES, 'UTF-8');
                if ($atr_value != '') {
                    if ($row_feature <> $row) {
                        $feature_row_text = '_r' . $number_feature_row . '_';
                    } else {
                        $feature_row_text = '';
                    }
                    $atributes .= '|**|' . $atribute_name . $feature_row_text . '|*|' . $atr_value;
                }
            }
        }

        //echo $atributes . '</br>';

        if ($name == '' && $article == '' && $desk == '' && $price == '' && $atribute_values == '') {
            break;
        }

        //echo $sort . ' ------ ' . $name . $atributes . '<br/>';

        if ($article == '' && $desk == '' && $price == '' && $atribute_values == '') {
            $cat_sort++;
            $sql_cat = "INSERT INTO catalog_category SET 
            sort = '$cat_sort',
            name = '$name',
            template = '$template',
            cpu = '$cpu',
            public = 1    
        ";
            $smf = $dbh->query($sql_cat);
            $cat_id = $dbh->lastInsertId();
            $product_id = '';
        } else {

            $iteration++;
            if ($iteration >= 10) {
                //echo '!!!!!!!!!!!!';
                $sort++;
                $sql .= "INSERT INTO catalog_products SET
                id = $id,
                sort = '$sort',
                name = '$name',
                atributes = '$atributes',
                category_id = $cat_id,
                public = 1,
                article_number = '$article',
                description = '$desk',
                price = '$price',    
                meta_name = '',
                meta_keywords = '',
                meta_description = '';
            ";
                //echo $sql.'</br></br></br></br>';
                $smf = $dbh->query($sql);
                //$product_id = $dbh->lastInsertId();
                $iteration = 0;
                $sql = '';
            } else {
                $sort++;
                $sql .= "INSERT INTO catalog_products SET
                id = $id,
                sort = '$sort',
                name = '$name',
                atributes = '$atributes',
                category_id = $cat_id,
                public = 1,
                article_number = '$article',
                description = '$desk',
                price = '$price',    
                meta_name = '',
                meta_keywords = '',
                meta_description = '';
            ";
                //echo $sql.'</br></br></br></br>';
                $smf = $dbh->query($sql);
                $sql = '';
            }
        }

        // добавляем изображения к товару, предварительно распарсив их по знаку *

        if (trim($images) <> '') {
            $arr = explode("*", $images);
            $sql_images_query = '';
            $sort = 0;
            foreach ($arr as $value) {
                if ($value == '') {
                    break;
                };
                if ($sort == 0) {
                    $general = '1';
                } else {
                    $general = '0';
                };
                $sql_images_query .= "INSERT INTO catalog_products_images SET 
                sort = $sort,
                name = '',
                module_item_id = $id,
                general = $general,
                big_img = '$value',
                small_img = 'small_$value';
                ";
                $sort++;
            }
            //echo $sql_images_query.'</br>';
            $smf = $dbh->query($sql_images_query);
        }

        $id++;
    }

    $dbh = null;

    echo "ok";
}



?>