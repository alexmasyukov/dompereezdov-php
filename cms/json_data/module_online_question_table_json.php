<?php	
	$param_json = '
		{
			"mysql_filelds":{
				"f1":{
					"name" : "id",
					"span_class" : "id_span_table"
				},
                                "f2":{
					"name": "date_question",
					"russian_date": "yes"
				},
                                "f3":{
					"name": "client_name"
				},
                                "f4":{
					"name": "client_contact",
                                        "fixed_lgd": "yes",
					"fixed_lgd_val": "80"
				},
                                "f5":{
					"name": "question",
                                        "edit_link": "yes",
                                        "add_view_text_full_no_hide": "yes",
					"count": 200,
					"dalee_chars": "...",
					"dalee_open_text": "Далее",
					"dalee_link_classes": "",
					"edit_link": "yes"
				},
                                "f6":{
					"name": "date_answer",
					"russian_date": "yes"
				},
                                "f7":{
					"name": "public",
                                        "visual_yes_no": "yes",
                                        "visual_yes_value": "1",
                                        "visual_yes_title": "Да",
                                        "visual_no_title": "Нет"
				},
                                "f8":{
					"name": "sort"
				},
				"f9": {
					"name": "button_edit",
					"html_button": "<a class=\"btn default btn-xs purple\" %onclick%  %href%><i class=\"glyphicon glyphicon-pencil\"></i></a>",
					"form": "online_question_edit_form",
					"link": "yes",
					"hook": "button_delete",
					"path": "&nbsp;&nbsp;"
				},
				"f10": {
					"name": "button_delete",
					"html_button": "<a class=\"btn btn-xs red \" %onclick%><i class=\"fa fa-times\"></i></a>",
					"form": "online_question_delete_form"
				}
			},
			"mt": "online_question",
			"sql_images_table_name": "none",
			"sql_images_table_id_title": "none",
			"sql_features_table_name": "none",
			"sql_features_table_id_title": "none",
			"go_link": "admin.php?link=online_question",
			"limit_string": 25, 
			"nl2br": "yes",
			"htmlspecialchars_decode": "yes",
			"string_open_tag": "<tr>",
			"string_close_tag": "</tr>",
			"fileld_value_open_tag": "<td>", 
			"fileld_value_close_tag": "</td>",
			"active_page": "1",
			"where_code": "  ",
			"sort_by": " date_question ",
			"desc": " DESC ",
			"sort_by2": " ,sort ",
			"desc2": "",
			"sort_by3": "  ",
			"desc3": ""
		}
	';
	
	/*				Сокращение слов
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
	
	*/
?>