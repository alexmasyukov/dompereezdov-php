$feature_id = 1;
$feature_sort_number = 10;




function add_new_feature() {
	// Провеояем есть ли данная характеристика уже в таблице
	real_reatures = $('#datatable_reviews').find('.feature_title');
	for (var i = 0; i < real_reatures.length; i++) {
		if ($('.feature_new_select option:selected').attr('data-title') == real_reatures.eq(i).text()) {
			//data-container="body"  data-placement="bottom" data-content="Данная характеристика уже пристутствует в списке"
			$('.feature_new_select').popover('show');
			
			setTimeout(function (){
				$('.feature_new_select').popover('hide');
			}, 2000);
			return;
		}
	}
	
	if ($('.feature_new_select option:selected').attr('data-icon') == '') {
		icon = '';
	} else {
		icon = '<img src="'+$('.feature_new_select option:selected').attr('data-icon')+'" class=" feature_icon"/>';
	}
	
	$('#datatable_reviews tbody').append(' \
		<tr role="row" class="filter" id="feature_id'+$feature_id+'" data-features-id="'+$('.feature_new_select option:selected').attr('data-id')+'"> \
			<td> \
				'+icon+' \
			</td> \
			<td> \
				<label class="help-block  feature_title">'+$('.feature_new_select option:selected').attr('data-title')+'</label>  \
			</td> \
			<td> \
				<textarea rows="1" cols="45" class="form-control input-sm  feature_value" value=""></textarea> \
			</td> \
			<td> \
				<label class="help-block  feature_prefix">'+$('.feature_new_select option:selected').attr('data-prefix_id')+'</label> \
			</td> \
			<td> \
				<input type="text" class="form-control input-sm  feature_sort" name="product_review_content" value="'+$feature_sort_number+'">  \
			</td> \
			<td> \
				<button class="btn btn-sm red filter-cancel" onclick="delete_feature(\'feature_id'+$feature_id+'\')"><i class="fa fa-times"></i> Удалить</button> \
			</td> \
		</tr>');
	$feature_id ++;
	$feature_sort_number += 10;
}





function set_features_of_matrix(matrix) {
	for (var el = 0; el < matrix.length; el++) {
		//получаем id хакактеристики
		features_id_sql = matrix[el][2];
		//alert(features_id);
		
		// Ищем id характеристики в select чтобы считать data атрибуты
		
		if ($(".feature_new_select option[value='"+features_id_sql+"']").attr('data-icon') == '') {
			icon = '';
		} else {
			icon = '<img src="'+$(".feature_new_select option[value='"+features_id_sql+"']").attr('data-icon')+'" class=" feature_icon"/>';
		}
		
		$('#datatable_reviews tbody').append(' \
			<tr role="row" class="filter" id="feature_id'+$feature_id+'" data-features-id="'+$(".feature_new_select option[value='"+features_id_sql+"']").attr('data-id')+'"> \
				<td> \
					'+icon+' \
				</td> \
				<td> \
					<label class="help-block  feature_title">'+$(".feature_new_select option[value='"+features_id_sql+"']").attr('data-title')+'</label>  \
				</td> \
				<td> \
					<textarea rows="1" cols="45" class="form-control input-sm  feature_value" value="">'+matrix[el][3]+'</textarea> \
				</td> \
				<td> \
					<label class="help-block  feature_prefix">'+$(".feature_new_select option[value='"+features_id_sql+"']").attr('data-prefix_id')+'</label> \
				</td> \
				<td> \
					<input type="text" class="form-control input-sm  feature_sort" name="product_review_content" value="'+matrix[el][4]+'">  \
				</td> \
				<td> \
					<button class="btn btn-sm red filter-cancel" onclick="delete_feature(\'feature_id'+$feature_id+'\')"><i class="fa fa-times"></i> Удалить</button> \
				</td> \
			</tr>');
		$feature_id ++;
		$feature_sort_number += 10;
	} // for
}







function delete_feature(feature_id) {
	$('#'+feature_id).remove();
}




	
$(document).ready(function() {
	$('body').on('click', '.feature_new_select', function(){
		$('.feature_new_select').popover('hide');
	});
});