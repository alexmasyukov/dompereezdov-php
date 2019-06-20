<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-27
 * Time: 16:52
 */

class PageCars extends Page {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Отображаем страницу
     */
    public function view() {
        parent::view();

        // Если action пуст, значит это страница со всеми автомобилями
        if (Core::getUrl()->action == '') {
            Core::getSmarty()->assign('pageType', 'allCars');
            Core::getSmarty()->assign('cars', Cars::getCars());

            $page = (object)array(
                'h1' => 'Автомобили для грузоперевозки в Москве и Московской области'
            );

            // Обновляем хлебные крошки, добавляя название страницы в конец
            $this->updateBreadcrumb((object)array('title' => $page->h1));

            Core::getSmarty()->assign('page', $page);
            Core::getSmarty()->assign('metaTitle', 'Машины для грузоперевозки, вывоза мебели, переездов в Москве и Московской области');
            Core::getSmarty()->assign('metaDescription', '');
        } else {
            $generalAndOtherCars = Cars::getGeneralAndOther(Core::getUrl()->urlPath);
            // Если такая машина не найдена
            if (empty($generalAndOtherCars->generalCar->name)) {
                Page::view404();
            }

//            Core::log($generalAndOtherCars->generalCar);

            $generalAndOtherCars->generalCar->h1 = Core::charsDecode($generalAndOtherCars->generalCar->h1);
            $generalAndOtherCars->generalCar->description = Core::charsDecode($generalAndOtherCars->generalCar->description);

            Core::getSmarty()->assign('pageType', 'car');
            Core::getSmarty()->assign('generalCar', $generalAndOtherCars->generalCar);
            Core::getSmarty()->assign('otherCars', $generalAndOtherCars->otherCars);

            // Обновляем хлебные крошки, добавляя название страницы в конец
            $this->updateBreadcrumb((object)array('title' => $generalAndOtherCars->generalCar->name));

            Core::getSmarty()->assign('metaTitle', $generalAndOtherCars->generalCar->meta_title);
            Core::getSmarty()->assign('metaDescription', $generalAndOtherCars->generalCar->meta_description);
            Core::getSmarty()->assign('metaKeywords', $generalAndOtherCars->generalCar->meta_keywords);
        }

        // Формируем отзывы слева
        $this->buildReviewsOnLeftBlock();

        Core::getSmarty()->display('carsPage.tpl');
    }
}