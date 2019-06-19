<script>
    jQuery(document).ready(function () {
            jQuery('body #menu_menu')
                    .addClass('open, active')
        });
</script>


<?php
include_once $root . '/cms/php/get_select_sql_data.php';
include_once $root . '/cms/php/get_categories_json_data.php';


    

function get_html_menu_module() {
    global $db;
    $db_res = $db->query("SELECT * FROM menu_link WHERE public=1 ORDER BY sort;");
    //$my_html .= '<ul id="get_menu_data_div" class="list-unstyled down_box">';
    while($array = $db_res->fetch(PDO::FETCH_ASSOC)) {
        $my_html .= '<i class="'.$array["icon_class"].'" style="opacity: 0.3;"></i>&nbsp;&nbsp;&nbsp;<a class="dash_link" href="#" '
                . 'data-link="'.$array["link"].'" '
                . 'data-page-default="'.$array["page_default"].'" '
                . 'data-table-category="'.$array["table_category"].'" '
                . 'data-table="'.$array["table"].'" '
                . 'onclick="set_menu_link(this, \'\');">'.$array["name"].'</a><br />';
    }
    //$my_html .= '</ul>';
    return  $my_html;                                                             	
};




//Сссылка на кнопки Сохранить и закрыть, Закрыть
$exit_link = 'admin.php?link='.$exit_link_get;

//Описание формы (Название сверху и путь на сером фоне)
$form_info = array (
    page_title => 'Редактирование пункта меню',
    module_title => 'МЕНЮ',
    where_you_title_1 => 'Меню',
    where_you_link_1 => $exit_link,
    where_you_title_2  => '',
    where_you_link_2  => '',
);


//Получаем категории для выбора родителя (с radio button)
$catalog_categories_json_data = get_categories_json_data(
        'contacts_category', //$sql_table_categories
        false, // Кнопка редактирования категории, 
        true, //Radio button при выборе родительской категории,
        $link, //название текущей формы согласно link_array - admin.php
        $sql_images_table_name, 
        $sql_images_table_id_title, 
        $sql_features_table_name, 
        $sql_features_table_id_title,
        'parent_id' // $sql_table_id_title -> прикрепляется к radio-button при сохранении выбора категории в виде data-table-field="parent_id"
        // Используется form.js для формирования запроса к БД. ЕСЛИ таблица_category: parent_id, ЕСЛИ это редактироваие материла и т.п.: category_id 
);


//Используем возможность загрузки изображений?
$show_load_images = false;
// Путь к папке с изображениями для загрузчика изображений
$this_module_images_path = '/images/menu_images/menu/';
// Параментры изображений (Вместо чисел Берутся переменные из configuration.php )
$this_module_big_img_width = 200; 
$this_module_big_img_height = 200;
$this_module_small_img_width = 50;
$this_module_small_img_height = 50;


// Получаем список файлов из папок  (без расширений)
//$product_templates_in_category = get_flies_on_dir('..//frontend/templates/content_category/', 0);
//$product_templates_karta = get_flies_on_dir('..//frontend/templates/catalog_product/', 1);

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
			'".$exit_link."'
		);";


?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">

        




        <div id="modal_menu_module_categories" class="modal  fade" tabindex="10" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="load_div" style="display: block;">
                        <div class="title_load">
                            <img src="..//cms/template/assets/img/loading-spinner-grey.gif">
                            <h4 class="page-title">Загрузка... Подождите...</h4>
                        </div>
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="myModalLabel1">Выберете категорию</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-control height-auto">
                            <div class="scroller" style="height:275px;" data-always-visible="1">
                                <div id="catalog_product_categories_tree">
                                    <ul id="get_menu_data_div" class="list-unstyled down_box">

                                    </ul>	
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn default cancel_set_category_menu_link" data-dismiss="modal" aria-hidden="true">Отменить</button>
                    </div>
                </div>
            </div>
        </div>

        
        
        <div id="modal_menu_module" class="modal  fade" tabindex="10" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="myModalLabel1">Выберете компонент</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-control height-auto">
                            <div class="scroller" style="height:275px;" data-always-visible="1">
                                <div>
                                    <?php echo get_html_menu_module(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn default cancel_set_menu_link" data-dismiss="modal" aria-hidden="true">Отменить</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        <div id="modal_menu_content" class="modal  fade" tabindex="10" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="myModalLabel1">Выберете материал</h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <table class="table table-striped table-bordered table-hover table-full-width" id="catalog_products_table">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th class="width_200px">
                                            Наименование
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn default cancel_set_menu_link" data-dismiss="modal" aria-hidden="true">Отменить</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            $(document).ready(function() {
                //TableAdvanced.init();
                //$('#catalog_products_table').dataTable({});
    });
        </script>

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

                                <?php if ($id != '') {?>
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
                <?php if ($show_load_images == true) {?>
                                    <li>
                                        <a href="#tab_images" data-toggle="tab">
                                            Изображения
                                        </a>
                                    </li>
                <?php
                    };
                ?>
                                    <li>
                                        <a href="#tab_meta" data-toggle="tab">
                                            Метаданные
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content no-space">
                                    <div class="tab-pane active" id="tab_general">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Компонент (ссылка):
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-1">
                                                    <button href="#modal_menu_module" role="button" class="btn yellow" data-toggle="modal"><i class="fa fa-wrench"></i> Выбрать</button>
                                                </div>
                                                <div class="col-md-9">

                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        data-default-value="" 
                                                        data-massive-element-type="input" 
                                                        data-necessarily="true" 
                                                        data-table-field="link_text"
                                                        id = "menu_link_text"
                                                        placeholder=""
                                                        readonly=""
                                                    >
                                                    
                                                    
                                                   <!-- style="visibility: hidden;" --> 
                                                        
                                                        <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        data-massive-element-type="input" 
                                                        data-default-value="" 
                                                        data-necessarily="true" 
                                                        data-table-field="link"
                                                        id = "menu_link"
                                                        placeholder=""
                                                        style="width:0px; height: 0px;visibility: hidden; padding: 0px;"
                                                        >
                                                
                                                        <input 
                                                            type="text" 
                                                            class="form-control" 
                                                            data-massive-element-type="input" 
                                                            data-default-value="0" 
                                                            data-necessarily="true" 
                                                            data-table-field="parent_id"
                                                            id = "menu_parent_id"
                                                            placeholder="0"
                                                            style="width:0px; height: 0px;visibility: hidden; padding: 0px;"
                                                            value="0"
                                                        >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Имя:
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
                                                        id = "menu_name"
                                                        placeholder=""
                                                        >
                                                </div>
                                            </div>
<!--                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Родитель:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-10">
                                                    <div class="form-control height-auto">
                                                        <div class="scroller" style="height:275px;" data-always-visible="1">
                                                            <div id="catalog_product_categories_tree">
                                                                <ul class="list-unstyled down_box">
<?php // echo $catalog_categories_json_data; ?>
                                                                </ul>	
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="help-block">Выберете одного родителя</span>
                                                </div>
                                            </div>-->




                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Статус:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-2">
                                                    <select 
                                                        class="table-group-action-input form-control input-medium" 
                                                        type="select" 
                                                        data-massive-element-type="select" 
                                                        data-necessarily="true" 
                                                        data-table-field="public"
                                                        data-select-of-type="value"
                                                        id = "category_public"
                                                        >
                                                        <option value="1" selected>Опубликовано</option>
                                                        <option value="0">Не опубликовано</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_meta">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Мета заголовок:</label>
                                                <div class="col-md-10">
                                                    <input 
                                                        type="text" 
                                                        class="form-control maxlength-handler"  
                                                        data-massive-element-type="input" 
                                                        data-default-value="" 
                                                        data-necessarily="true" 
                                                        data-table-field="meta_name"
                                                        id = "meta_name"
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
                                                        data-necessarily="true" 
                                                        data-table-field="meta_keywords"
                                                        id = "meta_keywords"
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
                                                        data-necessarily="true" 
                                                        data-table-field="meta_description"
                                                        id = "meta_description"
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
                                    </div>
                                    
                                    
                <?php if ($show_load_images == true) {?>
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
    
    //set_checkboxes_categories('#catalog_product_categories_tree');
</script>


<script>
</script>