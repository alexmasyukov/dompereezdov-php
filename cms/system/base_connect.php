<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);

//Конфигурация
include_once($root . '/configuration.php');


//	// Подключение к БД
$link_db = @mysql_connect($databaseConfig->server, $databaseConfig->login, $databaseConfig->password) or die('Нет связи с сервером баз данных');
mysql_select_db($databaseConfig->name) or die('Нет базы данных!');
mysql_set_charset('utf8', $link_db);

try {
    $db = new PDO('mysql:host=' . $databaseConfig->server . ';dbname=' . $databaseConfig->name, $databaseConfig->login, $databaseConfig->password, array()); // Постоянное соединение PDO::ATTR_PERSISTENT => true
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("set names utf8");
} catch (PDOException $e) {
    echo $e->getMessage();
}

