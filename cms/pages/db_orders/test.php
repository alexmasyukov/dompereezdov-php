<?php


$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root . "/cms/system/base_connect.php";



$catalog_file = $_REQUEST["catalog_file"];
require_once ('Excel/reader.php');


$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');
$data->read($root . '/cms/pages/db_orders/new.xls');

//echo '<pre>';
//print_r($data->sheets);


$html = '<table border="1">';
for ($row = 1; $row <= $data->sheets[0]['numRows']; $row++) {
    $html_row = '<tr>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][1]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][2]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][3]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][4]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][5]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][6]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][7]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][8]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][9]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '<td>' . html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][10]), ENT_QUOTES, 'UTF-8') . '</td>';
    $html_row .= '</tr>';
 
    $datas = '';
    for ($col = 1; $col <= 50; $col++) {
        $datas .= trim($data->sheets[0]['cells'][$row][$col]);
    }
    if ($datas <> '') {
        $html .= $html_row;
    }
}
$html .= '</table>';
echo $html;
?>


<style>
    table { 
        width: 100%; /* Ширина таблицы */
        border: 1px double #ddd; /* Рамка вокруг таблицы */
        border-collapse: collapse; /* Отображать только одинарные линии */
    }
    th { 
        text-align: left; /* Выравнивание по левому краю */
        background: #ccc; /* Цвет фона ячеек */
        padding: 5px; /* Поля вокруг содержимого ячеек */
        border: 1px solid #ddd; /* Граница вокруг ячеек */
    }
    td { 
        padding: 5px; /* Поля вокруг содержимого ячеек */
        border: 1px solid #ddd; /* Граница вокруг ячеек */
    }
</style>