<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-25
 * Time: 17:53
 */

class Page {
    protected $version;
    protected $year;
    private $menu;

    public function __construct() {
        // Для тестового сервера выводим постоянно новую версию для стилей и скриптов
        //        $this->core->host == $conf['test_host'] ? $this->version = '?v='.rand(0, 99999) : $this->version = '';
        $this->version = '?v=' . rand(0, 99999);
        $this->version = '';
        // Используется для footer copyright
        $this->year = date('Y');
        $this->menu = new Menu();
    }

    /**
     * Показывает замер время выполнения при разрушении класса
     */
    public function __destruct() {
        //        Core::brenchmark();
    }

    /**
     * 404 страница вывод
     */
    public static function view404() {
        header("HTTP/1.x 404 Not Found");
        $page = new Page();
        $page->view();
        Core::getSmarty()->display('page404.tpl');
        exit;
    }


    /**
     * Получает список услуг
     * @param $contentCategoryId
     * @return array|mixed
     */
    private function getServices($contentCategoryId) {
        $services = Database::query("
            SELECT 
                name,
                cpu_path
            FROM 
                content 
            WHERE 
                category_id = $contentCategoryId AND 
                public=1 
            ORDER BY 
                sort 
            ");

        //        Core::log($services);
        return $services;
    }


    /**
     * * Возвращает данные статьи из mysql по id
     * @param $id
     * @return object
     */
    public function getPageByID($id) {
        $sql = "SELECT 
                *
            FROM 
                content 
            WHERE 
                id = $id
            ";
        $smf = Database::query($sql, 'withCountFetch');
        if ($smf->rowCount > 0) {
            $page = (object)$smf->result;
            $page->title = trim(Core::charsDecode($page->title));
            $page->description = trim(Core::charsDecode($page->description));
            return $page;
        } else {
            return false;
        }
    }


    /**
     * Возвращает данные страницы по cpuPath
     * @param $cpuPath
     * @return mixed
     */
    public function getPageOfCpuPatch($cpuPath) {
        $cpuPath = Core::charsDecode($cpuPath);
        $sql = "SELECT
                    *
                FROM
                    content
                WHERE
                    cpu_path = '$cpuPath'";
        $smf = Database::query($sql, 'withCountFetch');
        if ($smf->rowCount > 0) {
            return $smf->result;
        } else {
            return false;
        }
    }


    /**
     * Защита от 2psk.ru
     * @return bool
     */
    private function psk2Check() {
        if (isset($_REQUEST['from']))
            if ($_REQUEST['from'] == '2psk.ru' || $_REQUEST['from'] == '2Psk.ru') return true;
        return false;
    }


    /**
     * Обновляет сгенерированный HTML хлебных крошек с названием страницы в конечном (неактивном) элементе
     * @param $page
     */
    public function updateBreadcrumb($page) {
        Core::getSmarty()->assign('breadcrumb', $this->generateBreadcrumbHTML(Core::getUrl(), $page));
    }


    /**
     * Заменяет переменные телефонов на телефоны из configuration
     * @param $text
     * @return string
     */
    public static function replacePhones($text){
        $text = mb_str_replace('#phone1#', $GLOBALS['phones']->phone1->text, $text);
        $text = mb_str_replace('#phone2#', $GLOBALS['phones']->phone2->text, $text);
        $text = mb_str_replace('#phone3#', $GLOBALS['phones']->phone3->text, $text);
        $text = mb_str_replace('#phone4#', $GLOBALS['phones']->phone4->text, $text);
        return $text;
    }

    /**
     * Генерирует HMTL хлебных крошек
     * @param $coreUrlObj
     * @param bool $page
     * @return string
     */
    private function generateBreadcrumbHTML($coreUrlObj, $page = false) {
        $breadcrumb = '<nav class="breadcrumb">
                            <a href="https://' . $coreUrlObj->host . '/">Главная</a>';

        switch ($coreUrlObj->module) {
            case 'services':
                if (!empty($page)) $breadcrumb .= ' » ' . $page->title;
                break;
            case 'moskovskaya-oblast':
            case 'moskva':
                // todo: fix it - as result Главная » Московская область, Домодедово » Вывоз и утилизация мебели и техники в Домодедово недорого
                if (!empty($page->breadcrumb)) $breadcrumb .= $page->breadcrumb;
                break;
            case 'otzyvy':
                if ($coreUrlObj->action == '') {
                    $breadcrumb .= ' » Отзывы';
                } else {
                    $breadcrumb .= '<a href="/otzyvy/">Отзывы</a>';
                    // Подставляем название "боли" пользователя (категории отзывов) к хлебным крошкам
                    if (!empty(PageReviews::$painTable[$coreUrlObj->action])) {
                        $breadcrumb .= ' » ' . PageReviews::$painTable[$coreUrlObj->action];
                    }
                }
                break;
            case 'cars':
                $breadcrumb .= '<a href="/cars/">Машины</a>';
                if (!empty($page)) $breadcrumb .= ' » ' . $page->title;
                break;
            default:
                if (!empty($page)) $breadcrumb .= ' » ' . $page->title;
                break;
        }

        $breadcrumb .= '</nav>';
        return $breadcrumb;
    }

    /**
     * Генерирует отзывы для левого блока
     * Вызывается из каждого класса страницы class.pageXXXXXXX.inc ,
     * имеет массив с параметрами отображения и получения, что гибко для классов
     * @param array $params
     */
    protected function buildReviewsOnLeftBlock($params = array()) {
        if (empty($params['limit'])) {
            $params['limit'] = $GLOBALS['reviewLimitOnLeftBlock'];
        }

        // Отображаем количество всех отзывов (Москва и МО услуги свой класс)
        $reviews = Reviews::getReviews($params);
        Core::getSmarty()->assign('reviewsOfLeftBlock', $reviews);
    }


    /**
     * Выводим страницу. Указываем переменные,
     * которые доступны в каждом шаблоне
     */
    protected function view() {
        Core::getSmarty()->assign('version', $this->version);
        Core::getSmarty()->assign('year', $this->year);
        Core::getSmarty()->assign('date_Y_m_d', date('Y-m-d'));
        Core::getSmarty()->assign('review_form_town_start_id', 1233);
        Core::getSmarty()->assign('HTTP_HOST', Core::getUrl()->host);
        Core::getSmarty()->assign('REQUEST_URI', Core::getUrl()->urlPath);

        // Контакты для _header.tpl
        Core::getSmarty()->assign('phoneOneNumber', $GLOBALS['phones']->phone1->number);
        Core::getSmarty()->assign('phoneOneText', $GLOBALS['phones']->phone1->text);
        Core::getSmarty()->assign('phoneTwoNumber', $GLOBALS['phones']->phone2->number);
        Core::getSmarty()->assign('phoneTwoText', $GLOBALS['phones']->phone2->text);

        // Основное меню _header.tpl
        Core::getSmarty()->assign('generalMenu', $this->menu->getGeneralMenu());

        // Московская область меню _header.tpl
        Core::getSmarty()->assign('subMenuMoskovskayaOblast', $this->menu->getMenuMoskovskayaOblast());

        // Москва меню _header.tpl
        Core::getSmarty()->assign('subMenuMoskva', $this->menu->getMenuMoskva());

        // Список услуг для левого блока _left__service_block.tpl
        Core::getSmarty()->assign('services', $this->getServices(10000));

        // Генерируем хлебные крошки
        Core::getSmarty()->assign('breadcrumb', $this->generateBreadcrumbHTML(Core::getUrl()));

        Core::log($this->psk2Check());
        if ($this->psk2Check()) {
            Core::getSmarty()->assign('canonical', 'https://' . Core::getUrl()->host . Core::getUrl()->urlPath);
        }

        Core::getSmarty()->assign('countAllReviews', Reviews::getInstance()->getReviewsAllCount()); //$reviews->count);

        // todo Так работать правильно не будет, у нас отзывы постраничные
        // Если есть параметры в запросе, выводим в шаблоне <link rel="canonical" href="" />
        // Говорим что страница с параметрами неканонична
        //        if (!empty(Core::getUrl()->urlQuery)) {
        //            Core::getSmarty()->assign('canonical', 'https://' . Core::getUrl()->host . Core::getUrl()->urlPath);
        //        }
    }
}