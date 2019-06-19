<script>
    jQuery(document).ready(function () {
        jQuery('body #clients_reviews')
                .addClass('active');

    });
</script>


<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);

//Конфигурация
include_once ($root . '/configuration.php');

$save_onclick = "
		save_data(
			'.page-content',
			'$id',
			'$sql_table',
			'$sql_images_table_name',
			'$sql_images_table_id_title',
			'#images_data',
			'',
			'$sql_features_table_name',
			'$sql_features_table_id_title'
		);";

$save_and_close_onclick = "
		save_data(
			'.page-content',
			'$id',
			'$sql_table',
			'$sql_images_table_name',
			'$sql_images_table_id_title',
			'#images_data',
			'admin.php?link=clients_reviews',
			'$sql_features_table_name',
			'$sql_features_table_id_title'
		);";

$close_onclick = "
		close_page(
			'admin.php?link=clients_reviews'
		);";
?>




<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">

        <?php include_once $root . '/cms/pages/load_save_modal.php'; ?>

        <textarea id="images_data"></textarea>
        <input id="sql_id_elemet" value="<?php echo $id; ?>"></input>



        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Редактирование отзыва <small>отзывы клиентов</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo $admin_panel_link ?>">
                            Панель управления
                        </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="admin.php?link=clients_reviews">
                            Отзывы клиентов
                        </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">
                            Редактирование
                        </a>
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
                        <div class="portlet-title">

                            <div class="actions btn-set">

                                <?php if ($id != '') {
                                    ?>

                                    <button class="btn green" onclick="<?php echo $save_onclick; ?>"><i class="fa fa-check"></i>Сохранить</button>

                                <?php } ?>	

                                <button class="btn green" onclick="<?php echo $save_and_close_onclick; ?>"><i class="fa fa-check-circle"></i> Сохранить и закрыть</button>
                                <button class="btn default" onclick="<?php echo $close_onclick; ?>"><i class="fa fa-reply"></i> Закрыть</button>
                                <!-- <div class="btn-group">
                                        <a class="btn yellow" href="#" data-toggle="dropdown">
                                                <i class="fa fa-share"></i> Дополнительно <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                                <li>
                                                        <a href="#">
                                                                <i class="fa fa-trash-o"></i> 
                                                                Удалить товар
                                                        </a>
                                                </li>
                                        </ul>
                                </div> -->
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_general" data-toggle="tab">
                                            Основные
                                        </a>
                                    </li>
                                    <!-- <li>
                                            <a href="#tab_reviews" data-toggle="tab">
                                                     Дополнительные характеристики
                                            </a>
                                    </li> -->
                                    <li>
                                        <a href="#tab_images" data-toggle="tab">
                                            Изображения
                                        </a>
                                    </li>
<!--                                    <li>
                                        <a href="#tab_meta" data-toggle="tab">
                                            Метаданные
                                        </a>
                                    </li>-->
                                </ul>
                                <div class="tab-content no-space">
                                    <div class="tab-pane active" id="tab_general">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Имя клиента:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-3">
                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        data-massive-element-type="input" 
                                                        data-default-value="" 
                                                        data-necessarily="true" 
                                                        data-table-field="client_name"
                                                        id = "client_name"
                                                        placeholder=""
                                                        >
                                                </div>

                                                <label class="col-md-1 control-label">Контакты:
                                                    <!--<span class="required">
                                                        *
                                                    </span>-->
                                                </label>
                                                <div class="col-md-4">
                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        data-massive-element-type="input" 
                                                        data-default-value="" 
                                                        data-necessarily="false" 
                                                        data-table-field="client_contact"
                                                        id = "client_contact"
                                                        placeholder=""
                                                        >
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Текст отзыва:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-10">
                                                    <textarea 
                                                        class="form-control" 
                                                        data-massive-element-type="textarea" 
                                                        data-default-value="" 
                                                        data-necessarily="true" 
                                                        data-table-field="client_text" 
                                                        id="client_text" 
                                                        placeholder="" 
                                                        rows="7"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Комментарий:
                                                </label>
                                                <div class="col-md-10">
                                                    <textarea 
                                                        class="form-control" 
                                                        data-massive-element-type="textarea" 
                                                        data-default-value="" 
                                                        data-necessarily="" 
                                                        data-table-field="comments" 
                                                        id="comments" 
                                                        placeholder="" 
                                                        rows="7"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Дата:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-10">
                                                    <div class="input-group">
                                                            <!-- <input
                                                                    type="text" 
                                                                    class="form-control" 
                                                                    data-massive-element-type="input" 
                                                                    data-default-value="" 
                                                                    data-necessarily="true" 
                                                                    data-table-field=""
                                                                    id = "work_add2"
                                                                    placeholder=""
                                                                    readonlydata-date-format="yyyy-mm-dd"
                                                            > -->
                                                        <!-- <div class="date-picker" 
                                                                data-massive-element-type="datepicker"
                                                                data-default-value="" 
                                                                data-necessarily="true" 
                                                                data-table-field="date"
                                                                data-date=""
                                                                id = "work_add">
                                                        </div> -->

                                                        <div class="input-group input-medium date date-picker" 
                                                             data-massive-element-type="datepicker"
                                                             id = "work_add"
                                                             data-date-format="yyyy-mm-dd" 
                                                             data-default-value="" 
                                                             data-necessarily="true" 
                                                             data-table-field="date"
                                                             data-date="" 
                                                             >
                                                            <input 
                                                                type="text" 
                                                                class="form-control date_value_input" 
                                                                readonly
                                                                >
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                            </span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>





                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Статус:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-10">
                                                    <select 
                                                        class="table-group-action-input form-control input-medium" 
                                                        type="select" 
                                                        data-massive-element-type="select" 
                                                        data-necessarily="true" 
                                                        data-table-field="public"
                                                        data-select-of-type="value"
                                                        id = "product_public"
                                                        >
                                                        <option value="1" selected>Опубликовано</option>
                                                        <option value="0">Не опубликовано</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<!--                                    <div class="tab-pane" id="tab_meta">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Мета заголовок:</label>
                                                <div class="col-md-10">
                                                    <input 
                                                        type="text" 
                                                        class="form-control maxlength-handler"  
                                                        data-massive-element-type="input" 
                                                        data-default-value="" 
                                                        data-necessarily="" 
                                                        data-table-field="meta_name"
                                                        id = "product_meta_name"
                                                        maxlength="100"
                                                        placeholder=""
                                                        >
                                                    <span class="help-block">
                                                        Максимум 100 символов
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Мета <br />ключевые слова:</label>
                                                <div class="col-md-10">
                                                    <textarea
                                                        type="textarea" 
                                                        class="form-control maxlength-handler"  
                                                        data-massive-element-type="textarea" 
                                                        data-default-value="" 
                                                        data-necessarily="" 
                                                        data-table-field="meta_keywords"
                                                        id = "product_meta_keywords"
                                                        maxlength="1000"
                                                        placeholder=""
                                                        rows="8" 
                                                        ></textarea>
                                                    <span class="help-block">
                                                        Максимум 1000 символов
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Мета описание:</label>
                                                <div class="col-md-10">
                                                    <textarea 
                                                        type="textarea" 
                                                        class="form-control maxlength-handler"  
                                                        data-massive-element-type="textarea" 
                                                        data-default-value="" 
                                                        data-necessarily="" 
                                                        data-table-field="meta_description"
                                                        id = "product_meta_description"
                                                        maxlength="255"
                                                        placeholder=""
                                                        rows="8" 
                                                        ></textarea>
                                                    <span class="help-block">
                                                        Максимум 255 символов
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="tab-pane" id="tab_images">


                                        <!-- <div class="alert alert-success margin-bottom-10">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                <i class="fa fa-warning fa-lg"></i> Для загругзе изображений используйте форму справа. <br /> <i class="fa fa-warning fa-lg"></i> Описание к изображению обязательно к заполнению!
                                        </div> -->
                                        <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" style="float: right;">
                                            <h4 id="tab_images_uploader_pickfiles" style="text-align: right; display: table; float: left;" >
                                                Загрузите изображение&nbsp;&nbsp;&nbsp;&nbsp;
                                            </h4>

                                            <a id="tab_images_uploader_uploadfiles" class="btn yellow"  style=" float: left;">
                                                <input type="file"  ACCEPT="image/*" name="fileupload" id="fileupload" onchange="return ajaxFileUpload2('fileupload',
                '/images/client_reviews_images/',
                '<?php echo $client_reviews_big_img_width; ?>',
                '<?php echo $client_reviews_big_img_height; ?>',
                '<?php echo $client_reviews_small_img_width; ?>',
                '<?php echo $client_reviews_small_img_height; ?>');" />
                                            </a> 

                                            <!-- Идентификатор поля с файлом, Тип загрузки: img или file,  -->
                                            <div class="clear"></div>
                                        </div>
                                        <div class="row">
                                            <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12">
                                            </div>
                                        </div>





                                        <table class="table table-bordered table-hover" id="tables_images_list">
                                            <thead>
                                                <tr role="row" class="heading">
                                                    <th width="8%">
                                                        Изображение
                                                    </th>
                                                    <th width="25%">
                                                        Название
                                                    </th>
                                                    <th width="8%">
                                                        Сортировка по номеру
                                                    </th>
                                                    <th width="20%">
                                                        Свойства
                                                    </th>
                                                    <th width="10%">

                                                    </th>
                                                    <!-- <th width="10%">
                                                             Small Image
                                                    </th>
                                                    <th width="10%">
                                                             Thumbnail
                                                    </th>
                                                    <th width="10%">
                                                    </th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab_reviews">

                                        <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" style="float: right;">
                                            <!-- <h4 id="tab_images_uploader_pickfiles" style="text-align: right; display: table; float: left;" >
                                                    Характеристики&nbsp;&nbsp;&nbsp;&nbsp;
                                            </h4> -->

                                            <select class="table-group-action-input form-control input-medium  feature_new_select" name="product[tax_class]" style="float: left; margin-right: 10px;" data-container="body"  data-placement="bottom" data-content="Данная характеристика уже пристутствует в списке">
                                                <?php echo $features ?>
                                            </select>

                                            <button class="btn yellow" onclick="add_new_feature();"><i class="fa fa-plus"></i> Добавить характеристику</button>

                                            <!-- Идентификатор поля с файлом, Тип загрузки: img или file,  -->
                                            <div class="clear"></div>
                                        </div>

                                        <div class="table-container">
                                            <table class="table table-bordered table-hover" id="datatable_reviews">
                                                <thead>
                                                    <tr role="row" class="heading">
                                                        <th width="2%">
                                                            Иконка
                                                        </th>
                                                        <th width="10%">
                                                            Название
                                                        </th>
                                                        <th width="20%">
                                                            Значение
                                                        </th>
                                                        <th width="10%">
                                                            Префикс
                                                        </th>
                                                        <th width="10%">
                                                            Сортировка
                                                        </th>
                                                        <th width="10%">

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->

<script>
    load_data(
            '<?php echo $sql_table; ?>',
            '<?php echo $id; ?>',
            '<?php echo $sql_images_table_name; ?>',
            '<?php echo $sql_images_table_id_title; ?>',
            '<?php echo $sql_features_table_name; ?>',
            '<?php echo $sql_features_table_id_title; ?>'
            );

</script>