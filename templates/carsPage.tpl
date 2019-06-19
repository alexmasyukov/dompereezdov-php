{include '_header.tpl'}


{* todo: здесь верстка косячит, жирный шрифт у таблицы *}
<div class="container all_catalog">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 page page_content">
            <div class="bg_white">
                <div class="row">
                    <div class="col-md-12">
                        {$breadcrumb}

                        {if $pageType eq 'allCars'}
                            <h1>{$page->h1}</h1>
                            {include '_carsPage__all_cars_page.tpl'}
                        {/if}

                        {if $pageType eq 'car'}
                            {include '_carsPage__one_car_page.tpl'}
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


<style>
    .left {
        text-align: center;
        width: 30%;
        border: 10px solid #fff !important;
        border-left: 0px solid #fff !important;
        background: #EBEBEB !important;

    }

    .right {
        background: #F2FDFF !important;
        border: 10px solid #fff !important;
        font-weight: 600;
        font-family: "Open Sans Bold";
    }

    .right span {
        font-family: 'Open Sans';
        font-weight: 400 !important
    }
</style>


{include '_footer.tpl'}