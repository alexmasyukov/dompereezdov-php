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

    view_module('module_my_works_table_json', 2000, '<?php echo $filter;?>'); // Универсальная
</script>

<?php


$module_info = array(
    link => 'my_works_edit_form', // Форма редактирования
    id => '',
    sql_table => 'my_works',
    sql_images_table_name => 'my_works_images',
    sql_images_table_id_title => 'module_item_id',
    sql_features_table_name => 'my_works_features_values',
    sql_features_table_id_title => 'module_item_id',
    
    page_title => 'Галерея',
    module_title => '',
    where_you_title_1 => 'Галерея',
    where_you_link_1 => 'admin.php?link=my_works',
    where_you_title_2  => '',
    where_you_link_2  => ''
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
        <div class="row">
            <div class="col-md-12">










                <div class="portlet">

                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-full-width" id="catalog_products_table">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                       
                                    </th>
                                    <th>
                                        Название
                                    </th>
                                     <th>
                                        Категория
                                    </th>
                                    <th class="hidden-xs" class="no-wrap">
                                        Сортировка
                                    </th>
                                    <th class="hidden-xs">
                                        Cоздано
                                    </th>
                                    <th class="hidden-xs">
                                        Опубликовано
                                    </th>
                                    <th class="hidden-xs" style="width: 100px!important;">
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
        <!-- END PAGE CONTENT-->
    </div>
</div>



