<?php

/**
 *
 *  установить шаблонизатор
 * todo переписать все страницы на использование шаблонизатора
 * todo сделать отдельный класс для формирования страницы
 * todo сделать отдельные классы для блоков
 * todo сделать отдельные шаблоны для блоков и интегрировать их в страницы
 * todo вставить в БД новые нас пункты с услугами к ним
 * todo сделать нужную работу отзывов
 * todo поменять контакты в шапке и контактах
 *
 */

//ini_set("display_errors", 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$log = true;


if (isset($_GET['nc'])) header("X-Accel-Expires: 0");

// Основные подключения
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require $root . '/configuration.php';
require $root . '/core/class.database.inc';
require $root . '/core/class.core.inc';
require $root . '/core/class.page.inc';
require $root . '/core/class.menu.inc';
require $root . '/core/class.reviews.inc';
require $root . '/core/functions.php';
require $root . '/frontend/libs/smarty/libs/Smarty.class.php';

$core = new Core();

//$core->log(Core::getUrl());


// start html compressed
//ob_start('compressHtml');


switch (Core::getUrl()->module) {
    case 'index':
        require $root . '/core/class.pageHome.inc';
        $homePage = new PageHome();
        $homePage->view();
        break;
    case 'cars':
        require $root . '/core/class.cars.inc';
        require $root . '/core/class.pageCars.inc';
        $carsPage = new PageCars();
        $carsPage->view();
        break;
    case 'otzyvy':
        // Здесь используется табличный метод Макконела
        include_once $root . '/core/class.reviews.inc';
        include_once $root . '/core/class.pageReviews.inc';
        $reviewsPage = new PageReviews(Core::getUrl()->action);
        $reviewsPage->view();
        break;

    case 'moskovskaya-oblast':
    case 'moskva':
        require $root . '/core/class.cars.inc';
        require $root . '/core/class.photogallery.inc';
        require $root . '/core/class.pageMskServices.inc';
        $mskServicesPage = new PageMskServices();
        $mskServicesPage->view();
        break;
    // todo: do sitemap
    //    case 'sitemap':
    //        $sitemap = new Sitemap($core);
    //        $sitemap->view();
    //        break;
    //      todo rss for turbo pages
    //    case 'rss':
    //        break;
    default:
        require $root . '/core/class.pageContent.inc';
        $PageContent = new PageContent();
        $pageData = $PageContent->getPageOfCpuPatch(Core::getUrl()->urlPath);
        if (!$pageData) {
            Page::view404();
        } else {
            $PageContent->view((object)$pageData);
        }
}


// end html compressed
ob_end_flush();


/**
 * Функция избавляется от переносов, пробелов и т.д. минифицирует HTML
 * @param $compress
 * @return null|string|string[]
 */
function compressHtml($compress) {
    $i = array('/([\n\r])+/s', '/([\r])+/s', '/([\n])+/s', '/([\t])+/s');
    $one = preg_replace($i, '', $compress);
    $ii = array('/\s{2,}/');
    $two = preg_replace($ii, ' ', $one);
    $iii = array('/[\>]\s{1,}[\<]/');
    $tree = preg_replace($iii, '><', $two);
    $res_compress = preg_replace('/<!--(.*?)-->/', '', $tree);
    return $res_compress;
}


exit;

// Назначаем модуль и действие по умолчанию.
$module = 'index';
$action = 'index';
// Массив параметров из URI запроса.
$params = array();
$params_names = [];

$uri_parts = array();

$url_path = '';
// Если запрошен любой URI, отличный от корня сайта.
if ($_SERVER['REQUEST_URI'] != '/') {
    try {
        // Для того, что бы через виртуальные адреса можно было также передавать параметры
        // через QUERY_STRING (т.е. через "знак вопроса" - ?param=value),
        // необходимо получить компонент пути - path без QUERY_STRING.
        // Данные, переданные через QUERY_STRING, также как и раньше будут содержаться в 
        // суперглобальных массивах $_GET и $_REQUEST.
        $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url_query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

        //        echo $url_path;

        // Разбиваем виртуальный URL по символу "/"
        $uri_parts = explode('/', trim($url_path, '/'));
        // Если количество частей не кратно 2, значит, в URL присутствует ошибка и такой URL
        // обрабатывать не нужно - кидаем исключение, что бы назначить в блоке catch модуль и действие,
        // отвечающие за показ 404 страницы.
        //		if (count($uri_parts) % 2) {
        //			throw new Exception();
        //		}

        $module = array_shift($uri_parts); // Получили имя модуля (первое значение массива у удаляем его из массива)
        $action = array_shift($uri_parts); // Получили имя действия
        // Получили в $params параметры запроса
        for ($i = 0; $i < count($uri_parts); $i++) {
            $params_names[$i] = $uri_parts[$i];
            $params[$uri_parts[$i]] = $uri_parts[++$i];
        }

        $uri_parts = explode('/', trim($url_path, '/'));

    } catch (Exception $e) {
        $module = '404';
        $action = 'main';
    }
}
//echo $url_path;


//echo "\$module: $module <br/>";
//echo "\$action: $action <br/>";
//echo "\$params:\n";
//print_r($params);
//
//echo '<br/><br/>';
//
//echo "\$params_names:\n";
//print_r($params_names);

//$_REQUEST = array_merge($_REQUEST, $params);
# Общая

//$server = $_SERVER['HTTP_HOST'];


//include_once $root . "/frontend/system/base_connect.php";
include_once $root . '/frontend/system/functions.php';
require $root . "/frontend/system/templateController.php";
require $root . "/frontend/system/templateController_return.php";

//$reviews_count = include_once $root . '/frontend/modules/clients_reviews/get_count_clients_reviews.php';

# Защита от 2psk.ru
if (isset($_REQUEST['from'])) {
    $from = $_REQUEST['from'];
    if ($from == '2psk.ru' || $from == '2Psk.ru') {
        $link_rel_canonical = '<link rel="canonical" href="https://www.' . $server . $url_path . '"/>';
    }
}


$my_tmpl = array(
    "map" => $root . "/frontend/pages/blocks/map_2gis.php",
    "module_top2" => '',
    "module_right1" => '',
    "module_right2" => '',
    "module_right3" => '',
    "module_content1" => '',
    "module_content2" => '',
    "meta" => '',
    "block_for_wigets_1" => '/frontend/pages/blocks/wigets1.php',
    "wiget_reviews" => "/frontend/pages/wigets/wiget_reviews.php",
    "wiget_question" => "/frontend/pages/wigets/wiget_questions.php"
);

$feedback_count = include_once $root . '/frontend/modules/feedback/get_count_feedback.php';

# Общая переменные
$host_http = $_SERVER['HTTP_HOST'];

if (isset($_GET['link'])) {
    $link = $_GET['link'];
    $content_type_name = $_GET['content_type_name'];
    $view = $_GET['view'];
    $id = $_GET['id'];
    $category_name = $_GET['category_name'];
    $category_id = $_GET['category_id'];
    $tmpl = $_GET['tmpl'];
    $product_template = $_GET['product_template'];
    $review_tmpl = $_GET['review_tmpl'];
}

if (empty($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

if ($module !== 'rss.xml') {
    //  старт буферизации выводимого
    ob_start('compress_html');
}

if (!empty($uri_parts[0])) {
    if ($uri_parts[0] == 'index') {
        $link = '404';
        $module = '404';
        $action = '';
        view_404();
    }
}


switch ($module) {
    case 'index':
        {
            include_once($root . "/frontend/pages/html_open.php");
            include_once($root . "/frontend/pages/header.php");
            include_once($root . "/frontend/pages/home.php");
            include_once($root . "/frontend/pages/footer.php");
            include_once($root . "/frontend/pages/html_close.php");
            $db = null;
            break;
        }

    case 'rss.xml':
        {
            include_once($root . "/frontend/modules/rss/rss.php");
            $db = null;
            exit;
            break;
        }

    case 'moskovskaya-oblast':
    case 'moskva':
        {
            include_once($root . "/frontend/modules/catalog_v2/read_url_of_catalog_category.php"); # Всегда подключаем ПЕРВЫМ
            include_once($root . "/frontend/pages/html_open.php");
            include_once($root . "/frontend/pages/header.php");
            include_once($root . "/frontend/pages/default.php");
            include_once($root . "/frontend/pages/footer.php");
            include_once($root . "/frontend/pages/html_close.php");
            $db = null;
            break;
        }


    case 'contacts':
        {
            include_once($root . "/frontend/pages/html_open.php");
            include_once($root . "/frontend/pages/header.php");
            include_once($root . "/frontend/pages/$module.php");
            include_once($root . "/frontend/pages/footer.php");
            include_once($root . "/frontend/pages/html_close.php");
            $db = null;
            break;
        }

    case 'cars':
        {
            include_once($root . "/frontend/pages/html_open.php");
            include_once($root . "/frontend/pages/header.php");
            include_once($root . "/frontend/pages/car.php");
            include_once($root . "/frontend/pages/footer.php");
            include_once($root . "/frontend/pages/html_close.php");
            $db = null;
            break;
        }

    case 'otzyvy':
        {
            switch ($action) {
                case '':
                    $pain = [
                        'Аккуратность и материальная ответственность',
                        'Вежливость',
                        'Индивидуальный подход',
                        'Недорогие цены',
                        'Оперативность и пунктуальность'];
                    $feedback_h1 = 'Отзывы';
                    break;
                case 'akkuratnost-i-materialnaya-otvetstvennost':
                    $pain = ['Аккуратность и материальная ответственность'];
                    $feedback_h1 = 'Аккуратность и материальная ответственность';
                    break;
                case 'vezhlivost':
                    $pain = ['Вежливость'];
                    $feedback_h1 = 'Вежливость';
                    break;
                case 'individualnyy-podhod':
                    $pain = ['Индивидуальный подход'];
                    $feedback_h1 = 'Индивидуальный подход';
                    break;
                case 'nedorogie-ceny':
                    $pain = ['Недорогие цены'];
                    $feedback_h1 = 'Недорогие цены';
                    break;
                case 'operativnost-i-punktualnost':
                    $pain = ['Оперативность и пунктуальность'];
                    $feedback_h1 = 'Оперативность и пунктуальность';
                    break;
                default:
                    view_404();
                    break;
            }
            include_once($root . "/frontend/pages/html_open.php");
            include_once($root . "/frontend/pages/header.php");
            include_once($root . "/frontend/pages/$module.php");
            include_once($root . "/frontend/pages/footer.php");
            include_once($root . "/frontend/pages/html_close.php");
            $db = null;
            break;
        }


    case 'sitemap.xml':
        {
            include_once($root . '/frontend/php/special/sitemap.php');
            $db = null;
            break;
        }

    default:
        {
            if ($module == '' && $url_query != '') {
                $module = 'index';
                $action = 'index';
                $link = 'home';
                include_once($root . "/frontend/pages/html_open.php");
                include_once($root . "/frontend/pages/header.php");
                include_once($root . "/frontend/pages/home.php");
                include_once($root . "/frontend/pages/footer.php");
                include_once($root . "/frontend/pages/html_close.php");
                $db = null;
                break;
            } else {
                # Все исключения пройдены и нет совподений
                # Поэтому ищем id страницы (из таблицы content, если в content не найдено,
                # то ищем в content_category и подключаем соответственный модуль)
                $page_id = get_page_in_content();
                include_once($root . "/frontend/pages/html_open.php");
                include_once($root . "/frontend/pages/header.php");
                include_once($root . "/frontend/pages/content.php");
                include_once($root . "/frontend/pages/footer.php");
                include_once($root . "/frontend/pages/html_close.php");
                $db = null;
                break;
            }
        }
}


function view_404() {
    global $db, $root, $link, $module, $action;
    $link = '404';
    $module = '404';
    $action = '';
    header("HTTP/1.x 404 Not Found");
    include_once($root . "/frontend/pages/html_open.php");
    include_once($root . "/frontend/pages/header.php");
    echo '<div class="container " style="min-height: 750px !important;">
            <p style="font-size: 100px; display: table; margin: 0 auto; margin-top: 100px; font-weight: bold; font-family: "Tahoma";">404</p>
            <h1 style="font-size: 36px; margin-bottom: 15px; margin-top: 0px; width: 100%; text-align: center;"><b style="font-size: 30px;">Страница не существует!</b></h1>
            <a href="http://' . $_SERVER['SERVER_NAME'] . '/" class="backlink" style="text-decoration: underline; color:#222; display: table; margin: 0 auto;">Вернуться на Главную</a>
        </div>';
    include_once($root . "/frontend/pages/footer.php");
    include_once($root . "/frontend/pages/html_close.php");
    $db = null;
    exit;
}


function get_page_in_content() {
    global $db, $url_path;
    $sql = "SELECT
            id
        FROM
            content
        WHERE
            cpu_path = '$url_path'
        ";
    $smf = $db->query($sql);
    if ($smf->rowCount() > 0) {
        foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
            return $value['id'];
        }
    } else {
        view_404();
    }
}


if ($module !== 'rss.xml') {
    // конец буферизации и вывод сжатого html кода
    ob_end_flush();
}


//Эта функция избавляется от переносов, пробелов и т.д.
function compress_html($compress) {
    $i = array('/([\n\r])+/s', '/([\r])+/s', '/([\n])+/s', '/([\t])+/s');
    $one = preg_replace($i, '', $compress);

    $ii = array('/\s{2,}/');
    $two = preg_replace($ii, ' ', $one);

    $iii = array('/[\>]\s{1,}[\<]/');
    $tree = preg_replace($iii, '><', $two);

    $res_compress = preg_replace('/<!--(.*?)-->/', '', $tree);
    return $res_compress;
}


?>