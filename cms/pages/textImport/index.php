<?php

require $root . '/core/class.database.inc';

?>
<script>
    jQuery(document).ready(function () {
        jQuery('body #textImport')
            .addClass('active');
    });
</script>

<style>
    .label-inverse, .badge-inverse {
        background-color: #E02222;
    }

    .label-warning, .badge-warning {
        background-color: #57B5E3;;
        background-image: none !important;
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content">
        <?php include_once $root . '/cms/pages/load_save_modal.php'; ?>

        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

        <!-- /.modal -->
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN STYLE CUSTOMIZER -->

        <!-- END STYLE CUSTOMIZER -->
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Импорт текста

                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo $admin_panel_link ?>">
                            Панель управления
                        </a>

                    </li>

                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <div class="form-horizontal form-row-seperated">
                    <div class="portlet">


                        <div class="form-group">
                            <label class="col-md-1 control-label">Раздел:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-9">
                                <select class="table-group-action-input form-control input-medium" type="select"
                                        data-massive-element-type="select" data-necessarily="true"
                                        data-table-field="public"
                                        data-select-of-type="value" id="textDirection" tabindex="13" style="width: 100% !important;">
                                    <option value=""></option>
                                    <?php
                                    include_once $root . '/cms/pages/textImport/textDirections.php';
                                    foreach ($textDirections as $key => $value) {
                                        $optionValue = $key;
                                        if (strpos($key, 'end') !== false) {
                                            $key = '----';
                                            $optionValue = '';
                                        }
                                        echo '<option value="' . $optionValue . '">' . $key . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-1 control-label">Положение текста:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-3">
                                <select class="table-group-action-input form-control input-medium" type="select"
                                        data-massive-element-type="select" data-necessarily="true"
                                        data-table-field="public"
                                        data-select-of-type="value" id="textPosititon" tabindex="13">
                                    <?php
                                    foreach ($textPostition as $key => $value) {
                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-1 control-label">
                                Выбирете файл <b>.txt</b> для загрузки
                                <span class="required">*</span>
                            </label>

                            <div class="col-md-10">
                                <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10"
                                     style=" width: 100%;">


                                    <a id="tab_images_uploader_uploadfiles" class="btn yellow" style=" width: 100%;">
                                        <input type="file" ACCEPT=".txt" name="fileupload" id="fileupload" style="width: 100%;"
                                               onchange="return ajaxFileUpload_file('fileupload', '/uploads/');"/>
                                    </a>

                                    <!-- Идентификатор поля с файлом, Тип загрузки: img или file,  -->
                                    <div class="clear"></div>
                                </div>

                                <div class="clear"></div>
                                <div class="file_info" style="display: none;">
                                    <h5><b>Загруженный файл:</b> <span class="file_name"></span></h5>
                                    <h5><b>Количество записей:</b> <span class="excel_num"></span></h5>

                                    <br/>
                                    <a class="btn purple big" onclick="startTextSync();"> Начать синхронизацию <i
                                                class="m-icon-big-swapright m-icon-white"></i></a>
                                </div>


                            </div>
                        </div>


                        <script>
                            function startTextSync() {
                                $.ajax({
                                        type: "POST",
                                        url: "/cms/pages/textImport/syncText.php",
                                        dataType: '',
                                        data: {
                                            file: $('.file_name').text(),
                                            textDirection: $.trim($('#textDirection option:selected').text()),
                                            textPosition: $.trim($('#textPosititon option:selected').val()),
                                        },
                                        success: function (result) {
                                            $('.result_sync').html(result);
                                        }, // success
                                        error: function (jqxhr, textStatus, error) {
                                            $('.load_div').fadeOut(200);
                                            var err = textStatus + ", " + error + ' ';
                                            console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);

                                            $('#error_modal').find('.modal-body').empty();
                                            $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                                            $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                                            $('#error_modal').modal();
                                        } // error
                                    }
                                )
                            }
                        </script>


                        <div class="col-md-12">


                            <br/>

                            <div class="result_sync" style="width: 100%;"></div>


                            <script type="text/javascript" src="/cms/system/fileupload/ajaxfileupload.js"></script>

                            <script>

                                $(document).on('change', '#textPosititon, #textDirection', function () {
                                    $('.result_sync').html('');
                                    $('.file_name').html('');
                                    $('.file_info').hide();
                                    $('.excel_num').html('');
                                    $("#fileupload").val('');
                                });

                                function ajaxFileUpload_file(file_id, images_path_text) {
                                    // Функция загрузки изображений на сервер и их конвертации
                                    //alert(images_path_text + ' -- ' + images_path_text + ' -- ' + big_img_width_val + ' -- ' + big_img_height_val + ' -- ' + small_img_width_val + ' -- ' + small_img_height_val);

                                    $('.load_div').fadeIn(200);
                                    $('.orders_table').html('');

                                    $.ajaxFileUpload({
                                        url: '../cms/pages/textImport/upload.php',
                                        secureuri: false,
                                        fileElementId: file_id,
                                        dataType: 'json',
                                        data: {},
                                        complete: function () {
                                            // Завершена обработка, убираем анимацию
                                            $('.load_div').fadeOut(200);
                                        },
                                        success: function (data, status) {
                                            console.log(data);
                                            if (data.msg === 'format') {
                                                alert('Формат файла не совпадает!');
                                                return false;
                                            }
                                            if (data.msg === 'cancel') {
                                                $('.file_name').text('');
                                                $('.excel_num').text('');
                                                $('.file_info').hide();
                                                $('.result_sync').html('');
                                                return false;
                                            }
                                            if (typeof (data.error) != 'undefined') {
                                                if (data.error != '') {
                                                    alert(data.error);
                                                } else {
                                                    // УСПЕШНО ЗАГРУЖЕНО
                                                    // получаем 2 переменные 	 data.bigimg   data.smallimg
                                                    // Если возращено data.bigimg=NO или data.smallimg=NO то изображние не загружено, выводим ошибку и выходим с функции
                                                    $('.file_info').show();
                                                    $('.file_name').text(data.file);
                                                    $('.excel_num').text(data.textItemsCount);
                                                    $('.result_sync').html('');
                                                } //  /else
                                            } //  /if typeof
                                        },
                                        error: function (data, status, e) {
                                            $('#error_modal').find('.modal-body').empty();
                                            $('#error_modal').find('.modal-body').append(data.responseText);
                                            $('#error_modal').modal();
                                            console.log("Ошибка: " + status + ', ' + e + '  ******** Данные: ' + data.responseText);
                                        }
                                    });
                                    return false;
                                }


                            </script>

                            <br/>
                            <br/>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>

