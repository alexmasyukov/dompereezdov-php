<?php

$param_json = '
		{
			"mysql_filelds":{
				"f1":{
					"name" : "id",
					"span_class" : "id_span_table"
				},
				"f2":{
				    "name": "admin_name",
				    "edit_link": "yes"
				},
				"f3":{
				    "name": "h1"
				}, 
				"f4":{
				    "name": "cpu_path"
				}, 
                "f5":{
                    "name": "type" 
				},
                "f6":{
					"name": "public",
                    "visual_yes_no": "yes",
                    "visual_yes_value": "1",
                    "visual_yes_title": "Да",
                    "visual_no_title": "Нет"
				},
				"f7": {
					"name": "button_edit",
					"html_button": "<a class=\"btn default btn-xs purple\" %onclick%  %href%><i class=\"glyphicon glyphicon-pencil\"></i></a>",
					"form": "town_edit_form",
                    "link": "yes",
					"hook": "button_delete",
					"path": "&nbsp;&nbsp;"
				},
				"f8": {
					"name": "button_delete",
					"html_button": "<a class=\"btn btn-xs red \" %onclick%><i class=\"fa fa-trash-o\"></i></a>",
					"form": "feedback_edit_form"
				}
			},
			"mt": "pages",
			"sql_images_table_name": "",
			"sql_images_table_id_title": "",
			"sql_features_table_name": "",
			"sql_features_table_id_title": "",
			"go_link": "admin.php?link=town",
			"limit_string": 25, 
			"nl2br": "yes",
			"htmlspecialchars_decode": "yes",
			"string_open_tag": "<tr>",
			"string_close_tag": "</tr>",
			"fileld_value_open_tag": "<td>", 
			"fileld_value_close_tag": "</td>",
			"active_page": "1",
			"where_code": "  ",
			"sort_by": " public ",
			"desc": "",
			"sort_by2": " ",
			"desc2": "",
			"sort_by3": "  ",
			"desc3": ""
		}
	';

/* 				Сокращение слов
  "fixed_lgd": "yes",
  "fixed_lgd_val": "60"



  Блоки Покащать и Скрыть (Сокращение)
  "add_view_text_full": "yes",
  "count": 70,
  "dalee_chars": "...",
  "dalee_open_text": " Показать",
  "dalee_close_text": " Скрыть",
  "dalee_link_classes": "",


  ORDER BY id


,
                    "find_sql": "yes",
					"find_sql_column": "id",
					"object": "value",
					"sql_table": "pages",
					"sql_id_column": "id",
					"sql_value_column": "name",
					"sql_sort_by": "",
					"sql_sort_by_query": "",
                    "span_class" : "",
                    "view_result_count": "yes"


 */
?>