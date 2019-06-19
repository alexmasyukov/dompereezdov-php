<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);


include_once $root . '/cms/system/base_connect.php';
//
// Авторизация.
//
$auth_errors = '';

function Login($username, $password, $remember) {
    global $auth_errors; //Для того что-бы использовать вышеобъявленную переменную в массиве
    // Имя не должно быть пустой строкой.
    if ($username == "") {
        $auth_errors = '<h4 class="form-title" style="text-align: center; color: #FFEFD5;"><i class="fa fa-warning" style="font-size: 18px;"></i>&nbsp;Неверный логин или пароль!</h4>';
        return false;
    } else {
        // Проверяем пользователя в MySQL
        $user_true = mysql_query("select * from users WHERE login='" . $username . "' and pass='" . md5($password) . "'");

        while ($row = mysql_fetch_assoc($user_true)) { //Получаем результаты запроса
            $id = $row['id'];
            $name = $row['name'];
        }

        if ($id == '' && $name == '') {
            $auth_errors = '<h4 class="form-title" style="text-align: center; color: #FFEFD5;"><i class="fa fa-warning" style="font-size: 18px;"></i>&nbsp;Неверный логин или пароль!</h4>';
        } else {
            // Запоминаем имя в
            $_SESSION["username"] = $username;
            //echo $_SESSION["username"];
            // и в cookies, если пользователь пожелал запомнить его (на неделю).
            if ($remember) {
                setcookie("username");
                // Успешная авторизация.
            };
            return true;
        }
    }
}


//
// Сброс авторизации.
//
function Logout() {
    // Делаем cookies
    setcookie("username");
    // Сброс сессии.
    unset($_SESSION["username"]);
}


//
// Точка входа.
//
session_start();
$enter_site = false;
// Попадая на страницу login.php, авторизация сбрасывается.
Logout();
// Если массив POST не пуст, значит, обрабатываем отправку формы.
if (count($_POST) > 0)
    $enter_site = Login($_POST["username"], $_POST["password"], $_POST["remember"]);
// Переадресуем авторизованного пользователя на одну из страниц сайта.
if ($enter_site) {
    header("Location: /cms/admin.php?link=admin");
    exit();
}


// Подключаем форму авторизации
include_once $root . '/cms/system/forms/login_form.php';

?>


<!--
<html>
	<head>
	<meta charset="utf-8" />
	<title>Аксиома.CMS - Система управления сайтом</title>
        <link href="../template/css/crmcss.css" rel="stylesheet">
	</head>
<body>
    <div class="login_forma">
        <a href="http://www.axioma5.ru"><img src="/cms/template/images/logo.gif" style="margin-left: 14px;"/></a>
        <br/>
       
        <form action="" method="post">
        Логин:
        <br/>
            <input class="edit" type="text" name="username" />
        <br/>
        Пароль:
        <br/>
            <input class="edit" type="password" name="userpass" />
        <br/>
        <input class="checks" type="checkbox" name="remember" checked/> Запомнить меня
        <br/><br/>
        <center><input class="but" type="submit" value="Войти" /></center>
        </form>
    </div>
    <br><br>
    <center><a href="/" style="color: gray;"/>Вернуться на сайт</a></center>
</body>
</html>
-->
