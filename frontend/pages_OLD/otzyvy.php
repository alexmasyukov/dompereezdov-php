<?php
include_once $root . '/frontend/modules/breadcrumb/view_breadcrumb.php';
?>
<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="bg_white">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $breadcrumb; ?>
                        <h1><?php echo $feedback_h1; ?></h1>
                        <?php if ($action == '') { ?>
                            <div class="bl text text-top">


                                <p>Отзывы клиентов — самая важная оценка нашей работы.</p>
                                <p>
                                    Выполнение таких ответственных работ как перевозка дорогой мебели и бытовой техники,
                                    перевозка пианино и роялей, а также другой такелаж требует подбора ответственного,
                                    профессионального исполнителя с большим опытом работы. В подтверждение высокой
                                    репутации компании «ДомПереездов», мы публикуем здесь отзывы реальных людей и фирм,
                                    доверивших нам перевозку и такелаж.
                                </p>
                                <p> Мы не занимаемся подделкой отзывов! Наши заказчики пишут отзывы через <span class="add_feedback">специальную
                                    защищённую форму</span> на сайте, после чего мы их публикуем. Все отзывы содержат реальные
                                    данные и точную информацию. Думаем, вам будет любопытно узнать мнения людей, которые
                                    уже заказывали у нас услуги грузоперевозки, переезда или такелажные работы.
                                </p>
                                <p> Став нашим клиентом, заполните и вы анкету с отзывом!</p>

                                <p>Для нас важен каждый отзыв - это показатель уровня нашей работы и справедливая оценка
                                    заказчиков.</p>

                                <p>Количество отзывов - <?php echo $feedback_count; ?></p>
                            </div>
                        <?php } ?>

                        <?php if ($action != '') { ?>
                        <div class="bl pohojie_uslugi">
                            <?php } ?>
                            <ul class="bl uslugi-ul">
                                <li><a href="/otzyvy/akkuratnost-i-materialnaya-otvetstvennost/">Аккуратность и
                                        материальная ответственность</a></li>
                                <li><a href="/otzyvy/vezhlivost/">Вежливость</a></li>
                                <li><a href="/otzyvy/individualnyy-podhod/">Индивидуальный подход</a></li>
                                <li><a href="/otzyvy/nedorogie-ceny/">Недорогие цены</a></li>
                                <li><a href="/otzyvy/operativnost-i-punktualnost/">Оперативность и пунктуальность</a>
                                </li>
                            </ul>
                            <?php if ($action != '') { ?>
                        </div>
                    <?php } ?>

                        <?php
                        $pagination_show = 'true';
                        require $root . '/frontend/modules/feedback/view_feedback.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="aside1">
            <?php
            include_once($root . "/frontend/pages/blocks/left.php");
            ?>
        </div>
    </div>
</div>

