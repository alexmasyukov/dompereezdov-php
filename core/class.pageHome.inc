<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-25
 * Time: 19:33
 */

class PageHome extends Page {
    /**
     * PageIndex constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Получаем изображение для блока
     * @param $id
     * @return mixed
     */
    private static function getHomeBlockImage($id) {
        $sql = "
            SELECT 
                homeblocks_images.small_img AS small_img,
                homeblocks_images.big_img AS big_img
            FROM 
                homeblocks_images
            WHERE
                module_item_id = $id
            ORDER BY
                general DESC
        ";
        $images = Database::query($sql);
        foreach ($images as $image) {
            return str_replace('../../..//images/homeblocks_images/homeblocks/', '', $image['small_img']);
        }
    }

    /**
     * Получаем блоки
     */
    public static function getHomeBlocks() {
        $blocks = array();

        $sql = '
            SELECT 
               *
            FROM 
                homeblocks
            WHERE 
                public=1
            ORDER BY 
                sort 
            ';
        $feedback = Database::query($sql, 'withCount');
        if ($feedback->rowCount > 0) {
            foreach ($feedback->result as $block) {
                Core::getSmarty()->assign('name', $block['name']);
                Core::getSmarty()->assign('description', Core::charsDecode($block['description']));
                Core::getSmarty()->assign('image', self::getHomeBlockImage($block['id']));
                $blocks[] = Core::getSmarty()->fetch('_home_block.tpl');
            }
        }

        return array_chunk($blocks, 2);
    }

    /**
     * Отображаем главную страницу
     */
    public function view() {
        parent::view();

        $page = $this->getPageByID(18);
        if (!$page) Page::view404();

        $page->text = $page->description;
        $homeBlocks = self::getHomeBlocks();
        $page->text = str_replace('#блок1#',
            '<div class="row">'
            . $homeBlocks[0][0]
            . $homeBlocks[0][1]
            . '</div><div class="cleafix"></div>', $page->text);

        $page->text = str_replace('#блок2#',
            '<div class="row">'
            . $homeBlocks[1][0]
            . $homeBlocks[1][1]
            . '</div><div class="cleafix"></div>', $page->text);

        $page->text = str_replace('#блок3#',
            '<div class="row">'
            . $homeBlocks[2][0]
            . $homeBlocks[2][1]
            . '</div><div class="cleafix"></div>', $page->text);

        // Формируем отзывы слева
        $this->buildReviewsOnLeftBlock();

        // Не нужно показывать хлебные крошки на главной странице
        Core::getSmarty()->assign('breadcrumb', '');

        Core::getSmarty()->assign('metaTitle', $page->meta_title);
        Core::getSmarty()->assign('metaDescription', $page->meta_description);
        Core::getSmarty()->assign('metaKeywords', $page->meta_keywords);

        Core::getSmarty()->assign('page', $page);
        Core::getSmarty()->display('homePage.tpl');
    }
}