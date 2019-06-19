<?php
    $root = realpath($_SERVER['DOCUMENT_ROOT']);
    // Проверка авторизации пользователя
    include_once $root."/cms/autorization.php";
    
    $path = $_REQUEST['path']; 
    $run = @unlink($root . str_replace('../../../', '/', $path));
    echo '{
        "result":"' . $run . '"
    }';
?>