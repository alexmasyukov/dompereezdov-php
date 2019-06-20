<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-27
 * Time: 18:56
 */

class PageReviews extends Page {
    private $page = array();

    // Таблица болей клиета (используется для роутинга и построение таблицы болей на странице)
    public static $painTable = array(
        'akkuratnost-i-materialnaya-otvetstvennost' => 'Аккуратность и материальная ответственность',
        'vezhlivost' => 'Вежливость',
        'individualnyy-podhod' => 'Индивидуальный подход',
        'nedorogie-ceny' => 'Недорогие цены',
        'operativnost-i-punktualnost' => 'Оперативность и пунктуальность'
    );


    private function getPainOfThisPage($urlAction) {
        foreach (PageReviews::$painTable as $action => $painTitle) {
            if ($urlAction == $action) {
                return (object)array(
                    'name' => $action,
                    'title' => $painTitle
                );
            }
        }
    }

    /**
     * PageReviews constructor.
     * @param $urlAction
     */
    public function __construct($urlAction) {
        parent::__construct();

        // Если это подкатегория отзывов
        if (!empty($urlAction)) {
            $findedAction = false;
            foreach (PageReviews::$painTable as $action => $painTitle) {
                if ($urlAction == $action) {
                    $findedAction = true;
                    $this->page = (object)array(
                        'pageType' => 'painReviews',
                        'title' => $painTitle,
                        'action' => $action,
                        'h1' => $painTitle,
                        'meta_title' => 'Отзывы - ' . $painTitle,
                        'meta_description' => 'Читайте отзывы о нашей работе выполненной у клиентов'
                    );
                    break;
                }
            }
            if ($findedAction == false) Page::view404();
        } else {
            // Это главная страница отзывов
            $this->page = (object)array(
                'pageType' => 'allReviews',
                'h1' => 'Отзывы',
                'meta_title' => 'Отзывы о компании Дом Переездов',
                'meta_description' => 'Читайте отзывы о нашей работе выполненной у клиентов',
            );
        }
    }


    /**
     * Отображаем основной шаблон
     */
    public function view() {
        parent::view();

        Core::getSmarty()->assign('pageType', $this->page->pageType);
        Core::getSmarty()->assign('page', $this->page);
        Core::getSmarty()->assign('painTable', self::$painTable);


        $currentPage = Core::toInt($_REQUEST['page']) == 0 ? 1 : Core::toInt($_REQUEST['page']);

        $pain = $this->getPainOfThisPage(Core::getUrl()->action);
        $reviewsParams = array(
            'currentPage' => $currentPage,
            'limit' => $GLOBALS['reviewLimitOnPage'],
            'pain' => !empty($pain) ? $pain->title : false
        );

        if (!$pain) {

            // Если это главная страница
            $countReviews = Reviews::getInstance()->getReviewsAllCount();
            $countReviewsPages = Reviews::getPagesCount($countReviews, $GLOBALS['reviewLimitOnPage']);
        } else {

            // Если это страница Боли
            $countReviews = Reviews::getReviewsCount($reviewsParams);
            $countReviewsPages = Reviews::getPagesCount($countReviews, $GLOBALS['reviewLimitOnPage']);

            // Добавляем cpu боли в ссылку в элементы пагинации
            Core::getSmarty()->assign('painCpu', $pain->name);
        }

        // Если указана явно большая страница, чем страниц отзывов, показываем 404-ю
        if ($currentPage > $countReviewsPages) Page::view404();

        Core::getSmarty()->assign('currentPage', $currentPage);
        Core::getSmarty()->assign('countReviews', $countReviews);
        Core::getSmarty()->assign('countReviewsPages', $countReviewsPages);
        Core::getSmarty()->assign('reviews', Reviews::getReviews($reviewsParams));

        // Скрываем надпись с левого блока "На данной странице еще не оставляли отзывов"
        // так как мы находимся на общей странице отзывов (или ее подразделе)
        Core::getSmarty()->assign('hideLabel__no_reviews', true);

        // В тайтле важно указать страницу
        $metaTitle = Reviews::getCurrentPage() > 1 ? $this->page->meta_title . ' | Страница ' . Reviews::getCurrentPage() : $this->page->meta_title;
        Core::getSmarty()->assign('metaTitle', $metaTitle);
        Core::getSmarty()->assign('metaDescription', $this->page->meta_description);
        Core::getSmarty()->assign('metaKeywords', $this->page->meta_keywords);

        Core::getSmarty()->display('reviewsPage.tpl');
    }
}