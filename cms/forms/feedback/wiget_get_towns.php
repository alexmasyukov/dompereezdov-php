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
            AND public=1
            AND parent_id < 10000
            AND id < 10000
        ORDER BY 
            name";
$pages = Database::query($sql);
foreach ($pages as $page) {
    echo '<option value="' . $page["id"] . '">' . trim($page["name"]) . '</option>';
}


$sql = "SELECT 
            id, 
            parent_id, 
            town_start_admin_name as name, 
            page_type
        FROM 
            pages
        WHERE
            page_type <> 'service'
            AND  type <> 'raion'
            AND type <> 'okrug'
            AND public=1
            AND parent_id >= 10000
            OR parent_id = 0
            AND id >= 10000 
        ORDER BY 
            id";
$pages = Database::query($sql);
foreach ($pages as $page) {
    echo '<option value="' . $page["id"] . '">' . trim($page["name"]) . '</option>';
}