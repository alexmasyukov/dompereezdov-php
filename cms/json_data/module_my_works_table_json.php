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
					"sql_table": "my_works_images",
					"sql_id_column": "module_item_id",
					"sql_value_column": "small_img",
					"sql_sort_by": "yes",
					"sql_sort_by_query": " ORDER BY general=1",
					"img_class": "sm_img_catalog_product_admin img-rounded",
					"img_null": "../../..//cms/template/assets/img/no_foto.jpg"
				},
				"f3":{
					"name": "name",
					"edit_link": "yes"
				}, 
                                "f4":{
					"name": "category_id",
					"find_sql": "yes",
					"find_sql_column": "category_id",
					"object": "value",
					"sql_table": "my_works_category",
					"sql_id_column": "id",
					"sql_value_column": "name",
					"sql_sort_by": "no",
					"sql_sort_by_query": "",
                                        "span_class" : "no-wrap text-category",
                                        "add_filter_link": "category_id=(category_id)"
				},
				"f5":{
					"name": "sort"
				},
                                "f6":{
					"name": "date_add",
					"russian_date": "yes",
                                        "span_class" : "no-wrap"
				},
                                "f7":{
					"name": "public",
                                        "visual_yes_no": "yes",
                                        "visual_yes_value": "1",
                                        "visual_yes_title": "Да",
                                        "visual_no_title": "Нет"
				},
				"f8": {
					"name": "button_edit",
					"html_button": "<a class=\"btn default btn-xs purple\" %onclick%  %href%><i class=\"glyphicon glyphicon-pencil\"></i></a>",
					"form": "my_works_edit_form",
                                        "link": "yes",
					"hook": "button_delete",
					"path": "&nbsp;&nbsp;"
				},
				"f9": {
					"name": "button_delete",
					"html_button": "<a class=\"btn btn-xs red \" %onclick%><i class=\"fa fa-trash-o\"></i></a>",
					"form": "my_works_edit_form"
				}
			},
			"mt": "my_works",
			"sql_images_table_name": "my_works_images",
			"sql_images_table_id_title": "module_item_id",
			"sql_features_table_name": "my_works_features_values",
			"sql_features_table_id_title": "module_item_id",
			"go_link": "admin.php?link=my_works",
			"limit_string": 25, 
			"nl2br": "yes",
			"htmlspecialchars_decode": "yes",
			"string_open_tag": "<tr>",
			"string_close_tag": "</tr>",
			"fileld_value_open_tag": "<td>", 
			"fileld_value_close_tag": "</td>",
			"active_page": "1",
			"where_code": "  ",
			"sort_by": " id ",
			"desc": "yes",
			"sort_by2": " ,date_add ",
			"desc2": "yes",
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

 */
?>