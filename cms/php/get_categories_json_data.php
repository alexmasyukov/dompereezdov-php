<?php

$root = realpath($_SERVER['DOCUMENT_ROOT']);
include_once $root . "/cms/system/base_connect.php";

function get_categories_json_data(
$sql_table_categories, $edit_categories = false, $select_parent_id = false, $edit_form, $sql_images_table_name, $sql_images_table_id_title, $sql_features_table_name, $sql_features_table_id_title, $sql_table_id_title, $data_id = false
) {

    global $db;

    $categories_sys = $db->query("SELECT * FROM $sql_table_categories ORDER BY sort, parent_id DESC;");
    $count = $categories_sys->rowCount();
    if ($count == 0) {
        if ($select_parent_id == false) {
            return "Нет категорий";
        } else {
            return '<li id="test0" data-id-number="0">'
                . '<input id="product_category_id0" name="cat_radio" value="0" style="margin-left: 0px;" data-massive-element-type="radio" data-table-field="' . $sql_table_id_title . '" type="radio" checked>' .
                'НЕТ</li>';
        }
        
    };
    while ($array = $categories_sys->fetch(PDO::FETCH_ASSOC)) {
        $rs[] = $array;
    }

    $str2 = '';

    $rs2 = array();
    foreach ($rs as $row) {
        $rs2[$row['parent_id']][] = $row;
    }

    function RecursiveTree2(
    &$rs, $parent, $edit_html, $radio_html, $edit_form2, $sql_table_categories2, $sql_images_table_name, $sql_images_table_id_title, $sql_features_table_name, $sql_features_table_id_title, $sql_table_id_title, $data_id
    ) {


        $out = array();
        if (!isset($rs[$parent])) {
            return $out;
        }
        foreach ($rs[$parent] as $row) {
            $chidls = RecursiveTree2(
                    $rs, $row['id'], $edit_html, $radio_html, $edit_form2, $sql_table_categories2, $sql_images_table_name, $sql_images_table_id_title, $sql_features_table_name, $sql_features_table_id_title, $sql_table_id_title, $data_id
            );
            if ($chidls) {
                $row['childs'] = $chidls;
                $chd = ' <ul class="down_box visual_ul_' . $row['id'] . '" > ' . $chidls . ' </ul></li>'; //Чтобы категории изначально ЗАКРЫТЫ добавить style="display: none;"
            } else {
                $chd = '</li>';
            }
            $test = $row;



            // Если включен выбор РОДИТЕЛЬСКОЙ КАТЕГОРИИ
            if ($radio_html == true) {
                $radio_all_buttons_html = '<input name="cat_radio" value="' . $row['id'] . '" style="margin-left: 0px;" data-massive-element-type="radio" data-table-field="' . $sql_table_id_title . '" id="product_category_id' . $row['id'] . '" type="radio">';
                if ($row['id'] == $_GET['id']) {
                    $radio_all_buttons_html = ''; //<span style="width: 27px; display: table; height: 10px; float: left;"></span>
                    $this_real_id_style = ' style="color: #E02222; opacity: 0.4;" ';
                    $this_real_id_text = '<span style=" font-size: 13px;"> &nbsp;&nbsp;&nbsp;(Вы сейчас редактируете)</span>';
                } else {
                    $this_real_id_style = '';
                    $this_real_id_text = '';
                }
            } else
                $radio_all_buttons_html = '';


            // Если включена кнопка РЕДАКТРИРОВАНИЕ КАТЕГОРИИ
            if ($edit_html == true) {
                $edit_buttons_html = ''.
                        '<a class="btn default  btn-xs green catalog_edit_category_but" href="admin.php?' .
                        'link=' . $edit_form2 .
                        '&id=' . $row['id'] .
                        '&sql_table=' . $sql_table_categories2 .
                        '&sql_images_table_name=' . $sql_images_table_name .
                        '&sql_images_table_id_title=' . $sql_images_table_id_title .
                        '&sql_features_table_name=' . $sql_features_table_name .
                        '&sql_features_table_id_title=' . $sql_features_table_id_title .
                        '" alt="Изменить" title="Изменить"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;'.
                        '<a class="btn default  btn-xs red catalog_delete_category_but" alt="Удалить"' .
                        ' onclick="delete_category(\''.$sql_table_categories2.'\','.$row['id'].')"><i class="fa fa-times"></i></a>' .

                $hide_up_down_but = ''; //
            } else {
                $edit_buttons_html = '';
                $hide_up_down_but = ' style="display:none;" '; //Скрываем кнопки сортировки (вверх, вниз)
            }

            // Если нужно вывести пустую ссылку и data отрибут с id элемента 
            // (используется в модуле Меню, при выборе категории)
            if ($data_id == true) {
                $href_data_option_start = '<a class="dash_link set_categories" href="#" onclick="set_menu_link(this, ' . $row['id'] . ');">';
                $href_data_option_end = '</a>';
            } else {
                $href_data_option_start = '';
                $href_data_option_end = '';
            };



            if ($chd == '</li>') {
                $disp_none = ' style="visibility: hidden;" ';
            } else
                $disp_none = ' ';

            if ($test['public'] == 0) {
                $no_public_class = ' no_publ_class ';
            } else {
                $no_public_class = '';
            }

            $str .= '<li id="test' . $row['id'] . '" data-id-number="' . $row['id'] . '">'
                    . '<div class="v_elem">
                        <div class="visual_plus" data-id="' . $row['id'] . '" ' . $disp_none . '> - </div>
                        <div class="visual_text ' . $no_public_class . '" ' . $this_real_id_style . ' >' . $radio_all_buttons_html . $href_data_option_start . html_entity_decode(htmlspecialchars_decode($test['name']), ENT_QUOTES, 'UTF-8') . ' (id: '.$row['id'].')' . $href_data_option_end . $this_real_id_text . '</div>
                        <div class="visual_but">
                            <i class="fa fa-arrow-circle-down category_up_down_but" ' . $hide_up_down_but . '></i>&nbsp;
                            <i class="fa fa-arrow-circle-up category_up_down_but" ' . $hide_up_down_but . '></i>' . $edit_buttons_html
                        . '</div>
                        <div class="clear"></div>
                    </div>'
                    . $chd;
            $out[] = $test;
        }
        //return $out;
        return $str;
    }

    if ($select_parent_id == true) {
        $epmty_cat_radio = '<li id="test0" data-id-number="0">'
                . '<input id="product_category_id0" name="cat_radio" value="0" style="margin-left: 0px;" data-massive-element-type="radio" data-table-field="' . $sql_table_id_title . '" type="radio" checked>' .
                'НЕТ</li>';
    } else {
        $epmty_cat_radio = '';
    }


    return $epmty_cat_radio .
            RecursiveTree2(
                    $rs2, 0, $edit_categories, $select_parent_id, $edit_form, $sql_table_categories, $sql_images_table_name, $sql_images_table_id_title, $sql_features_table_name, $sql_features_table_id_title, $sql_table_id_title, $data_id
    );
};


// <i class="fa fa-caret-down category_up_down_but"></i>&nbsp;
// <i class="fa fa-caret-up category_up_down_but"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
?>

