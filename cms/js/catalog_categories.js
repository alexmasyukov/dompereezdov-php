//function set_checkboxes_categories(id_view_cotegory) {
//	li_array = $(id_view_cotegory).find('li');
//	
//	for (var el = 0; el<=li_array.length-1; el++) 
//		{
//			$real_li = '';
//			$real_li = li_array.eq(el).find('li');
//			console.log($real_li);
//			
//			if ($real_li.length == 0) {
//				li_array.eq(el).prepend('<input \
//					name="cat_radio" \
//					value="'+li_array.eq(el).attr('data-id-number')+'" \
//					type="radio" \
//					style="margin-left: 0px;" \
//					data-massive-element-type="radio" \
//					data-table-field="category_id" \
//					id = "product_category_id" \
//				/>');
//			}
//		};
//	
//	//$li_real = $(id_view_cotegory).find('li');
//	//console.log($li_array);
//}
//



$(document).ready(function (){
    $('#product_category_id').live("click", function(){
            /*var allCheckboxes = $(".categories_check input:checkbox:enabled");
            var notChecked = allCheckboxes.not(':checked');
            allCheckboxes.removeAttr('checked');
            notChecked.attr('checked', 'checked');

            //$('body').find('.categories_check').attr('checked', '');
            //$(this).attr('checked', 'checked'); */

            console.log($('#product_category_id:checked').val());
    });



    $('.save_sort_categories').live("click", function(){
        save_sort_and_parents_categories('.categories_container', $(this).data('sql-table'))
    })



    down_up_but_visible(); //Создаем стрелки для перетаскивания категорий


    $('.visual_plus').live("click", function(){
        visual_ul = $(this).parent().siblings('.down_box');
        if (visual_ul.css('display')=='none') {
            visual_ul.css('display', '');
            $(this).html('-');
        } else {
            visual_ul.css('display', 'none');
            $(this).html('+');
        }
    });




    $('.visual_but .fa-arrow-circle-down').live("click", function(){
        this_li = $(this).closest('li');
        next_li = $(this_li).next('li');

        if (next_li.length != 0) {
            $(this_li).animate({
                backgroundColor: "#35AA47",
                color: "#fff"
            }, 200);
            $(this_li).insertAfter(next_li);
            $(this_li).animate({
                backgroundColor: "#fff",
                color: "#333"
            }, 300);
        }

        down_up_but_visible(this_li);
    });




    $('.visual_but .fa-arrow-circle-up').live("click", function(){
        this_li = $(this).closest('li');
        prev_li = $(this_li).prev('li');

        if (prev_li.length != 0) {
            $(this_li).animate({
                backgroundColor: "#35AA47",
                color: "#fff"
            }, 200);
            $(this_li).insertBefore(prev_li);
            $(this_li).animate({
                backgroundColor: "#fff",
                color: "#333"
            }, 300);
        } 

        down_up_but_visible(this_li);
    });


   

    $(".page-content li").draggable({
        revert: true,
        revertDuration: 150,
        opacity: 0.5,
        //helper: "clone",
        drag: function( event, ui ) {
            
        },
        stop: function( event, ui ) {

        }
    });
        
        
        
        
    $(".page-content .v_elem, .no_parent_category_div").droppable({
        tolerance: "pointer",
        hoverClass: "ui-state-active",
        drop: function(event, ui) {
            my_ul =  $(this).parent().children('ul');
            parent_li = ui.draggable.parent();

            if ($(this).attr('id') == 'no_parent_category_div') {
                $(this).next('ul').prepend(ui.draggable);
                
                if ($(parent_li).children().length == 0) {
                    parent_li.remove();
                }

                down_up_but_visible();
                return;
            }

            if (my_ul.length != 0) { //Если ul найден
                my_ul.append(ui.draggable);
            } else {
                $(this).parent().append('<ul class="down_box"></ul>');
                $(this).parent().find('ul').append(ui.draggable);
            }

            if ($(parent_li).children().length == 0) {
                parent_li.remove();
            }

            down_up_but_visible();
        }
    });

        


    function delete_terr(ul) {
        $(ul).find('.v_elem').css('color', 'inherit').removeClass('terr');
    }


       
    function down_up_but_visible() {
        all_li = $('.page-content .down_box').find('li');

        $('.terr').css('color', 'red');

        for (var i = 0; i < all_li.length; i++) {

            all_li.eq(i).find('.fa-arrow-circle-up, .fa-arrow-circle-down').css('visibility', 'visible');

            if (all_li.eq(i).prev('li').length == 0) {
                all_li.eq(i).find('.fa-arrow-circle-up').css('visibility', 'hidden');
                all_li.eq(i).find('.fa-arrow-circle-down').css('visibility', 'visible');
            }

            if (all_li.eq(i).next('li').length == 0) {
                all_li.eq(i).find('.fa-arrow-circle-down').css('visibility', 'hidden');
                all_li.eq(i).find('.fa-arrow-circle-up').css('visibility', 'visible');
            }

            if (all_li.eq(i).next('li').length == 0 && all_li.eq(i).prev('li').length == 0) {
                all_li.eq(i).find('.fa-arrow-circle-up, .fa-arrow-circle-down').css('visibility', 'hidden');
            }

            if (all_li.eq(i).find('ul').length == 0) {
                all_li.eq(i).find('.visual_plus').css('visibility', 'hidden');
            } else {
                all_li.eq(i).find('.visual_plus').css('visibility', 'visible');
            }
        }
    }



    function save_sort_and_parents_categories(html_obj, sql_table) {
        li_array = $(html_obj).find('li');
        sql_query = [];
        sort = 0;
        for (var el = 0; el <= li_array.length - 1; el++) {
            real_li = '';
            real_li_id = li_array.eq(el).data('id-number');
            real_li_parent_id = '';
            real_li_parent_id = li_array.eq(el).parents('li').data('id-number'); //
            sort += 10;
            if (real_li_parent_id == undefined) {
                real_li_parent_id = 0;
            }

            sql_query[sql_query.length] = "UPDATE " + sql_table + " SET parent_id=" + real_li_parent_id + ", sort=" + sort + " WHERE id=" + real_li_id + "; ";
        }

//       console.log(json.result);

        $('.save_div').fadeIn(100);
        $.ajax({
            type: "POST",
            url: "/cms/php/set_categories_sorting.php",
            dataType: 'json',
            data: {
                sql_table_name: sql_table,
                sql_query: sql_query
            },
            success: function (json) {
                $('.save_div').fadeOut(100);
                
                //$('.categories_container').html(result);
            }, // success	
            error: function (jqxhr, textStatus, error) {
                $('.save_div').fadeOut(100);
                var err = textStatus + ", " + error + ' ';
                console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);
                $('#error_modal').find('.modal-body').empty();
                $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                $('#error_modal').modal();
            } // error  				
        }); // ajax
    } // save_sort_and_parents_categories



//
// $('.visual_but .fa-caret-down').live("click", function() {
//        this_v_elem = $(this).closest('.v_elem'); //.
//        this_li = $(this).closest('li');
//
//        next_ul = this_li.find('ul'); //Внутри ul список
//        next_ul_ul = this_li.find('ul').find('ul'); //Внутри ul список, а внутри этого списка тоже ul
//        next_li = this_li.next('li'); //Следуюший элемент li
//        next_li_ul = this_li.next('li').children('ul'); //Следуюший элемент li содержащий список li
//        delete_terr('.page-content .down_box');
//
//
//        if (next_ul_ul.length != 0) { //Внутри ul список, а внутри этого списка тоже ul
//            $v_elem_sopernik = this_li.children('ul').children('li:first-child').children('.v_elem:first-child');
//
//            this_li.children('ul').children('li:first-child').children('.v_elem:first-child').replaceWith(function(){
//                return '<div class="v_elem terr">' + $(this_v_elem).html() + '</div>';
//            });
//            this_v_elem.replaceWith($v_elem_sopernik);
//
//            down_up_but_visible();
//            return;
//        }
//
//
//
//        if (next_ul.length != 0) { //Внутри ul список
//            $v_elem_sopernik = this_li.children('ul').children('li:first-child').children('.v_elem:first-child');
//
//            this_li.children('ul').children('li:first-child').children('.v_elem:first-child').replaceWith(function(){
//                return '<div class="v_elem terr">' + $(this_v_elem).html() + '</div>';
//            });
//            this_v_elem.replaceWith($v_elem_sopernik);
//
//            down_up_but_visible();
//            return;
//        }
//
//
//
//
//        if(next_li_ul.length != 0) { //Следуюший элемент li содержащий список li
//            $v_elem_sopernik = next_li_ul.parent().children('.v_elem:first-child');
//
//            next_li_ul.parent().children('.v_elem:first-child').replaceWith(function(){
//                return '<div class="v_elem terr">' + $(this_v_elem).html() + '</div>';
//            });
//            this_v_elem.replaceWith($v_elem_sopernik);
//
//            down_up_but_visible();
//            return;
//        }
//
//
//
//
//        if (next_li.length != 0) { //Следуюший элемент li
//            $(this_li).insertAfter(next_li);
//            this_li.children('.v_elem:first-child').addClass('terr');
//
//
//            down_up_but_visible();
//            return;
//        }
//
//
//
//
//
//
//        $el_obj = this_li.parents('li');
//        for (var el = 0; el<=60; el++) {
//            if ($el_obj.eq(el).next('li').length != 0) {
//                next_next_li =  $el_obj.eq(el).next('li');
//                break;
//            }
//        }
//
//
//        if (next_next_li.length != 0) {
//            delete_terr('.page-content .down_box');
//            $v_elem_sopernik = next_next_li.children('.v_elem:first-child');
//
//            next_next_li.children('.v_elem:first-child').replaceWith(function(){
//                return '<div class="v_elem terr">' + $(this_v_elem).html() + '</div>';
//            });
//            this_v_elem.replaceWith($v_elem_sopernik);
//
//            down_up_but_visible();
//            return;
//        }
//    });
//
//       

});