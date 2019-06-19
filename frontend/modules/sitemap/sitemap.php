<?php
include_once $root.'/frontend/wigets/broadcumb/get_broadcumb.php';
// Считываем последнюю новость
// Создаём экземпляр класса управления шаблонами:
// Инициализируем переменные для шаблона:
$sitemap = '';
$sitemap = $db->query('SELECT id, parent_id, name, link FROM menu WHERE public=1 ORDER BY sort');
if ($sitemap->rowCount() == 0) {
    echo " Карта пуста...";
} else {
    unset($rs); // Офищаем массив от задвоения
    
    $rs[] = array();
    while ($row_si = $sitemap->fetch(PDO::FETCH_ASSOC)) {   //fetch(PDO::FETCH_ASSOC)
        $rs[] = $row_si;
    }
    
//    echo '<pre>';
//    print_r($rs);
//    
    $rs_sitemap = array();

    $row_new = '';
    foreach ($rs as $row_new) {
        $rs_sitemap[$row_new['parent_id']][] = $row_new;
    }

    //echo $rs_sitemap[0][0]['id'];
//    
//    echo '<pre>';
//    print_r($rs_sitemap[0]);
    
    function sitemap(&$rs, $parent, $parent_number) {
        $parent_number++;
        $out = array();

        if (!isset($rs[$parent])) {
            return $out;
        }

        foreach ($rs[$parent] as $row) {
            $chidls = sitemap($rs, $row['id'], $parent_number);

            if ($parent_number >= 1) {
                $parent_class = '';
            } else {
                $parent_class = '  ';
            }
            
            if ($parent_number == 0) {
                $ad_calss = " parent";
                $ad_attr = ' '; // data-toggle="dropdown" 
                $caret = '<b class="caret"></b>';
            } else {
                $ad_calss = '';
                $ad_attr = '';
                $caret = '';
            }

            if ($chidls) {
                $row['childs'] = $chidls;
                $chd = ' <ul > ' . $chidls . ' </ul></li>'; //Чтобы категории изначально ЗАКРЫТЫ добавить style="display: none;"
            } else {
                $chd = '</li>';
                $parent_class = '  ';
                $ad_attr = '';
                $caret = '';
            }

            if ($row['link'] != 'none') {
                $link_db =  htmlspecialchars_decode($row['link']);
                $link_db = str_replace("&amp;amp;", "&amp;", $link_db);
                $link = 'href="' . $link_db.'"';
            } else {
                $link = '';
            }

            $text = html_entity_decode(htmlspecialchars_decode($row['name']), ENT_QUOTES, 'UTF-8') ;
            $text = str_replace('ё', 'е', $text);
            $str .= '<li class=" ' . $parent_class . $ad_calss . '" ' . $ad_attr . '><a '.$link.'>' .$text. '</a>' // .$caret
                    . $chd;
            $out[] = $row;
        }
        //return $out;
        return $str;
    }

    $master_all = '<div class="sitemap"><ul>'.sitemap($rs_sitemap, 0, -1).'</ul></div>';
}
?>

 <div class="page_content">
    <div class="b-pages-nav"><?php echo get_breadcumb(''); ?></div>
    <h2 class="b-page-title"><?php echo $breadcumb_page_name; ?></h2>
    <?php if ($master_all == '') { echo '<i>Нет материалов</i>';} else {echo $master_all;}; ?>
</div>