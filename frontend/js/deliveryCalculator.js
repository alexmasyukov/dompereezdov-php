ymaps.modules.define(
  'DeliveryCalculator',
  ['util.defineClass', 'vow'],
  function (provide, defineClass, vow) {
    /**
     * @class DeliveryCalculator Расчет стоимости доставки.
     * @param {Object} map    Экземпляр карты.
     */
    function DeliveryCalculator(map) {
      this._map = map;
      this._startPoint = null;
      this._finishPoint = null;
      this._route = null;
      this._startPointBalloonContent;
      this._finishPointBalloonContent;
      this._DELIVERY_TARIF = 5;
      this._MINIMUM_COST = 100;

      map.events.add('click', this._onClick, this);
    }

    defineClass(DeliveryCalculator, {
      /**
       * Задаём точке маршрута координаты и контент балуна.
       * @param {String} pointType Тип точки: 'start' - начальная, 'finish' - конечная.
       * @param {Number[]} position Координаты точки.
       * @param {String} content Контент балуна точки.
       */
      _setPointData: function (pointType, position, content) {
        if (pointType == 'start') {
          this._startPointBalloonContent = content;
          this._startPoint.geometry.setCoordinates(position);
          this._startPoint.properties.set('balloonContentBody', "Ожидаем данные");
        } else {
          this._finishPointBalloonContent = content;
          this._finishPoint.geometry.setCoordinates(position);
          this._finishPoint.properties.set('balloonContentBody', "Ожидаем данные");
        }
      },

      /**
       * Создаем новую точку маршрута и добавляем её на карту.
       * @param {String} pointType Тип точки: 'start' - начальная, 'finish' - конечная.
       * @param {Number[]} position Координаты точки.
       */
      _addNewPoint: function (pointType, position) {
        // Если новой точке маршрута не заданы координаты, временно задаём координаты вне области видимости.
        if (!position) position = [19.163570, -156.155197];
        // Создаем маркер с возможностью перетаскивания (опция `draggable`).
        // По завершении перетаскивания вызываем обработчик `_onStartDragEnd`.
        if (pointType == 'start' && !this._startPoint) {
          this._startPoint = new ymaps.Placemark(position, {iconContent: 'А'}, {draggable: true});
          this._startPoint.events.add('dragend', this._onStartDragEnd, this);
          this._map.geoObjects.add(this._startPoint);
        }
        if (pointType == 'finish' && !this._finishPoint) {
          this._finishPoint = new ymaps.Placemark(position, {iconContent: 'Б'}, {
            draggable: true,
            balloonAutoPan: false
          });
          this._finishPoint.events.add('dragend', this._onFinishDragEnd, this);
          this._map.geoObjects.add(this._finishPoint);
        }
      },

      /**
       * Задаём точку маршрута.
       * Точку маршрута можно задать координатами или координатами с адресом.
       * Если точка маршрута задана координатами с адресом, то адрес становится контентом балуна.
       * @param {String} pointType Тип точки: 'start' - начальная, 'finish' - конечная.
       * @param {Number[]} position Координаты точки.
       * @param {String} address Адрес.
       */
      setPoint: function (pointType, position, address) {
        if (!this._startPoint || !this._finishPoint) {
          this._addNewPoint(pointType, position);
        }
        if (!address) {
          this._reverseGeocode(position).then(function (content) {
            this._setPointData(pointType, position, content);
            this._setupRoute();
          }, this)
        } else {
          this._setPointData(pointType, position, address);
          this._setupRoute();
        }
      },

      /**
       * Проводим обратное геокодирование (определяем адрес по координатам) для точки маршрута.
       * @param {Number[]} point Координаты точки.
       */
      _reverseGeocode: function (point) {
        return ymaps.geocode(point).then(function (res) {
          // res содержит описание найденных геообъектов.
          // Получаем описание первого геообъекта в списке, чтобы затем показать
          // с описанием доставки по клику на метке.
          return res.geoObjects.get(0) &&
            res.geoObjects.get(0).properties.get('balloonContentBody') || '';
        });

      },

      /**
       * Проводим прямое геокодирование (определяем координаты по адресу) для точки маршрута.
       * @param {String} address Адрес.
       */
      _geocode: function (address) {
        return ymaps.geocode(address).then(function (res) {
          // res содержит описание найденных геообъектов.
          // Получаем описание и координаты первого геообъекта в списке.
          var balloonContent = res.geoObjects.get(0) &&
              res.geoObjects.get(0).properties.get("balloonContent") || '',
            coords = res.geoObjects.get(0) &&
              res.geoObjects.get(0).geometry.getCoordinates() || '';

          return [coords, balloonContent];
        });

      },

      setupTarif: function (DELIVERY_TARIF) {
        this._DELIVERY_TARIF = DELIVERY_TARIF;
        return '';
      },

      setupCost: function (MINIMUM_COST) {
        this._MINIMUM_COST = MINIMUM_COST;
        return '';
      },

      /**
       *
       * @param  {Number} routeLength Длина маршрута в километрах.
       * @return {Number} Стоимость доставки.
       */
      calculate: function (routeLength, DELIVERY_TARIF, MINIMUM_COST) {
        // Константы.
        // var DELIVERY_TARIF = 20, // Стоимость за километр.
        //     MINIMUM_COST = 500; // Минимальная стоимость.

        // return Math.max(routeLength * DELIVERY_TARIF, MINIMUM_COST);
        console.log(MINIMUM_COST + ' --- ' + DELIVERY_TARIF);

        price = MINIMUM_COST + (routeLength * DELIVERY_TARIF) * 2;

        $('#calculation_distance').html(routeLength + ' км.');
        $('#calculation_cost').html(price+ ' руб.');

        return (price);
      },

      /**
       * Прокладываем маршрут через заданные точки
       * и проводим расчет доставки.
       */
      _setupRoute: function () {
        // Удаляем предыдущий маршрут с карты.
        if (this._route) {
          this._map.geoObjects.remove(this._route);
        }

        if (this._startPoint && this._finishPoint) {
          var start = this._startPoint.geometry.getCoordinates(),
            finish = this._finishPoint.geometry.getCoordinates(),
            startBalloon = this._startPointBalloonContent,
            finishBalloon = this._finishPointBalloonContent;
          if (this._deferred && !this._deferred.promise().isResolved()) {
            this._deferred.reject('New request');
          }
          var deferred = this._deferred = vow.defer();
          // Прокладываем маршрут через заданные точки.
          ymaps.route([start, finish])
            .then(function (router) {
              if (!deferred.promise().isRejected()) {
                var price = this.calculate(Math.round(router.getLength() / 1000), this._DELIVERY_TARIF, this._MINIMUM_COST),
                  distance = ymaps.formatter.distance(router.getLength()),
                  message = '<span>Расстояние: ' + distance + ' км.</span><br/>' +
                    '<span style="font-weight: bold; font-style: italic">Стоимость доставки: %s руб.</span>';


                this._route = router.getPaths(); // Получаем коллекцию путей, из которых состоит маршрут.

                this._route.options.set({strokeWidth: 5, strokeColor: '0000ffff', opacity: 0.5});
                this._map.geoObjects.add(this._route); // Добавляем маршрут на карту.
                // Задаем контент балуна для начального и конечного маркера.
                this._startPoint.properties.set('balloonContentBody', startBalloon + message.replace('%s', price));
                this._finishPoint.properties.set('balloonContentBody', finishBalloon + message.replace('%s', price));

                this._map.setBounds(this._route.getBounds(), {checkZoomRange: true}).then(function () {
                  // Открываем балун над точкой доставки.
                  // Раскомментируйте, если хотите показывать балун автоматически.
                  // this._finishPoint.balloon.open().then(function(){
                  // this._finishPoint.balloon.autoPan();
                  // }, this);
                }, this);
                deferred.resolve();
              }

            }, function (err) {
              // Если через заданные точки невозможно проложить маршрут, откроется балун с предупреждением.
              this._finishPoint.properties.set('balloonContentBody', "Невозможно построить маршрут");
              this._finishPoint.balloon.open();
              this._finishPoint.balloon.autoPan();
            }, this);

        }
      },

      /**
       * Обработчик клика по карте. Получаем координаты точки на карте и создаем маркер.
       * @param  {Object} event Событие.
       */
      _onClick: function (event) {
        if (this._startPoint) {
          this.setPoint("finish", event.get('coords'));
        } else {
          this.setPoint("start", event.get('coords'));
        }
      },

      /**
       * Получаем координаты маркера и вызываем геокодер для начальной точки.
       */
      _onStartDragEnd: function () {
        this.setPoint('start', this._startPoint.geometry.getCoordinates());
      },

      _onFinishDragEnd: function () {
        this.setPoint('finish', this._finishPoint.geometry.getCoordinates());
      },

      /**
       * Создаем маршрут.
       * @param {Number[]|String} startPoint Координаты точки или адрес.
       * @param {Number[]|String} finishPoint Координаты точки или адрес.
       */
      setRoute: function (startPoint, finishPoint) {
        if (!this._startPoint) {
          this._addNewPoint("start");
        }
        if (!this._finishPoint) {
          this._addNewPoint("finish");
        }
        if (typeof(startPoint) === "string" && typeof(finishPoint) === "string") {
          vow.all([this._geocode(startPoint), this._geocode(finishPoint)]).then(function (res) {
            this._setPointData("start", res[0][0], res[0][1]);
            this._setPointData("finish", res[1][0], res[1][1]);
            this._setupRoute();
          }, this);
        } else if (typeof(startPoint) === "string") {
          vow.all([this._geocode(startPoint), this._reverseGeocode(finishPoint)]).then(function (res) {
            this._setPointData("start", res[0][0], res[0][1]);
            this._setPointData("finish", finishPoint, res[1]);
            this._setupRoute();
          }, this);
        } else if (typeof(finishPoint) === "string") {
          vow.all([this._reverseGeocode(startPoint), this._geocode(finishPoint)]).then(function (res) {
            this._setPointData("start", startPoint, res[0]);
            this._setPointData("finish", res[1][0], res[1][1]);
            this._setupRoute();
          }, this);
        } else {
          vow.all([this._reverseGeocode(startPoint), this._reverseGeocode(finishPoint)]).then(function (res) {
            this._setPointData("start", startPoint, res[0]);
            this._setPointData("finish", finishPoint, res[1]);
            this._setupRoute();
          }, this);

        }
      }
    });

    provide(DeliveryCalculator);
  }
);





$map = $('body').find('#map');
if ($map.length > 0) {
    ymaps.ready(['DeliveryCalculator']).then(function init() {



        var myMap = new ymaps.Map('map', {
                center: [55.753994, 37.622093],
                zoom: 9,
                type: 'yandex#map',
                controls: []
            }),
            searchStartPoint = new ymaps.control.SearchControl({
                options: {
                    useMapBounds: true,
                    noPlacemark: true,
                    noPopup: true,
                    placeholderContent: 'Адрес начальной точки',
                    size: 'large'
                }
            }),
            searchFinishPoint = new ymaps.control.SearchControl({
                options: {
                    useMapBounds: true,
                    noCentering: true,
                    noPopup: true,
                    noPlacemark: true,
                    placeholderContent: 'Адрес конечной точки',
                    size: 'large',
                    float: 'none',
                    position: {left: 10, top: 44}
                }
            }),
            // myListBox = new ymaps.control.ListBox({
            //     options: {
            //         expandOnClick: true
            //     },
            //     data: {
            //         content: 'Выбрать машину'
            //     },
            //     items: ListBoxControlName
            //     // [
            //     // new ymaps.control.ListBoxItem({
            //     //     options: {
            //     //         selectOnClick: 'false'
            //     //     },
            //     //     data: {
            //     //         content: '23443'
            //     //     },
            //     // })
            //     // ]
            // }),
            calculator = new ymaps.DeliveryCalculator(myMap);

            console.log($('#calculation_car').find('option:selected').data('tarif') + ' - ' + $('#calculation_car').find('option:selected').data('minimum-cost'));


        $('#calculation_car_text').html( $('#calculation_car').find('option:selected').text());
        calculator.setupTarif( $('#calculation_car').find('option:selected').data('tarif'));
        calculator.setupCost( $('#calculation_car').find('option:selected').data('minimum-cost'));


        // myListBox.events.add('click', function (e) {
        //     // Получаем ссылку на объект, по которому кликнули.
        //     // События элементов списка пропагируются
        //     // и их можно слушать на родительском элементе.
        //     var item = e.get('target');
        //     // Клик на заголовке выпадающего списка обрабатывать не надо.
        //     if (item != myListBox) {
        //
        //     }
        // });


        $('body').on('change', '#calculation_car', function () {
            // console.log($(this).find('option:selected').data('tarif'));

            $('#calculation_car_text').html( $('#calculation_car').find('option:selected').text());
            calculator.setupTarif( $('#calculation_car').find('option:selected').data('tarif'));
            calculator.setupCost( $('#calculation_car').find('option:selected').data('minimum-cost'));
            calculator._setupRoute();
        });


        ymaps.geocode($($map).data('name'), {
            /**
             * Опции запроса
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
             */
            // Сортировка результатов от центра окна карты.
            // boundedBy: myMap.getBounds(),
            // strictBounds: true,
            // Вместе с опцией boundedBy будет искать строго внутри области, указанной в boundedBy.
            // Если нужен только один результат, экономим трафик пользователей.
            results: 1
        }).then(function (res) {
            // Выбираем первый результат геокодирования.
            var firstGeoObject = res.geoObjects.get(0),
                // Координаты геообъекта.
                coords = firstGeoObject.geometry.getCoordinates(),
                // Область видимости геообъекта.
                bounds = firstGeoObject.properties.get('boundedBy');

            // Добавляем первый найденный геообъект на карту.
            myMap.geoObjects.add(firstGeoObject);
            // Масштабируем карту на область видимости геообъекта.
            myMap.setBounds(bounds, {
                // Проверяем наличие тайлов на данном масштабе.
                checkZoomRange: true
            });
        });


        myMap.controls.add(searchStartPoint)
            .add(searchFinishPoint)
            // .add(myListBox);
        // .add(routeButton, {float: 'none', position: {left: 10, bottom: 40}

        searchStartPoint.events
            .add('resultselect', function (e) {
                var results = searchStartPoint.getResultsArray(),
                    selected = e.get('index'),
                    point = results[selected].geometry.getCoordinates(),
                    balloonContent = results[selected].properties.get("balloonContent");


                // Задаем начало маршрута.
                calculator.setPoint("start", point, balloonContent);

            })
            .add('load', function (event) {
                // По полю skip определяем, что это не дозагрузка данных.
                // По getResultsCount определяем, что есть хотя бы 1 результат.
                if (!event.get('skip') && searchStartPoint.getResultsCount()) {
                    searchStartPoint.showResult(0);
                }
            });

        searchFinishPoint.events
            .add('resultselect', function (e) {
                var results = searchFinishPoint.getResultsArray(),
                    selected = e.get('index'),
                    point = results[selected].geometry.getCoordinates(),
                    balloonContent = results[selected].properties.get("balloonContent");

                // Задаем конец маршрута.
                calculator.setPoint("finish", point, balloonContent);
            })
            .add('load', function (event) {
                // По полю skip определяем, что это не дозагрузка данных.
                // По getResultsCount определяем, что есть хотя бы 1 результат.
                if (!event.get('skip') && searchFinishPoint.getResultsCount()) {
                    searchFinishPoint.showResult(0);
                }
            });

        // routeButton.events
        //     .add('click', function () {
        //         calculator.setRoute([59.939095, 30.315868], [55.757026, 37.615032])
        //     });
    });
}
