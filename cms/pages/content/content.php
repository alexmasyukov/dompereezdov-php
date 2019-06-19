<script>
    jQuery(document).ready(function () {
        /*	jQuery('body .page-sidebar-menu')
         .find('li,span')
         .removeClass('active open')
         .find('ul')
         .css('display', 'none'); */

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

    view_module('module_content_table_json', 2000, '<?php echo $filter;?>'); // Универсальная 
</script>

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
                    Менеджер материалов <small>материалы</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li class="btn-group">
                        <button type="button" class="btn blue" onclick="location.href = 'admin.php?link=content_edit_form&id=&sql_table=content&sql_images_table_name=content_images&sql_images_table_id_title=id_content&sql_features_table_name=&sql_features_table_id_title=';">
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
                        <a href="admin.php?link=content">
                            Материалы
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
                                        Название (cpu/ЧПУ)
                                    </th>
                                    <th>
                                       Заголовок
                                    </th>
                                    <th class="hidden-xs" class="no-wrap">
                                        Ссылка
                                    </th>
                                    <th class="hidden-xs" class="no-wrap">
                                        Cоздано
                                    </th>
                                    <th class="hidden-xs">
                                        
                                    </th>
                                    <th class="hidden-xs">
                                        Категория
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



