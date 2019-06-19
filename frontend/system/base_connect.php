<?php
	$root = realpath($_SERVER['DOCUMENT_ROOT']);
	
	//Конфигурация
	include_once ($root.'/configuration.php');

        try {
            $db = new PDO('mysql:host='.$databaseConfig->server.';dbname='.$databaseConfig->name, $databaseConfig->login, $databaseConfig->password, array()); //PDO::ATTR_PERSISTENT => true
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("set names utf8");
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }

        //$db = null;
?>