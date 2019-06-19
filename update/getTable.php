<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-04-08
 * Time: 10:13
 */
//
//date_default_timezone_set("Pacific/Palau");
//
//ini_set('error_reporting', E_ALL & ~E_NOTICE);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];


include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';


$sql = "SELECT
            *
        FROM
            pages
        ";
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    echo '<table>
        <thead>
        <th>id</th>
        <th>name</th>
        <th>p_ro</th>
        <th>p_da</th>
        <th>p_ve</th>
        <th>p_tv</th>
        <th>p_pr</th>
        </thead>


';

    foreach ($smf->fetchAll() as $value) {
//        echo '"'.substr($value['name'], 1, 1).'"';
//        if (substr($value['name'], 1, 1) == "�") continue;
        if ($value['p_ro'] == "") continue;
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['name'] . '</td>';
        echo '<td>' . $value['p_ro'] . '</td>';
        echo '<td>' . $value['p_da'] . '</td>';
        echo '<td>' . $value['p_ve'] . '</td>';
        echo '<td>' . $value['p_tv'] . '</td>';
        echo '<td>' . $value['p_pr'] . '</td>';
        echo '</tr>';
        //        echo '<td></td>'
        //        echo '<td></td>'
        //         = trim(html_entity_decode(htmlspecialchars_decode($value['title']), ENT_QUOTES, 'UTF-8'));
        //        $page['text'] = trim(html_entity_decode(htmlspecialchars_decode($value['description']), ENT_QUOTES, 'UTF-8'));
    }
    echo '</table>';
}
?>

<style>
    thead {
        text-align: left;
    }
</style>

