<?php 
    $root = realpath($_SERVER['DOCUMENT_ROOT']);
    include_once $root."/cms/system/base_connect.php";
	
    // Проверка авторизации пользователя
    include_once $root."/cms/autorization.php";
	
    // Принимаем переменную идентификатора в базе
    $sql_table_name = $_REQUEST['sql_table_name']; 	
    $sql_query = $_POST['sql_query'];
    
    $test= '';
    if ($sql_query == '') { exit;};
    
    foreach ($sql_query as $value) {
        $res = $db->query($value);
        $test .= '1';
    }
    
    echo '{
            "result":"'.$test.'"
    }';
    
   
?>
