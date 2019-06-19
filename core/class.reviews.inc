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
     * Возврадает отзывы
     * @param bool $params
     * @return array
     */
    public static function getReviews($params = false) {
        if (!empty($params)) $params = (object)$params;
//        Core::log($params);

        if (!empty($params->limit)) {
            $limit = $params->limit;
        } else {
            $limit = 10;
        }
        $sql_limit = ' LIMIT ' . $limit;



        if (!empty($params->pain)) {
            $sql_pain = " AND pain LIKE '%$params->pain%' ";
        } else {
            $sql_pain = '';
        }


        // todo fix it - если указать ?page=55 сработает (вкл Core::log($params);)
        // Показываем нужную страницу
        if (!empty($params->currentPage)) {
            $currentPage = $params->currentPage == 1 ? 0 : $params->currentPage;
            $start = $limit * $currentPage;
            $sql_limit = " LIMIT $start, " . $limit;
        }


        $sql = "SELECT
                   *
                FROM
                    feedback
                WHERE
                    public=1
                    $sql_pain
                ORDER BY
                    date DESC
                    $sql_limit";

//        echo $sql;

        $reviews = Database::query($sql, 'withCount');
        if ($reviews->rowCount > 0) {
            foreach ($reviews->result as &$review) {
                $review = (object)$review;
                $review->date = russain_date($review->date);
            }
            return $reviews->result;
        }

        return array();
    }


    /**
     * @param $pain
     * @return int
     */
    public static function getReviewsCount($pain) {
        $sql = 'SELECT 
                    COUNT(*) 
                FROM 
                    feedback 
                WHERE 
                    public = 1 
                    AND date <= \'' . date('Y-m-d') . '\' 
                    AND pain LIKE \'%' . $pain . '%\'
        ';
        $reviews = Database::query($sql, 'asResult');
        return $reviews->fetchColumn() - 1;
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