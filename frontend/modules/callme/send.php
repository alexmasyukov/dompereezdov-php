<?php

$root = realpath($_SERVER['DOCUMENT_ROOT']);

//Конфигурация
include_once ($root . '/configuration.php');

//подключение к БД
include_once $root . '/cms/system/base_connect.php';

//подключение ОБЩИХ ФУНКЦИЙ
include_once $root . '/cms/system/functions.php';


$fields_mas = $_POST['fields_mas'];
$title_mas = $_POST['title_mas'];
$values_mas = $_POST['values_mas'];
$site = $_POST['site'];
$form_type = $_POST['form_type'];
$table_name = $_POST['table'];


// Получаем дату и время:
$msg_order_date = date("d.m.y"); // присвоено 03.12.01
$msg_order_time = (date("H") + ($hours_difference_with_Moscow - 1)) . ':' . date("i");


// Проверяем массив со значеними на переменные времени, даты и т.п
for ($str = 0; $str <= count($values_mas); $str++) {
    if ($values_mas[$str] == 'p_date') {
        $values_mas[$str] = $msg_order_date;
    }

    if ($values_mas[$str] == 'p_time') {
        $values_mas[$str] = $msg_order_time;
    }
}

for ($str = 0; $str <= count($fields_mas); $str++) {
    if ($fields_mas[$str] == 'link') {
        if ($values_mas[$str] != '') {
            $values_mas[$str] = '<a href="http://www.' . str_replace(' ', '&nbsp;', $values_mas[$str]) . '" target="_blank">Смотреть</a>';
        }
    }
}



// Сохраняем в БД ----------------------------------------------------------------------------------------------------------------------

$SQL_query_fileds = '';

$SQL_query_fileds = $fields_mas[0] . ', ';
$SQL_query_fileds .= $fields_mas[1];

$x = 1;
while ($x++ < count($fields_mas) - 1) {
    $SQL_query_fileds .= ', ' . $fields_mas[$x];
}

$SQL_query_values = '\'' . htmlspecialchars($values_mas[0]) . '\', ';
$SQL_query_values .= '\'' . htmlspecialchars($values_mas[1]) . '\'';

$x = 1;
while ($x++ < count($values_mas) - 1) {
    $SQL_query_values .= ', \'' . htmlspecialchars($values_mas[$x]) . '\'';
}


$mysql_string = "INSERT INTO $table_name (" . $SQL_query_fileds . ") VALUES (" . $SQL_query_values . ")";
$get = mysql_query($mysql_string);






// Отправляем на почту -----------------------------------------------------------------------------------------------------------------

$List_values = '';

for ($i = 0; $i <= count($values_mas); $i++) {
    $List_values .= '<tr style="border: 1px dashed #ddd;">
			<td style="width: 250px;">' . $title_mas[$i] . '</td>
			<td>' . $values_mas[$i] . '</td>
		</tr>';
}

$subject_to_the_owner = $form_type;
// Сообщение ВЛАДЕЛЬЦУ сайта:
$message_to_the_owner = "
		<b>Здравствуйте!<br/>
		$form_type с &laquo;$site&raquo;<br/>
		<br/>
		Заявка сформирована: <b>$msg_order_time</b> по Читинскому времени, 
		<b>$msg_order_date</b>.<br/>
		<br/>
		<table>
			$List_values
		</table>
	";


// Дополнительные параметры:
$mailheaders = "From: $name_organization_for_mail <$mail_organization> \r\n";
$mailheaders .= "Reply-To: $mail_organization \r\n";
$mailheaders .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$mailheaders .= "Content-Type: text/html; charset=\"windows-1251\"";

$subject_to_the_owner = iconv("utf-8", "windows-1251", $subject_to_the_owner);
$message_to_the_owner = iconv("utf-8", "windows-1251", $message_to_the_owner);
$mailheaders = iconv("utf-8", "windows-1251", $mailheaders);

for ($i = 0; $i <= count($mail_array) - 1; $i++) {
    $result = mail($mail_array[$i], $subject_to_the_owner, $message_to_the_owner, $mailheaders);
}

echo '{
			"result":"' . $result . '"
		}';
?>