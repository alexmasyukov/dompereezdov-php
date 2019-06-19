<?php

$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root . "/cms/system/base_connect.php";

$filess = $_POST['file_path'];
require_once ('Excel/reader.php');

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');
$data->read($filess);

$html = '';

mysql_set_charset('utf8',$link_db); 

try {
    $dbh = new PDO('mysql:host='.$db_server.';dbname='.$db_name, $db_login, $db_password, array());
    $dbh->exec("set names utf8");
} catch (PDOException $e) {
   print "Error!: " . $e->getMessage() . "<br/>";
   die();
}

// Удаляем все данные и обнуляем AUTO_INCREMENT
$sql = "TRUNCATE price_of_excel";
$smf = $dbh->query($sql);
$e = $smf;
   
$start_row = $_REQUEST['start_row'];
$end_row = $_REQUEST['end_row'];
$start_cols = $_REQUEST['start_cols'];
$end_cols = $_REQUEST['end_cols'];



if (is_numeric($start_row) === false || is_numeric($end_row) === false || is_numeric($start_cols) === false || is_numeric($end_cols) === false) {
    echo '<h3>Ошибка! Проверьте введенные данные!</h3>';
    exit;
}




$now_date = date('d.m.Y');

$html_h3 = '<h3>Синхронизация документа успешно завершена!</h3>'
        . '<h4>Дата обновления документа обновлена на '.$now_date.'</h4>'
        . '</br></br></br>   ';
$html = '<table class="table table-striped table-bordered table-hover table-full-width dataTable">';
for ($row = $start_row; $row <= $end_row ; $row++) {
    for ($col = $start_cols; $col <= $end_cols ; $col++) {
        
        if ($row == $start_row) {
            if ($col == $start_cols) {$html .= '<tr>';};
            $html .= '<th>'.html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][$col]), ENT_QUOTES, 'UTF-8').'</th>';
            if ($col == $end_cols) {$html .= '</tr>';};
        } else {
            if ($col == $start_cols) {$html .= '<tr>';};
            $html .= '<td>'.html_entity_decode(htmlspecialchars_decode($data->sheets[0]['cells'][$row][$col]), ENT_QUOTES, 'UTF-8').'</td>';
            if ($col == $end_cols) {$html .= '</tr>';};
        }
    }  
}

$html .= '</table>';

$sql = " INSERT INTO price_of_excel SET html = '$html', date = '$now_date'; ";
$smf = $dbh->query($sql);
$lastId = $dbh->lastInsertId();
$cat_id = $lastId;
$dbh = null;

echo $html_h3.$html;
?>