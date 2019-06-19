<?php

ini_set('html_errors', 'On');

$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root . "/cms/system/base_connect.php";
include_once $root . "/cms/system/functions.php";



$catalog_file = $_REQUEST["catalog_file"];
// $catalog_file = $root . "/cms/pages/db_orders/XLS_standart_shari.xls";


require_once ('Excel/reader.php');

if ($catalog_file != '') {

    $catalog_file = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $catalog_file);

    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('UTF-8');
//    $data->read($catalog_file);
    $data->read($root . '/uploads/' . $catalog_file);


//    echo '<pre>';
//    print_r($data->sheets); 
// $html = '<table border="1">';
// for ($row = 1; $row <= $data->sheets[0]['numRows']; $row++) {
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
// }
// $html .= '</table>';
// echo $html;
// exit;



function gdecode($text) {
    return trim(html_entity_decode(htmlspecialchars_decode(addslashes(stripslashes($text))), ENT_QUOTES, 'UTF-8'));;
};



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

    $sql = "TRUNCATE catalog_features";
    $smf = $dbh->query($sql);
    $e = $smf;

    $sql = "TRUNCATE catalog_features_values";
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
    $end_row = 20000;
    $start_cols = 8; //Характеристики
    $end_cols = 100; //Характеристики
    $atributes = '';
    $sql = '';


  
    if (is_numeric($start_row) === false || is_numeric($end_row) === false || is_numeric($start_cols) === false || is_numeric($end_cols) === false) {
        echo '<h3>Ошибка! Проверьте введенные данные!</h3>';
        exit;
    };



    #Добавляем названия дополнительных характеристик в БД 
    $sort_attr = 0;
    for ($col = $start_cols; $col <= $end_cols; $col++) { 
        $atribute_name = gdecode($data->sheets[0]['cells'][1][$col]);
        preg_match('/\(\((.*)\)\)/',  $atribute_name, $prefix); // обозначение например - кг
        # Удаляем префикс из названия характеристики
        if (trim($prefix[1]) != '') {
            $atribute_name = trim(str_replace("((".$prefix[1]."))", '', $atribute_name));
        }
        if ($atribute_name == '') {
            $end_cols = $col - 1; # Ограничеваем конечный столбец для будущих операций
            break;
        };
        $sql = "INSERT INTO catalog_features SET
            id = '$col',
            title =  '$atribute_name',
            type = 'string',
            in_maket = '".str2url($atribute_name)."',
            sort = '$sort_attr',
            prefix = '".trim($prefix[1])."'
            ";
        $smf = $dbh->query($sql);
        $e = $smf;
        $sort_attr++;
        // echo $sql.'</br>';
    };
    $sql = '';






    #Определяем конец листа
    for ($row = $start_row; $row <= $end_row; $row++) {
        $text = '';
        for ($col = 1; $col <= $end_cols; $col++) {
            $text .= gdecode($data->sheets[0]['cells'][$row ][$col]);
        }
        if ($text == '') {
            $end_row = $row - 1;
            break;
        }
    };





    $now_date = date('d.m.Y');
    $sort = 0;
    $cat_sort = 0;
    $cat_id = '';
    $iteration = 0;
    $id = 1;


    for ($row = $start_row; $row <= $end_row; $row++) {

        $images = '';
        $product_id = $id;
        $article =  gdecode($data->sheets[0]['cells'][$row][1]);
        $name =  gdecode($data->sheets[0]['cells'][$row][2]);
        $desk =  gdecode($data->sheets[0]['cells'][$row][3]);
        $template =  gdecode($data->sheets[0]['cells'][$row][4]);
        $images =  gdecode($data->sheets[0]['cells'][$row][5]);
        $measured =  gdecode($data->sheets[0]['cells'][$row][6]);
        $public =  gdecode($data->sheets[0]['cells'][$row][7]);
        $price =  gdecode($data->sheets[0]['cells'][$row][9]);

        if (strtolower($public) == strtolower('нет')) {$public = 0; } else  { $public = 1; }
        
        
        

        
        


        
        // Если  это категория
        if (strtolower($article) == strtolower('категория')) {
        //    echo 'cat - '.$name.'</br>';
            
            $category_path_array = explode("/", $name);  
            $number = -1;
            $parent_cat_id = '';
            $real_cat_id = '';
            while ($number++ < count($category_path_array) - 1) {
                if ($number == 0) { // Если это ПЕРВАЯ Категория в массиве, значит у нее не должно быть родителей
                    $local_name = trim($category_path_array[$number]);
                    $real_cat_id = get_id_category($local_name, 0);
                    if ($real_cat_id == '') { //Если этой категории нет в БД, добавляем ее
                        $real_cat_id = add_category($local_name, 0, $template, eng_name($local_name));
                        $product_id = '';
                    }

                } else {
                    // Если это 2-я и т.д, значит у нее должен быть прописан родитель в БД
                    // Проходимся по ВСЕМ ее родителям и прородителям, чтобы точно указать ее родителя при записи в БД
                    $parent_first_id = get_id_category(trim($category_path_array[0]), 0);
                    $number_find = 0;
                    while ($number_find++ < count($category_path_array) - 1) {
                        if ($number_find == 1) {
                            $parent_cat_id = $parent_first_id;
                        } else {
                            $parent_cat_id = $real_cat_id;
                        }
                        $local_name = trim($category_path_array[$number_find]);
                        $real_cat_id = get_id_category($local_name, $parent_cat_id);
                        if ($real_cat_id == '') {//Если этой категории нет в БД, добавляем ее
                            $real_cat_id = add_category($local_name, $parent_cat_id, $template, eng_name($local_name));
                            $number = $number_find;
                            $product_id = '';
                            break;
                        }
                    }
                }
            };
            
           
        } else {
                $sort++;
                $sql .= "INSERT INTO catalog_products SET
                id = $id,
                sort = '$sort',
                name = '$name',
                cpu = '".str2url($name.'pid-'.$id)."',    
                atributes = '$atributes',
                category_id = $real_cat_id,
                public = '$public',
                article_number = '$article',
                description = '$desk',
                price = '$price',    
                meta_title = '',
                meta_keywords = '',
                meta_description = '';
            ";
                //echo $sql.'</br></br></br></br>';
                $smf = $dbh->query($sql);
                //$product_id = $dbh->lastInsertId();
                $sql = '';
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


        # Проход по строкам доп. характеристик  
        # Проходим вниз по строкам, если название товара пусто, то это тот же товар,
        # но у него нужно считать характеристики
        $is_attribute = false;
        for ($row_feature = $row; $row_feature <= $end_row; $row_feature++) {
            $realname =  gdecode($data->sheets[0]['cells'][$row_feature][2]);
            if (($realname != $name && $realname != '') || ($realname == $name && $is_attribute === true)) { # Если это уже другой товар
                $row = $row_feature-1;
                break;
            }

            # Если это следующая строка с характеристиками (НЕТ НАЗВАНИЯ ТОВАРА)
            if ($realname == '') {
                # Защита на случай ЕСЛИ ИМЯ СЛЕДУЮЩЕГО ТОВАРА БУДЕТ ОДНИНАКОВО С ИМЕНЕМ ТЕКУЩЕГО ТОВАРА
                # Такое условие не сработает !!!  if ($realname == '' || $realname == $name) { 
                $is_attribute = true;
            }
            if (($realname == '' || $realname == $name)) { 
                if (strtolower(gdecode($data->sheets[0]['cells'][$row_feature][1])) != 'категория') {
                    # Проход по столбцам характеристик и запись их в БД
                    $sort_attr = 0;
                    for ($col = $start_cols; $col <= $end_cols; $col++) { 
                        $atr_value = '';
                        $atr_value =  gdecode($data->sheets[0]['cells'][$row_feature][$col]);
                        if ($atr_value != '') {
                            $sql = "INSERT INTO catalog_features_values SET
                                module_item_id =  '$product_id',
                                features_id = '$col',
                                value = '$atr_value',
                                sort = '$sort_attr',
                                row = '$row_feature'
                                ";
                            $smf = $dbh->query($sql);
                            $e = $smf;
                            $sort_attr++;
                            $sql = '';
                        }
                    }
                }

            }
        }


        $id++;
    }

    $dbh = null;

    echo "ok";
}




function get_id_category($name, $parent_id) {
    global $dbh;
    $sql_query = "SELECT id FROM catalog_category WHERE name = '$name' AND parent_id = '$parent_id'";
    $smf = $dbh->query($sql_query);
    if ($smf->rowCount() > 0) {
        $test = $smf->fetch(PDO::FETCH_ASSOC);
        return $test['id'];
    } else {
        return '';
    }
};



function add_category($name, $parent_cat_id, $template, $cpu) {
    global $dbh, $cat_sort;
    // Добавляем категорию в БД
    $cat_sort++;
    $sql_cat = "INSERT INTO catalog_category SET 
        sort = '$cat_sort',
        name = '".$name."',
        parent_id = '$parent_cat_id',
        template = '$template',
        cpu = '$cpu',
        public = 1    
    ";
    $smf = $dbh->query($sql_cat);
    $cat_id = $dbh->lastInsertId();
    return $cat_id;
};

?>