<?php
//echo $module . '--' . $url_path;
if ($url_path == '' && $module == 'index') {
    $url_path = '/glavnaya-stranica/glavnaya/';
}
$sql = "SELECT 
            *
        FROM 
           meta 
        WHERE 
           module = '$module';
    ";
$module_get = $db->query($sql);
if ($module_get->rowCount() > 0) {
    while ($value = $module_get->fetch(PDO::FETCH_ASSOC)) {
//        echo trim($value['cpu_path']).'='.$url_path;
        if (trim($value['cpu_path']) == $url_path) {
            if ($page != 1 && $page != '') {
                $page_meta_title = ' | Страница '.$page;
            }
            $title_meta = $value['title'].$page_meta_title;
            $description_meta = $value['description'];
            $keywords_meta = $value['keywords'];
        } else {
            # делаем запрос к другой таблице для получения meta данных
            $sql = "SELECT 
                            meta_title,
                            meta_description,
                            meta_keywords
                        FROM 
                           " . $value['table'] . "
                        WHERE 
                           cpu_path = '$url_path';
                ";
            $module_get2 = $db->query($sql);
            if ($module_get2->rowCount() > 0) {
                while ($value = $module_get2->fetch(PDO::FETCH_ASSOC)) {
                    if ($page != 1 && $page != '') {
                        $page_meta_title = ' | Страница '.$page;
                    }
                    $title_meta = $value['meta_title'].$page_meta_title;
                    $description_meta = $value['meta_description'];
                    $keywords_meta = $value['meta_keywords'];
                }
            }
        }
    }
} else { # Если модуль не найден в mata, то ищем данные в таблице content
    $sql = "SELECT
                id,
                meta_title,
                meta_description,
                meta_keywords
            FROM
               content 
            WHERE
               cpu_path = '$url_path';
    ";
    $module_get = $db->query($sql);
    if ($module_get->rowCount() > 0) {
        while ($value = $module_get->fetch(PDO::FETCH_ASSOC)) {
            if ($page != 1 && $page != '') {
                $page_meta_title = ' | Страница '.$page;
            }
            $page_id = $value['id'];
            $title_meta = $value['meta_title'].$page_meta_title;
            $description_meta = $value['meta_description'];
            $keywords_meta = $value['meta_keywords'];
        }
    } else {
        $title_meta = '';
        $description_meta = '';
        $keywords_meta = '';
    }
}
$title_meta = str_replace('"', '&quot;', $title_meta);
$description_meta = str_replace('"', '&quot;', $description_meta);
?>
<title><?php echo $title_meta; ?></title>
<meta name="description" content="<?php echo $description_meta; ?>"/>
<meta name="keywords" content="<?php echo $keywords_meta; ?>"/>
<meta property="og:locale" content="ru_RU"/>
<meta property="og:title" content="<?php echo $title_meta; ?>"/>
<meta property="og:description" content="<?php echo $description_meta; ?>"/>
<meta property="og:image" content="https://<?php echo $server; ?>/frontend/template/images/logo-social-min.png"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
<!--https://webmaster.yandex.ru/tools/microtest/-->