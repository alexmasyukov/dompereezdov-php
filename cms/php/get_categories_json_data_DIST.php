<?php
	$root = realpath($_SERVER['DOCUMENT_ROOT']);
	include_once $root."/cms/system/base_connect.php";
	
	function get_categories_json_data(
                $sql_table_categories, 
                $edit_categories=false, 
                $select_parent_id=false,
                $edit_form,
                $sql_images_table_name,
                $sql_images_table_id_title,
                $sql_features_table_name,
                $sql_features_table_id_title
            ) {
			
                
		$query = "SELECT * FROM $sql_table_categories;";
		if (!($result = mysql_query ($query)))
				return (FALSE);
		
		while ($array = mysql_fetch_array($result)) {
			$rs[] = $array;
		};
		
		$str2 = '';
		
		$rs2=array();
		foreach ($rs as $row)
		{
			$rs2[$row['parent_id']][]=$row;
		}
		
                
              
                
                 
                
              
            
                
		function RecursiveTree2(
                        &$rs, 
                        $parent, 
                        $edit_html, 
                        $radio_html,
                        $edit_form2,
                        $sql_table_categories2,
                        $sql_images_table_name,
                        $sql_images_table_id_title,
                        $sql_features_table_name,
                        $sql_features_table_id_title
                        ) {
                        
			$out=array();
			if (!isset($rs[$parent]))
			{
				return $out;
			}
			foreach ($rs[$parent] as $row)
			{
				$chidls=RecursiveTree2(
                                        $rs,
                                        $row['id'], 
                                        $edit_html,
                                        $radio_html,
                                        $edit_form2,
                                        $sql_table_categories2,
                                        $sql_images_table_name,
                                        $sql_images_table_id_title,
                                        $sql_features_table_name,
                                        $sql_features_table_id_title
                                        
                                        );
				if ($chidls) {
					$row['childs']=$chidls;
					$chd = ' <ul> '.$chidls.' </ul></li>';
				} else {
					$chd = '</li>';
				}
				$test = $row;
                               
                                
                                
                                // Если включен выбор РОДИТЕЛЬСКОЙ КАТЕГОРИИ
                                if ($radio_html == true) {
                                    $radio_all_buttons_html = '<input name="cat_radio" value="'.$row['id'].'" style="margin-left: 0px;" data-massive-element-type="radio" data-table-field="parent_id" id="product_category_id'.$row['id'].'" type="radio">';
                                } else {
                                    $radio_all_buttons_html = '';
                                
                                }
                                
                                
                                // Если включена кнопка РЕДАКТРИРОВАНИЕ КАТЕГОРИИ
                                if ($edit_html == true ) {
                                    $edit_buttons_html = '<a class="btn default  btn-xs green catalog_edit_category_but" href="admin.php?'.
                                                                                                                                        'link='.$edit_form2.
                                                                                                                                        '&id='.$row['id'].
                                                                                                                                        '&sql_table='.$sql_table_categories2.
                                                                                                                                        '&sql_images_table_name='.$sql_images_table_name.
                                                                                                                                        '&sql_images_table_id_title='.$sql_images_table_id_title.
                                                                                                                                        '&sql_features_table_name='.$sql_features_table_name.
                                                                                                                                        '&sql_features_table_id_title='.$sql_features_table_id_title.
                                                                                                                                        '" alt="Изменить" title="Изменить"><i class="glyphicon glyphicon-pencil"></i></a>';
                                } else {
                                    $edit_buttons_html = '';
                                }

				$str .= '<li id="test'.$row['id'].'" data-id-number="'.$row['id'].'">'.$radio_all_buttons_html.$edit_buttons_html.$test['name'].$chd;
				$out[]= $test;
				
			}
			//return $out;
                        return $str;
		}

                if ($select_parent_id ==  true) {
                    $epmty_cat_radio = '<input name="cat_radio" value="0" style="margin-left: 0px;" data-massive-element-type="radio" data-table-field="parent_id" id="product_category_id0" type="radio" checked>';
                } else{
                    $epmty_cat_radio = '';
                }
                
                
		return '<li id="test0" data-id-number="0">'.$epmty_cat_radio.'НЕТ</li>'.
                    RecursiveTree2(
                        $rs2, 
                        0, 
                        $edit_categories, 
                        $select_parent_id,
                        $edit_form,
                        $sql_table_categories,
                        $sql_images_table_name,
                        $sql_images_table_id_title,
                        $sql_features_table_name,
                        $sql_features_table_id_title
                    ); 
	};
?>