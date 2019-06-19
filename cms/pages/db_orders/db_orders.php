<script>
    jQuery(document).ready(function() {
        jQuery('body #clients_reviews')
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
                    Синхронизация прайс-листа<small> &nbsp;&nbsp;&nbsp;Цены</small>
                   
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






                <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" style="float: left;">
                    <h4 id="tab_images_uploader_pickfiles" style="text-align: right; display: table; float: left;" >
                        Загрузите файл Excel 2003&nbsp;&nbsp;&nbsp;&nbsp;
                    </h4>

                    <a id="tab_images_uploader_uploadfiles" class="btn yellow"  style=" float: left;">
                        <input type="file"  ACCEPT="*/*" name="fileupload" id="fileupload" onchange="return ajaxFileUpload_file('fileupload', '/uploads/');" />
                    </a> 

                    <!-- Идентификатор поля с файлом, Тип загрузки: img или file,  -->
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>

                <div class="file_info" style="display: none;">
                    <h5><b>База:</b> <span class="file_name"><?php echo $count_str; ?></span></h5>
                    <h5><b>Количество записей:</b> <span class="excel_num"></span> </h5>
                    <br/>
                    <br/>
                    
                    <div class="form-group" style="width: 100% !important; display: inline-block;">
                        <label class="col-md-1 control-label">Начальная строка:
                            <span class="required">
                                *
                            </span>
                        </label>
                        <div class="col-md-1">
                            <input class="form-control" type="text" id="start_row" value="8" />
                        </div>
                    </div>
                    <div class="form-group" style="width: 100% !important; display: inline-block;">
                        <label class="col-md-1 control-label">Конечная <br/>строка:
                            <span class="required">
                                *
                            </span>
                        </label>
                        <div class="col-md-1">
                            <input class="form-control" type="text" id="end_row" value="70" />
                        </div>
                    </div>
                    <div class="form-group" style="width: 100% !important; display: inline-block;">
                        <label class="col-md-1 control-label">Начальный столбец:
                            <span class="required">
                                *
                            </span>
                        </label>
                        <div class="col-md-1">
                            <input class="form-control" type="text" id="start_cols" value="1" />
                        </div>
                    </div>
                    <div class="form-group" style="width: 100% !important; display: inline-block;">
                        <label class="col-md-1 control-label">Конечный слолбец:
                            <span class="required">
                                *
                            </span>
                        </label>
                        <div class="col-md-1">
                            <input class="form-control" type="text" id="end_cols" value="4" />
                        </div>
                    </div>
                    <br/>
                </div>

                <br />
                <br />
                <a class="btn purple big" onclick="get_table_orders();"> Начать синхронизацию <i class="m-icon-big-swapright m-icon-white"></i></a>



            </div>
            
            <div class="col-md-12">
                
                
                
                
                <div class="result_sync" style="width: 100%;"></div>
                
                
                
                <script type="text/javascript" src="/cms/system/fileupload/ajaxfileupload.js"></script>

                <script>
                    function ajaxFileUpload_file(file_id, images_path_text) {
                        // Функция загрузки изображений на сервер и их конвертации
                        //alert(images_path_text + ' -- ' + images_path_text + ' -- ' + big_img_width_val + ' -- ' + big_img_height_val + ' -- ' + small_img_width_val + ' -- ' + small_img_height_val);

                        $('.load_div').fadeIn(200);
                        $('.orders_table').html('');
                        
                        $.ajaxFileUpload({
                            url: '../cms/pages/db_orders/upload.php',
                            secureuri: false,
                            fileElementId: file_id,
                            dataType: 'json',
                            data: {},
                            complete: function() {
                                // Завершена обработка, убираем анимацию
                                $('.load_div').fadeOut(200);
                            },
                            success: function(data, status) {
                                if (data.msg == 'format') {
                                    alert('Формат файла не совпадает!');
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
                                        console.log(data);
                                        $('.file_name').text(data.file);
                                        $('.excel_num').text(data.excel_num);
                                    } //  /else
                                } //  /if typeof
                            },
                            error: function(data, status, e) {
                                $('#error_modal').find('.modal-body').empty();
                                $('#error_modal').find('.modal-body').append(data.responseText);
                                $('#error_modal').modal();
                                console.log("Ошибка: " + status + ', ' + e + '  ******** Данные: ' + data.responseText);
                            }
                        })
                        return false;
                    }
                    
                    
                    
                    
                    
                    
                    function get_table_orders() {
                        
                        
                        
                    $(document).ready(function (){
                        console.log($('.start_row').val());
                        
                        $('.load_div').fadeIn(200);
                        file_path = $('.file_name').text();
                        
                        $.ajax({  
                            type: "POST",  
                            url: "/cms/pages/db_orders/update_base.php",  
                            dataType: '',
                            data: {
                                file_path: file_path,
                                start_row: $.trim($('#start_row').val()),
                                end_row: $.trim($('#end_row').val()),
                                start_cols: $.trim($('#start_cols').val()),
                                end_cols: $.trim($('#end_cols').val())
                            },  
			success: function(html){ 
                            $('.result_sync').html('');
                            $('.result_sync').append(html);
//                            TableAdvanced.init();
                            $('.load_div').fadeOut(200);
                            //console.log(html);
                        }, // success	
                        error: function(jqxhr, textStatus, error ){  
                            $('.load_div').fadeOut(200);
                            var err = textStatus + ", " + error + ' ';
                            console.log("Ошибка: " + err + ' Данные: ' + jqxhr.responseText);

                            $('#error_modal').find('.modal-body').empty();
                            $('#error_modal').find('.modal-body').append("Ошибка: " + err);
                            $('#error_modal').find('.modal-body').append(jqxhr.responseText);
                            $('#error_modal').modal();
                        } // error  				
		}); // ajax
			
	}); //ready	
                    };

                </script>

<br/>
<br/>
<!--                <div class="portlet box purple">
                    <div class="portlet-title">
                        <div class="caption">
                            База
                        </div>
                        <div class="actions">
                           
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="catalog_products_table">
                            <thead>
                            </thead>
                            <tbody class="orders_table">
                                <tr class="odd gradeX">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><span class="label label-success">Добавлено</span></td>
                                </tr>
                                <tr class="odd gradeX">
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>userwow</td>
                                    <td class="hidden-phone"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
                                    <td class="hidden-phone"><span class="label label-warning">Обновлено</span></td>
                                </tr>
                                <tr class="odd gradeX">
                                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                        <td>test</td>
                                        <td class="hidden-phone"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
                                        <td class="hidden-phone"><span class="label label-inverse">Удалено</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                
                
                -->
                
                
               
				  
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>

     