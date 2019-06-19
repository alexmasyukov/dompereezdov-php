<div class="bl raschet">
  <?php echo $title_map; ?>
  <div class="row">
    <div class="col-md-12">
      <p class="title"><span class="map-num">Шаг 1.</span> Выберите подходящий автомобиль</p>
    </div>

    <div class="col-md-12 bl">
      <select id="calculation_car">
        <?php
        require $root . "/frontend/modules/cars/view_cars_json.php";
        echo $select_calculation_car_options;
        ?>
      </select>
    </div>

    <div class="col-md-12 bl">
      <p class="title"><span class="map-num">Шаг 2.</span> Задайте начальную и конечную точку маршрута</p>
      Кликнув в нужные места на карте, или
      задав нужные адреса в поисковых строках. На карте отобразятся точки A и B с
      проложенным маршрутом.
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