<?php
	$root = realpath($_SERVER['DOCUMENT_ROOT']);
	
	//Конфигурация
	include_once ($root.'/configuration.php');
	
	//подключение к БД
	include_once $root.'/cms/include/base_connect.php';
	
	//подключение ОБЩИХ ФУНКЦИЙ
	include_once $root.'/cms/include/functions.php';
	
	
	$table_name_sql = $_REQUEST['table_name_sql']; 
	$where = $_REQUEST['where']; 
	
	if ($where!='') {
		$where = ' WHERE '.$where;
	}

	$mysql_string = 'select id from '.$table_name_sql.' '.$where.';';
	
	$result = '';
	$get=mysql_query($mysql_string);
	$count = mysql_num_rows($get);

	echo '{
			"count":"'.$count.'"
		}';
?>