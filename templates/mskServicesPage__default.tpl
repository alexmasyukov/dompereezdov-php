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

                        {if $similarServices}
                            <div class="bl uslugi-list">
                                <ul class="uslugi-ul">
                                    {foreach $similarServices as $service}
                                        <li>
                                            <a href="{$service->link}">{$service->title}
                                                {if $service->type neq 'town'}
                                                    в {$page->p_pr}
                                                {/if}
                                            </a>
                                        </li>
                                    {/foreach}
                                </ul>
                            </div>
                        {/if}


                        {include '_mskServicePage__photogallery.tpl'}

                        {include '_mskServicesPage__map.tpl'}
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