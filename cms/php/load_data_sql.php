<?php
	$root = realpath($_SERVER['DOCUMENT_ROOT']);
	include_once $root."/cms/system/base_connect.php";

	$sql_table_name = $_POST['sql_table_name'];
	$id = $_POST['id'];
	$sql_images_table_name = $_POST['sql_images_table_name'];
	$sql_images_table_id_title = $_POST['sql_images_table_id_title'];
	$sql_features_table_name = $_POST['sql_features_table_name'];
	$sql_features_table_id_title = $_POST['sql_features_table_id_title'];
	
	
	function get_column_names_with_show ($conn_id, $tbl_name)
	{
		$query = "SHOW COLUMNS FROM $tbl_name";
		if (!($result_id = mysql_query ($query)))
			return (FALSE);
		
		$names = array(); # создать пустой массив
		# первое значение каждой строки вывода – это имя столбца
		while (list ($name) = mysql_fetch_row ($result_id))
		
		$names[] = $name; # добавить имя в конец массива
		mysql_free_result ($result_id);
		return ($names);
	}
	
	// Получаем имена столбцов
	$columns = get_column_names_with_show('', $sql_table_name);
	
	// Формируем SQL запрос столбцов
	
	$sql_column_query = '';
	$column_number = 0;
	while ($column_number<count($columns)) {
		if ($column_number==count($columns)-1) {
			$sql_column_query .= $columns[$column_number];
		} else {
			$sql_column_query .= $columns[$column_number].',';
		}
		$column_number++;
	}
	
	
	$values = array ();
	
	$mysql_string = 'select '.$sql_column_query.' from '.$sql_table_name.' WHERE id='.$id.';';
	$result = '';
	$get=mysql_query($mysql_string);
	while ($array = mysql_fetch_array($get)) {
		$column_number = 0;
		while ($column_number<count($columns)) {
			$values[] = html_entity_decode(htmlspecialchars_decode($array[$columns[$column_number]]), ENT_QUOTES, 'UTF-8');
			$column_number++;			
		}
	}

	
	if ($sql_images_table_name!='' &&  $sql_images_table_name != 'undefined' && $sql_images_table_name!='none' ) {
		// Считываем данные зображений из БД 
		$images_get = mysql_query("select * from $sql_images_table_name WHERE $sql_images_table_id_title=".$id."");
                
//                echo "select * from $sql_images_table_name WHERE $sql_images_table_id_title=".$id."";
                
		while ($images = mysql_fetch_array($images_get)) {
			// Формируем данные
				//$key = 'point'.(++$i);
				$image_data .= 
					$images['id'].';'.
					$images[$sql_images_table_id_title].';'.
					$images['big_img'].';'.
					$images['small_img'].';'.
					$images['general'].';'.
					';'.
					$images['name'].';'.
					$images['sort'].';'
				;	
		}
	};
	
	
	
	$features = array ();
	if ($sql_features_table_name!='' &&  $sql_features_table_name != 'undefined' &&  $sql_features_table_name != 'none') {
		$features_get = mysql_query("select * from $sql_features_table_name WHERE $sql_features_table_id_title=".$id." ORDER BY sort;");
		
                while ($features_values = mysql_fetch_array($features_get)) {

                    $features[] = array(
								$features_values['id'], 
								$features_values[$sql_features_table_id_title], 
								$features_values['features_id'],
								html_entity_decode(htmlspecialchars_decode($features_values['value']), ENT_QUOTES, 'UTF-8'),
								$features_values['sort']
							);
		}
	};
        
        
        $documents = array ();
        $get_s = mysql_query("select * from content_documents WHERE id_content=".$id." ORDER BY sort;");
        while ($doc = mysql_fetch_array($get_s)) {
            $documents[] = array(
                $doc['id_content'], 
                $doc['id_documents'], 
                $doc['sort']
            );
        }
//	
	/*
	if ($sql_features_table_name!='' &&  $sql_features_table_name != 'undefined') {
		// Считываем данные ХАРАКТЕРИСТИК из БД 
		$features_get = mysql_query("select * from $sql_features_table_name WHERE $sql_features_table_id_title=".$id."");
		while ($features = mysql_fetch_array($features_get)) {
			// Формируем данные
				//$key = 'point'.(++$i);
				$features_data .= 
					$features['id'].';'.
					$features[$sql_features_table_id_title].';'.
					$features['features_id'].';'.
					html_entity_decode(htmlspecialchars_decode($features['value']), ENT_QUOTES, 'UTF-8').';'.
					$features['sort'].';';	
		}
	}; */ //$features
	
	
	echo '{
                "sql_fields": '.json_encode($columns).', 
                "sql_values": '.json_encode($values).',
                "image_data": "'.$image_data.'",
                "features_data": '.json_encode($features).',
                "documents_data": '.json_encode($documents).'  
            }'; 	
?>