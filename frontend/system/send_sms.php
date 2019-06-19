<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);

include_once $root . "/configuration.php";

$client = $_REQUEST['client'];
$phone = $client['phone'];
$company_name = $client['company_name'];

$vowels = array("+", " ", "  ", "    ", "(", ")", "-", "_");
$phone = str_replace($vowels, "",$phone);

$status = 'Заявка +'.$phone.' / '.date("d.m.y H:i");

include 'atomspark_api/config.php';
include 'atomspark_api/Addressbook.php';
include 'atomspark_api/Exceptions.php';
include 'atomspark_api/Account.php';
include 'atomspark_api/Stat.php';

$Gateway=new APISMS($sms_key_private,$sms_key_public,
                    'http://api.myatompark.com/sms/');
$Addressbook=new Addressbook($Gateway);
$Exceptions=new Exceptions($Gateway);
$Account=new Account($Gateway);
$Stat = new Stat ($Gateway);

$res = $Stat->sendSMS("PerGruz",$status, $phone_to_sms, "", 0);

if (isset($res["result"]["error"])) {
    echo '{
        "status":" Ошибка ' . $res["result"]["code"] . ' !"
    }';
} else {
     echo '{
        "status": "ok"
    }';
}


?>


