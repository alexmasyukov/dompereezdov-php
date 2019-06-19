$active_page = 1;
$count_of_page = 20;

function view_module(json_data_file, count_of_page, filter) {
	$active_page = 1;
	$(document).ready(function (){
		get_table(
			'', 
			'#catalog_products_table', //html таблицы
			'', //count_id
			json_data_file, 
			$active_page, 
			count_of_page, // Элементов на странице
			'.pagination-plain', 
			filter //Фильтр
		);
	});
};

function close_page(go_link) {
	location.href = go_link;
}