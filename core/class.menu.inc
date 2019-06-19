<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-05-25
 * Time: 17:55
 */


class Menu {
    private static $_category_arr = array();
    private static $_category_names = array();

    /**
     * Получаем основное верхнее меню
     * @return array
     */
    public static function getGeneralMenu() {
        $menuFiltered = array();

        $menu = Database::query('
            SELECT 
                name,
                cpu_path
            FROM 
                content 
            WHERE 
                category_id = 0 AND 
                public=1 
            ORDER BY 
                id
        ');

        foreach ($menu as $menuItem) {
            if (strtolower($menuItem['name']) != 'services') {
                if ($menuItem['name'] == 'cars') {
                    $menuItem['name'] = 'Автопарк';
                }

                $menuFiltered[] = (object)array(
                    'name' => Core::charsDecode($menuItem['name']),
                    'link' => $menuItem['cpu_path'],
                );
            }
        }


        return $menuFiltered;
    }


    /**
     * Получаем элементы выпадающего меню Московская область
     */
    public static function getMenuMoskovskayaOblast() {
        self::getAllPages();
        return self::outTree(1, 0);

    }


    /**
     * Получаем элементы выпадающего меню Москва
     */
    public static function getMenuMoskva() {
        return self::outTree(10000, 1);

    }

    private static function getAllPages() {
        $sql = 'SELECT 
                    id, 
                    parent_id, 
                    name,
                    cpu_path, 
                    type,
                    page_type
                FROM 
                    pages
                WHERE 
                    public = 1
                ORDER BY 
                    type, 
                    name ';
        $addit_array = Database::query($sql);

        $return = array();
        $category_names = array();
        foreach ($addit_array as $value) { //Обходим массив
            $value = (object)$value;
            $return[$value->parent_id][] = $value;
            $category_names[$value->id] = $value;
        }

//                Core::log($return);

        self::$_category_arr = $return;
        self::$_category_names = $category_names;
    }


    public static function get_url($id) {
        $r = '';
        //return $this->_category_names[$id]->name;
        if (self::$_category_names[$id]->parent_id != 0) {
            $r = self::get_url(self::$_category_names[$id]->parent_id);
            $r .= self::$_category_names[$id]->cpu . '/';
            return $r;
        } else {
            return 'http://' . $_SERVER['HTTP_HOST'] . '/' . self::$_category_names[$id]->cpu . '/';
        }
    }


    public static function outTree($parent_id, $level) {
        global $category_id;
        $r = '';
        if (isset(self::$_category_arr[$parent_id])) { //Если категория с таким parent_id существует
            foreach (self::$_category_arr[$parent_id] as $value) { //Обходим ее
                $level++; //Увеличиваем уровень вложености
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $find_child = self::outTree($value->id, $level);
                $path = $value->cpu_path;

                if ($find_child != '') {

                    if (Core::getUrl()->uriParts[$level - 1] == $value->cpu) { #Если cpu у категорий совпадают - делаем ее открытой
                        $class = "open";
                        $str_text = '-';
                        $str_class = 'active';
                    } else {
                        $class = "";
                        $str_text = '+';
                        $str_class = '';
                    }


                    $value_name = $value->name;
                    if (strpos($value_name, "       ") !== false || $value_name == 'services') {
                        continue;
                    }

                    if ($value->type == 'район') {
                        $value_name .= ' ';
                    }
                    if ($value->type == 'округ') {
                        $value_name .= ' АО';
                    }
                    if ($value->type == 'поселение') {
                        $value_name .= ' поселение';
                    }

                    if ($level <= 2) {
                        $r .= "<li class=\"$class\"><a class=\"$str_class\" href=\"$path\" data-id=\"$value->id\">" . $value_name . " </a>" . '<ul>' . $find_child . '</ul></li>'; //." (".$value->count." - ".$value->id.")" <span class=\"id\">" . $value->id . "</span>
                    }

                } else {
                    if ($value->id == $category_id) { #$category_id из файла построения дерева категорий
                        $class = "active";
                        //                        $category_name = $value->name;
                    } else {
                        $class = "";
                    }


                    $value_name = $value->name;
//                    Core::log($value);
                    if (strpos($value_name, "       ") !== false || $value_name == 'services' ||
                        $value->page_type == 'service') {
                        continue;
                    }
                    if ($value->type == 'район') {
                        $value_name .= ' район';
                    }
                    if ($value->type == 'поселение') {
                        $value_name .= ' поселение';
                    }
                    if ($value->type == 'округ') {
                        $value_name .= ' АО';
                    }

                    if ($level <= 2) {
                        $r .= "<li><a class=\"$class\" href=\"$path\" data-id=\"$value->id\">" . $value_name . "</a></li>" . $find_child; //." (".$value->count." - ".$value->id.")" <span class=\"id\">" . $value->id . "</span>
                    }
                }
                $level--; //Уменьшаем уровень вложености
            }
            return $r;
        }
    }
}