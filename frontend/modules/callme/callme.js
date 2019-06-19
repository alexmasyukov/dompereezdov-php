
$(document).ready(function () {
    $(document).on('click', '#button_callme_form', function () {
        send_online_order('#callme_form');
    });
    
    $(document).on('click', '.button_online_order_form', function () {
        send_online_order('#online_order_form');
    });



    $(document).on('click', '[data-click=callme]',function () {
        $('.callme_modal').modal();
    });






function online_order(product_name, link) {
    $('.online_order_modal #online_order_form_product_link').val(link);
    $('.online_order_modal #online_order_form_product_name').val(product_name);
    $('.online_order_modal').modal();
}






function send_online_order(id_form) {
    var values_mas = [];
    var title_mas = [];
    var fields_mas = [];
    $err = 0;
    $site = '';
    $form_type = '';
    
    //Проверка на пустоту ТОЛЬКО INPUT т.к. в други проверять нечего
    massive_elements_valid = $(id_form).find("[data-massive-element-type]");
    for (var i = 0; i < massive_elements_valid.length; i++) {
        type_element = massive_elements_valid.eq(i).data('massive-element-type');
        id_element = massive_elements_valid.eq(i).attr('id');
        
        switch (type_element) {
            case 'input': 
            {
                // Проверяем на обязательность к заполнению
                if ($('#' + id_element).data('required-field') == 'yes') {
                    // Проверяем на пустоту
                    if ($.trim($('#' + id_element).val()) == '') {
                        $('#' + id_element).css('opacity', '1');
                        tblink_comments_7(4, '#' + id_element);
                        $err++;
                    }
                }
                break;
            }
        }
    }
    
    
    if ($err == 0) {
        massive_elements = $(id_form).find("[data-massive-element-type]");
        
        
        
        for (var i = 0; i < massive_elements.length; i++) {
            type_element = massive_elements.eq(i).data('massive-element-type');
            id_element = massive_elements.eq(i).attr('id');
            
            switch (type_element) {
                case 'input': 
                {
                    if ($('#' + id_element).data('form-type') != undefined) {
                        $form_type = $('#' + id_element).data('form-type');
                        break;
                    }
                    if ($('#' + id_element).data('site') != undefined) {
                        $site = $('#' + id_element).data('site');
                        break;
                    }
                    if ($('#' + id_element).data('tab') != undefined) {
                        $table = $('#' + id_element).data('tab');
                        break;
                    }
                    /*if ($('#' + id_element).data('product-link')!=undefined) {
                     $product_link = $('#' + id_element).data('product_link');
                     break;
                     }
                     if ($('#' + id_element).data('product-name')!=undefined) {
                     $product_name = $('#' + id_element).data('product-name');
                     break;
                     }*/
                    
                    values_mas.push($.trim($('#' + id_element).val()));
                    title_mas.push($('#' + id_element).data('title'));
                    fields_mas.push($('#' + id_element).data('field'));
                    break;
                }
                case 'textarea': 
                {
                    values_mas.push($.trim($('#' + id_element).val()));
                    title_mas.push($('#' + id_element).data('title'));
                    fields_mas.push($('#' + id_element).data('field'));
                    break;
                }
                case 'select': 
                {
                    values_mas.push($.trim($('#' + id_element + ' option:selected').text()));
                    title_mas.push($('#' + id_element).data('title'));
                    fields_mas.push($('#' + id_element).data('field'));
                    break;
                }		
                case 'datepicker': 
                {
                    values_mas.push($.trim($('#' + id_element).val()));
                    title_mas.push($('#' + id_element).data('title'));
                    fields_mas.push($('#' + id_element).data('field'));
                    break;
                }
                case 'checkbox': 
                {
                    checked = $('#' + id_element).prop("checked");
                    if (checked == false) {
                        checked = 'Нет'
                    }
                    ;
                    if (checked == true) {
                        checked = 'Да'
                    }
                    ;
                    values_mas.push('' + checked + '');
                    title_mas.push($('#' + id_element).data('title'));
                    fields_mas.push($('#' + id_element).data('field'));
                    break;
                }
                
            } //switch
        } //for			
//        
    //    console.log(fields_mas)
    //    console.log(title_mas)
    //    console.log(values_mas)
    //    console.log(massive_elements)
        
    //    console.log($table);
        
        
            $.ajax({
                type: "POST",
                url: "./frontend/modules/callme/send.php",
                dataType: 'json',
                data: {
                    fields_mas: fields_mas,
                    title_mas: title_mas,
                    values_mas: values_mas,
                    form_type: $form_type,
                    site: $site,
                    table: $table
                },
                success: function (json) { 
                    console.log(json);
                    if (json.result == '1') {
                        $(id_form).html('<p class="result-text">Спасибо! <br />Ваша заявка принята!</p>');
                    } 
                }, // success	
                error: function (jqxhr, textStatus, error) {  
                    var err = textStatus + ", " + error + ' ';
                    console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);
                    
                    $('#error_modal').find('.modal-body').empty();
                    $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                    $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                    $('#error_modal').modal();
                } // error  				
            }); // ajax
        
        
    } //if err = 0
}


function tblink_comments_7(n, name) {
        if (n) {
            var obj = $(name);
            (obj.css('opacity') == '0') ? obj.stop(true).animate({opacity: '1'}, 50) : obj.animate({opacity: '0'}, 50)
            setTimeout(function () {
                n--;
                tblink_comments_7(n, $(name));
            }, 150);
        };
    };

});