<?php
header('Content-Type: text/xml; charset=UTF-8');
$root = realpath($_SERVER['DOCUMENT_ROOT']);

#Конфигурация
include_once($root . '/configuration.php');

#подключение к БД
include_once $root . '/frontend/system/base_connect.php';

//include_once $root . '/frontend/system/functions.php';


echo '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>http://' . $_SERVER['HTTP_HOST'] . '/</loc>
        </url>';


$sql = "SELECT 
            *
        FROM 
           meta
        WHERE
            cpu_path <> ''
    ";
$module_array = array();
$module_get = $db->query($sql);


if ($module_get->rowCount() > 0) {
    $module_array = $module_get->fetchAll();

    foreach ($module_array as $value) {
        if ($value['cpu_path'] != '/index/gruzoperevozki-cao/' &&
            $value['cpu_path'] != '/glavnaya-stranica/glavnaya/'
        ) {
            echo '<url>
                <loc>https://' . $_SERVER['HTTP_HOST'] . '' . $value['cpu_path'] . '</loc>
            </url>';
        }
    }
}




//        if ($data_module_array['table'] == 'meta') {
//            #Если таблица META то заголовки и теги здесь
//
//            if ($data_module_array['module'] != 'index') {
//                echo '
//                <url>
//                    <loc>https://' . $_SERVER['HTTP_HOST'] . '/' . $data_module_array['module'] . '</loc>
//                </url>';
//
//            }
//
//
//            continue;
//        } else {
//            #Если таблица другая, то считываем теги с той таблицы, по CPU
//            $sql_page = "SELECT
//                            cpu
//                        FROM
//                           " . $data_module_array['table'] . "
//                ";
//            $module_get_page = array();
//            $module_get_page = $db->query($sql_page);
//            if ($module_get_page->rowCount() > 0) {
//                $page_array = $module_get_page->fetchAll();
//                foreach ($page_array as $data_page_array) {
//                    echo '
//                       <url>
//                           <loc>https://' . $_SERVER['HTTP_HOST'] . '/' . $data_module_array['module'] . '/' . $data_page_array['cpu'] . '</loc>
//                       </url>';
//                }
//            }
//        }



$sql = "SELECT cpu_path, public FROM content WHERE public=1";
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    $addit_array2 = $smf->fetchAll(PDO::FETCH_ASSOC);
    foreach ($addit_array2 as $value) {

        if ($value['cpu_path'] != '/index/gruzoperevozki-cao/' &&
            $value['cpu_path'] != '/glavnaya-stranica/glavnaya/'
        ) {
            echo '<url>
                   <loc>https://' . $_SERVER['HTTP_HOST'].$value['cpu_path'] . '</loc>
               </url>';
        }



    }
}


$sql = "SELECT id, parent_id, name, cpu_path FROM pages WHERE public=1 ORDER BY id";
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    $addit_array = $smf->fetchAll(PDO::FETCH_ASSOC);
    foreach ($addit_array as $value) {
        if ($value['cpu_path'] != '/index/gruzoperevozki-cao/' &&
            $value['cpu_path'] != '/glavnaya-stranica/glavnaya/'
        ) {
            echo '<url>
                   <loc>https://' . $_SERVER['HTTP_HOST'] . '' . $value['cpu_path'] . '</loc>
               </url>';
        }
    }
}


?>
</urlset>