<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];
include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';

$sql = "SELECT id, name FROM pages";
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
        update_type($value);
    }
}


function update_type($value)
{
    global $db;
    $type = '';
    if (strpos($value['name'], 'район') !== false) {
        $type = 'район';
    }
    if (strpos($value['name'], 'область') !== false) {
        $type = 'область';
    }
    if ($type != '') {
        $sql = "UPDATE 
                pages 
            SET
                type = '".$type."'
            WHERE 
                id = " . $value['id'] . "
            ";
        $smf = $db->query($sql);
    }
}

?>