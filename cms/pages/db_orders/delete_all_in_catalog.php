<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root . "/cms/system/base_connect.php";





mysql_set_charset('utf8',$link_db); 

try {
    $dbh = new PDO('mysql:host='.$db_server.';dbname='.$db_name, $db_login, $db_password, array());
    $dbh->exec("set names utf8");
} catch (PDOException $e) {
   print "Error!: " . $e->getMessage() . "<br/>";
   die();
}


 // Удаляем все данные из категорий
$sql = "TRUNCATE catalog_category";
    $smf = $dbh->query($sql);
    
   $e = $smf;
   
$sql = "TRUNCATE  catalog_in_excel";
$smf = $dbh->query($sql);

$e = $smf;

$sql = "DELETE FROM catalog_category;";
$smf = $dbh->query($sql);

$e = $smf;

$sql = "DELETE FROM catalog_in_excel; ";
$smf = $dbh->query($sql);

$e = $smf;



?>

<h1>Каталог очищен!</h1>