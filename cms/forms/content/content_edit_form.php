<script>
    jQuery(document).ready(function () {
        jQuery('body #menu_content')
                .addClass('open, active')
                .find('.arrow')
                .addClass('open')
                .parent()
                .parent()
                .find('ul')
                .css('display', 'block')
                .find('#menu_contents_materials')
                .addClass('active');
    });
</script>


<?php
include_once $root . '/cms/php/get_select_sql_data.php';
include_once $root . '/cms/php/get_categories_json_data.php';


// Быстрый способ получить таблицу и название категорий 
function get_table_documents() {
    global $db;
    
    $cat_mas = array();
    // Счтываем категории
    $db_res = $db->query("SELECT id, name FROM documents_category WHERE public=1;");
    while($array = $db_res->fetch(PDO::FETCH_ASSOC)) {
        $cat_mas[$array["id"]] = $array["name"];
    }
    
    $db_res = $db->query("SELECT *  FROM documents WHERE public=1 and path<>'' ORDER BY date_add, time_add;");
    while($array = $db_res->fetch(PDO::FETCH_ASSOC)) {
        $my_html .= '<tr>'
                . '<td>'.$array["id"].'</td>'
                . '<td>'
                . '<a class="select_doc curp" data-container=".modal-content" data-delay="{ show: 500, hide: 100 }" data-trigger="manual" data-toggle="popover" data-placement="top" data-content="Файл уже пристутствует в списке!"'
                . ' data-id="'.$array["id"].'" '
                . ' data-date-add="'.$array["date_add"].'" '
                . ' data-date-add="'.$array["date_add"].'" '
                . ' data-http-path="'.$array["http_path"].'" '
                . ' data-size="'.$array["size"].'" '
                . ' data-format="'.$array["format"].'" '
                . ' data-sort="'.$array["sort"].'" '
                . ' data-category-name="'.$cat_mas[$array["category_id"]].'" '
                . '>'.$array["name"].'</a></td>'
                . '<td>'.$cat_mas[$array["category_id"]].'</td>'
                . '</tr>';
    }
    return  $my_html;                                                             	
};


// Получаем ДОКУМЕНТЫ в таблицу #datatable_documents, тк ПРИ СОХРАНЕНИИ ТЕКУЩЕЙ ФОРМЫ мв передаем в матриду документов всего 3 праметра
// И передавать все даннве (имя категории, названия, ссылка и т.п) проблематично
// id_content, id_documents, sort
function get_tr_documents() {
    global $db, $id;

    $cat_mas = array();
    // Счтываем категории
    $db_res = $db->query("SELECT id, name FROM documents_category WHERE public=1;");
    while($array = $db_res->fetch(PDO::FETCH_ASSOC)) {
        $cat_mas[$array["id"]] = $array["name"];
    }
    
    if ($id != '') {
        $db_res = $db->query("SELECT * FROM content_documents WHERE id_content=$id ORDER BY sort");
        if ($db_res->rowCount() > 0) { 
            while($array_1 = $db_res->fetch(PDO::FETCH_ASSOC)) {
                $db_res_2 = $db->query("SELECT * FROM documents WHERE id=".$array_1["id_documents"]); // WHERE id_content=$id; WHERE id=$ids ".substr($ids, 7)
                while($array = $db_res_2->fetch(PDO::FETCH_ASSOC)) {
                    $my_html .= '<tr data-id="'.$array["id"].'">'
                            . '<td>'.$array["id"].'</td>'
                            . '<td>'.$array["date_add"].'</td>'
                            . '<td>'.$array["format"].'</td>'
                            . '<td>'.$array["name"].'</td>'
                            . '<td>'.$cat_mas[$array["category_id"]].'</td>'
                            . '<td><a href="'.$array["http_path"].'">'.$array["http_path"].'</a></td>'
                            . '<td>'.$array["size"].' Кб</td>'
                            . '<td>
                                   <i class="fa fa-arrow-circle-down category_up_down_but"></i> 
                                   <i class="fa fa-arrow-circle-up category_up_down_but"></i> 
                            </td> 
                            <td> 
                                    <button class="btn btn-sm red filter-cancel" onclick="delete_document_in_content(this);"><i class="fa fa-times"></i> Удалить</button>
                            </td>'
                            . '</tr>';
                }           
            }
        }
    }
    
    return  $my_html;                                                      	
};


//Сссылка на кнопки Сохранить и закрыть, Закрыть
$exit_link = 'admin.php?link=content&filter='.$filter;

//Описание формы (Название сверху и путь на сером фоне)
$form_info = array(
    page_title => 'Редактирование материала',
    module_title => 'материалы',
    where_you_title_1 => 'Материалы',
    where_you_link_1 => $exit_link
);

//Получаем категории для выбора родителя (с radio button)
$catalog_categories_json_data = get_categories_json_data(
        'content_category', //Таблица категорий модуля
        false, // Кнопка редактирования категории, 
        true, //Radio button при выборе родительской категории,
        $link, //название текущей формы согласно link_array - admin.php
        $sql_images_table_name, $sql_images_table_id_title, $sql_features_table_name, $sql_features_table_id_title, 'category_id' // $sql_table_id_title -> прикрепляется к radio-button при сохранении выбора категории в виде data-table-field="parent_id"
        // Используется form.js для формирования запроса к БД. ЕСЛИ таблица_category: parent_id, ЕСЛИ это редактироваие материла и т.п.: category_id 
);


//Используем возможность загрузки изображений?
$show_load_images = true;
// Используем дополнительные характеристики?
$show_features = false;
// Путь к папке с изображениями для загрузчика изображений
$this_module_images_path = '/images/content_images/content/';
// Параментры изображений (Вместо чисел Берутся переменные из configuration.php )
$this_module_big_img_width = 1000;
$this_module_big_img_height = 1000;
$this_module_small_img_width = 250;
$this_module_small_img_height = 250;

// Используем документы?
$show_documents = false;

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

        <div id="modal_menu_module2" class="modal  fade" tabindex="10" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="myModalLabel1">Выберете иконку</h3>
                    </div>
                    <div class="modal-body">
                        <div class="height-auto">
                            <div class="scroller" style="height:370px;" data-always-visible="1">
                                <div>
                                    <?php //echo get_html_icons(); ?>
                                    <div class="icons_window">
                                        <?php
                                        // Выводим иконки
                                        $icons_files = '';
                                        $dirname = $root . '/frontend/template/images/content_icons'; # Данный Каталог (Указываем любой)
                                        $dir = opendir($dirname); # Открываем каталог
                                        while ($file = readdir($dir)) {
                                            $size = bcdiv(@filesize($file), 1024, 2); /* чисто символьный размер в кб */
                                            $size_full = round($size) . '(кб.)'; /* размер файла с указанием в чем измеряем */
                                            $filename = substr($file, 0, strpos($file, ".")); /* имя файла без расширения */
                                            $exe = strrchr($file, '.'); /* его расширение */
                                            if (($file != ".") # Каталог Данный
                                                    && ($file != "..") # Каталог Корневой
                                                    && (substr($file, -3) != "php") /* Файлы с расшерением .php не выводяться, можно указать любой тип файлов который не надо выводить, пример: && (substr($file, -3) != "html") */
                                            ) {
                                                $icons_files .= '
                                                       <div class="icon">
                                                            <img src="../../../frontend/template/images/content_icons/' . $file . '" />
                                                            <div class="helper"></div>
                                                        </div>';
                                            }
                                        }

                                        echo $icons_files;
                                        closedir($dir); # Закрываем каталог 
                                        ?>
                                    </div>
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
                                    <button class="btn green" onclick="<?php echo $save_onclick; ?>"><i class="fa fa-check"></i>Сохранить</button>
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
                                    <?php if ($show_documents == true) { ?>                    
                                        <li>
                                            <a href="#tab_documents" data-toggle="tab">
                                                Документы
                                            </a>
                                        </li>
                                        <?php
                                    };
                                    ?>                                   
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
                                                <label class="col-md-1 control-label">Имя <br>(cpu/ЧПУ):
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-10">
                                                    <textarea 
                                                        type="text" 
                                                        class="form-control" 
                                                        data-massive-element-type="textarea" 
                                                        data-default-value="" 
                                                        data-necessarily="true" 
                                                        data-table-field="name"
                                                        data-is-cpu="true"
                                                        id = "product_name"
                                                        placeholder=""
                                                        rows = 2
                                                        ></textarea>
                                                </div>

<!--                                                <label class="col-md-1 control-label">Иконка:-->
<!--                                                    <span class="required">-->
<!--                                                        *-->
<!--                                                    </span>-->
<!--                                                </label>-->
<!--                                                <div class="col-md-1">-->
<!--                                                    <div class="icon_preview">-->
<!--                                                        <div -->
<!--                                                            class="preview"-->
<!--                                                            data-massive-element-type="icon"  -->
<!--                                                            data-table-field="icon"-->
<!--                                                            id="icon_img"-->
<!--                                                            >-->
<!--                                                            <p>Нет</p>-->
<!--                                                            <div class="helper"></div>-->
<!--                                                        </div>-->
<!--                                                        <a class="select_icon">Выбрать</a>-->
<!--                                                    </div>-->
<!--                                                    <input -->
<!--                                                        type="hidden" -->
<!--                                                        class="form-control" -->
<!--                                                        data-massive-element-type="input" -->
<!--                                                        data-default-value="" -->
<!--                                                        data-necessarily="" -->
<!--                                                        data-table-field="icon"-->
<!--                                                        id = "icon"-->
<!--                                                        placeholder=""-->
<!--                                                        hidden-->
<!--                                                        hidden-->
<!--                                                        >-->
<!--                                                </div>-->
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Заголовок <br> (H1):
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-10">
                                                    <textarea
                                                            type="text"
                                                            class="form-control"
                                                            data-massive-element-type="textarea"
                                                            data-default-value=""
                                                            data-necessarily="true"
                                                            data-table-field="title"
                                                            id = "title"
                                                            placeholder=""
                                                            rows = 2
                                                    ></textarea>
                                                </div>
                                            </div>



<!--                                            <div class="form-group">-->
<!--                                                <label class="col-md-1 control-label">cpu:-->
<!--                                                    <span class="required">-->
<!--                                                        *-->
<!--                                                    </span>-->
<!--                                                </label>-->
<!--                                                <div class="col-md-11">-->
<!--                                                   <textarea-->
<!--                                                           type="text"-->
<!--                                                           class="form-control"-->
<!--                                                           data-massive-element-type="textarea"-->
<!--                                                           data-default-value=""-->
<!--                                                           data-necessarily="true"-->
<!--                                                           data-table-field="cpu"-->
<!--                                                           id = "cpu"-->
<!--                                                           placeholder=""-->
<!--                                                           rows = 2-->
<!--                                                           disabled-->
<!--                                                   ></textarea>-->
<!--                                                </div>-->
<!--                                            </div>-->


                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Содержиние:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-11">
                                                    <textarea 
                                                        class="form-control ckeditor"
                                                        data-massive-element-type="ckeditor" 
                                                        data-default-value="" 
                                                        data-necessarily="true" 
                                                        data-table-field="description"
                                                        id = "description"
                                                        placeholder=""
                                                        rows = 10
                                                        ></textarea>
                                                </div>
                                            </div>

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
                                                <label class="col-md-1 control-label">Добавлено:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>

                                                <div class="col-md-2">
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

                                                <label class="col-md-1 control-label">Время:
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>

                                                <div class="col-md-2">      
                                                    <div class="input-group input-append bootstrap-timepicker-component">
                                                        <input class="form-control m-wrap m-ctrl-small timepicker-24" readonly 
                                                               type="text" 
                                                               data-massive-element-type="input"
                                                               id = "oq_time_question"
                                                               data-date-format="yyyy-mm-dd" 
                                                               data-default-value="" 
                                                               data-necessarily="true" 
                                                               data-table-field="time_add"
                                                               data-date="<?php echo date('H:i'); ?>" 
                                                               value="<?php echo date('H:i'); ?>"
                                                               />
                                                        <span class="input-group-addon add-on"><i class="glyphicon glyphicon-time"></i></span>
                                                    </div>

                                                </div>    
                                            </div>

                                              <div class="form-group">
                                                <label class="col-md-1 control-label">Код видео (YouTube):</label>
                                                <div class="col-md-11">
                                                    <textarea 
                                                        type="text" 
                                                        class="form-control" 
                                                        data-massive-element-type="textarea" 
                                                        data-default-value="" 
                                                        data-necessarily="" 
                                                        data-table-field="video_code"
                                                        id = "video_code"
                                                        placeholder=""
                                                        rows = 1
                                                        ></textarea>
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
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-2">
                                                    <input
                                                            type="text"
                                                            class="form-control"
                                                            data-massive-element-type="input"
                                                            data-default-value=""
                                                            data-necessarily="true"
                                                            data-table-field="sort"
                                                            id="sort"
                                                            placeholder=""
                                                            tabindex="5"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($show_documents == true) { ?>                
<div class="tab-pane" id="tab_documents">
    <div id="modal_documents" class="modal  fade" tabindex="10" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h3 id="myModalLabel1">Выберете документ</h3>
                </div>
                <div class="modal-body">
                    <div>
                        <table class="table table-striped table-bordered table-hover table-full-width" id="catalog_products_table">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th class="">
                                        Наименование
                                    </th>
                                    <th class="">
                                        Категория
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo get_table_documents(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn default" data-dismiss="modal" aria-hidden="true">Отменить</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="tab_container" class="text-align-reverse margin-bottom-10" style="float: right;">
        <!--<select class="table-group-action-input form-control input-medium  feature_new_select" name="product[tax_class]" style="float: left; margin-right: 10px;" data-container="body"  data-placement="bottom" data-content="Данная характеристика уже пристутствует в списке">
            <?php //echo $features ?>
        </select>-->
        <button class="btn yellow view_window_add_document"  data-toggle="modal" data-target="#modal_documents"><i class="fa fa-plus"></i> Добавить документ</button> 
        <div class="clear"></div>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover" id="datatable_documents">
            <thead>
                <tr role="row" class="heading">
                    <th width="2%">
                        id
                    </th>
                    <th width="4%">
                        Дата
                    </th>
                    <th width="2%">
                        
                    </th>
                    <th width="20%">
                        Название
                    </th>
                    <th width="20%">
                        Категория
                    </th>
                    <th width="10%">
                        Ссылка
                    </th>
                    <th width="4%">
                        
                    </th>
                    <th width="2%">
                    </th>
                    <th width="3%">

                    </th>
                </tr>
            </thead>
            <tbody>
                    <?php   echo get_tr_documents(); ?>
            </tbody>
        </table>
    </div>
</div>
                                    <?php }; ?>  
                                    
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
                                                        data-necessarily="" 
                                                        data-table-field="meta_title"
                                                        id = "product_meta_title"

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