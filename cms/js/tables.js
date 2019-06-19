function get_table(massive_param, table_id, count_id, data_json, page, count_of_page, pages_navigator, filter_data) {
	//alert('get_table - '+filter_data);
	$(document).ready(function (){
		if (page=='') {
			page = 1;
		}
		$('.load_div').fadeIn(200);
		$.getJSON("/cms/php/tables.php", {
                    data: $.toJSON(massive_param), 
                    data_json: data_json, 
                    page: page, 
                    count_of_page: count_of_page, 
                    pages_navigator: pages_navigator, 
                    filter_data: filter_data
                }) 
			.done(function( json ) {
                            console.log(json);
				$(table_id).find('tbody').empty();
				$(table_id).append(json.res);
				$(pages_navigator).html(json.pages_navigator_code);
				//$(count_id).html(json.count)
                                Init_table(60);
				$('.load_div').fadeOut(200);
			})
			.fail(function( jqxhr, textStatus, error ) {
				var err = textStatus + ", " + error + ' ';
				console.log("Ошибка: " + err + ' \n\r\ Данные: ' + jqxhr.responseText);
				
				$('#error_modal').find('.modal-body').empty();
				$('#error_modal').find('.modal-body').append("Ошибка: " + err);
				$('#error_modal').find('.modal-body').append(jqxhr.responseText);
				$('#error_modal').modal();
			});
	});
	
};


function Init_table(display_count) {

        var oTable3 = $('#catalog_products_table').dataTable({
            "aoColumnDefs": [
                {"aTargets": [0]}
            ],
            "aaSorting": [],
            "aLengthMenu": [
                [5, 20, 30, 60, 100, -1],
                [5, 20, 30, 60, 100, "Все"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": display_count,
        });

        jQuery('#catalog_products_table_wrapper .dataTables_filter input').addClass("form-control input-small input-inline"); // modify table search input
        jQuery('#catalog_products_table_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
        jQuery('#catalog_products_table_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

        $('#catalog_products_table_column_toggler input[type="checkbox"]').change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable3.fnSettings().aoColumns[iCol].bVisible;
            oTable3.fnSetColumnVis(iCol, (bVis ? false : true));
        });

	  
}



function get_count_table(table_name_sql, where , count_id) {
	$(document).ready(function (){
		$.getJSON("/cms/php/get_count.php", {table_name_sql: table_name_sql, where: where}) 
			.done(function( json ) {
				$(count_id).html(json.count)
			})
			.fail(function( jqxhr, textStatus, error ) {
				var err = textStatus + ", " + error + ' ';
				console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);
				
				$('#error_modal').find('.modal-body').empty();
				$('#error_modal').find('.modal-body').append("Ошибка: " + err);
				$('#error_modal').find('.modal-body').append(jqxhr.responseText);
				$('#error_modal').modal();
			});
	});
};



function get_filter_data() {
	//alert($.trim($('#new_form_select_200 option:selected').text()));
	
	result = '';
	// Район
	if ($.trim($('#new_form_select_200 option:selected').text())!='Не указан' && $.trim($('#new_form_select_200 option:selected').text())!='') {
		result += ' and raion=\''+$.trim($('#new_form_select_200 option:selected').text())+'\'';
	}
	
	// Этаж
	if ($.trim($('#new_form_select_205 option:selected').text())!='Не указан' && $.trim($('#new_form_select_205 option:selected').text())!='') {
		result += ' and etaj=\''+$.trim($('#new_form_select_205 option:selected').text())+'\'';
	}
	
	// Количество комнат
	if ($.trim($('#new_form_select_204 option:selected').text())!='Не указано' && $.trim($('#new_form_select_204 option:selected').text())!='') {
		result += ' and kolvo_comnat=\''+$.trim($('#new_form_select_204 option:selected').text())+'\'';
	}
	
	
	// Площадь от до
	plosad_ot = $.trim($('#new_form_input_text_208').val());
	plosad_do = $.trim($('#new_form_input_text_202').val());
	select_query = '';
	if (plosad_ot!='') {
		select_query += ' and (plosad>='+plosad_ot+' or plosad=0) ';
	}; 
	if (plosad_do!='') {
		select_query += ' and (plosad<='+plosad_do+' or plosad=0) ';
	}; 
	result += select_query;
	
	
	
	// Цена от до
	price_ot = $.trim($('#new_form_input_text_302').val());
	price_do = $.trim($('#new_form_input_text_305').val());
	select_query = '';
	if (price_ot!='') {
		select_query += ' and (price>='+price_ot+' or price=0 or price=\'\') ';
	}; 
	if (price_do!='') {
		select_query += ' and (price<='+price_do+' or price=0 or price=\'\') ';
	}; 
	result += select_query;
	
	if ($.trim($('#filter_street').val())!='') {
		result += ' and (adress LIKE \''+$.trim($('#filter_street').val())+'%\')';
	}
	
	
	
	//alert(result);
	return result;
}



function find_of_filter() {
	get_table('', '#apartments_table', '', $razdel, '1', $count_of_page, '.pagination-plain', get_filter_data());
}




function set_empty_filter() {
	//load_form('filter', '', 'yes', '', '', '#filter');
}



function view_page(page, data_json) {
		$active_page = page;
		get_table('', '#apartments_table', '', data_json, $active_page, $count_of_page, '.pagination-plain', get_filter_data());
	};