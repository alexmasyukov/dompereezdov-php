<?php

class Sitemap {
    private function __construct() {
    }

    private static function getContentPages() {
        return Database::query('select cpu_path from content where public = 1', 'column');
    }

    private static function getPages() {
        return Database::query('select cpu_path from pages where public = 1', 'column');
    }

    private static function getCars() {
        $carsPages = Database::query('select cpu_path from cars where public = 1', 'column');
        $carsPages[] = '/cars/';
        return $carsPages;
    }


    private static function getReviews() {
        include_once $GLOBALS['root'].'/core/class.pageReviews.inc';
        $reviewsPages = [];
        $reviewsPages[] = '/otzyvy/';
        foreach (PageReviews::$painTable as $cpu => $pain) {
            $reviewsPages[] = "/otzyvy/$cpu/";
        }
        return $reviewsPages;
    }

    public static function view(){
        $links = array_merge(self::getContentPages(), self::getPages(), self::getCars(), self::getReviews());
        Core::getSmarty()->assign('links', $links);
        Core::getSmarty()->assign('host', Core::getUrl()->host);
        Core::getSmarty()->display('sitemap.tpl');
    }
}