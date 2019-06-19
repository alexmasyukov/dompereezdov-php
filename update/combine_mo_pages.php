<?php
/**
 * Created by PhpStorm.
 * User: Alexey Masyukov  a.masyukov@chita.ru
 * Date: 2019-06-10
 * Time: 14:03
 */

include 'data/pages_array.php';
include 'data/pages_array_MO_for_merge.php';

echo '<pre>';

//print_r($pageMOForMerge[33]);

foreach ($pages as $page) {
    $page = (object)$page;
    $one = mb_strtolower($page->name);


    if ($one[0] != ' '
        && !mb_strpos($one, 'район')
        && !mb_strpos($one, 'область')) {
        echo $one . ' = ';

        foreach ($pagesMOForMerge as $pageForMerge) {
            $pageForMerge = (object)$pageForMerge;
            $two = trim(mb_strtolower($pageForMerge->name));

//            if ($one == 'яхрома') {
//                echo $one .' = '.$two;
//            }
            if ($one == $two) {
                echo $two;
                break;
            }
        }

        echo '<br><br>';
    }
}