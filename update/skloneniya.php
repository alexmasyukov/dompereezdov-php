<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-06-10
 * Time: 14:58
 */

$pages = array(
    array('name_with_type' => 'город Ногинск', 'name' => 'Ногинск')
);

echo '<table>';
foreach ($pages as $page) {
    echo '<tr>';

    echo '<td>' . $page['name'] . '</td>';
    echo '<td>' . $page['name_with_type'] . '</td>';

    echo getPadeji($page['name']);
    echo getPadeji($page['name_with_type']);

    echo '</tr>';

}
echo '</table>';


function getPadeji($name) {
    $html = '';

    $name = str_replace(' ', '%20', $name);
    $result = file_get_contents('https://ws3.morpher.ru/russian/declension?s='.$name.'&format=json');
// Таким будет результат
    //    $result = '{
//          "Р": "Соединенного королевства",
//          "Д": "Соединенному королевству",
//          "В": "Соединенное королевство",
//          "Т": "Соединенным королевством",
//          "П": "Соединенном королевстве",
//          "множественное": {   ------------------ это исключаем !is_array
//            "И": "Соединенные королевства",
//            "Р": "Соединенных королевств",
//            "Д": "Соединенным королевствам",
//            "В": "Соединенные королевства",
//            "Т": "Соединенными королевствами",
//            "П": "Соединенных королевствах"
//          }
//        }';
    $result = json_decode($result, true);
    foreach ($result as $key => $item) {
        if (!is_array($item)) $html .= '<td>' . $item . '</td>';
    }
    return $html;
}


?>

<style>
    table td {
        border: 1px solid #777;
    }
</style>
