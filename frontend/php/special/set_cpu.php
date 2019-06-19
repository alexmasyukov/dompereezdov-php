<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];
include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';

$sql = "SELECT id, name FROM pages";
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
        echo $value['name'].'<br>';
        update_cpu($value);
    }
}


function update_cpu($value) {
    $value['name'] = str_replace(['Требуются водители', 'Требуются грузчики','переезды'], ['работа водителем','работа грузчиком','переезд'],  $value['name']);

    global $db;
    $sql = "UPDATE 
                pages 
            SET
                cpu = '".str2url($value['name'])."'
            WHERE id = ".$value['id']."
            ";
    $smf = $db->query($sql);
}

?>