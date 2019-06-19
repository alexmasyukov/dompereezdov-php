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
					"sql_table": "content_images",
					"sql_id_column": "id_content",
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
					"name": "title"
				}, 
				"f5":{
					"name": "cpu_path"
				},
				"f6":{
					"name": "date_add",
					"russian_date": "yes",
                    "span_class" : "no-wrap"
				},
				"f7":{
					"name": "sort",
                    "find_sql": "yes",
					"find_sql_column": "id",
					"object": "value",
					"sql_table": "content_documents",
					"sql_id_column": "id_content",
					"sql_value_column": "id_documents",
					"sql_sort_by": "",
					"sql_sort_by_query": "",
                    "span_class" : "",
                    "view_result_count": "yes"
				},
				"f8":{
					"name": "category_id",
					"find_sql": "yes",
					"find_sql_column": "category_id",
					"object": "value",
					"sql_table": "content_category",
					"sql_id_column": "id",
					"sql_value_column": "name",
					"sql_sort_by": "no",
					"sql_sort_by_query": "",
                    "span_class" : "no-wrap text-category",
                    "add_filter_link": "category_id=(category_id)"
                                        
				},
				"f9":{
					"name": "public",
                    "visual_yes_no": "yes",
                    "visual_yes_value": "1",
                    "visual_yes_title": "Да",
                    "visual_no_title": "Нет"
				},
				"f10": {
					"name": "button_edit",
					"html_button": "<a class=\"btn default btn-xs purple\" %onclick%  %href%><i class=\"glyphicon glyphicon-pencil\"></i></a>",
					"form": "content_edit_form",
                                        "link": "yes",
					"hook": "button_delete",
					"path": "&nbsp;&nbsp;"
				},
				"f11": {
					"name": "button_delete",
					"html_button": "<a class=\"btn btn-xs red \" %onclick%><i class=\"fa fa-trash-o\"></i></a>",
					"form": "online_order_delete_form"
				}
			},
			"mt": "content",
            "sql_images_table_name": "content_images",
			"sql_images_table_id_title": "id_content",
			"sql_features_table_name": "none",
			"sql_features_table_id_title": "none",
            "go_link": "admin.php?link=content",
			"limit_string": 25,
			"nl2br": "yes",
			"htmlspecialchars_decode": "yes",
			"string_open_tag": "<tr>",
			"string_close_tag": "</tr>",
			"fileld_value_open_tag": "<td>", 
			"fileld_value_close_tag": "</td>",
			"active_page": "1",
			"where_code": "  ",
			"sort_by": " category_id ",
			"desc": "",
			"sort_by2": " , sort ",
			"desc2": " yes  ",
			"sort_by3": "",
			"desc3": ""
		}
	';
?>