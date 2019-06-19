<?php
/**
 * проверяем, что функция mb_ucfirst не объявлена
 * и включено расширение mbstring (Multibyte String Functions)
 */


$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server =  $_SERVER['HTTP_HOST'];
include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';



$id = $_REQUEST['id'];

$smf = $db->query("SELECT id, parent_id, name FROM catalog_category");
if ($smf->rowCount() > 0) {
    $array = $smf->fetchAll(PDO::FETCH_ASSOC);
}

$path_gl = '';
function get_path($id, $path) {
    global $path_gl;
    $cat = get_name_cat($id);
    //print_r($cat);
    if ($cat[1] != 0) {
        $path .= $cat[0];
        get_path($cat[1], $path);
    } else {
        $path .= $cat[0];
        $path_gl =  substr($path, 0, strlen($path)-2);
    }
}
get_path($id, '');
echo $path_gl;

function get_name_cat($id) {
    global $array;
    foreach ($array as $value) {
        if ($value['id'] == $id) {
            return  array($value['name']. ' - ', $value['parent_id']);
            break;
        }
    }
}

?>