<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="MobileOptimized" content="320">
    <meta name="HandheldFriendly" content="True">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="57x57" href="/frontend/template/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/frontend/template/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/frontend/template/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/frontend/template/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/frontend/template/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/frontend/template/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/frontend/template/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/frontend/template/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/frontend/template/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/frontend/template/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/frontend/template/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/frontend/template/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/frontend/template/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/frontend/template/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#000">
    <meta name="msapplication-TileImage" content="/frontend/template/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#000">
    <link rel="shortcut icon" href="/favicon.ico">

    {if $canonical}
        <link rel="canonical" href="{$canonical}"/>
    {/if}

    <title>{$metaTitle}</title>
    <meta name="description" content="{$metaDescription}"/>
    <meta name="keywords" content="{$metaKeywords}"/>
    <meta property="og:locale" content="ru_RU"/>
    <meta property="og:title" content="{$metaTitle}"/>
    <meta property="og:description" content="{$metaDescription}"/>
    <meta property="og:image" content="https://{$HTTP_HOST}/frontend/template/images/logo-social-min.png"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://{$HTTP_HOST}{$REQUEST_URI}"/>

    <meta name='wmail-verification' content='a796c46b5b63d653ab65e39615833d18'/>
    <meta name="msvalidate.01" content="54DEBF8186036894BED2A0919DAB6ADF"/>
    <meta name="google-site-verification" content="g7qXM_DQaQrppibLkQi7YneVJemgrJEhhT-K4aFetNA"/>
    <meta name="yandex-verification" content="5c7f144bc327a8bb"/>


    <link href='/frontend/template/css/libs.min.css?v=17' rel='stylesheet' type='text/css'>
    <link href='/frontend/template/css/main.min.css?v=20' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>


<style>
    nav {
        display: block;
    }

    .menu {
        /*display: block;*/
    }

    .menu li {
        display: inline-block;
        position: relative;
        z-index: 7;
    }

    .menu li:first-child {
        margin-left: 0;
    }

    .menu li a {
        text-transform: uppercase;
        text-decoration: none;
        padding: 13px 13px;
        display: block;
        color: #ffffff;

        -webkit-transition: all 0.2s ease-in-out 0s;
        -moz-transition: all 0.2s ease-in-out 0s;
        -o-transition: all 0.2s ease-in-out 0s;
        -ms-transition: all 0.2s ease-in-out 0s;
        transition: all 0.2s ease-in-out 0s;
    }

    .menu li a:hover, .menu li:hover > a {
        color: #ffffff;
        background: #0C9CD0;
    }

    .menu ul {
        display: none;
        margin: 0;
        padding: 0;
        width: 200px;
        position: absolute;
        /*top: 45px;*/
        left: 0px;
        background: #ffffff;
    }

    .menu ul li {
        display: block;
        float: none;
        background: none;
        margin: 0;
        padding: 0;
    }

    .menu ul li a {
        font-size: 12px;
        font-weight: normal;
        display: block;
        color: #797979;
        border-left: 3px solid #ffffff;
        background: #ffffff;
    }

    .menu ul li a:hover, .menu ul li:hover > a {
        background: #f0f0f0;
        border-left: 3px solid #0C9CD0;
        color: #0C9CD0;
    }

    .menu li:hover > ul {
        display: block;
    }

    .menu ul ul {

        left: 200px;
        top: 0px;
    }

    .menu ul li a {
        color: #DEDEDE;
        background: #333 !important;
        border-bottom: 1px solid #525252;
        font-size: 11px;
    }

    .menu ul li a:hover {
        background: #000;
    }

    .mobile-menu {
        display: none;
        width: 100%;
        /*background: #3E4156;*/
        color: #ffffff;
        text-transform: uppercase;
        font-weight: 600;
        padding: 0px;
        margin: 0px;
    }

    @media (min-width: 768px) and (max-width: 979px) {

        .mainWrap {
            width: 768px;
        }

        .menu ul {
            top: 37px;
        }

        .menu li a {
            font-size: 12px;
            padding: 8px;
        }
    }

    @media (max-width: 767px) {
        .mainWrap {
            width: auto;
            padding: 50px 20px;
        }

        .menu {
            display: none;
        }

        .mobile-menu {
            display: block;
            position: absolute;
            right: 0;
            width: 72px;
            top: 10px;
            z-index: 999;
        }

        nav {
            margin: 0;
            background: none;
        }

        .menu li {
            display: block;
            margin: 0;
        }

        .menu li a {
            background: #333;
            color: #c6e7f4;
            border-top: 1px solid #444;
            border-left: 3px solid #666;
        }

        .menu li a:hover, .menu li:hover > a {
            color: #fff;
            border-left: 3px solid #0194ca;
        }

        .menu ul {
            display: block;
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
        }

        .menu ul ul {
            left: 0;
        }

    }

    @media (max-width: 480px) {

    }

    @media (max-width: 320px) {
    }

    .cars .car table td:first-child,
    .cars .car table tr:first-child td {
        font-size: 14px;
    }

    .cars .car table td:last-of-type {
        font-size: 14px !important;
    }

    .feedback .polosa {
        display: block;
    }
</style>

<style>
    .id {
        padding-left: 10px;
        padding-right: 10px;
        text-decoration: none !important;
    }
</style>

<header>
    <div id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                    <a href="/">
                        <img class="img-responsive" src="/frontend/template/images/logo.png" alt=""/>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 tar">
                    <div class="phones">
                        <a class="phone" href="tel:{$phoneOneNumber}">
                            {$phoneOneText}
                        </a>
                        <a class="phone last_phone" href="tel:{$phoneTwoNumber}">
                            {$phoneTwoText}
                        </a>
                        <a id="touch-menu" class="mobile-menu" onclick="myFunction(this)" href="#">
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="menu">
        <div class="container">
            <nav>
                <ul class="menu">
                    <li class="active">
                        <a href="https://{$HTTP_HOST}/">Главная</a>
                    </li>
                    {foreach $generalMenu as $item}
                        <li><a href="https://{$HTTP_HOST}{$item->link}">{$item->name}</a></li>
                    {/foreach}
                    <li>
                        <a href="https://{$HTTP_HOST}/otzyvy/">Отзывы</a>
                    </li>
                    <li>
                        <a href="https://{$HTTP_HOST}/moskva/">Москва</a>
                        <ul class="sub-menu">
                            {$subMenuMoskva}
                        </ul>
                    </li>
                    <li>
                        <a href="https://{$HTTP_HOST}/moskovskaya-oblast/">Московская область</a>
                        <ul class="sub-menu">
                            {$subMenuMoskovskayaOblast}
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
