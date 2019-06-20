<?php
/* ---------- Конфигурация ------------- */

$db_server = 'localhost';
$db_login = 'root';
$db_password = 'root';
$db_name = 'dp';

//$db_server = 'localhost';
//$db_login = 'u0339017_default';
//$db_password = '6d3!K8jk';
//$db_name = 'u0339017_default';
//
$databaseConfig = (object)array(
    'server' => 'localhost',
    'name' => 'dp',
    'login' => 'root',
    'password' => 'root'
);
//
//$databaseConfig = (object)array(
//    'server' => 'localhost',
//    'name' => 'u0339017_default',
//    'login' => 'u0339017_default',
//    'password' => '6d3!K8jk'
//);


// Отправка зявкок
$company_name = 'Дом Переездов';
$company_www = 'https://dompereezdov.ru/';
$mail_array = array('alienspro2008@yandex.ru', 'transport@dompereezdov.ru');
$name_organization_for_mail = '';
$mail_organization = 'noreply@dompereezdov.ru';
$otdel_name = '';
$phone_to_sms = '';

$phones = (object)array(
    'phone1' => (object)array(
        'text' => '+7 (926) 803-35-30',
        'number' => '+79268033530'
    ),
    'phone2' => (object)array(
        'text' => '+7 (495) 978-78-09',
        'number' => '+74959787809'
    ),
    'phone3' => (object)array(
        'text' => '+7 (499) 408-59-20',
        'number' => '+74994085920'
    ),
    'phone4' => (object)array(
        'text' => '+7 (926) 792-01-05',
        'number' => '+79267920105'
    ),
);

$reviewLimitOnPage = 15;
$reviewLimitOnLeftBlock = 3;


$hours_difference_with_Moscow = 6; // Смещение ЧП относительно Москвы
$limit_reviews_in_wigets = 2;
$clients_reviews_limit = 50;