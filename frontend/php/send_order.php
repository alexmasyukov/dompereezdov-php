<?php
$client = $_REQUEST['client'];
$sms = $client['phone'].'\n\r '.implode(", ", $client['apartment']['select_dates']);
$send = array(
    'status' => '',
    'sms' => $sms
);
echo json_encode($send);
?>