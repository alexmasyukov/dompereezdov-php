<div class="bl gallary">
    <h2>{$page->titleGallery}</h2>

    <div id="carousel-cars" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            {foreach from=$photogallery key=$k item=$groupImages}
                <div class="item {if $k eq 0}active{/if}">
                    <div class="row">
                        {foreach $groupImages as $image}
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <a data-fancybox-group="img_gallary" class="fancybox car-img"
                                   href="{$image.big_img}">
                                    <img class="img-responsive" alt="{$image.name}"
                                         src="{$image.small_img}"/>
                                    <span class="car-name">{$image.name}</span>
                                </a>
                            </div>
                        {/foreach}
                    </div>
                </div>
            {/foreach}
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-cars" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-cars" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>