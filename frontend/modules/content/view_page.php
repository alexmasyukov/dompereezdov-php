<?php
//$sql = "SELECT
//            *
//        FROM
//            content
//        WHERE
//            id = $page_id
//        ";
//$smf = $db->query($sql);
//if ($smf->rowCount() > 0) {
//    $page = array();
//    foreach ($smf->fetchAll(PDO::FETCH_ASSOC) as $value) {
//        $page['title'] = trim(html_entity_decode(htmlspecialchars_decode($value['title']), ENT_QUOTES, 'UTF-8'));
//        $page['text'] = trim(html_entity_decode(htmlspecialchars_decode($value['description']), ENT_QUOTES, 'UTF-8'));
//    }
//} else {
//    view_404();
//}
//