<?php
    session_start();
    // Если в контексте сессии не установлено имя пользователя, пытаемся взять его
    // из cookies.
    if (!isset($_SESSION["username"]) && isset($_COOKIE["username"])) {
        $_SESSION["username"] = $_COOKIE["username"]; 
    }
    // Еще раз ищем имя пользователя в контексте сессии.
    $username = null;
    if (!empty($_SESSION["username"])) {
        $username = $_SESSION["username"];
    }


// Неавторизованных пользователей отправляем на страницу авторизации.
   if ($username == null) {
       header("Location: login.php");
       exit();
   }
?>