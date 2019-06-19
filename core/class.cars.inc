<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-27
 * Time: 16:51
 */

class Cars {
    /**
     * Получаем автомобили
     * @param bool $withoutCarID
     * @return array|mixed
     */
    public static function getCars($withoutCarID = false) {
        $preparedFeaturesData = array();

        $carsFeaturesData = Database::query('
            SELECT 
                cars.id AS product_id,
                cars_features_values.value AS feature_value,
                cars_features.title AS feature_title,
                cars_features.in_maket AS in_maket,
                cars_features.prefix AS prefix,
                cars_features_values.row AS row_number,
                cars_features_values.sort
             FROM 
                cars
             INNER JOIN cars_features_values ON 
                cars_features_values.module_item_id = cars.id
             INNER JOIN cars_features ON 
                cars_features.id = cars_features_values.features_id
             WHERE
                cars.public=1
        ', 'withCount');
        if ($carsFeaturesData->rowCount > 0) {
            # Приводим массив к виду (Все эти столбцы должны быть отсортированы в SQL заранее !!! )
            /*

            product_id ---- | features_row ---   | - in_maket
                            |                    | - Цена
                            |                    | - Количество
                            |
                            | features_row ---   | - in_maket
                            |                    | - Цена
                            |                    | - Количество
                            |
                            | features_row ---   | - in_maket
                            |                    | - Цена
                            |                    | - Количество

            product_id ---- | features_row ---   | - in_maket
                            |                    | - Цена
                            |                    | - Количество
                            |
                            | features_row ---   | - in_maket
                            |                    | - Цена
                            |                    | - Количество
                            |
                            | features_row ---   | - in_maket
                            |                    | - Цена
                            |                    | - Количество
            */

            $old_product_id = 0;
            foreach ($carsFeaturesData->result as $row) {
                if ($old_product_id == $row['product_id']) {
                    $preparedFeaturesData[$row['product_id']][][] = $row;
                } else {
                    $preparedFeaturesData[$row['product_id']][] = array($row);
                    $old_product_id = $row['product_id'];
                }
            }
        }

        // Применяется для исключения отображения автомобиля
        // в таблице автомобилей, находясь на странице этого автомобиля
        // (Зачем дублировать, если мы на его странице?)
        $notShowCarID = '';
        if ($withoutCarID) {
            $notShowCarID = " AND cars.id <> $withoutCarID ";
            $limit = ' LIMIT 6';
        } else {
            $limit = '';
        }


        $cars = Database::query('
            SELECT 
               *
            FROM 
                cars
            WHERE
                cars.public=1 
                ' . $notShowCarID . '
            ORDER BY 
                cars.id
            ' . $limit);


        foreach ($cars as &$car) {
            $car = (object)$car;
            $images = self::getCarImages($car->id);
            $car->small_img = $images[0];
            $car->big_img = $images[1];
            $car->name = get_UTF8_text(trim($car->name));

            //        echo $master->content["small_img"].' '.$cars_images_matrix[$number_car].' id-'.$product_id.'<br/>';

            # Генерируем таблицу с характеристиками автомобиля
            $car->attributes = array();
            foreach ($preparedFeaturesData[$car->id] as $features) {
                foreach ($features as $feature) {
                    $prefix = '';
                    if ($feature['feature_value'] == 'Бесплатно' || $feature['feature_value'] == 'бесплатно') {
                        $prefix = '';
                    } else {
                        $feature['prefix'] = str_replace('м3', 'м<sup>3</sup>', $feature['prefix']);
                        $prefix = ' <span>' . $feature['prefix'] . '</span>';
                    }

                    $car->attributes[$feature['feature_title']] = (object)array(
                        'title' => $feature['feature_title'],
                        'value' => $feature['feature_value'] . $prefix,
                        'intValue' => str_replace([' ', ',00', ',0'], '', $feature['feature_value'])
                    );
                }
            }
        }

        return $cars;
    }


    /**
     * Возвращает массив из автомобилей с нужными характеристиками
     * для построение option внутри select выбора машины на Яндекс карте
     * на страницах услуг для расчета стоимости перевозки/услуги
     *
     * Используется в core/class.pageMskServices.inc +
     * templates/_mskServicesPage__map.tpl
     */
    public static function getCarsJsonForYandexMap() {
        $cars = Cars::getCars();
        foreach ($cars as $key => &$car) {
            $car->title = $car->name . ' (Грузоподъёмность ' . $car->attributes['Грузоподъёмность']->value . ')';
            $car->minimumCost = $car->attributes['Цена']->intValue;
            $car->tarif = $car->attributes['Выезд за город']->intValue;
        }
        return $cars;
    }


    /**
     * Используется для страницы автомобиля
     *
     * Получает основной автомобиль и все остальные (исключая основной) для таблицы
     * @param $cpuPath
     * @return object
     */
    public static function getGeneralAndOther($cpuPath) {
        $result = (object)array(
            'generalCar' => (object)array(),
            'otherCars' => array()
        );

        $cars = self::getCars();

        foreach ($cars as $car) {
            if ($car->cpu_path == trim($cpuPath)) {
                $result->generalCar = $car;
            } else {
                $result->otherCars[] = $car;
            }
        }

        return $result;
    }


    /**
     * Получаем изображения для автомобиля
     * @param $carID
     * @return array
     */
    private static function getCarImages($carID) {
        $images = Database::query("
                SELECT 
                    cars_images.small_img AS small_img,
                    cars_images.big_img AS big_img
                FROM 
                    cars_images
                WHERE
                    module_item_id = $carID
                ORDER BY
                    general DESC
            ");

        foreach ($images as $image) {
            return ['/sync/' . $image['small_img'], '/sync/' . $image['big_img']];
        }
    }
}


