{include '_header.tpl'}

<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="bg_white">
                <div class="row">
                    <div class="col-md-12">
                        {$breadcrumb}

                        <h1>{$page->h1}</h1>

                        {if $pageType eq 'allReviews'}
                            {include '_reviewsPage__all_reviews_page.tpl'}
                        {/if}

                        {if $pageType eq 'painReviews'}
                            {include '_reviewsPage__pain_page.tpl'}
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