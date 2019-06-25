<div class="col-md-12 col-xs-12 feedback">
    <p class="name">
        {$review->name} 

        {if $review->about}
            {if !$review->aboutHide}
                <span class="about">({$review->about})</span>
            {/if}
        {/if}

        {if $review->date}
            {if !$review->dateHide}
                <span class="date">/ {$review->date}</span>
            {/if}
        {/if}
    </p>

    <p class="comment">{$review->comment}</p>

    {if $review->why}
        {if !$review->whyHide}
            <p><span>Почему обратились к нам?:</span> {$review->why}</p>
        {/if}
    {/if}

    {if $review->otkuda}
        {if !$review->otkudaHide}
            <p><span>Откуда о нас узнали:</span> {$review->otkuda}</p>
        {/if}
    {/if}

    {if $review->zakazannaya_usluga}
        {if !$review->zakazannaya_uslugaHide}
            <p class="zakazannaya_usluga">
                <span>Заказанные услуги:</span> {$review->zakazannaya_usluga}</p>
        {/if}
    {/if}

    {if $review->worker}
        {if !$review->workerHide}
            <p class="worker">
                <span>Было задействовано:</span> {$review->worker}</p>
        {/if}
    {/if}

    {if $review->works}
        {if !$review->worksHide}
            <p><span>Выполненные работы:</span> {$review->works}</p>
        {/if}
    {/if}

    {if $review->from_to}
        {if !$review->from_toHide}
            <p class="<php:Hide_from_to>">
                <span>{$review->from_to_title}:</span> {$review->from_to}</p>
        {/if}
    {/if}

    {if $review->route neq '' || $review->where_place neq ''}
        {if $review->route eq ''}
            <p><span>Где оказывались услуги:</span> {$review->where_place}</p>
        {/if}
        {if $review->where_place eq ''}
            <p><span>Маршрут:</span> {$review->route}</p>
        {/if}
    {/if}

    <div class="polosa"></div>
</div>