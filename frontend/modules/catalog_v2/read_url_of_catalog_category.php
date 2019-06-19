<?php
$cars_images_matrix = '';
if ($url_path != '') {
    $uri_parts = explode('/', trim($url_path, '/'));
} else {
    $uri_parts = [];
}


#Для всех станиц НУЛЕВОГО уровня (главная, все меню и т.п.)
$page_parent_id = '';
$page_arr_number = 0;
$map_location = '';
$mini_breadcumb = array();

if (count($uri_parts) > 0) {
    # Сначала получаем id страницы
    # Затем получаем массив страниц из БД где cpu равный разбитой строке со ссылкой из браузера
    # Это будет примерный массив, из которого споследствии выстроим по parent_id нужный на массив
    # построения breadcumb по порядку без лишних элементов

    $ids = get_page_id();
    $page_id = $ids['page_id'];
    $page_name = $ids['page_name'];
    $page_parent_id = $ids['page_parent_id']; // ДАЛЕЕ ЗАДАСТСЯ В ФУНКЦИИ get_page_id()
    $pages = get_breadcumb_array($page_id, get_about_sql_array());

    //    echo '<pre>';
    //    print_r($pages);


    $parent_id = 0;
    $link_url = 'http://' . $server . '/';
    $breadcrumb = '<nav class="breadcrumb">';
    $breadcrumb .= '<a href="http://' . $server . '/">Главная</a>';
    foreach ($pages as $value) {
        $link_url = $value['cpu_path'];

        $h1 = mb_ucfirst($value['h1']);
        $name = mb_ucfirst($value['name']);
        $name_p_pr = mb_ucfirst($value['p_pr']);
        $name_p_ro = mb_ucfirst($value['p_ro']);
        $name_p_da = mb_ucfirst($value['p_da']);
        $type_for_broadcumb = mb_ucfirst($value['type'] . ' ' . $value['name']);

        # Определяем имя родителя для постоения списка ПОХОЖИХ услуг (грузоперевозки в ------ ) на странице УСЛУГИ(usluga)
        if ($page_arr_number == count($pages) - 2) {
            $page_parent_name_p_pr = mb_ucfirst($value['p_pr']);
        }

        # Если это текущая страница
        if ($page_id == $value['id']) {
            $cars_images_matrix = $value['cars_images_matrix'];
            $header_text = $texts_for_page['header_text'];
            $type_p_pr = $value['type'];
            $category_id = $value['id'];
            $parent_id = $value['id'];
        } # / Если это текущая страница

        $breadcrumb .= '<a href="' . $link_url . '">' . $type_for_broadcumb . '</a> ';
        $mini_breadcumb[] = '<a href="' . $link_url . '">' . $type_for_broadcumb . '</a>';
        $breadcrumb_links[] = $link_url;
        $breadcrumb_text[] = $type_for_broadcumb;
        $map_location .= ', ' . $type_for_broadcumb;

        $page_arr_number++;
    }
    $breadcrumb .= '</nav>';
} else {
    if ($module == 'catalog') {
        $link_url = 'http://' . $server . '/';
        $breadcrumb .= '<nav class="breadcrumb">';
        $breadcrumb .= '<a href="http://' . $server . '/">Главная</a>';
        $breadcrumb .= '</nav>';
    } else {
        $breadcrumb = '<div class="empty"></div>';
    }

}


//function get_page_id() {
//    global $db, $url_path, $uri_parts;
//
//    $smf = $db->query("
//        SELECT
//            id,
//            parent_id,
//            name
//        FROM
//            pages
//        WHERE
//        public = 1 AND
//            cpu_path = '$url_path'
//        ");
//    if ($smf->rowCount() > 0) {
//        foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
//            $ids['page_parent_id'] = $value['parent_id'];
//            $ids['page_id'] = $value['id'];
//            $ids['page_name'] = $value['name'];
//            return $ids;
//        }
//    } else {
//        view_404();
//    }
//}


function get_breadcumb_array($page_id, $pages_about) {
    # Получаем правильно выстроенную цепочку из id для breadcumb (найденную через рекурсию parent_id)
    $parents_ids = outTree_parent_ids($page_id, $pages_about);

    $pages = array();
    if ($parents_ids != '') { # Без этого условия массив pages получит один пустой элемент
        $parents_ids = explode(",", $parents_ids);
        # Содаем правильный массив для breadcumb
        foreach ($parents_ids as $value) { //Обходим массив
            $pages[$value] = $pages_about[$value];
        }
    }
    # Добавляем в конец массива ТЕКУЩУЮ страницу (потому как outTree_parent_ids работает только с родителями)
    $pages[$page_id] = $pages_about[$page_id];
    return $pages;
}


function get_about_sql_array() {
    global $db, $uri_parts;
    $placeholder = implode(',', array_fill(0, count($uri_parts), '?'));
    $smf = $db->prepare("
       SELECT
            id,
            parent_id, 
            p_pr,
            p_ro,
            p_da,
            p_pr_with_type,
            p_ro_with_type,
            name,
            cpu,
            cpu_path,
            h1
        FROM
            pages
        WHERE
            cpu
        IN
            ($placeholder)
        AND
            public = 1
        ORDER BY
            id
        ");
    $smf->execute($uri_parts);
    if ($smf->rowCount() > 0) {
        $array = $smf->fetchAll(PDO::FETCH_ASSOC);
        $pages_about = array(); # Преобразуем массив
        foreach ($array as $value) { //Обходим массив
            $pages_about[$value['id']] = $value;
        }
    }
    return $pages_about;
}


function outTree_parent_ids($page_id, $pages_about) {
    $parent_id = $pages_about[$page_id]['parent_id'];
    if ($parent_id != '' && $parent_id > 0) {
        $find_child = outTree_parent_ids($parent_id, $pages_about);
        if ($find_child != '') {
            $text = $find_child . ',' . $parent_id;
        } else {
            $text = $parent_id;
        }
    }
    return $text;
}


?>