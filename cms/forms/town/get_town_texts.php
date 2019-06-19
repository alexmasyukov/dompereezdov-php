<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];
include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';


$smf = $db->query($wiget_sql);
if ($smf->rowCount() > 0) {
    while($value = $smf->fetchAll(PDO::FETCH_ASSOC)) {
       return $value;
    }
}
?>