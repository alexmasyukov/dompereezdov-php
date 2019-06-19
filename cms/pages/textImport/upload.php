<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);

// Проверка авторизации пользователя
include_once $root . '/cms/autorization.php';

//Конфигурация
include_once $root . '/configuration.php';


if (isset ($_POST['images_path'])) {
    $images_path = $_POST['images_path'];
}

if (empty($_FILES['fileupload']['name'])) {
    echo json_encode(array(
        'error' => '',
        'file' => '',
        'msg' => 'cancel',
    ));
    exit;
}

$extension = strtolower(substr(strrchr($_FILES['fileupload']['name'], '.'), 1));

if ($extension <> 'txt') {
    echo json_encode(array(
        'error' => '',
        'file' => '',
        'msg' => 'format',
    ));

    exit;
}

$error = "";
$msg = "";
$fileElementName = 'fileupload';
if (!empty($_FILES[$fileElementName]['error'])) {
    switch ($_FILES[$fileElementName]['error']) {

        case '1':
            $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            break;
        case '2':
            $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            break;
        case '3':
            $error = 'The uploaded file was only partially uploaded';
            break;
        case '4':
            $error = 'Файл для загрузки не выбран!';
            break;

        case '6':
            $error = 'Missing a temporary folder';
            break;
        case '7':
            $error = 'Failed to write file to disk';
            break;
        case '8':
            $error = 'File upload stopped by extension';
            break;
        case '999':
        default:
            $error = 'No error code avaiable';
    }
} elseif (empty($_FILES['fileupload']['tmp_name']) || $_FILES['fileupload']['tmp_name'] == 'none') {
    $error = 'No file was uploaded..';
} else {
    $msg .= " File Name: " . $_FILES['fileupload']['name'] . ", ";
    $msg .= " File Size: " . @filesize($_FILES['fileupload']['tmp_name']);


    //$folder =  '../../../images/my_works_images/';

//    $folder = '../../../uploads/' . $images_path;
    $folder = $root . '/uploads/';

    $extension = strtolower(substr(strrchr($_FILES['fileupload']['name'], '.'), 1));

    $filename1 = md5(microtime()) . rand(0, 99999);


    $uploadedFile = $folder . $filename1 . "." . $extension;


    /* Загрузка файла СТАНДАРТНЫМ ДЛЯ СКРИПТА СПОСОБОМ! */
    if (is_uploaded_file($_FILES['fileupload']['tmp_name'])) {

        /* ИМЕННО ОНА!  */
        if (move_uploaded_file($_FILES['fileupload']['tmp_name'], $uploadedFile)) {
            $msg .= 'Успешно сохранён';
        }


        //		//ПОДКЛЮЧАЕМ ФУНКЦИЮ РЕСАЙЗ
        //		require $root.'/cms/system/resizer/imgresize.php';
        //
        //				if (img_resize($_FILES['fileupload']['tmp_name'], $folder.$filename1.".".$extension, $big_img_width, $big_img_height)) {
        //							$big_img .=$folder.$filename1.".".$extension; // Создание большого изображения прошло успешно
        //						} else {
        //							$big_img .='NO';
        //						};
        //
        //				if (img_resize($_FILES['fileupload']['tmp_name'], $folder.$filename1."_small.".$extension, $small_img_width, $small_img_height)) {
        //						$small_img .=$folder.$filename1."_small.".$extension; // Создание малого изображения прошло успешно
        //					} else {
        //						$small_img .='NO';
        //					};
        //
        //

        //}
        /* Перемещение файла */

        // Делаем 2 изображения - 1 стандартное, 2 - уменьшенное

        //        $excel_file_name = $uploadedFile;

                include_once($root . "/cms/pages/textImport/getTextItems.php");


        //for security reason, we force to remove all uploaded file
        @unlink($_FILES['fileupload']);
    }
}

echo json_encode(array(
    'error' => $error,
    'file' => $uploadedFile,
    'textItemsCount' => $textItemsCount,
    'msg' => $msg
));