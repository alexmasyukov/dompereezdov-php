<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];

$root = realpath($_SERVER['DOCUMENT_ROOT']);
require $root . '/configuration.php';
require $root . '/core/class.core.inc';
require $root . '/core/class.database.inc';

$log = true;
$sql = "SELECT 
            id, 
            parent_id, 
            town_start_admin_name as name, 
            page_type
        FROM 
            pages
        WHERE
            page_type <> 'service'
          
        ORDER BY 
            name"; //WHERE public=1
$pages = Database::query($sql, 'withCount');
if ($pages->rowCount > 0) {
    foreach ($pages->result as &$page) {
        //            if ($select_town != '' && $select_town == $page["id"]) {
        //                $selected = ' selected ';
        //            } else {
        //                $selected = '';
        //            }

        $selected = '';
        echo '<option value="' . $page["id"] . '" ' . $selected . '>' . trim($page["name"]) . '</option>';
    }
}