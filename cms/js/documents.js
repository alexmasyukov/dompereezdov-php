$(document).ready(function() {
    $('.select_doc').popover({delay: { show: 500, hide: 100 }});
    down_up_but_visible_datatable();
    
    $('.view_window_add_document').click(function () {
        $('#catalog_products_table').dataTable().fnDestroy(); // Убиваем таблицу
        $('#catalog_products_table').dataTable({
            "iDisplayLength": 40
        }); //создаем таблицу
        jQuery('#catalog_products_table_wrapper .dataTables_filter input').addClass("form-control input-small input-inline"); // modify table search input
        jQuery('#catalog_products_table_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
        jQuery('#catalog_products_table_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
    });
    
    
    $('.select_doc').click(function () {
        // Проверяем есть ли данный файл в таблице
        real_reatures = $('#datatable_documents').find('tr');
	for (var i = 0; i < real_reatures.length; i++) {
            if ($(this).attr('data-id') == real_reatures.eq(i).attr('data-id')) {
                $(this).popover('show');
                    setTimeout(function (){
                            $('.select_doc').popover('hide');
                    }, 1000);
                return;
            }
	}
        
        $('#datatable_documents tbody').append(' \
            <tr role="row" data-id="'+$(this).attr('data-id')+'"> \
                <td> \
                        '+$(this).attr('data-id')+' \
                </td> \
                <td> \
                        '+$(this).attr('data-date-add')+' \
                </td> \
                <td> \
                        '+$(this).attr('data-format')+' \
                </td> \
                <td> \
                        '+$(this).text() +' \
                </td> \
                <td> \
                        '+$(this).attr('data-category-name')+' \
                </td> \
                <td> \
                        <a href="'+$(this).attr('data-http-path')+'" target="blank">'+$(this).attr('data-http-path')+'</a> \
                </td> \
                <td> \
                        '+$(this).attr('data-size')+' Кб \
                </td> \
                <td> \
                       <i class="fa fa-arrow-circle-down category_up_down_but"></i> \
                       <i class="fa fa-arrow-circle-up category_up_down_but"></i> \
                </td> \
                <td> \
                        <button class="btn btn-sm red filter-cancel" onclick="delete_document_in_content(this);"><i class="fa fa-times"></i> Удалить</button> \
                </td> \
            </tr>');
            $('#modal_documents').modal('hide');
            down_up_but_visible_datatable();
    }); 
    
    
    $('#datatable_documents .fa-arrow-circle-down').live("click", function(){
        this_li = $(this).closest('tr');
        next_li = $(this_li).next('tr');

        if (next_li.length != 0) {
            $(this_li).insertAfter(next_li);
        }

        down_up_but_visible_datatable();
    });
    
    $('#datatable_documents .fa-arrow-circle-up').live("click", function(){
        this_li = $(this).closest('tr');
        prev_li = $(this_li).prev('tr');

        if (prev_li.length != 0) {
            $(this_li).insertBefore(prev_li);
        } 

        down_up_but_visible_datatable();
    });
});



function down_up_but_visible_datatable() {
    $(document).ready(function () {    
        all_li = $('#datatable_documents').find('tr');

        for (var i = 0; i < all_li.length; i++) {
            all_li.eq(i).find('.fa-arrow-circle-up, .fa-arrow-circle-down').css('visibility', 'visible');

            if (all_li.eq(i).prev('tr').length == 0) {
                all_li.eq(i).find('.fa-arrow-circle-up').css('visibility', 'hidden');
                all_li.eq(i).find('.fa-arrow-circle-down').css('visibility', 'visible');
            }

            if (all_li.eq(i).next('tr').length == 0) {
                all_li.eq(i).find('.fa-arrow-circle-down').css('visibility', 'hidden');
                all_li.eq(i).find('.fa-arrow-circle-up').css('visibility', 'visible');
            }

            if (all_li.eq(i).next('tr').length == 0 && all_li.eq(i).prev('tr').length == 0) {
                all_li.eq(i).find('.fa-arrow-circle-up, .fa-arrow-circle-down').css('visibility', 'hidden');
            }
        }
    });
}


function delete_document_in_content(obj) {
    $(document).ready(function () {
        $(obj).parents('tr').remove();
        down_up_but_visible_datatable();
    });
}




function set_documents_of_matrix(matrix) {
    for (var el = 0; el < matrix.length; el++) {
            $('#datatable_documents tbody').append(' \
            <tr role="row" data-id="'+$(this).attr('data-id')+'"> \
                <td> \
                        '+matrix[el][1]+' \
                </td> \
                <td> \
                        '+$(this).attr('data-date-add')+' \
                </td> \
                <td> \
                        '+$(this).attr('data-format')+' \
                </td> \
                <td> \
                        '+$(this).text() +' \
                </td> \
                <td> \
                        '+$(this).attr('data-category-name')+' \
                </td> \
                <td> \
                        <a href="'+$(this).attr('data-http-path')+'" target="blank">'+$(this).attr('data-http-path')+'</a> \
                </td> \
                <td> \
                        '+$(this).attr('data-size')+' Кб \
                </td> \
                <td> \
                       <i class="fa fa-arrow-circle-down category_up_down_but"></i> \
                       <i class="fa fa-arrow-circle-up category_up_down_but"></i> \
                </td> \
                <td> \
                        <button class="btn btn-sm red filter-cancel" onclick="delete_document_in_content(this);"><i class="fa fa-times"></i> Удалить</button> \
                </td> \
            </tr>');
    } // for
    down_up_but_visible_datatable();
}
