<?php	
	$param_json = '
		{
			"mysql_filelds":{
				"f1":{
					"name" : "id",
					"span_class" : "id_span_table"
				},
				"f2":{
					"name": "empty",
					"find_sql": "yes",
					"find_sql_column": "small_img",
					"object": "image",
					"sql_table": "banners_images",
					"sql_id_column": "module_item_id",
					"sql_value_column": "small_img",
					"sql_sort_by": "yes",
					"sql_sort_by_query": " ORDER BY general=1",
					"img_class": "sm_img_catalog_product_admin img-rounded",
					"img_null": "../../..//cms/template/assets/img/no_foto.jpg"
				},
				"f3":{
					"name": "name"
				},
				"f4":{
					"name": "sort"
				},
				"f5":{
					"name": "public",
					"visual_yes_no": "yes",
					"visual_yes_value": "1",
					"visual_yes_title": "Да",
					"visual_no_title": "Нет"
				},
				"f6": {
					"name": "button_edit",
					"html_button": "<a class=\"btn default btn-xs purple\" %onclick%  %href%><i class=\"glyphicon glyphicon-pencil\"></i></a>",
					"form": "banners_edit_form",
                                        "link": "yes"
				}
			},
			"mt": "banners",
                        "sql_images_table_name": "banners_images",
			"sql_images_table_id_title": "module_item_id",
			"sql_features_table_name": "banners_features_values",
			"sql_features_table_id_title": "module_item_id",
                        "go_link": "admin.php?link=banners",
			"limit_string": 25,
			"nl2br": "yes",
			"htmlspecialchars_decode": "yes",
			"string_open_tag": "<tr>",
			"string_close_tag": "</tr>",
			"fileld_value_open_tag": "<td>", 
			"fileld_value_close_tag": "</td>",
			"active_page": "1",
			"where_code": "  ",
			"sort_by": " name ",
			"desc": "",
			"sort_by2": " ,sort ",
			"desc2": "yes",
			"sort_by3": "  ",
			"desc3": ""
		}
	';
?>