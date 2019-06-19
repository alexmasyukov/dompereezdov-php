<?php

$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];
include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';


$text = 'Масюков';

function getXML( $text ){
    # Если не удалось установить сеанс curl
    if( !$ch = curl_init() )
        # Прерываем работу
        return false;

    # Формируем строку GET-запроса
    curl_setopt($ch, CURLOPT_URL, 'http://api.morpher.ru/WebService.asmx/GetXml?s=' . $text);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $result = curl_exec($ch);
    curl_close($ch);

    return simplexml_load_string($result);
}



//$xml = getXML('Сельское_поселение_Кашинское');
//echo $xml->{'П'}.'<br>';
//
//exit;


$sql = "SELECT id, name FROM pages WHERE name NOT LIKE '%     %' AND id BETWEEN 0 AND 5000";
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    $arr = $smf->fetchAll();

    foreach ($arr as $value) {

        if (strpos('     ', $value['name']) === true) {
            continue;
        }

        $text = str_replace(" ", "_", $value['name']);
        $xml = getXML($text);

        $mysql_string = " UPDATE pages SET 
                            p_ro = '".str_replace("_", " ", $xml->{'Р'})."',
                            p_da = '".str_replace("_", " ", $xml->{'Д'})."',
                            p_ve = '".str_replace("_", " ", $xml->{'В'})."',
                            p_tv = '".str_replace("_", " ", $xml->{'Т'})."',
                            p_pr = '".str_replace("_", " ", $xml->{'П'})."' 
                            WHERE id = ".$value['id']."";
        $module_get = $db->query($mysql_string);
        echo $text.' - '.$module_get->rowCount().'<br>';

    }
}




?>