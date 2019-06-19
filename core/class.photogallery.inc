<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-29
 * Time: 21:16
 */


class Photogallery {
    /**
     * Возвращает массив из изображений, поделенный на чанки по 4 изображения
     * @param $galleryCategory
     * @return array
     */
    public static function getImages($galleryCategory) {
        $images = Database::query('
            SELECT 
                my_works.id,
                my_works.name as names_work,
                my_works_images.small_img,
                my_works_images.big_img,
                my_works_images.name as name,
                my_works_images.id,
                my_works_images.general
            FROM 
                my_works
            INNER JOIN my_works_images ON
                my_works_images.module_item_id = my_works.id
            WHERE
                my_works.category_id = ' . $galleryCategory . '
            ORDER BY
                my_works_images.id,
                my_works_images.general DESC
        ', 'withCount');

        if ($images->rowCount > 0) {
            return array_chunk($images->result, 4);
        }
        return array();
    }
}