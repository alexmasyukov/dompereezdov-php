<?php

$root = realpath($_SERVER['DOCUMENT_ROOT']);

//Конфигурация
//include_once ($root . '/configuration.php');

//подключение к БД
//include_once $root . '/cms/system/base_connect.php';
include_once $root . "/frontend/system/base_connect.php";


//подключение ОБЩИХ ФУНКЦИЙ
include_once $root . '/cms/system/functions.php';


$massive_json = $_REQUEST['data'];
$data_json_php_file = $_REQUEST['data_json'];
$page = $_REQUEST['page'];
$count_of_page = $_REQUEST['count_of_page'];
$data_json_php_file = $_REQUEST['data_json'];
$filter_data = $_REQUEST['filter_data'];

if ($data_json_php_file != '') {
    // Если передан путь к php файлу c json массивом
    include_once($root . '/cms/json_data/' . $data_json_php_file . '.php');
    // Массив из php файла всегда должен быть с именем $param_json
    $massive = json_decode($param_json, true);
} else {
    // Иначе берем масиив json из переданного через ajax
    $massive = json_decode($massive_json, true);
};


// Получаем поля таблицы для формирования запроса
for ($f = 1; $f <= count($massive['mysql_filelds']); $f++) {
    if ($massive['mysql_filelds']['f' . $f]['name'] == 'button_edit') {
        continue;
    }
    if ($massive['mysql_filelds']['f' . $f]['name'] == 'button_delete') {
        continue;
    }
    if ($massive['mysql_filelds']['f' . $f]['name'] == 'button_set_actual') {
        continue;
    }
    if ($massive['mysql_filelds']['f' . $f]['name'] == 'empty') {
        continue;
    }
    if ($massive['mysql_filelds']['f' . $f]['name'] == 'no_actual') {
        continue;
    }
    $fields .= $massive['mysql_filelds']['f' . $f]['name'] . ',';
}

// Удаляем послейдний символ (запятую) из сформированной строки с полями таблицы
$fields = substr($fields, 0, -1);

$hooks = array();

// Формируем шаблон
for ($f = 1; $f <= count($massive['mysql_filelds']); $f++) {
    $err = 0;

    for ($hook_val = 0; $hook_val <= count($hooks) - 1; $hook_val++) {
        if ($hooks[$hook_val] == $massive['mysql_filelds']['f' . $f]['name']) {
            $err = 1;
        }
    }

    if ($err == 0) {
        $templ_string .= '#td#--' . $massive['mysql_filelds']['f' . $f]['name'] . '--';
    }

    /*
      if ($massive['mysql_filelds']['f'.$f]['hook']!='') {
      $templ_string .= $massive['mysql_filelds']['f'.$f]['path'].'--'
      .$massive['mysql_filelds']['f'.$f]['hook'].'--'
      .$massive['mysql_filelds']['f'.$f]['path2'].'--'
      .$massive['mysql_filelds']['f'.$f]['hook2'].'--#/td#--';
      $hooks[count($hooks)] = $massive['mysql_filelds']['f'.$f]['hook'];
      } else {
      $templ_string .= '#/td#';
      } */

    if ($massive['mysql_filelds']['f' . $f]['hook'] != '') {
        $templ_string .= $massive['mysql_filelds']['f' . $f]['path'] . '--' . $massive['mysql_filelds']['f' . $f]['hook'] . '--';
        $hooks[count($hooks)] = $massive['mysql_filelds']['f' . $f]['hook'];

        if ($massive['mysql_filelds']['f' . $f]['hook2'] != '') {
            $templ_string .= $massive['mysql_filelds']['f' . $f]['path2'] . '--' . $massive['mysql_filelds']['f' . $f]['hook2'] . '--#/td#--';
            $hooks[count($hooks)] = $massive['mysql_filelds']['f' . $f]['hook2'];
        } else {
            $templ_string .= '#/td#--';
        }
    } else {
        $templ_string .= '#/td#';
    }
}

if ($massive['sort_by'] != '') {
    $O_B = ' ORDER BY ';
} else {
    $O_B = '';
}

if ($massive['desc'] != '') {
    $DESC = ' DESC ';
} else {
    $DESC = '';
}

if ($massive['desc2'] != '') {
    $DESC2 = ' DESC ';
} else {
    $DESC2 = '';
}

if ($massive['desc3'] != '') {
    $DESC3 = ' DESC ';
} else {
    $DESC3 = '';
}


////* --------------------- Постраничная навигация --------------------------------- *//
////$mysql_string = 'select id from '.$massive['mt'].' '.$massive['where_code'].';';
//$mysql_string = 'select id from ' . $massive['mt'] . ' ' . $massive['where_code'] . ' ' . $filter_data . ' ' . $O_B . ' ' . $massive['sort_by'] . ' ' . $DESC . $massive['sort_by2'] . ' ' . $DESC2 . $massive['sort_by3'] . ' ' . $DESC3 . ' ;';
//
////                echo '{
////			"res":"'.$mysql_string.'",
////			"count":"",
////			"pages_navigator_code":""
////			}';
////                
////                exit;
//
//$result = '';
//$get = $db->query($mysql_string);
//$count = mysql_num_rows($get);
//
//
//
//// Полученное количество делим на доступный лимит и округляем в большую сторону
//$count_pages = ceil($count / $count_of_page);
//
//$count_pages_html = '';
//
//if ($page >= 2) {
//    $previous_page = $page - 1;
//    $count_pages_html .= '<li class=\"previous\"><a href=\"#fakelink\" onclick=\"view_page(\'' . $previous_page . '\', \'' . $data_json_php_file . '\');\">← Назад</a></li>';
//} else {
//    if ($count_pages == 0) {
//        $count_pages_html .= '';
//    } else {
//        $count_pages_html .= '<li class=\"previous\"><a href=\"#fakelink\" onclick=\"view_page(\'1\', \'' . $data_json_php_file . '\');\">← Назад</a></li>';
//    }
//}
//
//$i = 1;
//while ($i <= $count_pages) {
//    // Выделяем текущую ссылку
//    if ($i == $page) {
//        $count_pages_html .= '<li class=\"active\"><a onclick=\"view_page(\'' . $i . '\', \'' . $data_json_php_file . '\');\" href=\"#fakelink\">' . $i . '</a></li>';
//    } else {
//        $count_pages_html .= '<li><a onclick=\"view_page(\'' . $i . '\', \'' . $data_json_php_file . '\');\" href=\"#fakelink\">' . $i . '</a></li>';
//    }
//    $i++;
//}
//
//
//if ($page < $count_pages) {
//    $next_page = $page + 1;
//    $count_pages_html .= '<li class=\"next\"><a href=\"#fakelink\" onclick=\"view_page(\'' . $next_page . '\', \'' . $data_json_php_file . '\');\">Далее →</a></li>';
//};
//if ($page == $count_pages) {
//    $next_page = $page;
//    $count_pages_html .= '<li class=\"next\"><a href=\"#fakelink\" onclick=\"view_page(\'' . $next_page . '\', \'' . $data_json_php_file . '\');\">Далее →</a></li>';
//};
//
//
//// Задаем начальный елемент для базы
//if ($page == 1) {
//    $limit_start = 0;
//} else {
//    $limit_start = $count_of_page * ($page - 1);
//}
//
////* --------------------------------------------------------------------------------*//


if ($massive['no_actual_class'] != '') {
    $no_actual_in_query = 'no_actual, ';
} else {
    $no_actual_in_query = '';
}

// ВНИМАНИЕ !!!!! КОСТЫЛЬ!!!!
// Чтоьы считать иконку к материалы и документы (поле icon присутствует только в таблице content) ставим костыль, иначе на других модулях 
// выдает ошибку
$massive['mt'] == 'content' || $massive['mt'] == 'documents' ? $content_icon = ' , icon ' : $content_icon = '';

if (str_replace(" ", "", $massive['where_code']) == '' && $filter_data != '') {
    $massive['where_code'] = ' WHERE ';
}

$limit_start = 0;
$mysql_string = 'SELECT ' . $no_actual_in_query . $fields . $content_icon . ' FROM ' . $massive['mt'] . ' ' . $massive['where_code'] . ' ' . $filter_data . ' ' . $O_B . ' ' . $massive['sort_by'] . ' ' . $DESC . $massive['sort_by2'] . ' ' . $DESC2 . $massive['sort_by3'] . ' ' . $DESC3 . '  LIMIT ' . $limit_start . ',' . $count_of_page . ';';


//echo $mysql_string;

$result = '';
$get = $db->query($mysql_string);
//$get = $db->query($mysql_string);
//$count = mysql_num_rows($get);
$count = $get->rowCount();
//while ($array = mysql_fetch_array($get)) {
while ($array = $get->fetch(PDO::FETCH_ASSOC)) {

    // Формируем данные


    if ($massive['no_actual_class'] != '') {
        if ($array['no_actual'] != '') {
            $result .= '<tr class="' . $massive['no_actual_class'] . '">';
            $no_actual_result_display = '';
        } else {
            $result .= $massive['string_open_tag'];
            $no_actual_result_display = ' style="display: none" ';
        }
    } else {
        $result .= $massive['string_open_tag'];
    }

    //no_actual_class

    $string_real = $templ_string;
    for ($a = 1; $a <= count($massive['mysql_filelds']); $a++) {
        // Ищем по наименованию поля
        $string = html_entity_decode(htmlspecialchars_decode($array[$massive['mysql_filelds']['f' . $a]['name']]), ENT_NOQUOTES, 'UTF-8');


        switch ($massive['mysql_filelds']['f' . $a]['number_format']) {
            case 'yes': {
                $string = number_format($array[$massive['mysql_filelds']['f' . $a]['name']], 0, ',', $massive['mysql_filelds']['f' . $a]['number_separator']);
                //$string = $array[$massive['mysql_filelds']['f'.$a]['name']];
                break;
            };
        }


        switch ($massive['mysql_filelds']['f' . $a]['russian_date']) {
            case 'yes': {
                $string = russain_date($array[$massive['mysql_filelds']['f' . $a]['name']]);
                //$string = $array[$massive['mysql_filelds']['f'.$a]['name']];
                break;
            };
        }


        switch ($massive['mysql_filelds']['f' . $a]['fixed_lgd']) {
            case 'yes': {
                $string = fixed_lgd(
                    $array[$massive['mysql_filelds']['f' . $a]['name']], $massive['mysql_filelds']['f' . $a]['fixed_lgd_val'], ' ...'
                );
                //$string = $array[$massive['mysql_filelds']['f'.$a]['name']];
                break;
            };
        }


        switch ($massive['mysql_filelds']['f' . $a]['add_view_text_full']) {
            case 'yes': {
                $string = add_view_text_full(
                    $array[$massive['mysql_filelds']['f' . $a]['name']], $massive['mysql_filelds']['f' . $a]['count'], $massive['mysql_filelds']['f' . $a]['dalee_chars'], $massive['mysql_filelds']['f' . $a]['dalee_open_text'], $massive['mysql_filelds']['f' . $a]['dalee_close_text'], $massive['mysql_filelds']['f' . $a]['dalee_link_classes']
                );
                //$string = $array[$massive['mysql_filelds']['f'.$a]['name']];
                break;
            };
        }


        switch ($massive['mysql_filelds']['f' . $a]['add_view_text_full_no_hide']) {
            case 'yes': {
                $string = add_view_text_full_no_hide(
                    $array[$massive['mysql_filelds']['f' . $a]['name']], $massive['mysql_filelds']['f' . $a]['count'], $massive['mysql_filelds']['f' . $a]['dalee_chars'], $massive['mysql_filelds']['f' . $a]['dalee_open_text'], $massive['mysql_filelds']['f' . $a]['dalee_link_classes']
                );
                //$string = $array[$massive['mysql_filelds']['f'.$a]['name']];
                break;
            };
        }


        switch ($massive['mysql_filelds']['f' . $a]['visual_yes_no']) {
            case 'yes': {
                if ($massive['mysql_filelds']['f' . $a]['visual_yes_value'] == $array[$massive['mysql_filelds']['f' . $a]['name']]) {
                    $string = $massive['mysql_filelds']['f' . $a]['visual_yes_title'];
                } else {
                    $string = $massive['mysql_filelds']['f' . $a]['visual_no_title'];
                }
                break;
            };
        }


        if ($massive['mysql_filelds']['f' . $a]['name'] == 'button_edit') {
            if ($massive['mysql_filelds']['f' . $a]['link'] == 'yes') {
                $code = 'href="admin.php?link=' .
                    $massive['mysql_filelds']['f' . $a]['form'] .
                    '&id=' .
                    $array['id'] .
                    '&sql_table=' .
                    $massive['mt'] .
                    '&sql_images_table_name=' .
                    $massive['sql_images_table_name'] .
                    '&sql_images_table_id_title=' .
                    $massive['sql_images_table_id_title'] .
                    '&sql_features_table_name=' .
                    $massive['sql_features_table_name'] .
                    '&sql_features_table_id_title=' .
                    $massive['sql_features_table_id_title'] .
                    '&filter=' . $filter_data .
                    '"';

                $html_code = $massive['mysql_filelds']['f' . $a]['html_button'];
                $string_changed_one = str_replace('%onclick%', '', $html_code);
                $string = str_replace('%href%', $code, $string_changed_one);
            } else {
                $code = 'onclick="edit_element(&#39;' . $massive['mysql_filelds']['f' . $a]['form'] . '&#39;, &#39;' . $array['id'] . '&#39;, &#39;' . $massive['mt'] . '&#39;);"';

                $html_code = $massive['mysql_filelds']['f' . $a]['html_button'];
                $string_changed_one = str_replace('%onclick%', $code, $html_code);
                $string = str_replace('%href%', '', $string_changed_one);
            }
        }


        if ($massive['mysql_filelds']['f' . $a]['name'] == 'button_set_actual') {
            $code = 'onclick="set_actual(&#39;' . $array['id'] . '&#39;);"';

            $string_plus_display = str_replace('%display%', $no_actual_result_display, $massive['mysql_filelds']['f' . $a]['html_button']);

            $string = str_replace('%onclick%', $code, $string_plus_display);
        }


        if ($massive['mysql_filelds']['f' . $a]['name'] == 'button_delete') {
            $code = 'onclick="delete_element(&#39;' . $array['id'] . '&#39;, &#39;' . $massive['active_page'] . '&#39;,&#39;' . $massive['mt'] . '&#39;, &#39;' . $massive['go_link'] . '&#39;, &#39;' . $massive['sql_images_table_name'] . '&#39;, &#39;' . $massive['sql_images_table_id_title'] . '&#39, &#39;' . $massive['sql_features_table_name'] . '&#39, &#39;' . $massive['sql_features_table_id_title'] . '&#39;);"';
            $string = str_replace('%onclick%', $code, $massive['mysql_filelds']['f' . $a]['html_button']);
        }

        if ($massive['mysql_filelds']['f' . $a]['name'] == 'empty') {
            $string = '';
        };


        if ($massive['mysql_filelds']['f' . $a]['find_sql'] == 'yes') {
            switch ($massive['mysql_filelds']['f' . $a]['object']) {
                case 'value': {
                    if ($massive['mysql_filelds']['f' . $a]['sql_sort_by'] == 'yes') {
                        $mysql_param_sort_by = $massive['mysql_filelds']['f' . $a]['sql_sort_by_query'];
                    } else {
                        $mysql_param_sort_by = '';
                    };

                    $limit = ' LIMIT 1 ';
                    $massive['mysql_filelds']['f' . $a]['view_result_count'] == 'yes' ? $limit = ' ' : $limit = ' LIMIT 1 ';

                    $mysql_string_param = 'select ' .
                        $massive['mysql_filelds']['f' . $a]['sql_value_column'] .
                        ' from ' .
                        $massive['mysql_filelds']['f' . $a]['sql_table'] .
                        ' WHERE ' .
                        $massive['mysql_filelds']['f' . $a]['sql_id_column'] .
                        '=' .
                        $array[$massive['mysql_filelds']['f' . $a]['find_sql_column']] .
                        $mysql_param_sort_by .
                        $limit;

//                    echo $mysql_string_param;
                    $get_sql_param = $db->query($mysql_string_param);
                    while ($array_param = $get_sql_param->fetch(PDO::FETCH_ASSOC)) {
                        $string = $array_param[$massive['mysql_filelds']['f' . $a]['sql_value_column']];
                    }; //while


                    if ($massive['mysql_filelds']['f' . $a]['view_result_count'] == 'yes') {
                        $count_of_case = $get_sql_param->rowCount();
                        $count_of_case > 0 ? $string = '<span class="files_in_row">' . $count_of_case . '&nbsp;</span>' : $string = '';
                    }

                    break;
                }; //case 'value'

                case 'image': {
                    if ($array['icon'] != '') {
                        $string = '<img src="' . $array['icon'] . '" class="sm_img_catalog_product_admin img-rounded icon" />';
                        break;
                    };


                    if ($massive['mysql_filelds']['f' . $a]['sql_sort_by'] == 'yes') {
                        $mysql_param_sort_by = $massive['mysql_filelds']['f' . $a]['sql_sort_by_query'];
                    } else {
                        $mysql_param_sort_by = '';
                    };

                    $mysql_string_param = 'select ' .
                        $massive['mysql_filelds']['f' . $a]['sql_value_column'] .
                        ' from ' .
                        $massive['mysql_filelds']['f' . $a]['sql_table'] .
                        ' WHERE ' .
                        $massive['mysql_filelds']['f' . $a]['sql_id_column'] .
                        '=' .
                        $array['id'] .
                        $mysql_param_sort_by .
                        '';
                    $get_sql_param = $db->query($mysql_string_param);


                    while ($array_param = $get_sql_param->fetch(PDO::FETCH_ASSOC)) {


                        /* $mysql_string_img = 'select small_img from catalog_products_images WHERE id_products='.$array['id'].' LIMIT 1;'; */


                        if ($array_param['small_img'] == '') {
                            $array_param['small_img'] = $massive['mysql_filelds']['f' . $a]['img_null'];
                        };
                        $string = '<img src="' . $array_param['small_img'] . '" class="' . $massive['mysql_filelds']['f' . $a]['img_class'] . '" />';
                    } //while
                    break;
                }; //case 'image'
            }; //switch
        }; //if


        if ($massive['mysql_filelds']['f' . $a]['name'] == 'no_actual') {
            $code = 'onclick="set_no_actual(' . $array['id'] . ', &#39;show&#39;)"';
            $string = str_replace('%onclick%', $code, $massive['mysql_filelds']['f' . $a]['html_button']);
        }


        switch ($massive['mysql_filelds']['f' . $a]['span_class']) {
            case true: {
                $string = '<span class="' . $massive['mysql_filelds']['f' . $a]['span_class'] . '">' . $string . '</span>';
                break;
            };
        }


        if ($massive['mysql_filelds']['f' . $a]['add_filter_link'] != '') {
            preg_match_all("|\((.*)\)|U", $massive['mysql_filelds']['f' . $a]['add_filter_link'], $matches);
            $filter = str_replace($matches[0][0], $array[$matches[1][0]], $massive['mysql_filelds']['f' . $a]['add_filter_link']);
            $string = '<a class="view_category" href="admin.php?link=' . $massive['mt'] . '&filter=(' . $filter . ')">' . $string . '</a>';
        }


        /*
          switch ($massive['mysql_filelds']['f'.$a]['add_chars']) {
          case true: {
          $string = $massive['mysql_filelds']['f'.$a]['add_chars'].$string;
          break;
          };
          } */


        // Меняем наименование поля в шаблоне на полученные данные
        $string_real = str_replace('--' . $massive['mysql_filelds']['f' . $a]['name'] . '--', $string, $string_real);
    }

    $string_real = str_replace('#td#', '<td>', $string_real);
    $string_real = str_replace('#/td#', '</td>', $string_real);

    $result .= $string_real;

    $result .= $massive['string_close_tag'];
}

function jsAddSlashes($str)
{
    $pattern = array(
        "/\n/", "/\r/", "/\t/"
    );
    $replace = array(
        "", "", ""
    );
    return preg_replace($pattern, $replace, $str);
}

//

if ($result == '') {
    $result = ''; //<tr><td colspan="6"><p class="no_find">К сожалению, по Вашему запросу ничего не найдено</p></td></tr>
}

//

echo '{
			"res":"' . jsAddSlashes(nl2br(addslashes($result))) . '",
			"count":"' . $count . '",
			"pages_navigator_code":"' . $count_pages_html . '"
			}
	';

//
// 
// stripslashes --  Удаляет экранирование символов, произведенное функцией addslashes()


/*

  echo '{
  "res":"'.$mysql_string.'",
  "count":"",
  "pages_navigator_code":""
  }';

  exit;


 */
?>