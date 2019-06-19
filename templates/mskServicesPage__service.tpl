{include '_header.tpl'}

<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="bg_white">
                <div class="row">
                    <div class="col-md-12">
                        {$breadcrumb}

                        <h1>{$page->h1}</h1>

                        <div class="bl text text-top">
                            {$page->top_text}
                        </div>

                        <div class="bl cars">
                            <h2>Цены на грузоперевозки</h2>
                            {include '_carsPage__all_cars_page.tpl'}
                        </div>

                        {if $photogallery}
                            {include '_mskServicePage__photogallery.tpl'}
                        {/if}

                        {if $similarServices}
                            <div class="bl similar-uslugi pohojie_uslugi">
                                <h3>Похожие услуги</h3>
                                <div class="bl uslugi-list">
                                    <ul class="uslugi-ul">
                                        {foreach $similarServices as $service}
                                            {* Исключаем в списке услуг текущую услугу (мы итак на ее странице,
                                            зачем показывать ее в списке *}
                                            {if $service->cpu_path neq $page->cpu_path}
                                                <li>
                                                    <a href="{$service->link}">{$service->title} в {$page->p_pr}</a>
                                                </li>
                                            {/if}
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                        {/if}

                        {* todo: здесь должен быть список из родительских нас пунктов с их ссылками
                                    Московская область
                                    Балашиха
                                    breadcrumb?
                         *}

                        <div class="bl text text-bottom">
                            {$page->bottom_text}
                        </div>

                        {if $page->cpu != 'vyvoz-mebeli'}
                            {include '_mskServicesPage__map.tpl'}
                        {/if}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="aside1">
            {include '_left_block_of_page.tpl'}
        </div>
    </div>
</div>


{include '_footer.tpl'}