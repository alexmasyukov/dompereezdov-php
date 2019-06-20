<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-27
 * Time: 16:14
 */

class PageContent extends Page {
    /**
     * PageContent constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $page
     */
    public function view($page) {
        parent::view();

//        Core::log($page);

        // todo: сделать замену всех телефонов в БД на переменные
        // todo: сделать функцию замены номеров на переменные

        // Обновляем хлебные крошки, добавляя название страницы в конец
        $this->updateBreadcrumb($page);

        Core::getSmarty()->assign('metaTitle', $page->meta_title);
        Core::getSmarty()->assign('metaDescription', $page->meta_description);
        Core::getSmarty()->assign('metaKeywords', $page->meta_keywords);

        $page->text = Core::charsDecode($page->description);

        // Формируем отзывы слева
        $this->buildReviewsOnLeftBlock();

        Core::getSmarty()->assign('page', $page);
        Core::getSmarty()->display('contentPage.tpl');
    }
}