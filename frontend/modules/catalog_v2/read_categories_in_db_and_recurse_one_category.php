<?php


// echo '<pre>';

// print_r($addit_array);

// echo $addit_array[0]['level'];
// echo $addit_array[0]->name;
//
// exit;


// print_r($addit_array[0]);


$uri_parts = explode('/', trim($url_path, '/'));
array_shift($uri_parts);
//print_r($uri_parts);

$open_ul_id = '';
$r = '';

//$category_name = '';

class TreeOX2 {
    private $_db = null;
    private $_category_arr = array();
    private $_category_names = array();

    public function __construct() {
        global $db;
        $sql = "SELECT  id, parent_id, name, cpu, cpu_path, type FROM pages WHERE public = 1 ORDER BY type, name "; //
        $smf = $db->query($sql);
        if ($smf->rowCount() > 0) {
            $addit_array = $smf->fetchAll(PDO::FETCH_OBJ);
        }

        //        print_r($addit_array);
        $return = array();
        $category_names = array();
        foreach ($addit_array as $value) { //Обходим массив
            $return[$value->parent_id][] = $value;
            $category_names[$value->id] = $value;
        }
        $this->_category_arr = $return;
        $this->_category_names = $category_names;

        //
        //        var_dump($addit_array);
        //        exit;
    }


    public function get_url($id) {
        $r = '';
        //return $this->_category_names[$id]->name;
        if ($this->_category_names[$id]->parent_id != 0) {
            $r = $this->get_url($this->_category_names[$id]->parent_id);
            $r .= $this->_category_names[$id]->cpu . '/';
            return $r;
        } else {
            return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $this->_category_names[$id]->cpu . '/';
        }
    }


    public function outTree($parent_id, $level) {
        global $uri_parts;
        global $category_id;
        $r = '';
        if (isset($this->_category_arr[$parent_id])) { //Если категория с таким parent_id существует
            foreach ($this->_category_arr[$parent_id] as $value) { //Обходим ее
                $level++; //Увеличиваем уровень вложености
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $find_child = $this->outTree($value->id, $level);
                $path = $value->cpu_path;

                if ($find_child != '') {

                    if ($uri_parts[$level - 1] == $value->cpu) { #Если cpu у категорий совпадают - делаем ее открытой
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
                    if (strpos($value_name, "       ") !== false || $value_name == 'services') {
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

?>


