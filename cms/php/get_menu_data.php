<?php 
    $root = realpath($_SERVER['DOCUMENT_ROOT']);

    // Проверка авторизации пользователя
    include_once $root . '/cms/autorization.php';
    include_once $root . '/cms/php/get_categories_json_data.php';

    $sql_table = $_REQUEST['sql_table_name'];
    $type = $_REQUEST['type'];
    
    if ($type == 'categories') {
        //Получаем категории для выбора родителя (с radio button)
        $json_data = get_categories_json_data(
            $sql_table, //$sql_table_categories
            false, // Кнопка редактирования категории, 
            false, //Radio button при выборе родительской категории,
            '', //название текущей формы согласно link_array - admin.php
            '', //$sql_images_table_name 
            '', //$sql_images_table_id_title 
            '', //$sql_images_table_id_title 
            '', //$sql_features_table_id_title
            'parent_id', // $sql_table_id_title -> прикрепляется к radio-button при сохранении выбора категории в виде data-table-field="parent_id"
            // Используется form.js для формирования запроса к БД. ЕСЛИ таблица_category: parent_id, ЕСЛИ это редактироваие материла и т.п.: category_id 
            true
        );
    };
    
    
    if ($type == 'content') {
        $content = $db->query('SELECT * FROM '.$sql_table.' WHERE public=1 ORDER BY sort');
        while($row = $content->fetch(PDO::FETCH_ASSOC)) {
            $json_data .= '<tr>';
            $json_data .= '<td>'.$row['id'].'</td>';
            $json_data .= '<td><a href="#" onclick="set_menu_link(this, '.$row['id'].');" class="dash_link">'.html_entity_decode(htmlspecialchars_decode($row['name']), ENT_QUOTES, 'UTF-8').'</a></td>';
            $json_data .= '</tr>';
        }
    }
    
    
    function jsAddSlashes($str) {
		$pattern = array(
			"/\n/"    , "/\r/", "/\t/"
		);
		$replace = array(
			"",  ""     , "" 
		);
		return preg_replace($pattern, $replace, $str);
	}
	//
    
    echo '{
            "data":"'.jsAddSlashes(addslashes($json_data)).'"
    }';
?>