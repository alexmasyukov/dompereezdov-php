<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-04-08
 * Time: 12:11
 */


$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];


include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';


//$db->query('create table new_pages like pages');
//exit;


$db->query('TRUNCATE TABLE new_pages');


$fields = getFiledNames();


$sql = "SELECT
            *
        FROM
            pages
        ";
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    foreach ($smf->fetchAll() as $item) {
        addToDB($item);
    }
}

function addToDB($item) {
    global $db, $fields;

    $sql = "INSERT INTO new_pages
                    SELECT 
                        $fields
                    FROM pages WHERE id = " . $item['id'];
    echo $sql;
    $db->query($sql);
}


function getFiledNames() {
    global $db;
    $smf = $db->query("SELECT * FROM pages LIMIT 1");
    $item = $smf->fetchAll(PDO::FETCH_ASSOC)[0];
//    $keys = array_splice(array_keys($item), 1);
    $keys = array_keys($item);
    return implode($keys, ', ');
}