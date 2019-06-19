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
                .find('#menu_my_works_categories')
                .addClass('active');
    });
</script>

<?php
include_once $root . '/cms/php/get_categories_json_data.php';

$module_info = array(
    link => 'my_works_category_edit_form', // Форма редактирования
    id => '',
    sql_table => 'my_works_category',
    sql_images_table_name => 'my_works_category_images',
    sql_images_table_id_title => 'module_item_id',
    sql_features_table_name => '', //contacts_category_features_values
    sql_features_table_id_title => '',
    
    page_title => 'Категории',
    module_title => 'Галерея',
    where_you_title_1 => 'Галерея',
    where_you_link_1 => 'admin.php?link=my_works',
    where_you_title_2  => '',
    where_you_link_2  => ''
);





$contacts_categories_json_data = get_categories_json_data(
        $module_info['sql_table'], 
        true, 
        false, 
        $module_info['link'], 
        $module_info['sql_images_table_name'], 
        $module_info['sql_images_table_id_title'], 
        $module_info['sql_features_table_name'], 
        $module_info['sql_features_table_id_title'],
        '' // $sql_table_id_title -> прикрепляется к radio-button при сохранении выбора категории в виде data-table-field="parent_id"
        // Используется form.js для формирования запроса к БД. ЕСЛИ таблица_category: parent_id, ЕСЛИ это редактироваие материла и т.п.: category_id 
);



?>







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
                    <?php echo $module_info['page_title']; ?> <small><?php echo $module_info['module_title']; ?></small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li class="btn-group">
                        <button type="button" class="btn green save_sort_categories" data-sql-table="<?php echo $module_info['sql_table']; ?>" onclick="" style="margin-right: 10px;">
                            <span>
                                <i class="fa fa-check"></i>
                                Сохранить расположение
                            </span>
                        </button>
                        <button type="button" class="btn blue" onclick="location.href = 'admin.php?link=<?php echo $module_info['link']; ?>&id=<?php echo $module_info['id']; ?>&sql_table=<?php echo $module_info['sql_table']; ?>&sql_images_table_name=<?php echo $module_info['sql_images_table_name']; ?>&sql_images_table_id_title=<?php echo $module_info['sql_images_table_id_title']; ?>&sql_features_table_name=<?php echo $module_info['sql_features_table_name']; ?>&sql_features_table_id_title=<?php echo $module_info['sql_features_table_id_title']; ?> '">
                            <span>
                                Добавить
                            </span>
                        </button>
                    </li>
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo $admin_panel_link ?>">
                            Панель управления
                        </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $module_info['where_you_link_1']; ?>">
                            <?php echo $module_info['where_you_title_1']; ?>
                        </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $module_info['where_you_link_2']; ?>">
                            <?php echo $module_info['where_you_title_2']; ?>
                        </a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->

        <div class="categories_container">
            <div id="no_parent_category_div" class="no_parent_category_div">Перенесите элемент сюда, чтобы сделать его основным</div>
            <ul class="down_box " style="padding: 0px;">
                <?php echo $contacts_categories_json_data; ?>
            </ul>	
        </div>
        <!-- END PAGE CONTENT-->
    </div>