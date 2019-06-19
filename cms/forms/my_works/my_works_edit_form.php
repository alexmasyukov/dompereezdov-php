<script>
    jQuery(document).ready(function () {
        jQuery('body #my_works')
                .addClass('open, active')
                .find('.arrow')
                .addClass('open')
                .parent()
                .parent()
                .find('ul')
                .css('display', 'block')
                .find('#menu_my_works')
                .addClass('active');
    });
</script>

<?php
include_once $root . '/cms/php/get_select_sql_data.php';
include_once $root . '/cms/php/get_categories_json_data.php';

$features = get_select_html_plus_data(
        'my_works_features', // таблица МОДУЛЬ_features
        'id', //$field_value
        'title', //$field_text
        'value', //$select_type
        '1', //$select
        'my_works_features_prefix', // таблица МОДУЛЬ_features_prefix
        array(// Таблица 
    'id',
    'title',
    'default_value', // data-
    'prefix_id', // data-
    'type',
    'icon'
        )
);


//Сссылка на кнопки Сохранить и закрыть, Закрыть
$exit_link = 'admin.php?link=my_works&filter=' . $filter;

//Описание формы (Название сверху и путь на сером фоне)
$form_info = array(
    page_title => 'Редактирование портфолио',
    module_title => 'Галерея',
    where_you_title_1 => 'Галерея',
    where_you_link_1 => $exit_link
);

//Получаем категории для выбора родителя (с radio button)
$catalog_categories_json_data = get_categories_json_data(
        'my_works_category', //Таблица категорий модуля
        false, // Кнопка редактирования категории, 
        true, //Radio button при выборе родительской категории,
        $link, //название текущей формы согласно link_array - admin.php
        $sql_images_table_name, 
        $sql_images_table_id_title, 
        $sql_features_table_name, 
        $sql_features_table_id_title, 
        'category_id' // $sql_table_id_title -> прикрепляется к radio-button при сохранении выбора категории в виде data-table-field="parent_id"
        // Используется form.js для формирования запроса к БД. ЕСЛИ таблица_category: parent_id, ЕСЛИ это редактироваие материла и т.п.: category_id 
);


//Используем возможность загрузки изображений?
$show_load_images = true;
// Используем дополнительные характеристики?
$show_features = false;
// Путь к папке с изображениями для загрузчика изображений
$this_module_images_path = '/images/my_works_images/works_images/';
// Параментры изображений (Вместо чисел Берутся переменные из configuration.php )
$this_module_big_img_width = 900;
$this_module_big_img_height = 900;
$this_module_small_img_width = 200;
$this_module_small_img_height = 200;


// НЕ ТРОГАЕМ --- НЕ ТРОГАЕМ --- НЕ ТРОГАЕМ
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
			'$exit_link',
			'$sql_features_table_name',
			'$sql_features_table_id_title'
		);";

$close_onclick = "
		close_page(
			'" . $exit_link . "'
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
                    <?php echo $form_info['page_title']; ?> <small><?php echo $form_info['module_title']; ?></small>
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
                        <a href="<?php echo $form_info['where_you_link_1']; ?>">
                            <?php echo $form_info['where_you_title_1']; ?>
                        </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $form_info['where_you_link_2']; ?>">
                            <?php echo $form_info['where_you_title_2']; ?>
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

                                <?php if ($id != '') { ?>
                                    <button class="btn green save_but" onclick="<?php echo $save_onclick; ?>"><i class="fa fa-check"></i>Сохранить</button>
                                <?php } ?>	


                                <button class="btn green" onclick="<?php echo $save_and_close_onclick; ?>"><i class="fa fa-check-circle"></i> Сохранить и закрыть</button>
                                <button class="btn default" onclick="<?php echo $close_onclick; ?>"><i class="fa fa-reply"></i> Закрыть</button>

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
                                    <?php if ($show_features == true) { ?>                    
                                        <li>
                                            <a href="#tab_reviews" data-toggle="tab">
                                                Дополнительные характеристики
                                            </a>
                                        </li>
                                        <?php
                                    };
                                    ?>
                                    <?php if ($show_load_images == true) { ?>
                                        <li>
                                            <a href="#tab_images" data-toggle="tab">
                                                Изображения
                                            </a>
                                        </li>
                                        <?php
                                    };
                                    ?>

                                </ul>
                                <div class="tab-content no-space">
                                       <div class="tab-pane active" id="tab_general">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Имя:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        data-massive-element-type="input" 
                                                        data-default-value="" 
                                                        data-necessarily="true" 
                                                        data-table-field="name"
                                                        id = "work_name"
                                                        placeholder=""
                                                        
                                                        >
                                                </div>
                                            </div>
<!--                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Описание:
                                                </label>
                                                <div class="col-md-10">
                                                    <textarea 
                                                        class="form-control"
                                                        data-massive-element-type="textarea" 
                                                        data-default-value="" 
                                                        data-necessarily="" 
                                                        data-table-field="description"
                                                        id = "description"
                                                        placeholder=""
                                                        rows = 7
                                                        ></textarea>
                                                </div>
                                            </div>-->
                                             <div class="form-group">
                                                <label class="col-md-1 control-label">Категория:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-11">
                                                    <div class="form-control height-auto">
                                                        <div class="scroller" style="height:275px;" data-always-visible="1">
                                                            <div id="catalog_product_categories_tree">
                                                                <ul class="list-unstyled down_box">
<?php echo $catalog_categories_json_data; ?>
                                                                </ul>	
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="help-block">
                                                        Выберете одну категорию
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            
                                          
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Дата:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-10">
                                                   <div class="input-group input-medium date date-picker" 
                                                         data-massive-element-type="datepicker"
                                                         id = "oq_date_question"
                                                         data-date-format="yyyy-mm-dd" 
                                                         data-default-value="" 
                                                         data-necessarily="true" 
                                                         data-table-field="date_add"
                                                         data-date="<?php echo date('Y-m-d'); ?>" 
                                                         >
                                                        <input 
                                                            type="text" 
                                                            class="form-control date_value_input" 
                                                            readonly
                                                            value="<?php echo date('Y-m-d'); ?>"
                                                            >
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>





                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Статус:
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
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Сортировка:

                                                </label>
                                                <div class="col-md-2">
                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        data-massive-element-type="input" 
                                                        data-default-value="" 
                                                        data-necessarily="" 
                                                        data-table-field="sort"
                                                        id = "sort"
                                                        placeholder=""
                                                        />
                                                </div>
                                                </div>
                                        </div>
                                    </div>


                                    <?php if ($show_load_images == true) { ?>                
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
                                                    <input type="file"  ACCEPT="image/*" name="fileupload" id="fileupload" onchange="return ajaxFileUpload2('fileupload', '<?php echo $this_module_images_path; ?>', '<?php echo $this_module_big_img_width; ?>', '<?php echo $this_module_big_img_height; ?>', '<?php echo $this_module_small_img_width; ?>', '<?php echo $this_module_small_img_height; ?>');" />
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
                                    <?php }; ?>     

                                    <?php if ($show_features == true) { ?>                

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
                                    <?php }; ?>  
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