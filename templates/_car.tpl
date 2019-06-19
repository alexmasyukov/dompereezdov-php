<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 car">
    <a href="https://{$HTTP_HOST}{$car->cpu_path}">
        {$car->name}
        <img src="{$car->small_img}" alt="{$car->name}" title="{$car->name}"/>
    </a>
    <div class="clearfix"></div>

    <table>
        {foreach $car->attributes as $attribute}
            <tr>
                <td>{$attribute->title}</td>
                <td>{$attribute->value}</td>
            </tr>
        {/foreach}
    </table>
</div>

