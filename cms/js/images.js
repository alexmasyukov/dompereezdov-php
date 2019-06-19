var images_matrix = [];

/* ----------------------------------------------------- ЗАГРУЗКА ИЗОБРАЖЕНИЯ ----------------------------------------------- */

function ajaxFileUpload2(file_id, images_path_text, big_img_width_val, big_img_height_val, small_img_width_val, small_img_height_val) {
    // Функция загрузки изображений на сервер и их конвертации
    //alert(images_path_text + ' -- ' + images_path_text + ' -- ' + big_img_width_val + ' -- ' + big_img_height_val + ' -- ' + small_img_width_val + ' -- ' + small_img_height_val);

    $('.load_div').fadeIn(200);

    $.ajaxFileUpload({
        url: '../cms/system/fileupload/doajaxfileupload2.php',
        secureuri: false,
        fileElementId: file_id,
        dataType: 'json',
        data: {
            images_path: images_path_text,
            big_img_width: big_img_width_val,
            big_img_height: big_img_height_val,
            small_img_width: small_img_width_val,
            small_img_height: small_img_height_val
        },
        beforeSend: function () {
            // Анимация на процесс загрузки
            //$("#loading2").show();

        },
        complete: function () {
            // Завершена обработка, убираем анимацию
            $('.load_div').fadeOut(200);
        },
        success: function (data, status) {
            if (typeof (data.error) != 'undefined') {
                if (data.error != '') {
                    alert(data.error);
                } else {
                    // УСПЕШНО ЗАГРУЖЕНО
                    // получаем 2 переменные 	 data.bigimg   data.smallimg
                    // Если возращено data.bigimg=NO или data.smallimg=NO то изображние не загружено, выводим ошибку и выходим с функции
                    if (data.smallimg == "NO" || data.bigimg == 'NO') {
                        alert('Файл не подходит!');
                        return;
                    } else {
                        // Вставляем изображение в масиив изображений
                        add_new_images(data.bigimg, data.smallimg);
                    } //  /if		
                } //  /else
            } //  /if typeof
        },
        error: function (data, status, e) {
            $('#error_modal').find('.modal-body').empty();
            $('#error_modal').find('.modal-body').append(data.responseText);
            $('#error_modal').modal();
            console.log("Ошибка: " + status + ', ' + e + '  ******** Данные: ' + data.responseText);
        }
    })
    return false;
}

function body_images_list_get_my_works() {
    // Функция строит div с помощью массива изображений
    $(document).ready(function () {
        $('#tables_images_list tbody').html('');
        for (var $el_stroka = 0; $el_stroka <= images_matrix.length - 1; $el_stroka++)
        {
            // Если нет пометки на удаление, то строим изображение (Пометка на удаление будет в массиве если строка получена из БД (т.е не пусто 0 элемент), т.к нужно удалить строку из БД, и удалить файлы по путям)
            // Потому-что при нажатии на "Сделать главной" происходит пересоздание изображений, и если не сделать этого правила, то все картинки со всеми пометками будут построены (всмысле удаленные тоже)
            if (images_matrix[$el_stroka][5] != 'delete' && images_matrix[$el_stroka][5] != 'NONE') {

                // Проверяем главное ли это изображение. Если 1 то главное, если 0 нет, если нет то добавляем "Сделать главным"
                if (images_matrix[$el_stroka][4] == '1') {
                    $select_general_images = '<span class="help-block">Главное изображение</span>';
                } else {
                    $select_general_images = ' \
                        <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn btn-sm yellow" onclick="select_general_images(' + $el_stroka + ')"> \
                                <i class="fa fa-share"></i> Сделать главным \
                        </a>';
                }
                ; //  /if

                $('#tables_images_list tbody').append(' \
                    <tr id="image_id' + $el_stroka + '"> \
                        <td> \
                            <img  src="' + images_matrix[$el_stroka][3] + '" alt="" onclick="show_big_img(\'' + images_matrix[$el_stroka][2] + '\')" title="Нажмите чтобы увеличить" > \
                        </td> \
                        <td> \
                            <input type="text" class="form-control input_name_image"  data-id-massive="' + $el_stroka + '" name="" value="' + images_matrix[$el_stroka][6] + '" placeholder="Добавьте описание"> \
                        </td> \
                        <td> \
                            <input type="text" class="form-control input_sort_image"  data-id-massive="' + $el_stroka + '"  value="' + images_matrix[$el_stroka][7] + '"> \
                        </td> \
                        <td style="text-align: center;"> \
                                <label> \
                                ' + $select_general_images + ' \
                                </label> \
                        </td> \
                         \
                        <td style="text-align: center;"> \
                                <a class="btn btn-sm red"  onclick="add_metka_delete(' + $el_stroka + ', \'image_id' + $el_stroka + '\')"> \
                                        <i class="fa fa-times"></i> Удалить \
                                </a> \
                        </td> \
                    </tr>');
                //Делаем маску ввода для СОРТИРОВКИ
                $('.input_sort_image').mask('00000');
            } // if											
        } //  /for
        // Выводим массив в формате JSon
        document.getElementById('images_data').value = JSON.stringify(images_matrix);
    });
}

function select_general_images(id_stroka) {
    // Функция делает выбор главного изображения (1 в выводе на страницу)
    // Получает номер строки в массиве изображений images_matrix, и в 4 элементе строки (отвечает за вывод главного изображения) ставит 1 (0 - не главное)
    // Во всех остальных строках элемент 4 стивит 0
    for (var $el_stroka = 0; $el_stroka <= images_matrix.length - 1; $el_stroka++)
    {
        // Если переданный номер строки совпадает с текущей в 4 элементе ставим 1, если нет 0
        if (id_stroka == $el_stroka) {
            images_matrix[$el_stroka][4] = '1';

            // Ставим метку на ОБНОВЛЕНИЕ
            add_metka_update($el_stroka);
        } else {
            images_matrix[$el_stroka][4] = '0';

            // Ставим метку на ОБНОВЛЕНИЕ
            add_metka_update($el_stroka);
        }
    }

    // Перестраиваем изображения для визуализации изменений
    body_images_list_get_my_works();

    // Выводим массив в формате JSon для просмотра
    document.getElementById('images_data').value = JSON.stringify(images_matrix);
}

function add_metka_update(id_stroka) {
    // Функция ставит метку на ОБНОВЛЕНИЕ СТРОКИ в БД (update) в переданной строке
    // Метка ставится только там где присутствует ID из БД (значит строка ранее содержалась в БД, и будет обновлена по этому ID)
    //
    // Массив:
    //    id_из_ДБ | id_my_works | Большое изобр. | Малое изобр. | Главное? | Метка
    //       0           1               2               3            4         5
    // Если изображение только добавлено (его нет в БД) то НИЧЕГО НЕ ДЕЛАЕМ ДАБЫ НЕ СБИТЬ МЕТКУ add
    if (images_matrix[id_stroka][0] != '') {
        // И если уже стоит пометка на удаление, значит изображение уже физически недоступно для пользователя (ничего не может нажать)
        //  и менять её не надо
        if (images_matrix[id_stroka][5] != 'delete' && images_matrix[id_stroka][5] != 'NONE')
        {
            images_matrix[id_stroka][5] = 'update';
        } //  /if
    } //  /if
} 

function add_metka_delete(id_stroka, id_for_remove) {
    // Функция ставит метку на УДАЛЕНИЕ СТРОКИ из БД (delete) в переданной строке
    // Метка ставится только там где присутствует ID из БД (значит строка ранее содержалась в БД, и будет удалена по этому ID)
    //
    // Массив:
    //    id_из_ДБ | id_my_works | Большое изобр. | Малое изобр. | Главное? | Метка
    //       0           1               2               3            4         5
        images_matrix[id_stroka][5] = 'delete';
        
        // ЕСЛИ НАЖАЛИ НА УДАЛЕНИЕ ГЛАВНОГО ИЗОБРАЖЕНИЯ, ПЕРВЫЙ В МАССИВЕ СТАНОВИТСЯ ГЛАВНЫМ!!!
        if (images_matrix[id_stroka][4] == '1') {
            // Если это и был первый элемент в миассиве!
            // Значит делаем перебор массива до первого элемента где нет delete и NONE
            for (var $el_stroka = 0; $el_stroka <= images_matrix.length - 1; $el_stroka++) {
                if (images_matrix[$el_stroka][5] != 'delete' && images_matrix[$el_stroka][5] != 'NONE') {
                    images_matrix[id_stroka][4] = '0'
                    images_matrix[$el_stroka][4] = '1';
                    add_metka_update($el_stroka);
                    break;
                }
            }  
        }

        // Сначала удаляем файлы по полученному пути
        $.ajax({
            type: "POST",
            url: "../cms/system/delete_images_files.php",
            data: "bigimg=" + images_matrix[id_stroka][2] + "&smallimg=" + images_matrix[id_stroka][3],
            success: function (html) {
                //Удачное получение данных
//                alert(html);
            },
            error: function (html) {
                //Ошибка
                alert('Ошибка: ' + html);
            }
        }); // ajax

        // ЕСЛИ ЭТО НЕ ЭЛЕМЕНТ ИЗ БД - УДАЛЯЕМ ЕГО ИЗ МАССИВА
//        // Удаляем строку из массива ОБРАТИ ВНИМАНИЕ! Метод splice(номер строки, количество строк)
//        if (images_matrix[id_stroka][0] == '') {
//            images_matrix.splice(id_stroka, 1);
//        }
        // НЕ УДАЛАЯЕМ - ТК ПРИ УДАЛЕНИИИ ЭЛ С МАССИВА массив сдвинется -1 и новые изображения будут с одинаковыми номерами
        // Просто ПОСТАВИМ МЕТКУ - NONE
        if (images_matrix[id_stroka][0] == '') {
            images_matrix[id_stroka][2] = ''; // Очистим путь к изображению
            images_matrix[id_stroka][3] = ''; // Очистим путь к изображению
            images_matrix[id_stroka][5] = 'NONE';
            images_matrix[id_stroka][6] = ''; // Очистим имя
        }

        // Удаляем элемент
        $('#' + id_for_remove).remove();

        //set_general_image();

        // Перестраиваем изображения для визуализации изменений
        body_images_list_get_my_works();

        // Выводим массив в формате JSon для просмотра
        document.getElementById('images_data').value = JSON.stringify(images_matrix);
}

function add_new_images(big_img, small_img) {
    // Функция добавляет в массив новую строку в переданными даннымии ставит метку add (add - метка добавления новой строки в БД)
    // id_my_works мы получаем из скрытого поля id_my_works_input
    //
    // Массив:
    //    id_из_ДБ | id_my_works | Большое изобр. | Малое изобр. | Главное? | Метка | Имя | Сортировка 
    //       0           1               2               3            4         5      6        7
    //
    // Получаем id_my_works из span #id_my_works_input
    $id_my_works = $('#sql_id_elemet').val();
    // Добавляем новые элемент в массив
    // Если длинна массива 0, то это первое изображение, делаем его главным по умолчанию

    if (images_matrix.length == 0) {
        $gen_img = "1";
    } else {
        // Значит делаем перебор массива до первого элемента где нет delete и NONE
        $NONE_el = 0;
        for (var $el_stroka = 0; $el_stroka <= images_matrix.length - 1; $el_stroka++) {
            if (images_matrix[$el_stroka][5] == 'delete' || images_matrix[$el_stroka][5] == 'NONE') {
                $NONE_el++;
            }
        }
        if ($NONE_el == images_matrix.length) {
            $gen_img = "1";
        } else {
            $gen_img = "0";
        }
    }

    images_matrix[images_matrix.length] = ['', $id_my_works, big_img, small_img, $gen_img, 'add', '', (images_matrix.length + 1)];

    //set_general_image();

    // Перестраиваем изображения для визуализации изменений
    body_images_list_get_my_works();

    // Выводим массив в формате JSon для просмотра
    document.getElementById('images_data').value = JSON.stringify(images_matrix);
}

$(document).ready(function () {
    $('.input_name_image').live("keyup", function () {
        images_matrix[$(this).attr('data-id-massive')][6] = $(this).val();
        if (images_matrix[$(this).attr('data-id-massive')][5] != 'add' && images_matrix[$(this).attr('data-id-massive')][5] != 'delete') {
            images_matrix[$(this).attr('data-id-massive')][5] = 'update';
        }
        // Выводим массив в формате JSon
        $('#images_data').val(JSON.stringify(images_matrix));
    });


    $('.input_sort_image').live("keyup", function () {
        images_matrix[$(this).attr('data-id-massive')][7] = $(this).val();
        if (images_matrix[$(this).attr('data-id-massive')][5] != 'add' && images_matrix[$(this).attr('data-id-massive')][5] != 'delete') {
            images_matrix[$(this).attr('data-id-massive')][5] = 'update';
        }
        // Выводим массив в формате JSon
        $('#images_data').val(JSON.stringify(images_matrix));
    });
});

function show_big_img(path) {
    $(document).ready(function () {
        // Функция показывает увеличенное изображение
        $('#modal_big_img').find('img').attr('src', path);
        $('#modal_big_img').modal();
    });
}	






//
//function set_general_image() {
//    one_no_delite_image_of_massive = '';
//    // Выделяем главное изображение
//    
//    // Массив:
//    //    id_из_ДБ | id_my_works | Большое изобр. | Малое изобр. | Главное? | Метка | Имя | Сортировка 
//    //       0           1               2               3            4         5      6        7
//    //
//    
//    for (var el_stroka = 0; el_stroka <= images_matrix.length - 1; el_stroka++)
//    {
//        // Если переданный номер строки совпадает с текущей в 4 элементе ставим 1, если нет 0
////        if (images_matrix[el_stroka][4] == "1" && images_matrix[el_stroka][5] != 'delete') {
////            break;
////        }
//        if ((images_matrix[el_stroka][4] == "0" || images_matrix[el_stroka][4] == "") && (images_matrix[el_stroka][5] != 'delete')) {
//            if (one_no_delite_image_of_massive == '') {
//                one_no_delite_image_of_massive = el_stroka;
//            }
//            ;
//        }
//    }
//
//    if (one_no_delite_image_of_massive != '') {
//        images_matrix[one_no_delite_image_of_massive][4] = "1";
//    }
//    ;
//}
	