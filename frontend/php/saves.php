<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root . "/frontend/system/base_connect.php";

$sql_table_name = $_POST['name'];
$sql_values = $_POST['values'];
$sql_fields = $_POST['inputs'];

$sql_values = json_decode($sql_values, true);
$sql_fields = json_decode($sql_fields, true);

if ($sql_table_name == 'online_question') {
    $sql_fields[] = 'date_question';
    $sql_values[] = date('Y-m-d');
    
    $sql_fields[] = 'time_question';
    $sql_values[] = date('H:i');
    
    $sql_fields[] = 'public';
    $sql_values[] = '0';
}

$SQL_query_fileds = '';

$SQL_query_fileds = $sql_fields[0] . ', ';
$SQL_query_fileds .= $sql_fields[1];

$x = 1;
while ($x++ < count($sql_fields) - 1) {
    $SQL_query_fileds .= ', ' . $sql_fields[$x];
}

$SQL_query_values = '\'' . htmlentities(addslashes(htmlspecialchars(strip_tags($sql_values[0]))), ENT_QUOTES, 'UTF-8') . '\', ';
$SQL_query_values .= '\'' . htmlentities(addslashes(htmlspecialchars(strip_tags($sql_values[1]))), ENT_QUOTES, 'UTF-8') . '\'';

$x = 1;
while ($x++ < count($sql_values) - 1) {
    $SQL_query_values .= ', \'' . htmlentities(addslashes(htmlspecialchars(strip_tags($sql_values[$x]))), ENT_QUOTES, 'UTF-8') . '\'';
}

$mysql_string = "INSERT INTO $sql_table_name (" . $SQL_query_fileds . ") VALUES (" . $SQL_query_values . ")";
$module_get = $db->query($mysql_string);
$count = $module_get->rowCount();
if ($count > 0) {
    echo '{
        "result":"' . $count . '"
    }';
}


?>