<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];
include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';

$sql_table_name = $_REQUEST['sql_table_name'];
$sql_where = $_REQUEST['sql_where'];
$sql_set_filed = $_REQUEST['sql_set_filed'];
$sql_set_value = $_REQUEST['sql_set_value'];

$sql = "UPDATE 
            $sql_table_name 
        SET
            $sql_set_filed = '".$sql_set_value."'
        WHERE 
            $sql_where
        ";
$smf = $db->query($sql);

?>