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
					"sql_table": "catalog_products_images",
					"sql_id_column": "module_item_id",
					"sql_value_column": "small_img",
					"sql_sort_by": "yes",
					"sql_sort_by_query": " ORDER BY general=1",
					"img_class": "sm_img_catalog_product_admin img-rounded",
					"img_null": "../../..//cms/template/assets/img/no_foto.jpg"
				},
				"f3":{
					"name": "name",
					"add_view_text_full_no_hide": "yes",
					"count": 100,
					"dalee_chars": "...",
					"dalee_open_text": "Далее",
					"dalee_link_classes": "",
					"edit_link": "yes"
				}, 
				"f4":{
					"name": "price"
				},
				"f5":{
					"name": "category_id",
					"find_sql": "yes",
					"find_sql_column": "category_id",
					"object": "value",
					"sql_table": "catalog_category",
					"sql_id_column": "id",
					"sql_value_column": "name",
					"sql_sort_by": "no",
					"sql_sort_by_query": "",
                                        "span_class" : "no-wrap text-category",
                                        "add_filter_link": "category_id=(category_id)"
				},
				"f6":{
					"name": "article_number"
				},
				"f7":{
					"name": "date_add",
					"russian_date": "yes"
				},
				"f8":{
					"name": "sale_down"
				},
				"f9": {
					"name": "button_edit",
					"html_button": "<a class=\"btn default btn-xs purple\" %onclick%  %href%><i class=\"glyphicon glyphicon-pencil\"></i></a>",
					"form": "catalog_product_edit_form",
					"link": "yes",
					"hook": "button_delete",
					"path": "&nbsp;&nbsp;"
				},
				"f10": {
					"name": "button_delete",
					"html_button": "<a class=\"btn btn-xs red \" %onclick%><i class=\"fa fa-times\"></i></a>",
					"form": "catalog_product_delete_form"
				}
			},
			"mt": "catalog_products",
			"sql_images_table_name": "catalog_products_images",
			"sql_images_table_id_title": "module_item_id",
			"sql_features_table_name": "catalog_features_values",
			"sql_features_table_id_title": "module_item_id",
			"go_link": "admin.php?link=catalog_products",
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