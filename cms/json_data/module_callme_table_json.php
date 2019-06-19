<?php	
	$param_json = '
		{
			"mysql_filelds":{
				"f1":{
					"name" : "id",
					"span_class" : "id_span_table"
				},
				"f2":{
					"name": "date",
					"russian_date": "yes"
				},
				"f3":{
					"name": "time"
				}, 
				"f4":{
					"name": "name"
				}, 
				"f5":{
					"name": "phone"
				},
				"f6":{
					"name": "status"
				},
				"f7": {
					"name": "button_edit",
					"html_button": "<a class=\"btn default btn-xs purple\" %onclick%  %href%><i class=\"glyphicon glyphicon-pencil\"></i></a>",
					"form": "callme_edit_form",
                                        "link": "yes",
					"hook": "button_delete",
					"path": "&nbsp;&nbsp;"
				},
				"f8": {
					"name": "button_delete",
					"html_button": "<a class=\"btn btn-xs red \" %onclick%><i class=\"fa fa-trash-o\"></i></a>",
					"form": "online_order_delete_form"
				}
			},
			"mt": "callme",
                        "sql_images_table_name": "none",
			"sql_images_table_id_title": "none",
			"sql_features_table_name": "none",
			"sql_features_table_id_title": "none",
                        "go_link": "admin.php?link=callme",
			"limit_string": 25,
			"nl2br": "yes",
			"htmlspecialchars_decode": "yes",
			"string_open_tag": "<tr>",
			"string_close_tag": "</tr>",
			"fileld_value_open_tag": "<td>", 
			"fileld_value_close_tag": "</td>",
			"active_page": "1",
			"where_code": "  ",
			"sort_by": " date ",
			"desc": "yes",
			"sort_by2": " ,id ",
			"desc2": "yes",
			"sort_by3": "  ",
			"desc3": ""
		}
	';
?>