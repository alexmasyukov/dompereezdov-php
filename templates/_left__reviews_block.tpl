<div class="left_block">
    <p class="title">Отзывы клиентов</p>
    <div id="add_feedback">Добавить отзыв</div>

    <div class="row">
        {if $reviewsOfLeftBlock}
            {foreach from=$reviewsOfLeftBlock key=k item=$review}
                {include '_review.tpl'}
            {/foreach}
        {else}
            {if !$hideLabel__no_reviews}
                <div class="col-md-12 col-xs-12 feedback">На этой странице еще не оставляли отзывы...<br><br></div>
            {/if}
        {/if}
    </div>

    <a class="link all_feedback" href="/otzyvy/">Читать все отзывы ({$countAllReviews})</a>
</div>
