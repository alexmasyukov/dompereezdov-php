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
$PageBuilder->buildNewPages();
$PageBuilder->cleanPagesTable();
$PageBuilder->combineOldPageWithNewAdditionalParams();
$PageBuilder->recordOldPagesToDB();
$PageBuilder->recordNewPagesToDB();
$PageBuilder->buildNewMoskvaPages();
$PageBuilder->recordMoskvaPagesToDB();

class PagesBuilder {
    private $pages;
    private $pagesMOForMerge;
    private $moskvaPages;
    private $services;
    private $newMOPages = array();
    private $newMoskvaPages = array();

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


    public function combineOldPageWithNewAdditionalParams() {
        foreach ($this->pages as &$page) {
            $one = mb_strtolower($page->name);


            if ($one[0] != ' '
                && !mb_strpos($one, 'район')
                && !mb_strpos($one, 'область')) {
                echo '<b>'.$one.'</b>';
                foreach ($this->pagesMOForMerge as $pageForMerge) {
                    $two = trim(mb_strtolower($pageForMerge->name));

                    if ($one == $two) {
                        $page = (object)array_merge((array)$pageForMerge, (array)$page);
                        echo ' = <span style="color: red">'.$two.'</span>';
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
//                Core::log($newTown);
//                Core::log($this->generateUniversalPage($newTown));
                $this->newMoskvaPages[] = $this->generateUniversalPage($newTown);

                // Формируем услуги для каждого города
                foreach ($this->services as $sortService => $serviceItem) {
                    if ($serviceItem->pageType == 'service') {
                        $serviceItem->type = 'service';
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
            if ($page[$column] != '') {
                $columns[] = $column;
                $values[] = $page[$column];
            }
        }

        $sql = 'INSERT INTO pages (' . implode(',', $columns) . ') 
                        VALUES (\'' . implode('\',\'', array_values((array)$values)) . '\')';

        //        echo $sql;
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
                    if (!empty($service->isNewService) && $service->isNewService == true)
                        $service->public = 0;
                        $this->newMOPages[] = $this->generatePage($service, $lastTown, $sort);
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
            'etnohoronim_mn_p_da' => !empty($params->etnohoronim_mn_p_da) ? : '',
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

