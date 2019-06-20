<div class="bl raschet">
    <h3>{$page->titleMap}</h3>
    <div class="row">
        <div class="col-md-12">
            <p class="title"><span class="map-num">Шаг 1.</span> Выберите подходящий автомобиль</p>
        </div>

        <div class="col-md-12 bl">
            <select id="calculation_car">
                {foreach from=$carsForMap key=$k item=$car}
                    <option data-tarif="{$car->tarif}"
                            data-minimum-cost="{$car->minimumCost}"
                            data-img="{$car->small_img}"
                            value="{$k}">{$car->title}
                    </option>
                {/foreach}
            </select>
        </div>

        <div class="col-md-12 bl">
            <p class="title"><span class="map-num">Шаг 2.</span> Задайте начальную и конечную точку маршрута</p>
            Кликнув в нужные места на карте, или
            задав нужные адреса в поисковых строках. На карте отобразятся точки A и B с
            проложенным маршрутом.
            {* todo: fix $map_location формировался в breadcrumb *}
            <div id="map" data-name="<?php echo $map_location; ?>"></div>
        </div>

        <div class="col-md-12 bl result">
            <p class="title"><span class="map-num">Шаг 3.</span> Результат расчета</p>
            <p>Выбранный грузовик: <span id="calculation_car_text">Не выбран</span></p>
            <p>Расстояние: <span id="calculation_distance">0 км.</span></p>
            <p>Стоимоcть: ≈ <span id="calculation_cost">0 руб.</span></p>
        </div>
    </div>
</div>