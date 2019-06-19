<?php
include_once $root . '/configuration.php';
?>

<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>


            <li class="start" id="menu_dashboard" style="display: none;">
                <a href="admin.php?link=dashboard">
                    <i class="fa fa-bar-chart-o"></i>
                    <span class="title">
                        Статистика
                    </span>
                </a>
            </li>


            <li class="start" id="homeblock"> <!-- online_order_form_name_user -->
                <a href="admin.php?link=homeblock">
                    <i class="glyphicons glyphicons-show_big_thumbnails"></i>
                    <span class="title">
                        Блоки на главной
                    </span>
                </a>
            </li>


            <li class="start" id="town"> <!-- online_order_form_name_user -->
                <a href="admin.php?link=town">
                    <i class="fa fa-bar-chart-o"></i>
                    <span class="title">
                        Населенные пункты
                    </span>
                </a>
            </li>


            <li id="feedback">  <!--style=""-->
                <a href="javascript:;">
                    <i class="glyphicons glyphicons-show_big_thumbnails"></i>
                    <span class="title">
                        Отзывы
                    </span>
                    <span class="arrow">
                    </span>
                </a>
                <ul class="sub-menu" style="">
                    <li id="feedback_all">
                        <a href="admin.php?link=feedback">
                            <span class="title">
                                Все отзывы
                            </span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="start" id="car"> <!-- online_order_form_name_user -->
                <a href="admin.php?link=car">
                    <i class="glyphicons glyphicons-show_big_thumbnails"></i>
                    <span class="title">
                        Машины
                    </span>
                </a>
            </li>


            <li id="menu_menu_cat" style="display: none;">  <!--style=""-->
                <a href="javascript:;">
                    <i class="glyphicons glyphicons-show_big_thumbnails"></i>
                    <span class="title">
                        Меню
                    </span>
                    <span class="arrow">
                    </span>
                </a>
                <ul class="sub-menu" style="">
                    <li id="menu_menu">
                        <a href="admin.php?link=menu">
                            <span class="title">
                                Главное меню
                            </span>
                        </a>
                    </li>

                    <li id="menu_menu_footer" style="display: none;">
                        <a href="admin.php?link=menu_footer">
                            <span class="title">
                                Нижнее меню
                            </span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="start" id="menu_db_orders" style="display: none;"> <!-- online_order_form_name_user -->
                <a href="admin.php?link=db_orders">
                    <i class="fa fa-bar-chart-o"></i>
                    <span class="title">
                        Синхронизация прайса
                    </span>
                </a>
            </li>


            <li id="menu_catalog_products" style="display: none;">  <!--style=""-->
                <a href="javascript:;">
                    <i class="glyphicons glyphicons-t-shirt"></i>
                    <span class="title">
                        Каталог товаров
                    </span>
                    <span class="arrow  open">
                    </span>
                </a>
                <ul class="sub-menu" style="">
                    <li id="menu_catalog_products_categories">
                        <a href="admin.php?link=catalog_products_categories">
                            Категории
                        </a>
                    </li>
                    <li id="menu_catalog_products_products">
                        <a href="admin.php?link=catalog_products">
                            Товары
                        </a>
                    </li>
                    <li id="menu_catalog_products_features_setting" style="display: none;">
                        <a href="admin.php?link=catalog_features_setting">
                            Настройка характеристик
                        </a>
                    </li>
                </ul>
            </li>
            <!--            <li  id="menu_orders">
                            <a href="javascript:;">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="title">
                                    Заказы
                                </span>
                                <span class="arrow">
                                </span>
                            </a>
                            <ul class="sub-menu" style="">
                                <li id="menu_orders_online_orders">
                                    <a href="admin.php?link=online_orders">
                                        <span class="title">
                                            Онлайн заявки
                                        </span>
                                    </a>
                                </li>
                                <li id="menu_orders_callme">
                                    <a href="admin.php?link=callme">
                                        <span class="title">
                                            Заказанные звонки
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        -->
            <li id="documents_menu" style="display: none;">
                <a href="javascript:;">
                    <i class="fa fa-file-text"></i>
                    <span class="title">
                        Документы
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li id="menu_contents_documents_categories">
                        <a href="admin.php?link=documents_categories">
                            Категории
                        </a>
                    </li>
                    <li id="menu_contents_documents_documents">
                        <a href="admin.php?link=documents">
                            Документы
                        </a>
                    </li>
                </ul>
            </li>


            <li id="menu_content">
                <a href="javascript:;">
                    <i class="fa fa-file-text"></i>
                    <span class="title">
                        Материалы
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li id="menu_content_categories">
                        <a href="admin.php?link=content_categories">
                            Категории
                        </a>
                    </li>
                    <li id="menu_contents_materials">
                        <a href="admin.php?link=content">
                            Материалы
                        </a>
                    </li>

                </ul>
            </li>


            <!--            <li id="menu_photogallary">
                            <a href="admin.php?link=photogallary">
                                <i class="glyphicon glyphicon-picture"></i>
                                <span class="title">
                                    Фото
                                </span>
                                <span class="arrow">
                                </span>
                            </a>
                            <ul class="sub-menu" style="">
                                <li id="menu_photogallary_categories">
                                    <a href="admin.php?link=photogallary_categories">
                                        Категории
                                    </a>
                                </li>
                                <li id="menu_photogallary_images">
                                    <a href="admin.php?link=photogallary">
                                        Изображения
                                    </a>
                                </li>
                            </ul>
                        </li>
                        -->

            <!--            <li id="menu_sertificates">
                            <a href="admin.php?link=sertificates">
                                <i class="glyphicon glyphicon-picture"></i>
                                <span class="title">
                                    Сертификаты
                                </span>
                            </a>
                        </li>-->


            <!--            <li  id="online_question" class="last">
                            <a  href="admin.php?link=online_question">
                                <i class="fa fa-comments"></i>
                                <span class="title">
                                    Вопрос-ответ
                                </span>
                            </a>
                        </li>-->


            <li id="our_clients" style="display: none;">
                <a href="admin.php?link=our_clients">
                    <i class=" glyphicon glyphicon-star"></i>
                    <span class="title">
                        <?php echo $our_clients_module_text; ?>
                    </span>
                </a>
            </li>


            <li id="my_works">
                <a href="javascript:;">
                    <i class="fa fa-briefcase"></i>
                    <span class="title">
                        Галерея
                    </span>
                    <span class="arrow open">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li id="menu_my_works_categories">
                        <a href="admin.php?link=my_works_categories">
                            Категории
                        </a>
                    </li>
                    <li id="menu_my_works">
                        <a href="admin.php?link=my_works">
                            Фото
                        </a>
                    </li>

                </ul>
            </li>


            <li class="" id="textImport"> <!-- online_order_form_name_user -->
                <a href="admin.php?link=textImport">
                    <i class="glyphicons glyphicons-show_big_thumbnails"></i>
                    <span class="title">
                        Импорт текста
                    </span>
                </a>
            </li>

            <!--            <li  id="clients_reviews" class="last" >
                            <a  href="admin.php?link=clients_reviews">
                                <i class="fa fa-comments"></i>
                                <span class="title">
                                    Отзывы клиентов
                                </span>
                            </a>
                        </li>-->


            <li id="menu_contacts" style="display: none;">
                <a href="javascript:;">
                    <i class="glyphicon glyphicon-user"></i>
                    <span class="title">
                        Контакты
                    </span>
                    <span class="arrow">
                    </span>
                </a>
                <ul class="sub-menu" style="">
                    <li id="menu_contacts_department">
                        <a href="admin.php?link=contacts_categories">
                            Отделы
                        </a>
                    </li>
                    <li id="menu_contacts_worker">
                        <a href="admin.php?link=contacts">
                            Сотрудники
                        </a>
                    </li>
                </ul>
            </li>


            <li id="menu_banners" style="display: none;">
                <a href="admin.php?link=banners">
                    <i class="glyphicon glyphicon-th"></i>
                    <span class="title">
                        Баннеры
                    </span>
                </a>
            </li>


            <!--            <li id="menu_organization_info">
                            <a href="admin.php?link=organization_info">
                                <i class="glyphicon glyphicon-th"></i>
                                <span class="title">
                                    Информация о нас
                                </span>
                            </a>
                        </li>-->


            <li style="display: none;">
                <a href="javascript:;">
                    <i class="fa fa-cogs"></i>
                    <span class="title">
                        Настройки
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="ecommerce_orders_view.html">
                            <i class="fa fa-cogs"></i>
                            Основные
                        </a>
                    </li>
                    <li>
                        <a href="ecommerce_products.html">
                            <i class="fa fa-user"></i>
                            Пользователи
                        </a>
                    </li>
                    <li style="display: none;">
                        <a href="ecommerce_products_edit.html">
                            <i class="fa fa-bar-chart-o"></i>
                            Яндекс.Метрика
                        </a>
                    </li>
                    <li style="display: none;">
                        <a href="ecommerce_products_edit.html">
                            <i class="fa fa-bar-chart-o"></i>
                            Яндекс.Директ
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->


<div class="modal fade bs-modal-lg" id="error_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                Modal body goes here
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade bs-modal-lg" id="modal_big_img" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" style="display: table; width: auto; margin: 0 auto;"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
