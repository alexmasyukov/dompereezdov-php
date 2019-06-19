<?php
header("Content-Type: text/xml; charset=utf-8");
//header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate");

header("Expires: " . date("r"));
header("Cache-Control: 0");

include_once($root . '/frontend/modules/rss/price_table.php');
?>
<rss xmlns:yandex="http://news.yandex.ru"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:turbo="http://turbo.yandex.ru"
     version="2.0">
    <channel>
        <?php
        $names_array = [];


        function replaceText($text) {
            $top_text = trim(html_entity_decode(htmlspecialchars_decode(nl2br($text)), ENT_QUOTES, 'UTF-8'));
            $top_text = mb_str_replace('сотни отзывов реальных клиентов', '<b><a href="https://www.dompereezdov.ru/otzyvy/">сотни отзывов реальных клиентов</a></b>', $top_text);
            $top_text = mb_str_replace('сотни отзывов реальных заказчиков', '<b><a href="https://www.dompereezdov.ru/otzyvy/">сотни отзывов реальных заказчиков</a></b>', $top_text);
            $top_text = mb_str_replace('рассказали в отзывах', '<b><a href="https://www.dompereezdov.ru/otzyvy/">рассказали в отзывах</a></b>', $top_text);
            return $top_text;
        }


        function similar_uslugi($page_parent_id, $url_path) {
            global $db, $names_array;
            # $name_p_pr из файла read_url_of_catalog_category.php
            $all_uslugi = '';
            $sql = "
                SELECT 
                    name,
                    cpu_path
                FROM 
                    pages 
                WHERE 
                    parent_id = $page_parent_id 
                    AND p_ro IS NULL
                    AND public = 1
            ";
            $smf = $db->query($sql);
            if ($smf->rowCount() > 0) {
                foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
                    # Если это не текущая страница и не вакансия - то добавляем в список
                    if ($url_path != $value['cpu_path'] && strpos($value['name'], 'Требуются') === false) {
                        $usluga = mb_ucfirst(str_replace([' ', ' '], ' ', $value['name'])) . ' в ' . $names_array[$page_parent_id];
                        $all_uslugi .= '<li><a href="' . $value['cpu_path'] . '" alt="">' . $usluga . '</a></li>';
                    }
                }
            }
            if ($all_uslugi != '') {
                return '<h3>Похожие услуги</h3>
                <ul class="uslugi-ul">' . $all_uslugi . '</ul>';
            } else {
                return '';
            }
        }


        function price($cpu_path) {
            global $price_table;

            $price_presult = '<h2>Цены на грузоперевозки</h2>';
            $price_presult .= $price_table;
            $price_presult .= '<a href="https://www.dompereezdov.ru' . $cpu_path . '">Смотреть все цены и машины</a>';

            return $price_presult;
        }


        $sql = "
            SELECT
                pages.id AS pageId,
                pages.cpu_path,
                pages.cpu,
                pages_texts.top_text,
                pages.h1,
                pages.type,
                pages.parent_id,
                pages.p_pr
            FROM 
                pages
            LEFT JOIN pages_texts ON
                pages_texts.page_id = pages.id
            WHERE
                pages.public = 1
            LIMIT 30
            ";
        $smf = $db->query($sql);
        if ($smf->rowCount() > 0) {
            $array = $smf->fetchAll(PDO::FETCH_OBJ);
            foreach ($array as $page) {
                $names_array[$page->pageId] = $page->p_pr;


                ?>
                <item turbo="true">
                    <link>
                    https://www.dompereezdov.ru<?php echo $page->cpu_path ?></link>
                    <turbo:content>
                        <![CDATA[
                        <header>
                            <h1><?php echo $page->h1 ?></h1>
                        </header>
                        <p><?php echo replaceText($page->top_text); ?></p>

                        <?php
                        if ($page->p_pr == null && $page->cpu != 'rabota-voditelem' && $page->cpu != 'rabota-gruzchikom') {
                            echo price($page->cpu_path) . '<br><br>';
                        };
                        ?>

                        <?php echo similar_uslugi($page->parent_id, $page->cpu_path); ?>

                        <h2>Звоните:</h2>
                        <p><big>+7 (495) 978-78-09</big></p>
                        <p><big>+7 (926) 803-35-30</big></p>
                        ]]>
                    </turbo:content>
                </item>
                <?php
            }
        }
        ?>
    </channel>
</rss>