<div id="top_image">
    <div class="container">
        <p>Недорогие <br>
            транспортные услуги<br> и
            услуги грузчиков <br>
            в Москве и Московской<br> области</p>
    </div>
</div>
<div id="navigation_blocks">
    <div>
        <a href="/otzyvy/akkuratnost-i-materialnaya-otvetstvennost/">Аккуратность <br>и ответственность</a>
        <p>Наши грузчики и водители бережно относятся к вещам и несут полную материальную ответственность</p>
    </div>
    <div>
        <a href="/otzyvy/vezhlivost/" class="pt">Вежливость</a>
        <p>Наши сотрудники культурные, вежливые люди, приятные в общении, не смотря на все стереотипы о грузчиках</p>
    </div>
    <div>
        <a href="/otzyvy/operativnost-i-punktualnost/">Пунктуальность <br> и оперативность</a>
        <p>Бригады приезжают на заказы заранее, грузчики работают без проволочек, экономя деньги клиентов</p>
    </div>
    <div>
        <a href="/otzyvy/nedorogie-ceny/" class="pt">Низкие цены</a>
        <p>Минимальные цены обеспечены отличной оптимизацией и большим потоком заказов</p>
    </div>
    <div>
        <a href="/otzyvy/individualnyy-podhod/">Индивидуальный <br> подход</a>
        <p>Имеем отработанные решения, но при этом всегда идём на встречу заказчику, выполняя его пожелания</p>
    </div>
    <div class="clearfix"></div>
</div>


<?php
$page_id = 18;
include_once $root . '/frontend/modules/content/view_page.php';
?>


<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="bg_white">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $breadcrumb; ?>

                        <h1><?php echo $page['title']; ?></h1>

                        <div class="bl text text-top">
                            <?php
                                include_once $root . "/frontend/modules/homeblocks/view_homeblocks.php";
                                $page['text'] = str_replace('#блок1#', '<div class="row">'.$homeblocks[0][0].$homeblocks[0][1].'</div><div class="cleafix"></div>', $page['text']);
                                $page['text'] = str_replace('#блок2#', '<div class="row">'.$homeblocks[1][0].$homeblocks[1][1].'</div><div class="cleafix"></div>', $page['text']);
                                $page['text'] = str_replace('#блок3#', '<div class="row">'.$homeblocks[2][0].$homeblocks[2][1].'</div><div class="cleafix"></div>', $page['text']);
                                echo $page['text'];
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="aside1">
            <?php
            # Настройки для отзывов
            $page_type = 'moscow';
            $page_id = 1233;
            $feedback_usluga = 'Грузоперевозки';
            include_once($root . "/frontend/pages/blocks/left.php");
            ?>
        </div>
    </div>
</div>





<div class="modal fade" id="zakaz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="bg_content"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Оформить заказ</h4>
            </div>
            <div class="modal-body" data-type="onlineform"
                 data-result-text="Оставайтесь на связи, мы перезвоним Вам!">
                <span data-type="form-type" data-name="Новая онлайн заявка"></span>
                <span data-type="site" data-name="Дом Переездов"></span>
                <span id="form_name" data-type="form-text" data-name="Название формы ** Заказать услугу"></span>
                <span data-type="form-text"
                      data-name="Где находится ** Главная страница - блоки с услугами"></span>

                <p>Оставьте заявку на <b>бесплатный</b> обратный звонок, и ожидайте звонка оператора</p>

                <input
                        value=""
                        autocomplete="off"
                        data-necessarily="yes"
                        data-type="form-val"
                        data-id="name_sms"
                        data-name="Имя клиента"
                        class="input partext"
                        id="client_name"
                        placeholder="Ваше имя"
                        type="text" />

                <input
                        value=""
                        autocomplete="off"
                        data-necessarily="yes"
                        data-type="form-val"
                        data-id="phone_sms"
                        data-name="Телефон"
                        class="input partext phone_mask"
                        placeholder="+7 (___) ___-____"
                        id="client_phone"
                        type="text" />

                <div class="modal-footer">
                    <button type="button" class="btn sender">Заказать</button>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
