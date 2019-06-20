<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-06-01
 * Time: 20:59
 */

$root = realpath($_SERVER['DOCUMENT_ROOT']);
require $root . '/configuration.php';
require $root . '/core/class.database.inc';
require $root . '/core/class.core.inc';
require $root . '/core/class.page.inc';
require $root . '/core/functions.php';


include 'data/pages_array_MO.php';
include 'data/pages_array_MO_for_merge.php';
include 'data/moskva_array.php';
include 'data/services.php';

$log = true;

$PageBuilder = new PagesBuilder();
$PageBuilder->cleanPagesTable();
$PageBuilder->combineOldPageWithNewAdditionalParams();
$PageBuilder->recordOldPagesToDB();
$PageBuilder->buildNewPages();
$PageBuilder->recordNewPagesToDB();
$PageBuilder->buildNewMoskvaPages();
$PageBuilder->recordMoskvaPagesToDB();
$PageBuilder->buildBreadcrumbs();
$PageBuilder->recordBreadcrumbs();
$PageBuilder->buildTownStartAdminNames();
$PageBuilder->recordTownStartAdminNames();

class PagesBuilder {
    private $pages;
    private $pagesMOForMerge;
    private $moskvaPages;
    private $services;
    private $newMOPages = array();
    private $newMoskvaPages = array();
    private $breadcrumbs = array();
    private $townStartAdminNames = array();

    /**
     * PagesBuilder constructor.
     */
    public function __construct() {
        //        $this->pages = $this->convertToObjects(array_slice($GLOBALS['pages'], 0, 50));
        $this->pages = $this->convertToObjects($GLOBALS['pages']);
        $this->pagesMOForMerge = $this->convertToObjects($GLOBALS['pagesMOForMerge']);
        $this->services = $this->convertToObjects($GLOBALS['services']);

        $this->moskvaPages = (object)array();
        foreach ($GLOBALS['moskva_pages_array'] as $key => $group) {
            $this->moskvaPages->$key = (object)$this->convertToObjects($group);
        }


    }

    private function getAllPages() {
        $sql = "SELECT 
                    id, parent_id, name, admin_name, cpu, type, page_type, cpu_path
                FROM 
                    pages 
                ORDER BY 
                    id";
        $pages = Database::query($sql);
        $convertPages = array();
        foreach ($pages as $page) { //Обходим массив
            $convertPages[$page['id']] = $page;
        }

        return $convertPages;
    }


    /**
     * Возвращает путь до страницы разделенный символом * (включая саму страницу)
     * @param $pageId
     * @param $pages
     * @param $field
     * @return string
     */
    private function getPagePathAsText($pageId, $pages, $field) {
        if (isset($pages[$pageId]['parent_id'])) {
            if ($pages[$pageId]['parent_id'] == 0) return $pages[$pageId][$field];
            return $this->getPagePathAsText($pages[$pageId]['parent_id'], $pages, $field) . '*' . $pages[$pageId][$field];
        }
    }


    /**
     * Возвращает массив с путем до страницы (включая саму страницу)
     * @param $pageId
     * @param $pages
     * @param $field
     * @return array
     */
    private function getPagePathAsArray($pageId, $pages, $field) {
        $arr = explode('*', $this->getPagePathAsText($pageId, $pages, $field));
        $arr[count($arr) - 1] = mb_ucfirst(trim($arr[count($arr) - 1]));
        return $arr;
    }

    /**
     * Генерирует основные массивы хлебных крошек
     */
    public function buildBreadcrumbs() {
        $pages = $this->getAllPages();

        foreach ($pages as $page) {
            $this->breadcrumbs[$page['id']] = (object)array(
                'id' => $page['id'],
                'breadcrumb_ids' => implode('*', $this->getPagePathAsArray($page['id'], $pages, 'id')),
                'breadcrumb_paths' => implode('*', $this->getPagePathAsArray($page['id'], $pages, 'cpu_path')),
                'breadcrumb_names' => implode('*', $this->getPagePathAsArray($page['id'], $pages, 'name'))
            );
        }
        //                Core::log($this->breadcrumbs);
    }


    /**
     * Записывает сгенерированные хлебные крошки в БД
     */
    public function recordBreadcrumbs() {
        foreach ($this->breadcrumbs as $breadcrumb) {
            $this->recordUpdate($breadcrumb);
        }
    }


    /**
     * Генерирует такую штуку "Вывоз мебели (Московская область/Одинцовский район/Новоивановское)"
     */
    public function buildTownStartAdminNames() {
        $pages = $this->getAllPages();

        foreach ($pages as $page) {
            $names_array = $this->getPagePathAsArray($page['id'], $pages, 'name');
            if (count($names_array) > 1) {
                $lastName = array_pop($names_array);
            } else {
                $lastName = $names_array[0];
            }

            $town_start_admin_name = $lastName . ' (' . implode('/', $names_array) . ')';

            $this->townStartAdminNames[] = (object)array(
                'id' => $page['id'],
                'town_start_admin_name' => $town_start_admin_name
            );
        }

        //        Core::log($this->townStartAdminNames);
    }

    /**
     * Записывает штуки в БД
     */
    public function recordTownStartAdminNames() {
        foreach ($this->townStartAdminNames as $item) {
            $this->recordUpdate($item);
        }
    }


    /**
     * Обновляет данные в БД (исключая id из записи, но включае его в Where)
     * @param $item
     */
    private function recordUpdate($item) {
        $columns = array_keys((array)$item);
        $values = array_values((array)$item);

        $sql_part = array();
        foreach ($columns as $key => $column) {
            if ($key == 'id') continue;
            $value = $values[$key];
            $sql_part[] = "$column = '$value'";
        }

        $sql = "UPDATE pages SET " . implode(',', $sql_part) . "  WHERE id = $item->id";
        //        echo $sql.'<br>';
        $result = Database::query($sql, 'asResult');
    }


    public function combineOldPageWithNewAdditionalParams() {
        foreach ($this->pages as &$page) {
            $one = mb_strtolower($page->name);


            if ($one[0] != ' '
                && !mb_strpos($one, 'район')
                && !mb_strpos($one, 'область')) {
                echo '<b>' . $one . '</b>';
                foreach ($this->pagesMOForMerge as $pageForMerge) {
                    $two = trim(mb_strtolower($pageForMerge->name));

                    if ($one == $two) {
                        $page = (object)array_merge((array)$pageForMerge, (array)$page);
                        //                        Core::log($page);
                        echo ' = <span style="color: red">' . $two . '</span>';
                        break;
                    }
                }

                echo '<br>';
            }
        }
    }


    public function buildNewMoskvaPages() {
        $startID = 10000;
        $serviceDefault = $this->services[count($this->services) - 1];

        $moskvaTown = (object)array(
            'id' => $startID,
            'parent_id' => 0,
            'name' => $GLOBALS['moskvaPage']->p_im,
            'h1' => $serviceDefault->h1,
            'cpu_path' => '/moskva/',
            'cpu' => '',
            'page_type' => 'town',
            'metaTitle' => $serviceDefault->metaTitle,
            'metaDescription' => $serviceDefault->metaDescription,
            'sort' => 1,
            'pageType' => 'connected',
        );

        // Записываем Москву
        $moskvaTown = (object)array_merge((array)$moskvaTown, (array)$GLOBALS['moskvaPage']);
        $this->newMoskvaPages[] = $this->generateUniversalPage($moskvaTown);

        // Генерируем страницы городов и услуг для них
        foreach ($this->moskvaPages as $key => $group) {
            foreach ($group as $sort => $town) {

                $startID++;
                $newTown = (object)array(
                    'id' => $startID,
                    'parent_id' => $moskvaTown->id,
                    'name' => $town->p_im,
                    'h1' => $serviceDefault->h1,
                    'cpu_path' => '/moskva/' . eng_name($town->p_im) . '/',
                    'cpu' => '',
                    'page_type' => 'town',
                    'metaTitle' => $serviceDefault->metaTitle,
                    'metaDescription' => $serviceDefault->metaDescription,
                    'sort' => $sort,
                    'type' => $key,
                    'pageType' => 'town',

                );
                $newTown = (object)array_merge((array)$newTown, (array)$town);
                //                                Core::log($newTown);
                //                Core::log($this->generateUniversalPage($newTown));
                $this->newMoskvaPages[] = $this->generateUniversalPage($newTown);

                // Формируем услуги для каждого города
                foreach ($this->services as $sortService => $serviceItem) {
                    if ($serviceItem->pageType == 'service') {
                        $serviceItem->type = 'service';

                        if (
                            $serviceItem->cpu == 'gruzoperevozki' ||
                            $serviceItem->cpu == 'vyvoz-mebeli' ||
                            $serviceItem->cpu == 'perevozka-pianino' ||
                            $serviceItem->cpu == 'kvartirnyj-pereezd'
                        ) {
                            $serviceItem->public = 1;
                        } else {
                            $serviceItem->public = 0;
                        }

                        $startID++;
                        $this->newMoskvaPages[] = $this->generatePage($serviceItem, (object)$newTown, $sortService, 'service', $startID);
                    }
                }
            }
        }

//        Core::log($this->newMoskvaPages);
    }


    /**
     * Записывает в БД старые страницы Московской области
     */
    public function recordOldPagesToDB() {
        foreach ($this->pages as $oldPage) {
            $this->record($oldPage);
        }
    }

    /**
     * Записывает в БД сгенерированные новые Московской области
     */
    public function recordNewPagesToDB() {
        foreach ($this->newMOPages as $page) {
            $this->record($page);
        }
    }

    /**
     * Записывает в БД сгенерированные новые страницы Москвы
     */
    public function recordMoskvaPagesToDB() {
        foreach ($this->newMoskvaPages as $page) {
            $this->record($page);
        }
    }


    /**
     * Формирует запрос на добавление страницы и записывет в БД
     * пропускает столбцы где пустое значение
     * @param $page
     */
    private function record($page) {
        $page = (array)$page;
        $pageColumns = array_keys((array)$page);

        $columns = [];
        $values = [];
        foreach ($pageColumns as $column) {
            if ($page[$column] !== '') {
                $columns[] = $column;
                $values[] = $page[$column];
            }
        }

        $sql = 'INSERT INTO pages (' . implode(',', $columns) . ') 
                        VALUES (\'' . implode('\',\'', array_values((array)$values)) . '\')';

        //                echo $sql;
        $result = Database::query($sql, 'asResult');
    }


    /**
     * Генерирует массив из новых страниц
     */
    public function buildNewPages() {
        foreach ($this->pages as $key => &$page) {
            if ($page->page_type == 'town') {
                $lastTown = $page;
                foreach ($this->services as $sort => $service) {
                    if (!empty($service->isNewService) && $service->isNewService == true) {
                        //                        Core::log($service);
                        if ($service->cpu == 'kvartirnyj-pereezd') {
                            $service->public = 1;
                        } else {
                            $service->public = 0;
                        }
                        $this->newMOPages[] = $this->generatePage($service, $lastTown, $sort);
                    }
                }
            }
        }
    }


    /**
     * Возвращает сгенерированную страницу в виде массива
     * @param $service
     * @param $lastTown
     * @param $sort
     * @param string $pageType
     * @param bool $id
     * @return array
     */
    private function generatePage($service, $lastTown, $sort, $pageType = 'service', $id = false) {
        $page = array(
            'parent_id' => $lastTown->id,
            'name' => $service->russianName,
            'admin_name' => '', // todo: сделать это
            'cpu_path' => $lastTown->cpu_path . $service->cpu . '/',
            'cpu' => $service->cpu,
            'level' => '-1',
            'h1' => $service->h1,
            'p_ro' => !empty($lastTown->p_ro) ? $lastTown->p_ro : '',
            'p_da' => !empty($lastTown->p_da) ? $lastTown->p_da : '',
            'p_ve' => !empty($lastTown->p_ve) ? $lastTown->p_ve : '',
            'p_tv' => !empty($lastTown->p_tv) ? $lastTown->p_tv : '',
            'p_pr' => !empty($lastTown->p_pr) ? $lastTown->p_pr : '',
            'sort' => $sort,
            'public' => !empty($service->public) ? $service->public : 0,
            'meta_title' => $service->metaTitle,
            'meta_description' => $service->metaDescription,
            'meta_keywords' => '',
            'type' => !empty($service->type) ? $service->type : '',
            'page_type' => $pageType,
            'zn_1' => $lastTown->zn_1,
            'etnohoronim_mn_p_da' => $lastTown->etnohoronim_mn_p_da,
            'zn_2' => $lastTown->zn_2,
            'zn_3' => $lastTown->zn_3,
            'zn_4' => $lastTown->zn_4,
            'zn_5' => $lastTown->zn_5,
            'zn_6' => $lastTown->zn_6,
            'zn_7' => $lastTown->zn_7
        );

        if (!empty($id)) {
            $page['id'] = $id;
        }

        return $page;
    }


    private function generateUniversalPage($params) {
        return array(
            'id' => $params->id,
            'parent_id' => !empty($params->parent_id) ? $params->parent_id : 0,
            'name' => $params->name,
            'admin_name' => '', // todo: сделать это
            'cpu_path' => $params->cpu_path,
            'cpu' => $params->cpu,
            //            'level' => '0',
            'h1' => $params->h1,
            'p_ro' => !empty($params->p_ro) ? $params->p_ro : '',
            'p_da' => !empty($params->p_da) ? $params->p_da : '',
            'p_ve' => !empty($params->p_ve) ? $params->p_ve : '',
            'p_tv' => !empty($params->p_tv) ? $params->p_tv : '',
            'p_pr' => !empty($params->p_pr) ? $params->p_pr : '',
            'sort' => $params->sort,
            'public' => '1',
            'meta_title' => $params->metaTitle,
            'meta_description' => $params->metaDescription,
            'meta_keywords' => '',
            'type' => !empty($params->type) ? $params->type : '',
            'page_type' => $params->pageType,
            'zn_1' => !empty($params->zn_1) ? $params->zn_1 : '',
            'etnohoronim_mn_p_da' => !empty($params->etnohoronim_mn_p_da) ? $params->etnohoronim_mn_p_da : '',
            'zn_2' => !empty($params->zn_2) ? $params->zn_2 : '',
            'zn_3' => !empty($params->zn_3) ? $params->zn_3 : '',
            'zn_4' => !empty($params->zn_4) ? $params->zn_4 : '',
            'zn_5' => !empty($params->zn_5) ? $params->zn_5 : '',
            'zn_6' => !empty($params->zn_6) ? $params->zn_6 : '',
            'zn_7' => !empty($params->zn_7) ? $params->zn_7 : '',
        );
    }

    //    /**
    //     *
    //     * @param $cpu
    //     * @return bool
    //     */
    //    private function findExistingServices($cpu) {
    //        foreach ($this->services as $service) {
    //            if (trim($cpu) == $service->cpu) {
    //                return true;
    //            }
    //        }
    //        return false;
    //    }


    /**
     * Конвертирует массивы в объекты
     * @param $array
     * @return mixed
     */
    private function convertToObjects($array) {
        foreach ($array as &$item) {
            $item = (object)$item;
        }
        return $array;
    }

    /**
     * Очищает таблицу pages
     */
    public function cleanPagesTable() {
        $truncate = Database::query('TRUNCATE TABLE pages', 'asResult');
        Core::log('TRUNCATE pages');
    }
}

