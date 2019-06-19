<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-25
 * Time: 18:33
 */

class Core {
    private static $url;
    private static $smarty;

    /**
     * Core constructor.
     */
    public function __construct() {
        $this->parseUrl();
        $this->initSmarty();
    }

    /**
     * Инициируем шаблонизатор
     */
    public function initSmarty() {
        self::$smarty = new Smarty;
        self::$smarty->caching = false;
        self::$smarty->template_dir = $GLOBALS['root'] . '/templates';
        self::$smarty->compile_dir = $GLOBALS['root'] . '/templates_c';
    }


    /**
     * Парсит запрос
     */
    private function parseUrl() {
        self::$url = (object)array();

        self::$url->host = $_SERVER['HTTP_HOST'];
        // Если запрошен любой URI, отличный от корня сайта. (с параметрами или без)
        if ($_SERVER['REQUEST_URI'] != '/') {
            try {
                // Для того, что бы через виртуальные адреса можно было также передавать параметры
                // через QUERY_STRING (т.е. через "знак вопроса" - ?param=value),
                // необходимо получить компонент пути - path без QUERY_STRING.
                // Данные, переданные через QUERY_STRING, также как и раньше будут содержаться в
                // суперглобальных массивах $_GET и $_REQUEST.
                self::$url->urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                self::$url->urlQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
                // Разбиваем виртуальный URL по символу "/"
                self::$url->uriParts = explode('/', trim(self::$url->urlPath, '/'));
                //print_r($uri_parts);
                self::$url->module = array_shift(self::$url->uriParts); // Получили имя модуля (первое значение массива у удаляем его из массива)
                self::$url->action = array_shift(self::$url->uriParts); // Получили имя действия
                // Если это главная страница (верхнее условие выполнилось потому что нам передали параметры ?...)
                if (self::$url->urlPath == '/') {
                    self::$url->module = 'index';
                    self::$url->action = 'index';
                    return;
                }
                // Получили в $params параметры запроса
                //                for ($i = 0; $i < count($this->uriParts); $i++) {
                //                    $params_names[$i] = $this->uriParts[$i];
                //                    $this->params[$this->uriParts[$i]] = $this->uriParts[++$i];
                //                }
            } catch (Exception $e) {
                self::$url->module = '404';
                self::$url->action = 'main';
            }
        } else {
            self::$url->module = 'index';
            self::$url->action = 'index';
        }
    }

    /**
     * Бренчмарк. Выводит время работы скирпта с момента запроса на ссылку
     */
    public static function brenchmark() {
        $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        echo '<div class="container brenchmark"><span>' . $time . '</span></div>';
    }


    /**
     * Возвращает обработанную строку
     * @param $txt
     * @return string
     */
    public static function charsEncode($txt) {
        return htmlentities(addslashes($txt), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Возращает декодированную строку
     * @param $txt
     * @return string
     */
    public static function charsDecode($txt) {
        return html_entity_decode(htmlspecialchars_decode(stripslashes($txt)));
    }


    /**
     * @param $txt
     */
    public static function log($txt) {
        if (!empty($GLOBALS['log']) && $GLOBALS['log'] == true) {
            echo '<pre>';
            print_r($txt);
            echo '</pre>';
        }
    }

    /**
     * @property string action
     * @property string module
     * @return object
     */
    public static function getUrl() {
        return self::$url;
    }

    /**
     * @return mixed
     */
    public static function getSmarty() {
        return self::$smarty;
    }


    /**
     * Проверяет, если это число, возвращает его, несли нет возвращает 0
     * @param bool $number
     * @return bool|int
     */
    public static function toInt($number = false) {
        if (!empty($number)) {
            if (is_numeric($number)) {
                return $number;
            }
        }
        return 0;
    }
}