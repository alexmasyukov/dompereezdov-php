<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-27
 * Time: 14:51
 */

class Reviews {
    private static $reviewsAllCount;
    private static $currentPage;
    private static $_instance; //The single instance

    /**
     * @return Reviews
     */
    public static function getInstance() {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    public function __construct() {
        self::$reviewsAllCount = self::getAllCount();
    }

    /**
     * Получает количество всех отзывов (независимо от подраздела (боли PageReviews::painTable))
     * @return integer
     */
    public static function getAllCount() {
        $sql = '
                SELECT COUNT(*) FROM feedback WHERE public = 1 AND date <= \'' . date('Y-m-d') . '\'';
        $reviews = Database::query($sql, 'asResult');
        return $reviews->fetchColumn() - 1;
    }

    /**
     * @param mixed $currentPage
     */
    public static function setCurrentPage($currentPage) {
        self::$currentPage = $currentPage;
    }

    /**
     * Возвращает отзывы
     * @param bool $params
     * @return array
     */
    public static function getReviews($params = false) {
        if (!empty($params)) $params = (object)$params;
        //        Core::log($params);

        $limit = 10;
        if (!empty($params->limit)) {
            $limit = $params->limit;
        }
        $sql_limit = ' LIMIT ' . $limit;


        $sql_pain = '';
        if (!empty($params->pain)) {
            $sql_pain = " AND pain LIKE '%$params->pain%' ";
        }

        $sql_service = '';
        if (!empty($params->service)) {
            $sql_service = " AND usluga LIKE '%$params->service%' ";
        }


        // todo fix it - если указать ?page=55 сработает (вкл Core::log($params);)
        // Показываем нужную страницу
        if (!empty($params->currentPage)) {
            $currentPage = $params->currentPage == 1 ? 0 : $params->currentPage;
            $start = $limit * $currentPage;
            $sql_limit = " LIMIT $start, " . $limit;
        }

        $sql_towns = '';
        if (!empty($params->townId)) {
            $sql_towns = " AND town_start_id = $params->townId ";
        }

        $sqlSelector = 'SELECT * ';
        $sql = " FROM
                    feedback
                WHERE
                    public=1
                    $sql_pain
                    $sql_towns
                    $sql_service
                ORDER BY
                    date DESC";

//        echo $sqlSelector . $sql;

        if (!empty($params->returnCount)) {
            // ЭТО МОЖНО ИСПОЛЬЗОВАТЬ ТОГДА: когда нам нужно получить
            // количество всех отызвов по выбранным параметрам
            // Получаем общее количество таких отзывов
            $sqlSelector = 'SELECT COUNT(*) ';
            $reviewsForCount = Database::query($sqlSelector . $sql, 'asResult');

            return $reviewsForCount->fetchColumn() - 1;
        }

//        echo $sqlSelector . $sql . $sql_limit;

        $reviews = Database::query($sqlSelector . $sql . $sql_limit, 'withCount');
        if ($reviews->rowCount > 0) {
            foreach ($reviews->result as &$review) {
                $review = (object)$review;
                $review->date = russain_date($review->date);
                $review->comment = Core::charsDecode($review->comment);
                $review->why = Core::charsDecode($review->why);
            }

            return $reviews->result;
        }

        return array();
    }


    /**
     * @param $params
     * @return array
     */
    public static function getReviewsCount($params) {
        // Установим параметр, чтобы возвратилось только число отзывов
        $additParams = array(
            'returnCount' => true
        );

        $params = array_merge($params, $additParams);
        return Reviews::getReviews($params);
    }


    /**
     * @param $reviewsCount
     * @param $limit
     * @return mixed
     */
    public static function getPagesCount($reviewsCount, $limit) {
        return ceil($reviewsCount / $limit);
    }


    /**
     * @return mixed
     */
    public static function getCurrentPage() {
        return self::$currentPage;
    }


    /**
     * @return int
     */
    public static function getReviewsAllCount() {
        return self::$reviewsAllCount;
    }
}