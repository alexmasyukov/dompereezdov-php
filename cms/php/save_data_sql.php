<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root . "/cms/system/base_connect.php";
include_once $root . "/cms/system/functions.php";

$sql_table_name = $_POST['sql_table_name'];
$sql_values = $_POST['sql_values'];
$sql_fields = $_POST['sql_fields'];
$id = $_POST['id'];
$sql_images_table_name = $_POST['sql_images_table_name'];
$sql_images_table_id_title = $_POST['sql_images_table_id_title'];
$images_matrix = $_POST['images_matrix'];
$sql_features_table_name = $_POST['sql_features_table_name'];
$sql_features_table_id_title = $_POST['sql_features_table_id_title'];
$features_matrix = $_POST['features_matrix'];
$documents_matrix = $_POST['documents_matrix'];


$sql_values = json_decode($sql_values, true);
$sql_fields = json_decode($sql_fields, true);

//echo '<pre>';
//print_r($sql_fields);


# 01.04.2017 - Автоматически проставляем cpu
$number_corrent_field = 0;
foreach ($sql_fields as $corrent_field) {
    if (trim($corrent_field) == 'name') {
        $sql_fields[] = 'cpu';
        $corrent_cpu = str2url($sql_values[$number_corrent_field]);
        $sql_values[] = $corrent_cpu;
    }
    if (trim($corrent_field) == 'category_id') {
        $corrent_category_id = $sql_values[$number_corrent_field];
    }
    $number_corrent_field++;
}

# Автоматически проставляем cpu_path
# Получаем все категории и делаем поиск по ним
if ($sql_table_name == 'content') {
    $mysql_string = "select id, cpu, parent_id FROM content_category";
    $categories_get = mysql_query($mysql_string);
    $categories = array();
    while ($value = mysql_fetch_array($categories_get)) {
        $categories[$value['id']] = $value;
    }
    $path = outTree_cpu_path($corrent_category_id, $categories);
    $sql_fields[] = 'cpu_path';
    $sql_values[] = $path.'/'.$corrent_cpu.'/';
}




# Автоматически проставляем cpu_path
# Получаем все категории и делаем поиск по ним
if ($sql_table_name == 'cars') {
    $mysql_string = "select id, cpu, parent_id FROM cars_category";
    $categories_get = mysql_query($mysql_string);
    $categories = array();
    while ($value = mysql_fetch_array($categories_get)) {
        $categories[$value['id']] = $value;
    }
    $path = outTree_cpu_path($corrent_category_id, $categories);
    $sql_fields[] = 'cpu_path';
    $sql_values[] = '/cars'.$path.'/'.$corrent_cpu.'/';
}




# Автоматически проставляем cpu_path
# Получаем все категории и делаем поиск по ним
if ($sql_table_name == 'content_category') {

    # Сначала находим parent_id (потому как если это ДОБАВЛЕНИЕ категории, текущего id еще не существует)
    $number_corrent_field = 0;
    foreach ($sql_fields as $corrent_field) {
        if (trim($corrent_field) == 'parent_id') {
            $corrent_parent_id = $sql_values[$number_corrent_field];
            break;
        }
        $number_corrent_field++;
    }


    $mysql_string = "select id, cpu, parent_id FROM content_category";
    $categories_get = mysql_query($mysql_string);
    $categories = array();
    while ($value = mysql_fetch_array($categories_get)) {
        $categories[$value['id']] = $value;
    }

//    echo '<pre>';
//    print_r($sql_fields);
    $path = outTree_cpu_path($corrent_parent_id, $categories);
    $sql_fields[] = 'cpu_path';
    $sql_values[] = $path.'/'.$corrent_cpu.'/';
}


function outTree_cpu_path($id, $array)
{
    $cpu = $array[$id]['cpu'];
    $parent_id = $array[$id]['parent_id'];
    if ($parent_id != '' && $cpu != '') {
        $find_child = outTree_cpu_path($parent_id, $array);
        if ($find_child != '') {
            $cpu_path = $find_child . '/' . $cpu;
        } else {
            $cpu_path = '/'.$cpu;
        }
    }
    return $cpu_path;
}




$SQL_query_fileds = '';

$SQL_query_fileds = $sql_fields[0] . ', ';
$SQL_query_fileds .= $sql_fields[1];

$x = 1;
while ($x++ < count($sql_fields) - 1) {
    $SQL_query_fileds .= ', ' . $sql_fields[$x];
}


$SQL_query_values = '\'' . htmlentities(addslashes(htmlspecialchars($sql_values[0])), ENT_QUOTES, 'UTF-8') . '\', ';
$SQL_query_values .= '\'' . htmlentities(addslashes(htmlspecialchars($sql_values[1])), ENT_QUOTES, 'UTF-8') . '\'';

$x = 1;
while ($x++ < count($sql_values) - 1) {
    $SQL_query_values .= ', \'' . htmlentities(addslashes(htmlspecialchars($sql_values[$x])), ENT_QUOTES, 'UTF-8') . '\'';
}

if ($id == '') {
    $mysql_string = "INSERT INTO $sql_table_name (" . $SQL_query_fileds . ") VALUES (" . $SQL_query_values . ")";
    $get = mysql_query($mysql_string);

    // Получаем id олько-что добавленного элемента
    $id = mysql_insert_id();

//                echo '{
//			"result":"'.$mysql_string.'"
//		}';
//                exit;

} else {

    $SQL_query_update = '';

    $SQL_query_update = $sql_fields[0] . ' = \'' . htmlentities(addslashes(htmlspecialchars($sql_values[0])), ENT_QUOTES, 'UTF-8') . '\',';
    $SQL_query_update .= $sql_fields[1] . ' = \'' . htmlentities(addslashes(htmlspecialchars($sql_values[1])), ENT_QUOTES, 'UTF-8') . '\'';

    $x = 1;
    while ($x++ < count($sql_fields) - 1) {
        $SQL_query_update .= ', ' . $sql_fields[$x] . ' = \'' . htmlentities(addslashes(htmlspecialchars($sql_values[$x])), ENT_QUOTES, 'UTF-8') . '\'';
    }

    if (strpos($sql_table_name, 'category')) { //Если найдено, т.е если идет сохранение редактирования категории
        $get_parent_id = mysql_query("SELECT parent_id FROM $sql_table_name WHERE id = " . $id . ";");

        while ($array = mysql_fetch_array($get_parent_id)) {
            $real_parent_id = $array['parent_id'];
        }

        //$get = mysql_query("UPDATE contacts_category SET parent_id=$real_parent_id WHERE parent_id=$id;");
    }

    $mysql_string = "UPDATE $sql_table_name SET " . $SQL_query_update . " WHERE id = " . $id . ";";

//                echo '{
//			"result":"'.$mysql_string.'"
//		}';
//                exit;

    $get = mysql_query($mysql_string);
}


if ($sql_images_table_name != 'none' && $sql_images_table_name != '') {
    for ($el = 0; $el <= count($images_matrix) - 1; $el++) {
        // Проверяем метку ADD
        if ($images_matrix[$el][5] == 'add') {
            // добавляем элемент в БД
            $SQL_images_query = "INSERT INTO $sql_images_table_name (
                                                                                        $sql_images_table_id_title,
                                                                                        big_img ,
                                                                                        small_img ,
                                                                                        general,
                                                                                        name,
                                                                                        sort
                                                                                ) VALUES (
                                                                                        $id,  
                                                                                        '" . $images_matrix[$el][2] . "', 
                                                                                        '" . $images_matrix[$el][3] . "',  
                                                                                        '" . $images_matrix[$el][4] . "',
                                                                                        '" . $images_matrix[$el][6] . "',
                                                                                        '" . $images_matrix[$el][7] . "'
                                                                                );"; // mysql_query
        } // if =add


        // Проверяем метку update
        if ($images_matrix[$el][5] == 'update') {
            // добавляем элемент в БД
            $SQL_images_query = "UPDATE $sql_images_table_name SET  
                                                                                    $sql_images_table_id_title =  '" . $images_matrix[$el][1] . "',
                                                                                    big_img =  '" . $images_matrix[$el][2] . "',
                                                                                    small_img =  '" . $images_matrix[$el][3] . "',
                                                                                    general =  '" . $images_matrix[$el][4] . "', 
                                                                                    name = '" . $images_matrix[$el][6] . "', 
                                                                                    sort = " . $images_matrix[$el][7] . "
                                                                            WHERE  
                                                                                    id = '" . $images_matrix[$el][0] . "';";
        } // if update


        // Проверяем метку delete
        if ($images_matrix[$el][5] == 'delete') {
            // Удаляем связанные файлы
            @unlink($root . str_replace('../../../', '/', $images_matrix[$el][2]));
            @unlink($root . str_replace('../../../', '/', $images_matrix[$el][3]));
            // Удаляем элемент из БД
            $SQL_images_query = "DELETE FROM $sql_images_table_name WHERE id = " . $images_matrix[$el][0] . ";";
        } // if delete


        $image_get = mysql_query($SQL_images_query);
    } // for $images_matrix
}


if ($sql_features_table_name != 'none' && $sql_features_table_name != '') {
    if (count($features_matrix) > 0) {
        // Сначала удаляем все старые поля из таблицы
        $SQL_features_query = "DELETE FROM $sql_features_table_name WHERE $sql_features_table_id_title = $id;";
        $features_get = mysql_query($SQL_features_query);

        for ($el = 0; $el <= count($features_matrix) - 1; $el++) {
            // добавляем элемент в БД
            $SQL_features_query = "INSERT INTO $sql_features_table_name (
                                                                                        $sql_features_table_id_title,
                                                                                        features_id,
                                                                                        value,
                                                                                        sort
                                                                                ) VALUES (
                                                                                        '$id',
                                                                                        '" . $features_matrix[$el][1] . "',
                                                                                        '" . htmlentities(addslashes(htmlspecialchars($features_matrix[$el][2])), ENT_QUOTES, 'UTF-8') . "',
                                                                                        '" . $features_matrix[$el][3] . "'
                                                                                ); "; // mysql_query

            $features_get = mysql_query($SQL_features_query);

        }
    };


    if (count($features_matrix) == 0) {
        // удаляем все старые поля из таблицы
        $SQL_features_query = "DELETE FROM $sql_features_table_name WHERE $sql_features_table_id_title = $id;";
        $features_get = mysql_query($SQL_features_query);
    }

    if ($features_get == '') {
        $features_get = $get;
    }
};


if ($sql_table_name == 'content') {
    $SQL_query = "DELETE FROM content_documents WHERE id_content = $id;";
    $get = mysql_query($SQL_query);

    if (count($documents_matrix) > 0) {
        for ($el = 0; $el <= count($documents_matrix) - 1; $el++) {
            $SQL_query = "INSERT INTO content_documents (
                                                    id_content,
                                                    id_documents,
                                                    sort
                                            ) VALUES (
                                                    $id,  
                                                    '" . $documents_matrix[$el][0] . "', 
                                                    '" . $documents_matrix[$el][1] . "'
                                            );"; // mysql_query

            $get = mysql_query($SQL_query);
        } // for $documents_matrix
    }
}


if ($sql_images_table_name != '' && $sql_images_table_name != 'undefined' && $sql_images_table_name != 'none') {
    // Считываем данные зображений из БД
    $images_get = mysql_query("select * from $sql_images_table_name WHERE $sql_images_table_id_title=" . $id . "");
    while ($images = mysql_fetch_array($images_get)) {
        // Формируем данные
        //$key = 'point'.(++$i);
        $image_data .=
            $images['id'] . ';' .
            $images[$sql_images_table_id_title] . ';' .
            $images['big_img'] . ';' .
            $images['small_img'] . ';' .
            $images['general'] . ';' .
            ';' .
            $images['name'] . ';' .
            $images['sort'] . ';';
    }
};


echo '{
                "result":"' . $get . '",
                "image_data": "' . $image_data . '"
            }';
?>