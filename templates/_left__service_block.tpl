<div class="left_block" id="service_block">
    <p class="title">Мы предлагаем</p>
    <ul>
        {foreach $services as $service}
            <li>
                <a href="https://{$HTTP_HOST}{$service.cpu_path}" title="">{$service.name}</a>
            </li>
        {/foreach}
    </ul>
</div>