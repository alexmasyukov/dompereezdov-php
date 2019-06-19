<?php
	$root = realpath($_SERVER['DOCUMENT_ROOT']);
	include_once $root."/cms/system/base_connect.php";
	
        // Проверка авторизации пользователя
        include_once $root."/cms/autorization.php";
	
	
	// Принимаем переменную идентификатора в базе

	$id = $_REQUEST['id']; 
        $type = $_REQUEST['type']; 
	$sql_table_name = $_REQUEST['sql_table_name']; 	
	$sql_images_table_name = $_REQUEST['sql_images_table_name'];
	$sql_images_table_id_title = $_REQUEST['sql_images_table_id_title'];
        $sql_features_table_name = $_REQUEST['sql_features_table_name'];
        $sql_features_table_id_title = $_REQUEST['sql_features_table_id_title'];
        
	
	//Проверяем имеет ли эта работы изображения и упоминания в таблице my_works_images
	// Если да - удаляем все изображения и все элементы таблици с этим id в таблице my_works_images
	// Если нет - удаляем элемент по id в таблице my_works
	
	
        switch ($type) {
            case 'category': {
               
                        
                $get = mysql_query("SELECT parent_id FROM $sql_table_name WHERE id = $id");
                while ($array = mysql_fetch_array($get)) {
                    $parent_id = $array['parent_id'];
                };
                    

                // Находим все элементы где этот элемент был главный (parent_id был равен id)
                // Заменяем у этих элементов parent_id на его parent_id
                $get = mysql_query("SELECT * FROM $sql_table_name WHERE parent_id = $id");
                while ($array = mysql_fetch_array($get)) {
                    $get2 = mysql_query("UPDATE $sql_table_name SET parent_id=$parent_id WHERE id=".$array['id']);
                    $run = $get2;
                };
                $get = mysql_query("DELETE FROM $sql_table_name WHERE id=$id");
                $run = $get;
                //UPDATE `menu` SET `parent_id`=0
                
                echo '{
                    "result":"' . $run . '"
                }';
                break;  
            }
            
            case 'element': {
                // Считываем нужные данные из БД таблица my_works_images
                $get = mysql_query("select * from $sql_images_table_name WHERE $sql_images_table_id_title=$id");
                while ($my_works_array = mysql_fetch_array($get)) {
                    // Удаляем фалы изображений
                    @unlink($root . str_replace('../../..//', '/', $my_works_array['big_img']));
                    @unlink($root . str_replace('../../..//', '/', $my_works_array['small_img']));
                }

                // Удаляем элемент из БД таблицы _images
                $my_works_get = mysql_query("DELETE FROM $sql_images_table_name WHERE $sql_images_table_id_title=$id");
                $run = $my_works_get;

                // Удаляем элемент из БД таблицы _features_values
                $my_works_get = mysql_query("DELETE FROM $sql_features_table_name WHERE $sql_features_table_id_title=$id");
                $run = $my_works_get;

                // Удаляем элемент из БД  
                $my_works_get = mysql_query("DELETE FROM $sql_table_name WHERE id=$id");
                $run = $my_works_get;

                echo '{
                        "result":' . $run . '
                    }';
                break;
            }
        }
        
?>