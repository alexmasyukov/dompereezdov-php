<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-06-01
 * Time: 14:30
 */


$root = realpath($_SERVER['DOCUMENT_ROOT']);
require $root . '/configuration.php';
require $root . '/core/class.database.inc';
require $root . '/core/class.core.inc';
require $root . '/core/class.page.inc';
require $root . '/core/functions.php';

$log = true;

include 'data/services.php';


function findExistingServices($cpu) {
    foreach ($GLOBALS['services'] as $service) {
        if (trim($cpu) == $service['cpu'] ||
            trim($cpu) == 'rabota-gruzchikom' ||
            trim($cpu) == 'rabota-voditelem' ||
            trim($cpu) == 'pereezd'
            ) {
            return true;
        }
    }
    return false;
}

function checkRaionOrOblastOrMoskva($pageName) {
    if (strpos($pageName, 'район') !== false ||
        strpos($pageName, 'область') !== false ||
        mb_strtolower($pageName) == 'москва'
    ) {
        return true;
    }
    return false;
}



$columns = Database::getColumns('pages');
//Core::log($columns);

$limit = ' LIMIT 10000 ';
$sql = 'SELECT
            *
        FROM
            pages
        WHERE
            cpu <> \'pereezd\'
        ORDER BY
            id
       '.$limit;
$pages = Database::query($sql);


//$idsTable = array(0 => 0);

echo '$pages = array(<br>';
foreach ($pages as $key => &$page) {
    if (findExistingServices($page['cpu'])) {
        $page['pageType'] = 'service';
    } else {
        if (checkRaionOrOblastOrMoskva($page['name'])) {
            $page['pageType'] = 'connected';
        } else {
            $page['pageType'] = 'town';
        }
    }

    echo $page['id'] . ' => array(<br>';
    foreach ($columns as $column) {
        echo "'$column' => '".$page[$column]."',<br>";
    }
    echo "'page_type' => '".$page['pageType']."',<br>";
    echo '),<br>';
}
echo ');';




//Core::log($pages);