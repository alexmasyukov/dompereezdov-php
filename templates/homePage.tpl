{include '_header.tpl'}

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


<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="bg_white">
                <div class="row">
                    <div class="col-md-12">
                        {$breadcrumb}

                        <h1>{$page->title}</h1>

                        <div class="bl text text-top">
                            {$page->text}
                        </div>

                        <div class="cleafix"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="aside1">
            {include '_left_block_of_page.tpl'}
        </div>
    </div>
</div>



{include '_order_form.tpl'}


{include '_footer.tpl'}