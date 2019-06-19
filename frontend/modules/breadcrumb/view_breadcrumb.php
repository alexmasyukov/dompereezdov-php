<?php
# Подготавливаем $breadcrumb
$breadcrumb = '<nav class="breadcrumb">
                    <a href="http://' . $server . '/">Главная</a>';

switch ($module) {
    case 'services':
        if ($module == 'services' && $action == '') {
            $breadcrumb .= ' » ' . $page['title'];
        } else {
//        $breadcrumb .= '<a href="/services/">Мы предлагаем</a>';
            $breadcrumb .= ' » ' . $page['title'];
        }
        break;
    case 'otzyvy':
        if ($action == '') {
            $breadcrumb .= ' » Отзывы';
        } else {
            $breadcrumb .= '<a href="/otzyvy/">Отзывы</a>';
            switch ($action) {
                case 'akkuratnost-i-materialnaya-otvetstvennost':
                    $breadcrumb .= ' » Аккуратность и материальная ответственность';
                    break;
                case 'vezhlivost':
                    $breadcrumb .= ' » Вежливость';
                    break;
                case 'individualnyy-podhod':
                    $breadcrumb .= ' » Индивидуальный подход';
                    break;
                case 'nedorogie-ceny':
                    $breadcrumb .= ' » Недорогие цены';
                    break;
                case 'operativnost-i-punktualnost':
                    $breadcrumb .= ' » Оперативность и пунктуальность';
                    break;
            }
        }
        break;
    case 'cars':
        $breadcrumb .=  '<a href="http://' . $server . '/cars/">Машины</a>';
        $breadcrumb .= ' » ' . $page['title'];
        break;
    default:
        # Подготавливаем $breadcrumb
        $breadcrumb = '<nav class="breadcrumb">
                    <a href="http://' . $server . '/">Главная</a>';
        $breadcrumb .= ' » ' . $page['title'];
        break;
}

$breadcrumb .= '</nav>';
?>