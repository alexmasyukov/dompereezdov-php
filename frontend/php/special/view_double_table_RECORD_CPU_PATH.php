<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];
include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';

$table = '<table>';

$sql = "SELECT id, parent_id, name, cpu   FROM pages ORDER BY name"; // WHERE count > 200 AND public=1
$smf = $db->query($sql);
if ($smf->rowCount() > 0) {
    $addit_array = $smf->fetchAll(PDO::FETCH_ASSOC);

    $pages = array();
    foreach ($addit_array as $value) { //Обходим массив
        $pages[$value['id']] = $value;
    }


    $prev_name = '';

    foreach ($addit_array as $row) {
        if (strtolower($row["name"])   == strtolower($prev_name)) {
            $class = 'double';
        } else {
            $class = '';
        }

        $table .= '<tr>';
        $table .= '<td>' . $row["id"] . '</td>';
        $table .= '<td class="' . $class . '">' . $row["name"] . '</td>';
        $table .= '<td>' . outTree_names($row["id"]) . '</td>';

        $path = outTree_cpu_path($row["id"]) .'/';
        $table .= '<td>' . $path . '</td>';
        $table .= '</tr>';

        update_cpu_paths($row["id"], $path);

        $prev_name = $row["name"];
    }
}

$table .= '</table>';

echo $table;


function update_cpu_paths($id, $path) {
    global $db;
    $mysql_string = "UPDATE pages SET
                        cpu_path = '".$path."'
                        WHERE id = $id";
    $module_get = $db->query($mysql_string);
}


function outTree_names($id)
{
    global $pages;
    $name = $pages[$id]['name'];
    $parent_id = $pages[$id]['parent_id'];
    if ($parent_id != '' && $parent_id >= 0 && $name != '') {
        $find_child = outTree_names($parent_id);
        if ($find_child != '') {
            $names_path = $find_child . '/' . $name;
        } else {
            $names_path = $name;
        }
    }
    return $names_path;
}


function outTree_cpu_path($id)
{
    global $pages;
    $cpu = $pages[$id]['cpu'];
    $parent_id = $pages[$id]['parent_id'];
    if ($parent_id != '' && $parent_id >= 0 && $cpu != '') {
        $find_child = outTree_cpu_path($parent_id);
        if ($find_child != '') {
            $cpu_path = $find_child . '/' . $cpu;
        } else {
            $cpu_path = '/'.$cpu;
        }
    }
    return $cpu_path;
}


?>


<style>
    table {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
        border-bottom: 1px solid #E5E5E5;
        border-top: 1px solid #E5E5E5;
        margin-bottom: 20px;
    }

    table td {
        padding: 8px 10px;
        border-right: 1px solid #E5E5E5;
    }

    table tr:hover {
        background-color: #E6E5FF;
    }

    table th {
        padding: 8px 5px;
        color: #1f1f1f;
        text-align: left;
        border-right: 1px solid #E5E5E5;
        font-weight: normal;
        background: #efefef;
    }

    table tr {
        border-left: 1px solid #E5E5E5;
        border-top: 1px solid #E5E5E5;
    }
    
    td.double {
        background: #FFB6C1;
    }

</style>
