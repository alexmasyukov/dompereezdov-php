<div class="bl text text-top">
    <p>Количество отзывов - <span style="font-size: 140%;">{$countReviews}</span></p>
</div>
<div class="bl pohojie_uslugi">
    <ul class="bl uslugi-ul">
        {foreach from=$painTable key=k item=$pain}
            <li><a href="https://{$HTTP_HOST}/otzyvy/{$k}/">{$pain}</a></li>
        {/foreach}
    </ul>
</div>

{if $reviews}
    <div class="row">
        {foreach from=$reviews key=k item=$review}
            {include '_review.tpl'}
        {/foreach}
    </div>
{/if}

{include '_reviewsPage__pagination.tpl'}