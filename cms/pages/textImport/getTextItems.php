<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-06-12
 * Time: 15:09
 */

$text = file_get_contents($uploadedFile);
$textItems = explode('+++++', $text);
$textItemsCount = count($textItems);

if ($textItemsCount > 1) $textItemsCount -= 1;
if (trim($textItems[0]) == '') $textItemsCount = 0;
