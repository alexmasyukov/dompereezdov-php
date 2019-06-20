<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-06-12
 * Time: 15:26
 */

$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root.'/configuration.php';
include_once $root.'/cms/pages/textImport/textDirections.php';
include_once $root.'/core/class.core.inc';
include_once $root.'/core/class.database.inc';

$log = true;

$file = $_REQUEST['file'];
$textDirectionRequest = $_REQUEST['textDirection'];
$textPositionRequest = $_REQUEST['textPosition'];
$direction = $textDirections[$textDirectionRequest];


if (empty($direction->pagesId)) {
    $pagesId = Database::query($direction->sql, 'column');
} else {
    $pagesId = [$direction->pagesId];
}



$text = file_get_contents($file);
$textItems = explode('+++++', $text);
$textItemsCount = count($textItems);

if (count($pagesId) > $textItemsCount) {
    echo '<p style="color: red">Количество страниц больше чем текстов в файле! Некоторые страницы будут без текста!</p>';
}

setUnpublicTextsByPagesIds($pagesId);
recordTextsToPages($pagesId, $textItems, $textPositionRequest);

echo '<p style="color: green">Обработано страниц: '.count($pagesId).'</p><br><br>';

Core::log(implode(', ', (array)$pagesId));
Core::log($direction);


function recordTextsToPages($pagesId, $texts, $textPosition) {
    foreach ($pagesId as $key => $pageId) {
        $text = '';
        if (!empty($texts[$key])) $text = $texts[$key];

        $text = mb_convert_encoding($text,  "UTF-8", "windows-1251");

        $updateSQL = "UPDATE pages_texts SET $textPosition = '".Core::charsEncode($text)."'
                            WHERE page_id = $pageId";

        $insertSQL = "INSERT INTO pages_texts (page_id, $textPosition)
                            VALUES ($pageId, '".Core::charsEncode($text)."')";

//        echo $updateSQL.'<br/>';

        $result = Database::query($updateSQL, 'asResult');

        if ($result->rowCount() == 0) {
//            echo $insertSQL . '<br/>';
            Database::query($insertSQL, 'asResult');
        } else {
//            echo $updateSQL.'<br/>';
        }

        setPublicPage($pageId);
    }
}


function setUnpublicTextsByPagesIds($pagesIds) {
    $sql = 'UPDATE pages SET public = 0 WHERE id IN ('.implode(',', (array)$pagesIds).')';
    Database::query($sql, 'asResult');
}

function setPublicPage($id) {
    $sql = "UPDATE pages SET public = 1 WHERE id = $id";
    Database::query($sql, 'asResult');
}




//echo $file. ' ' . $textDirectionRequest . ' ' . $textPositionRequest . ' ' . $textItemsCount;

/**
 *
 * Москва
 * Московская область
 *
 *      округ
 *      район
 *      населенный пункт
 *
 *          Услуга
 *          сам нас. пункт
 *
 *              верхний текст
 *              нижний текст
 *
 *
 *
 *
 *
 */



