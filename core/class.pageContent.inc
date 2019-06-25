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

        // Обновляем хлебные крошки, добавляя название страницы в конец
        $this->updateBreadcrumb($page);

        Core::getSmarty()->assign('metaTitle', $page->meta_title);
        Core::getSmarty()->assign('metaDescription', $page->meta_description);
        Core::getSmarty()->assign('metaKeywords', $page->meta_keywords);

        $page->text = Core::charsDecode($page->description);
        $page->text = Page::replacePhones($page->text);

        // Формируем отзывы слева
        switch (Core::getUrl()->urlPath) {
            case '/services/transportnye-uslugi/':
                // Транспортные услуги:
                // Если выбрана Москва - Это связующая страница connected везде + страница контента /services/transportnye-uslugi/
                $this->buildReviewsOnLeftBlock(array(
                    'townId' => 1, // Московская область
                    'service' => 'Транспортные услуги'
                ));
                break;
            case '/services/kvartirnyy-pereezd/':
            case '/services/ofisnyy-pereezd/':
            case '/services/dachnyy-pereezd/':
                $this->buildReviewsOnLeftBlock(array(
                    'townId' => 10000, // (Если выбрана Москва отображаются на страницах контента:)
                    'service' => 'Переезды'
                ));
                break;
            case '/services/vyvoz-staroy-mebeli/':
                $this->buildReviewsOnLeftBlock(array(
                    'townId' => 10000, // (Если выбрана Москва отображаются на страницах контента:)
                    'service' => 'Вывоз мебели'
                ));
                break;
            case '/services/perevozka-pianino/':
                $this->buildReviewsOnLeftBlock(array(
                    'townId' => 10000, // (Если выбрана Москва отображаются на страницах контента:)
                    'service' => 'Перевозка пианино'
                ));
                break;

            default:
                $this->buildReviewsOnLeftBlock();
        }

        Core::getSmarty()->assign('page', $page);
        Core::getSmarty()->display('contentPage.tpl');
    }
}