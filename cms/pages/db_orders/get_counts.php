<?php
require_once ('Excel/reader.php');

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');
$data->read($excel_file_name);   



$a = 2;
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
    $excel_num = $i;
}


?>