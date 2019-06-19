function load_data(sql_table_name, id, sql_images_table_name, sql_images_table_id_title, sql_features_table_name, sql_features_table_id_title, features_table_id) {
    if (id == '' || id == 'undefined') {
        return;
    }

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "/cms/php/load_data_sql.php",
            dataType: 'json',
            data: {
                sql_table_name: sql_table_name,
                id: id,
                sql_images_table_name: sql_images_table_name,
                sql_images_table_id_title: sql_images_table_id_title,
                sql_features_table_name: sql_features_table_name,
                sql_features_table_id_title: sql_features_table_id_title
            },
            success: function (json) {
                // console.log(json.sql_fields);
                // console.log(json.sql_values);

                sql_fields = json.sql_fields;
                sql_values = json.sql_values;
                image_data = json.image_data;
                features_data = json.features_data;
                documents_data = json.documents_data;

                // console.log(documents_data);
                // console.log(features_data.length);


                massive_elements = $('.page-content-wrapper').find("[data-massive-element-type]");

                // Строим массив изображений и сами изображения
                set_images_json_massive(image_data);


                features_start_matrix = [];
                // Заполняем таблицу характеристик
                if (features_data != '') {
                    for (var $el_stroka = 0; $el_stroka <= features_data.length - 1; $el_stroka++) {
                        // Добавляем пустую строку чтобы её заполнить   (в конце строки ещё один элемент для ПОМЕТКИ add, delete, update)
                        features_start_matrix[$el_stroka] = [
                            '', // 
                            '', // 
                            '', // 
                            '', // 
                            '', // 
                            '', // 
                        ];

                        //Заполняем строку элементами (Считается с нуля!!!)
                        for (var $el = 0; $el <= 4; $el++) {
                            // ($el_stroka*7)+$el сдвигает массив на уже полученные элементы
                            features_start_matrix[$el_stroka][$el] = features_data[$el_stroka][$el];
                        }

                    }

                    // Выводим массив в формате JSon
                    //$('.page-content-wrapper').find("#datatable_reviews").html(features_html);
                    console.log(features_start_matrix);
                    set_features_of_matrix(features_start_matrix);
                }


                for (var i = 0; i < massive_elements.length; i++) {

                    type_element = massive_elements.eq(i).attr('data-massive-element-type');
                    id_element = massive_elements.eq(i).attr('id');
                    table_field_element = massive_elements.eq(i).attr('data-table-field');

                    switch (type_element) {
                        case 'input': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    $('#' + id_element).val(sql_values[mas_el]);

                                    if ($('#' + id_element).attr('data-mask')) {
                                        $('#' + id_element).mask($('#' + id_element).attr('data-mask'));
                                    }
                                }
                            } //for
                            break;
                        }
                        case 'chosen': {
                            chosen = massive_elements.eq(i);

                            // Определям значение по заданному полю БД (table_field_element), из массива значений из БД)
                            $(sql_fields).each(function (index) {
                                if (table_field_element == sql_fields[index]) {
                                    town_id = sql_values[index];
                                }
                            })

                            // Так как индексы элементов списка не совпадают со значениями (если это id), а сделать
                            // выбранный элемент можно только по индексу, поэтому ищем индекс по нужному
                            // нам значению, найденного выше и делаем selected для этого элемента, затем обновляем плагин
                            // Проходим по всем option выпадающего списка (скрытого, который является настоящим)
                            $('#' + id_element + ' option').each(function (index) {
                                if ($(this).attr('value') == town_id) {
                                    change(chosen, index)
                                }
                                //console.log(index + ' ' + $(this).attr('value'));
                            });
                            function change(chosen, index) {
                                $(chosen)
                                    .prop('selectedIndex', index)
                                    .trigger("chosen:updated");
                            }

                            break;
                        }
                        case 'chosen_multiple': {
                            chosen_multiple = massive_elements.eq(i);

                            // Определям значение по заданному полю БД (table_field_element), из массива значений из БД)
                            $(sql_fields).each(function (index) {
                                if (table_field_element == sql_fields[index]) {
                                    multiple_array = sql_values[index].split(',');
                                }
                            })

                            // Примерно как работает смотрим выше
                            $('#' + id_element + ' option').each(function (index) {
                                this_option = $(this);
                                $.each(multiple_array, function (text_index) {
                                    if ($(this_option).attr('value') == multiple_array[text_index]) {
                                        $(this_option).prop('selected', true);
                                    }
                                })
                            });

                            $(chosen_multiple).trigger("chosen:updated");
                            break;
                        }
                        case 'textarea': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    $('#' + id_element).val(sql_values[mas_el]);
                                }
                            } //for
                            break;
                        }
                        case 'select': {
                            $("#" + id_element + " option:selected").removeAttr("selected");
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    if ($("#" + id_element).attr('data-select-of-type')) {
                                        $("#" + id_element + " [value='" + sql_values[mas_el] + "']").first().attr("selected", "selected");
                                    } else {
                                        $("#" + id_element + " :contains('" + sql_values[mas_el] + "')").first().attr("selected", "selected");
                                    }
                                    ;


                                } // if совпадение 
                            } // for
                            break;
                        }
                        case 'datepicker': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    if (sql_values[mas_el] != '0000-00-00') {
                                        $('#' + id_element).data('date', sql_values[mas_el]);
                                        $('#' + id_element).attr('data-date', sql_values[mas_el]);
                                        $('#' + id_element + ' .date_value_input').val(sql_values[mas_el])
                                    } else {
                                        $('#' + id_element).data('date', '2014-01-01');
                                        $('#' + id_element).attr('data-date', '2014-01-01');
                                        $('#' + id_element + ' .date_value_input').val('2014-01-01');
                                    }
                                    $('#' + id_element).datepicker({
                                        autoclose: true,
                                        format: 'yyyy-mm-dd',
                                        minDate: '2000-01-01'
                                    });
                                }
                            } //for
                            break;
                        }
                        case 'label': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    if ($('#' + id_element).data("save-nospace") == 'yes') {
                                        $('#' + id_element).text(number_format(sql_values[mas_el]));
                                    } else {
                                        $('#' + id_element).text(sql_values[mas_el]);
                                    }
                                }
                            } //for
                            break;
                        }
                        case 'link': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    if (sql_values[mas_el] != '' || sql_values[mas_el] != 'none')
                                        $('#' + id_element).html(sql_values[mas_el]);
                                    $('#' + id_element).attr('href', sql_values[mas_el]);
                                    $('#' + id_element).attr('target', '_blank');
                                    if (sql_values[mas_el] != '') {
                                        //Убираем загрузчик
                                        //Выводим кнопку удалить
                                        $('#uploader').css('display', 'none');
                                        $('#delete_file_but').css('display', '');
                                    } else {
                                        $('#uploader').css('display', '');
                                        $('#delete_file_but').css('display', 'none');
                                    }
                                }
                            } //for
                            break;
                        }
                        case 'radio': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    $("[name='cat_radio']").each(function () {
                                        $(this).parent().removeClass('checked');
                                        $(this).attr('checked', 'false');
                                    });


                                    $("[name='cat_radio'][value='" + sql_values[mas_el] + "']").each(function () {
                                        //console.log(this);
                                        $(this).parent().addClass('checked');
                                        $(this).attr('checked', 'checked');
                                    });
                                }
                            } //for
                            break;
                        }
                        case 'check': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    if (sql_values[mas_el] == '1') {
                                        $("#" + id_element).parent().addClass('checked');
                                        $("#" + id_element).attr('checked', 'checked');
                                    }
                                }
                            } //for
                            break;
                        }
                        case 'icon': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    if (sql_values[mas_el] != '') {
                                        $('.preview').html('<img src="' + sql_values[mas_el] + '" /><div class="helper"></div>');
                                        $('.icon_preview a').text('Удалить');
                                    }
                                }
                            } //for
                            break;
                        }
                        case 'ckeditor': {
                            for (var mas_el = 0; mas_el < sql_fields.length; mas_el++) {
                                if (table_field_element == sql_fields[mas_el]) {
                                    $('#' + id_element).val(sql_values[mas_el]);
                                }
                            } //for
                            break;
                        }

                    } //switch
                } //forJSON.stringify(
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

    }); //ready	
} // function 


function save_data(id_form, id, sql_table_name, sql_images_table_name, sql_images_table_id_title, images_data_id, go_link, sql_features_table_name, sql_features_table_id_title) {
    $(document).ready(function () {

        var sql_values = [];
        var sql_fields = [];
        $('.save_div').fadeIn(200);

        massive_elements = $(id_form).find("[data-massive-element-type]");
        //console.log(massive_elements);
        for (var i = 0; i < massive_elements.length; i++) {
            type_element = massive_elements.eq(i).data('massive-element-type');
            id_element = massive_elements.eq(i).attr('id');

            switch (type_element) {
                case 'input': {
                    // Проверка на заполненность input -> data-necessarily=true
                    //console.log($('#' + id_element).val());
                    if ($('#' + id_element).attr('data-necessarily') == 'true'
                        && $.trim($('#' + id_element).val()) == ''
                        && id_element != 'meta_name'
                        && id_element != 'meta_keywords'
                        && id_element != 'meta_description'
                    ) {
                        //console.log('эл - ' + $('#' + id_element).val() + id_element);
                        find_error_of_input(massive_elements, 'input');
                        return;
                    }
                    ;
                    sql_values.push($.trim($('#' + id_element).val()));
                    sql_fields.push($('#' + id_element).data('table-field'));
                    unstyle_error_input(massive_elements, 'input');
                    break;
                }
                case 'textarea': {
                    // Проверка на заполненность input -> data-necessarily=true
                    if ($('#' + id_element).attr('data-necessarily') == 'true'
                        && $.trim($('#' + id_element).val()) == ''
                        && id_element != 'meta_name'
                        && id_element != 'meta_keywords'
                        && id_element != 'meta_description'
                    ) {
                        find_error_of_input(massive_elements, 'textarea');
                        return;
                    }
                    ;
                    sql_values.push($.trim($('#' + id_element).val()));
                    sql_fields.push($('#' + id_element).data('table-field'));
                    unstyle_error_input(massive_elements, 'textarea');
                    break;
                }
                case 'select': {
                    sql_values.push($.trim($('#' + id_element + ' option:selected').val()));
                    sql_fields.push($('#' + id_element).data('table-field'));
                    break;
                }
                case 'check': {
                    sql_values.push($.trim($('#' + id_element + ':checked').val()));
                    sql_fields.push($('#' + id_element).data('table-field'));
                    break;
                }
                case 'datepicker': {
                    sql_values.push($.trim($('#' + id_element + ' .date_value_input').val()));
                    sql_fields.push($('#' + id_element).data('table-field'));
                    break;
                }
                case 'chosen_multiple': {
                    var selected_options = [];
                    $('#' + id_element + ' option:selected').each(function (index) {
                        selected_options.push($.trim($(this).val()))
                    });
                    console.log(selected_options.length);
                    if (selected_options.length == 0) {
                        show_error($('#pain_error_label'), true);
                        return;
                    }
                    sql_values.push($.trim(selected_options.join()));
                    sql_fields.push($('#' + id_element).data('table-field'));
                    show_error($('#pain_error_label'), false);
                    break;
                }
                case 'radio': {
                    for (var t = 0; t < sql_fields.length; t++) {
                        if (sql_fields[t] == $('#' + id_element).data('table-field')) {
                            break;
                        }
                        if (t == sql_fields.length - 1) {
                            name_of_radio = $('#' + id_element).attr('name');
                            $("[name='" + name_of_radio + "']:checked").each(function () {
                                real_value = $(this).val();
                            });
                            sql_values.push(real_value);
                            sql_fields.push($('#' + id_element).data('table-field'));
                        }
                    }
                    break;
                }
                case 'label': {
                    // Проверка на заполненность input -> data-necessarily=true
                    if ($('#' + id_element).attr('data-necessarily') == 'true'
                        && $.trim($('#' + id_element).val()) == ''
                        && id_element != 'meta_name'
                        && id_element != 'meta_keywords'
                        && id_element != 'meta_description'
                    ) {
                        find_error_of_input(massive_elements, 'label');
                        return;
                    }
                    ;
                    if ($('#' + id_element).data("save-nospace") == 'yes') {
                        sql_values.push($.trim(nospace($('#' + id_element).text())));
                    } else {
                        sql_values.push($.trim($('#' + id_element).text()));
                    }
                    sql_fields.push($('#' + id_element).data('table-field'));
                    unstyle_error_input(massive_elements, 'label');
                    break;
                }
                case 'link': {
                    sql_values.push($.trim($('#' + id_element).text()));
                    sql_fields.push($('#' + id_element).data('table-field'));
                    break;
                }
                case 'ckeditor': {
                    // Два варианта работы - редактор может использоваться для текста из таблицы БД, которая прописывается на форме
                    // и может использоваться для текста из ДРУГОЙ таблицы (будет иметь атрибуты data-save-table)
                    var data_ckeditor_save = CKEDITOR.instances[id_element].getData().replace(/[\n\r]/g, '')

                    var attr = $('#' + id_element).attr("data-save-table");
                    if (attr !== undefined && attr !== false) {
                        // Сохраняем данные в таблицу БД указанную в атрибуте через ajax
                        $.ajax({
                            type: "POST",
                            url: "/cms/php/save_wiget_data_sql.php",
                            dataType: 'json',
                            data: {
                                sql_table_name: $('#' + id_element).attr("data-save-table"),
                                sql_where: $('#' + id_element).attr("data-save-where"),
                                sql_set_filed: $('#' + id_element).attr("data-save-set-value-field"),
                                sql_set_value: data_ckeditor_save
                            },
                            success: function (json) {
                                console.log(json)
                            },
                            error: function (jqxhr, textStatus, error) {
                                var err = textStatus + ", " + error + ' ';
                                console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);

                                $('#error_modal').find('.modal-body').empty();
                                $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                                $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                                $('#error_modal').modal();
                            }
                        })
                    } else {

                        console.log(data_ckeditor_save);
                        sql_values.push($.trim(data_ckeditor_save));
                        sql_fields.push($('#' + id_element).data('table-field'));
                        break;
                    }
                }
            } //switch
        } //for

        // Формируем массив ХАРАКТЕРИСТИК
        var features_matrix = [];

        //images_matrix[images_matrix.length] = ['',$id_my_works, big_img, small_img, '0', 'add', 'Изображение ' + (images_matrix.length+1), (images_matrix.length+1)];
        features_trs = $('#datatable_reviews tbody').find("tr");

        if (features_trs.length > 0) {
            for (var tr_number = 0; tr_number <= features_trs.length - 1; tr_number++) {
                features_matrix[features_matrix.length] = [
                    $('#sql_id_elemet').val(),
                    features_trs.eq(tr_number).attr('data-features-id'),
                    features_trs.eq(tr_number).find('.feature_value').val(),
                    features_trs.eq(tr_number).find('.feature_sort').val(),
                ];
            } // for

        } // if


        // Формируем массив ДОКУМЕНТОВ 30.04.2015
        var documents_matrix = [];
        documents_trs = $('#datatable_documents tbody').find("tr");
        sort = 0;
        if (documents_trs.length > 0) {
            for (var tr_number = 0; tr_number <= documents_trs.length - 1; tr_number++) {
                sort += 10;
                documents_matrix[documents_matrix.length] = [
                    documents_trs.eq(tr_number).attr('data-id'),
                    sort
                ];
            } // for
        } // if

        console.log(documents_matrix)
        console.log(sql_fields)
        console.log(features_matrix);


        $.ajax({
            type: "POST",
            url: "/cms/php/save_data_sql.php",
            dataType: 'json',
            data: {
                sql_table_name: sql_table_name,
                sql_values: $.toJSON(sql_values),
                sql_fields: $.toJSON(sql_fields),
                sql_images_table_name: sql_images_table_name,
                sql_images_table_id_title: sql_images_table_id_title,
                images_matrix: images_matrix,
                sql_features_table_name: sql_features_table_name,
                sql_features_table_id_title: sql_features_table_id_title,
                features_matrix: features_matrix,
                documents_matrix: documents_matrix,
                id: id
            },
            success: function (json) {
                // console.log(json);
                //
                // console.log(images_matrix);
                // console.log(sql_images_table_name);
                // console.log(sql_images_table_id_title);
                // console.log(sql_values)
                // console.log(sql_fields)
                // console.log('Матрица: ')
                // console.log(features_matrix);
                // console.log('id: ' + id);
                // console.log(json);
                // console.log('Матрица: ')
                // console.log(features_matrix);
                // console.log(sql_features_table_name + '  ' + sql_features_table_id_title);

                if (json.result == '1') {
                    set_images_json_massive(json.image_data);

                    setTimeout(function () {
                        $('.save_div').fadeOut(200);
                        if (go_link != '') {
                            location.href = go_link;
                        }
                    }, 1000);
                }

            },
            error: function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error + ' ';
                console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);

                $('#error_modal').find('.modal-body').empty();
                $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                $('#error_modal').modal();
            }
        });


    })
    ; // ready


}
;


function set_images_json_massive(image_data) {
    // приводим к нужному виду массив изображений
    // Очищаем массив
    images_matrix = [];

    // массив получаем изображений (Элементы в длинном массиве через запятую)
    var arrays = image_data.split(';');


    //console.log(image_data);

    // Если первичный массив изображений передан, то заполняем конечный массив изображений
    if (image_data != '') {
        for (var $el_stroka = 0; $el_stroka <= ((arrays.length - 1) / 8) - 1; $el_stroka++) {
            // Добавляем пустую строку чтобы её заполнить   (в конце строки ещё один элемент для ПОМЕТКИ add, delete, update)
            images_matrix[$el_stroka] = [
                '', // id_из_ДБ
                '', // id_?
                '', // big_img
                '', // small_img
                '', // general
                '', // метка
                '', // Имя
                '' // Сортировка
            ];

            //Заполняем строку элементами (Считается с нуля!!!)
            for (var $el = 0; $el <= 7; $el++) {
                // ($el_stroka*7)+$el сдвигает массив на уже полученные элементы
                images_matrix[$el_stroka][$el] = arrays[($el_stroka * 8) + $el];
            }
        }

        // Выводим массив в формате JSon
        $('.page-content-wrapper').find("#images_data").text(JSON.stringify(images_matrix));

        // Выстраиваем изображения из массива
        body_images_list_get_my_works();
    } else {
        $('.page-content-wrapper').find("#images_data").val('');
    }
}


function delete_element(id,
                        page,
                        sql_table_name,
                        go_link,
                        sql_images_table_name,
                        sql_images_table_id_title,
                        sql_features_table_name,
                        sql_features_table_id_title) {
    var r = confirm("Удалить?");
    if (r == true) {
        $.getJSON("/cms/php/delete_element.php", {
            sql_table_name: sql_table_name,
            type: 'element',
            id: id,
            sql_images_table_name: sql_images_table_name,
            sql_images_table_id_title: sql_images_table_id_title,
            sql_features_table_name: sql_features_table_name,
            sql_features_table_id_title: sql_features_table_id_title
        })
            .done(function (json) {
                //console.log(json);
                if (json.result == '1') {
                    if (go_link != '') {
                        location.href = go_link;
                    }
                }

            })
            .fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error + ' ';
                console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);

                $('#error_modal').find('.modal-body').empty();
                $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                $('#error_modal').modal();
            });
    }
}


function delete_category(sql_table_name, id) {
    if (confirm("Удалить?")) {
        $.getJSON("/cms/php/delete_element.php", {
            sql_table_name: sql_table_name,
            id: id,
            type: 'category'
        })
            .done(function (json) {
                //console.log(json);
                if (json.result == '1') {
                    location.href = location.href;
                }

            })
            .fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error + ' ';
                console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);

                $('#error_modal').find('.modal-body').empty();
                $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                $('#error_modal').modal();
            });
    }
}


function show_error(obj, boolean) {
    if (boolean === true) {
        $(obj).addClass('error');
        if ($('.portlet-body').find('.alert-error').length == 0) {
            $('.portlet-body').prepend(
                '<div class="alert alert-error"> \
                        <button class="close" data-dismiss="alert"></button> \
                        <strong>Внимание!</strong> Заполните обязательные поля! \
                </div>');
        }
    } else {
        $(obj).removeClass('error');
        $('.portlet-body .alert-error').remove();
    }
}


function find_error_of_input(obj_array, massive_element_type) {
    $('.save_div').fadeOut(200);

    for (var i = 0; i < obj_array.length; i++) {
        if (massive_elements.eq(i).data('massive-element-type') == massive_element_type) {

            if (massive_elements.eq(i).attr('data-necessarily') == 'true'
                && $.trim(massive_elements.eq(i).val()) == ''
                && massive_elements.eq(i).attr('id') != 'meta_name'
                && massive_elements.eq(i).attr('id') != 'meta_keywords'
                && massive_elements.eq(i).attr('id') != 'meta_description'
            ) {
                massive_elements.eq(i).css('border-color', '#E02222');
                if ($('.portlet-body').find('.alert-error').length == 0) {
                    $('.portlet-body').prepend(
                        '<div class="alert alert-error"> \
                                <button class="close" data-dismiss="alert"></button> \
                                <strong>Внимание!</strong> Заполните обязательные поля! \
                        </div>');
                }

            }

        }

    }
}


function unstyle_error_input(obj_array, massive_element_type) {
    $('.save_div').fadeOut(200);
    for (var i = 0; i < obj_array.length; i++) {
        if (massive_elements.eq(i).data('massive-element-type') == massive_element_type) {
            massive_elements.eq(i).css('border-color', '#E5E5E5');
        }
    }
    $('.portlet-body .alert-error').remove();
}


function set_emty_parent_category() {
    $(document).ready(function () {
        $('#category_parent_id').val('0');
    });
}


function get_menu_data(type, html_obj, table) {
    //type - categories / materials
    switch (type) {
        case 'categories': {
            $('#modal_menu_module_categories #myModalLabel1').text('Выберете категорию');
            $.getJSON("/cms/php/get_menu_data.php", {
                sql_table_name: table,
                type: 'categories'
            })
                .done(function (res) {
                    $(html_obj).html(res.data);
                    $('#modal_menu_module_categories .load_div').css('display', 'none');
                })
                .fail(function (jqxhr, textStatus, error) {
                    var err = textStatus + ", " + error + ' ';
                    console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);

                    $('#error_modal').find('.modal-body').empty();
                    $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                    $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                    $('#error_modal').modal();
                });
            return
        }

        case 'content': {
            $('#modal_menu_module_categories .load_div').css('display', 'block');
            $('#modal_menu_module_categories #myModalLabel1').text('Выберете материал');
            $.getJSON("/cms/php/get_menu_data.php", {
                sql_table_name: table,
                type: 'content'
            })
                .done(function (res) {
                    $('#catalog_products_table').dataTable().fnDestroy(); // Убиваем таблицу
                    $(html_obj).find('tbody').empty();
                    $(html_obj).find('tbody').append(res.data);
                    $('#catalog_products_table').dataTable({
                        "iDisplayLength": 40
                    }); //создаем таблицу
                    jQuery('#catalog_products_table_wrapper .dataTables_filter input').addClass("form-control input-small input-inline"); // modify table search input
                    jQuery('#catalog_products_table_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
                    jQuery('#catalog_products_table_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
                    $('#catalog_products_table_length').empty();
                    $('#modal_menu_module_categories .load_div').css('display', 'none');
                })
                .fail(function (jqxhr, textStatus, error) {
                    var err = textStatus + ", " + error + ' ';
                    console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);

                    $('#error_modal').find('.modal-body').empty();
                    $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                    $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                    $('#error_modal').modal();
                });
            return
        }

        case 'materials_of_category': {
            return
        }
    }
}


var $temp_text = '';
var $temp_link = '';


function set_menu_link(obj, id) {
    $('#menu_link').css({
        'width': '0px',
        'height': '0px',
        'visibility': 'hidden',
        'padding': '0px',
        'margin-top': '0px'
    });

    if (id == '') { //Происходит выбор модуля
        // Название ссылки
        $temp_text = $(obj).text();

        // Формирпуем ссылку
        $temp_link = $(obj).attr('data-link')

        // Если указана страница по умолчанию
        if ($(obj).attr('data-page-default') != '') {
            $temp_link += '&page=' + $(obj).attr('data-page-default');
        }

        // Если указана таблица категорий, значит выводим следующее окно с выбором категорий
        if ($(obj).attr('data-table-category') != '') {
            $('#modal_menu_module').modal('hide');
            $('#modal_menu_module_categories').modal();
            get_menu_data('categories', '#get_menu_data_div', $(obj).attr('data-table-category'));
            return;
        }

        // Если указана таблица с контентом, значит выводим следующее окно с выбором контента
        if ($(obj).attr('data-table') != '') {
            $('#modal_menu_module').modal('hide');
            $('#modal_menu_module_categories').modal('hide');
            $('#modal_menu_content').modal();
            get_menu_data('content', '#catalog_products_table', $(obj).attr('data-table'));
            return;
        }

        if ($(obj).attr('data-table') == '' && $(obj).attr('data-table-category') == '') {
            if ($(obj).attr('data-link') == '') {
                $temp_link = 'none';
            }
        }

        // Если не указано ни того ни другого, пишем все в input. Выбор сделан
        $('#menu_link_text').val($temp_text);
        $('#menu_link').val($temp_link);
        $temp_link = '';
        $temp_text = '';
        $('#modal_menu_module').modal('hide'); // Скрываем окно выбора модуля

        if ($(obj).text() == 'Специальная ссылка') {
            $('#menu_link').css({
                'width': '',
                'height': '',
                'visibility': '',
                'padding': '',
                'margin-top': '10px'
            });
            $('#menu_link').val('');
        }
        ;

    } else { //Происходит выбор категории или контента

        $temp_link += '&id=' + id;
        // ЭТОТ data-id СЛУЖИТ ДЛЯ ДАЛЬНЕЙШЕЙ ПРОВЕРКЕ ПРИ НАЖАТИИ НА ЛЮБУЮ ОБЛАСТЬ ЭКРАНА РЯДОМ С МОДАЛЬЮ (МОДАЛЬ ПРИ ЭТОМ ЗАКРЫВАЕТСЯ)
        // А ЭТО МОЖЕТ ПРИВЕСТИ К ОШИБКЕ!!! (МОДУЛЬ БУДЕТ ПРОПИСАН А ID НЕТ!!!)
        $temp_text += ' > ' + $(obj).text();
        // пишем все в input. Выбор сделан
        $('#menu_link_text').val($temp_text);
        $('#menu_link').val($temp_link);
        $temp_link = '';
        $temp_text = '';
        $('#modal_menu_module_categories').modal('hide'); // Скрываем окно выбора категории
        $('#modal_menu_content').modal('hide'); // Скрываем окно выбора категории
    }
    ;
}


$(document).ready(function () {

    // $('[data-is-cpu="true"]').keyup(function () {
    //     $('#cpu').val(translit($(this).val()))
    //     return false;
    // })


    $('.select_icon').click(function () {
        if ($(this).text() == 'Удалить') {
            $('.preview').html('<p>Нет</p><div class="helper"></div>');
            $('#icon').val('');
            $(this).text('Выбрать');
        } else {
            $('#modal_menu_module2').modal();
        }
    });

    $('.icons_window .icon').click(function () {
        imgp = $(this).find('img').attr('src');
        $('.preview').html('<img src="' + imgp + '" /><div class="helper"></div>');
        $('#icon').val(imgp);
        $('.icon_preview a').text('Удалить');
        $('#modal_menu_module2').modal('hide');
    });

    $('.preview').click(function () {
        $('#modal_menu_module2').modal();
    });

    if ($('body').find('.ckeditor').length > 0) {
        // АКТИВИРЕМ РЕДАКТОР
        CKEDITOR.replaceAll('ckeditor', {
            'filebrowserBrowseUrl': 'plugins/ckeditor/kcfinder/browse.php?type=files',
            'filebrowserImageBrowseUrl': 'plugins/ckeditor/kcfinder/browse.php?type=images',
            'filebrowserFlashBrowseUrl': 'plugins/ckeditor/kcfinder/browse.php?type=flash',
            'filebrowserUploadUrl': 'plugins/ckeditor/kcfinder/upload.php?type=files',
            'filebrowserImageUploadUrl': 'plugins/ckeditor/kcfinder/upload.php?type=images',
            'filebrowserFlashUploadUrl': 'plugins/ckeditor/kcfinder/upload.php?type=flash'
        });

        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.on('instanceReady', function (ev) {
                // Output paragraphs as <p>Text</p>.
                ev.editor.dataProcessor.writer.setRules('*', {
                    indent: false,
                    breakBeforeOpen: true,
                    breakAfterOpen: false,
                    breakBeforeClose: false,
                    breakAfterClose: true
                });
            });
        }
    }


});

function nospace(str) {
    var VRegExp = new RegExp(/\s*/g);
    var VResult = str.replace(VRegExp, '');
    return VResult
}

function number_format(str) {
    return str.replace(/(\s)+/g, '').replace(/(\d{1,3})(?=(?:\d{3})+$)/g, '$1 ');
}


function translit(my_text) {
// Символ, на который будут заменяться все спецсимволы
    var space = '-';
// Берем значение из нужного поля и переводим в нижний регистр
    var text = my_text.toLowerCase();

// Массив для транслитерации
    var transl = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
        'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
        'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
        'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': space, 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya',
        ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
        '#': space, '$': space, '%': space, '^': space, '&': space, '*': space,
        '(': space, ')': space, '-': space, '\=': space, '+': space, '[': space,
        ']': space, '\\': space, '|': space, '/': space, '.': space, ',': space,
        '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
        '?': space, '<': space, '>': space, '№': space, ' ': space
    }

    var result = '';
    var curent_sim = '';

    for (i = 0; i < text.length; i++) {
        // Если символ найден в массиве то меняем его
        if (transl[text[i]] != undefined) {
            if (curent_sim != transl[text[i]] || curent_sim != space) {
                result += transl[text[i]];
                curent_sim = transl[text[i]];
            }
        }
        // Если нет, то оставляем так как есть
        else {
            result += text[i];
            curent_sim = text[i];
        }
    }

    result = TrimStr(result);
    return result;
}
function TrimStr(s) {
    s = s.replace(/^-/, '');
    return s.replace(/-$/, '');
}