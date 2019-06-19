<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];
include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';


$sql = "SELECT id, parent_id, name FROM pages "; //WHERE public=1
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    $addit_array = $smf->fetchAll(PDO::FETCH_ASSOC);
    $pages = array();
    foreach ($addit_array as $value) { //Обходим массив
        $pages[$value['id']] = $value;
    }
    foreach ($addit_array as $row) {
        if (strpos($row["name"], '      ') !== false) {
            $path = outTree_names($row["parent_id"]);
            $path = str_replace('/'.$row["name"], '', $path);
            $row["name"] = mb_ucfirst(str_replace(' ', '', $row["name"]));
            update_admin_name($row['id'], $pages[$row["parent_id"]]['name'].' - '.trim($row["name"]).'   ('.$path.')');
        } else {
            $path = outTree_names($row["id"]);
            $path = str_replace('/'.$row["name"], '', $path);
            update_admin_name($row['id'], trim($row["name"]).' - Транспортные услуги ('.$path.')');
        }
    }
}


function update_admin_name($id, $text) {
    global $db;
    $sql = "UPDATE 
                pages 
            SET
                admin_name = '".$text."'
            WHERE 
                id = " . $id . "
            ";
    $smf = $db->query($sql);
}


function outTree_names($id)
{
    global $pages;
    $name = $pages[$id]['name'];
    $parent_id = $pages[$id]['parent_id'];
    if ($parent_id != '' && $parent_id >= 0 && $name != '') {
        $find_child = outTree_names($parent_id);
        if ($find_child != '') {
            $names_path = $find_child . '/' . $name;
        } else {
            $names_path = $name;
        }
    }
    return $names_path;
}
?>