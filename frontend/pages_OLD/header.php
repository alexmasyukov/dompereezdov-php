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
                <span class="phones">
                    <a class="phone" href="tel:+74959787809">
                        <?php echo $organization_phone; ?>495-978-78-09
                    </a>
                    <a class="phone last_phone" href="tel:+79268033530">
                        <?php echo $organization_phone_two; ?>
                    </a>
                    <a id="touch-menu" class="mobile-menu" onclick="myFunction(this)" href="#">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                    </a>
                </span>
                </div>
            </div>
        </div>
    </div>
    <div id="menu">
        <div class="container">
            <nav>
                <ul class="menu">
                    <?php $server = $_SERVER['HTTP_HOST']; ?>
                    <li class="active"><a href="https://<?php echo $server; ?>/">Главная</a></li>
                    <?php
                    require($root . "/frontend/pages/wigets/menu_content_block.php");
                    echo $content_small_blocks_html;
                    ?>
                    <li><a href="https://<?php echo $server; ?>/otzyvy/">Отзывы</a></li>
                    <li><a href="https://<?php echo $server; ?>/moskva/">Москва</a>
                        <?php
                        include_once($root . "/frontend/modules/catalog_v2/read_categories_in_db_and_recurse_one_category.php");  # Всегда подключаем ВТОРЫМ
                        $tree = new TreeOX2();

                        echo '<ul class="sub-menu">' . $tree->outTree(1248, 0, '/') . '</ul>'; //Выводим дерево
                        ?>

                    <li><a href="https://<?php echo $server; ?>/moskovskaya-oblast/">Московская область</a>
                        <?php
                        include_once($root . "/frontend/modules/catalog_v2/read_categories_in_db_and_recurse_one_category.php");  # Всегда подключаем ВТОРЫМ
                        $tree = new TreeOX2();


                        # Для Главной страницы
                        if ($corrent_parent_id == '') {
                            $corrent_parent_id = 0;
                        }
                        echo '<ul class="sub-menu">' . $tree->outTree(1, 0, '/') . '</ul>'; //Выводим дерево
                        ?>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

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
        padding: 13px 14px;
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
</style>