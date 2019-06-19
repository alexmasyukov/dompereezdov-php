<?php

header("Content-Type: text/html; charset=utf-8");
$root = realpath($_SERVER['DOCUMENT_ROOT']);

// Проверка авторизации пользователя
include_once $root . '/cms/autorization.php';

$admin_name = 'Администратор';
$path_template = $root . '/cms/template/';
$exit_of_admin_panel_link = 'login.php';
$admin_panel_link = 'admin.php?link=admin';

//Страница по умолчанию (при входе в админпанель)
$links_array["admin"]                           = $root . '/cms/pages/feedback/feedback.php';

$links_array["textImport"]                           = $root . '/cms/pages/textImport/index.php';

// Статистика
$links_array["dashboard"]                       = $root . '/cms/pages/dashboard/dashboard.php';

// Населенные пункты НОВОЕ
$links_array["town"]                            = $root . '/cms/pages/town/town.php';
$links_array["town_edit_form"]                  = $root . '/cms/forms/town/town_edit_form.php'; // Форма редактирования

// Машины НОВОЕ
$links_array["car"]                            = $root . '/cms/pages/car/car.php';
$links_array["car_edit_form"]                  = $root . '/cms/forms/car/car_edit_form.php'; // Форма редактирования

// Блоки для главной страницы НОВОЕ
$links_array["homeblock"]                            = $root . '/cms/pages/homeblock/homeblock.php';
$links_array["homeblock_edit_form"]                  = $root . '/cms/forms/homeblock/homeblock_edit_form.php'; // Форма редактирования

//База заказов
$links_array["db_orders"]                       = $root . '/cms/pages/db_orders/db_orders.php'; // ИСПОЛЬЗОВАЛОСЬ для ЗАГРУЗКИ ИЗ EXCELL
$links_array["db_orders_edit_form"]             = $root . '/cms/forms/db_orders/db_orders_edit_form.php'; // Форма редактирования

// Пустая страница
$links_array["blank_default"]                   = $root . '/cms/pages/blank_default.php';

// Каталог товаров
$links_array["catalog_products"]                = $root . '/cms/pages/catalog/catalog_products.php';
$links_array["catalog_product_edit_form"]       = $root . '/cms/forms/catalog/catalog_product_edit_form.php'; // Форма редактирования
$links_array["catalog_products_categories"]     = $root . '/cms/pages/catalog/catalog_products_categories.php';
$links_array["categories_edit_form"]            = $root . '/cms/forms/catalog/categories_edit_form.php'; // Форма редактирования
$links_array["catalog_features_setting"]        = $root . '/cms/pages/catalog/catalog_features_setting.php';

//Портфолио
$links_array["my_works"]                        = $root . '/cms/pages/my_works/my_works.php';
$links_array["my_works_edit_form"]              = $root . '/cms/forms/my_works/my_works_edit_form.php'; // Форма редактирования
$links_array["my_works_categories"]             = $root . '/cms/pages/my_works/my_works_categories.php';
$links_array["my_works_category_edit_form"]     = $root . '/cms/forms/my_works/my_works_category_edit_form.php'; // Форма редактирования



// Отзывы клиентов
$links_array["clients_reviews"]                 = $root . '/cms/pages/clients_reviews/view_clients_reviews.php';
$links_array["clients_reviews_edit_form"]       = $root . '/cms/forms/clients_reviews/clients_reviews_edit_form.php'; // Форма редактирования

// Заказы каталога товаров
$links_array["online_orders"]                   = $root . '/cms/pages/orders/online_orders.php';
$links_array["online_order_edit_form"]          = $root . '/cms/forms/online_orders/online_order_edit_form.php'; // Форма редактирования

// Обратные звонки
$links_array["callme"]                          = $root . '/cms/pages/orders/callme.php';
$links_array["callme_edit_form"]                = $root . '/cms/forms/callme/callme_edit_form.php'; // Форма редактирования

// Материалы
$links_array["content"]                         = $root . '/cms/pages/content/content.php';
$links_array["content_edit_form"]               = $root . '/cms/forms/content/content_edit_form.php'; // Форма редактирования
$links_array["content_categories"]              = $root . '/cms/pages/content/content_categories.php';
$links_array["content_category_edit_form"]      = $root . '/cms/forms/content/content_category_edit_form.php'; // Форма редактирования

// Документы
$links_array["documents"]                         = $root . '/cms/pages/documents/documents.php';
$links_array["documents_edit_form"]               = $root . '/cms/forms/documents/documents_edit_form.php'; // Форма редактирования
$links_array["documents_categories"]              = $root . '/cms/pages/documents/documents_categories.php';
$links_array["documents_category_edit_form"]      = $root . '/cms/forms/documents/documents_category_edit_form.php'; // Форма редактирования


// Наши клиенты
$links_array["our_clients"]                     = $root . '/cms/pages/our_clients/view_our_clients.php';
$links_array["our_clients_edit_form"]           = $root . '/cms/forms/our_clients/our_clients_edit_form.php'; // Форма редактирования

// Онлайн-приемная
$links_array["online_question"]                 = $root . '/cms/pages/online_question/view_online_question.php';
$links_array["online_question_edit_form"]       = $root . '/cms/forms/online_question/online_question_edit_form.php';

// Контакты
$links_array["contacts"]                        = $root . '/cms/pages/contacts/contacts.php';
$links_array["contacts_edit_form"]              = $root . '/cms/forms/contacts/contacts_edit_form.php'; // Форма редактирования
$links_array["contacts_categories"]             = $root . '/cms/pages/contacts/contacts_categories.php';
$links_array["contacts_category_edit_form"]     = $root . '/cms/forms/contacts/contacts_category_edit_form.php'; // Форма редактирования

// Баннеры
$links_array["banners"]                         = $root . '/cms/pages/banners/banners.php';
$links_array["banners_edit_form"]               = $root . '/cms/forms/banners/banners_edit_form.php'; // Форма редактирования

// Меню
$links_array["menu"]                            = $root . '/cms/pages/menu/general_menu.php';
$links_array["menu_edit_form"]                  = $root . '/cms/forms/menu/menu_edit_form.php'; // Форма редактирования
$links_array["menu_footer"]                     = $root . '/cms/pages/menu/footer_menu.php';

// Фотогалерея
$links_array["photogallary"]                    = $root . '/cms/pages/photogallary/photogallary.php';
$links_array["photogallary_edit_form"]          = $root . '/cms/forms/photogallary/photogallary_edit_form.php'; // Форма редактирования
$links_array["photogallary_categories"]         = $root . '/cms/pages/photogallary/photogallary_categories.php';
$links_array["photogallary_category_edit_form"] = $root . '/cms/forms/photogallary/photogallary_category_edit_form.php'; // Форма редактирования

// Отзывы (Новые)
$links_array["feedback"]                        = $root . '/cms/pages/feedback/feedback.php';
$links_array["feedback_edit_form"]              = $root . '/cms/forms/feedback/feedback_edit_form.php'; // Форма редактирования



if (isset($_GET['link'])) {
    $link = $_GET['link'];
    $id = $_GET['id'];
    $sql_table = $_GET['sql_table'];
    $filter = $_GET['filter'];

    $sql_images_table_name = $_GET['sql_images_table_name'];
    $sql_images_table_id_title = $_GET['sql_images_table_id_title'];

    $sql_features_table_name = $_GET['sql_features_table_name'];
    $sql_features_table_id_title = $_GET['sql_features_table_id_title'];
    
    $exit_link_get = $_GET['exit_link_get'];
}

if ($link == '') {$link = 'admin';};



include_once $root . '/cms/pages/header.php';
        include_once $root . '/cms/pages/left.php';
        include_once $links_array[$link];
include_once $root . '/cms/pages/footer.php';
?>
