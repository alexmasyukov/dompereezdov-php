<h1>{$generalCar->h1}</h1>

<div class="bl text text-top">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <img src="{$generalCar->big_img}" alt="{$generalCar->name}"
                 title="{$generalCar->name}"
                 class="img-responsive"/>
        </div>
        <div class="col-lg-4 col-md-6">
            {$generalCar->description}
        </div>
    </div>

</div>

<div class="bl text">
    <h2>Тарифы на грузоперевозки и характеристики</h2>

    <table>
        {foreach $generalCar->attributes as $attribute}
            <tr>
                <td class="left">{$attribute->title}</td>
                <td class="right">{$attribute->value}</td>
            </tr>
        {/foreach}
    </table>

</div>

<h2>Другие автомобили</h2>
<div class="bl cars">
    <div class="row bl">
        {foreach $otherCars as $car}
            {include '_car.tpl'}
        {/foreach}
    </div>
</div>