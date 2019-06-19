<noindex>
    {* todo: include form callme *}
    <?php include_once($root . '/frontend/modules/callme/callme_form.php'); ?>

    {* todo: fix add review form *}
    <div class="modal fade modal_question" id="feedback_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Добавьте Ваш отзыв</h4>
                </div>
                <div class="modal-body saves">
                    <div class="process">
                        <p>Отправка...</p>
                    </div>
                    <div class="row myform">
                        <div class="col-sm-6">
                            <label>ФИО (или Ваше имя): <span class="necess">*</span></label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder=""
                                    id="name"
                                    data-type="form-val"
                                    data-necessarily="yes"/>
                        </div>
                        <div class="col-sm-6">
                            <label>Почему обратились к нам?: </label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder=""
                                    id="why"
                                    data-type="form-val"
                                    data-necessarily=""/>
                        </div>

                        <div class="col-sm-12">
                            <label>Какие услуги/работы заказывали?: <span class="necess">*</span></label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder=""
                                    id="zakazannaya_usluga"
                                    data-type="form-val"
                                    data-necessarily="yes"/>
                        </div>
                        <div class="col-sm-12">
                            <label>Ваш населенный пункт: <span class="necess">*</span></label>

                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder=""
                                    id="where_place"
                                    value="<?php
                                    if ($page_id <> 1233 && $page_parent_id <> 1233) {
                                        if (strpos($page_name, '    ') !== false) {
                                            $select_town = $page_parent_id;
                                        } else {
                                            $select_town = $page_id;
                                        }
                                    }
                                    include_once $root . '/cms/forms/feedback/get_town_name.php'; ?>"
                                    data-type="form-val"
                                    data-necessarily="yes"/>

                        </div>


                        <div class="col-sm-12">
                            <label>Текст отзыва: <span class="necess">*</span></label>
                            <textarea
                                    class="form-control"
                                    rows="4"
                                    placeholder=""
                                    id="comment"
                                    data-type="form-text"
                                    data-necessarily="yes"
                            ></textarea>
                        </div>

                        <div class="col-sm-6">
                            <label>Как узнали о нас?:</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder=""
                                    id="otkuda"
                                    data-type="form-val"
                                    data-necessarily=""/>
                            <br>
                        </div>

                        <div class="col-sm-6">
                            <label>Коротко о себе:</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder=""
                                    id="about"
                                    data-type="form-val"
                                    data-necessarily=""/>
                            <br>
                        </div>


                        <input
                                type="text"
                                class="form-control"
                                placeholder=""
                                id="town_start_id"
                                data-type="form-val"
                                data-necessarily="yes"
                                value="1233"
                                style="display: none; opacity: 0;"
                        />

                        <input
                                type="text"
                                class="form-control"
                                placeholder=""
                                id="public"
                                data-type="form-val"
                                data-necessarily="yes"
                                value="0"
                                style="display: none; opacity: 0;"
                        />

                        <input
                                type="text"
                                class="form-control"
                                placeholder=""
                                id="date"
                                data-necessarily="yes"
                                data-type="form-val"
                                value="<?php echo date('Y-m-d'); ?>"
                                style="display: none; opacity: 0;"/>

                        <div class="col-xs-12">
                            <p id="error">Пожалуйста, заполните обязательные поля!</p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn but-fr but-modal" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn but-fr but-modal saves_but" data-name="feedback">Оставить отзыв
                    </button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</noindex>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                © {$year}. Все права защищены. Копирование с сайта запрещено.
            </div>
            <div class="col-md-6">
                <div class="social_button">
                    <div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir,gplus"
                         data-counter=""></div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript" src="/frontend/js/libs.min.js?v=7"></script>
<script type="text/javascript" src="/frontend/js/main.min.js?v=8"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter20693695 = new Ya.Metrika({
                    id: 20693695,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true,
                    ut: "noindex"
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
            n.parentNode.insertBefore(s, n);
        };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks"); </script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/20693695?ut=noindex" style="position:absolute; left:-9999px;" alt=""/>
    </div>
</noscript> <!-- /Yandex.Metrika counter -->

<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript" src="/frontend/js/deliveryCalculator.js?v=8"></script>

<!--<script>-->
<!--    --><?php
//        require $root . "/frontend/modules/cars/view_cars_json.php";
//        //echo $list_items;
//    ?>
<!--</script>-->


{*
<!--<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>-->
<!--<script src="//yastatic.net/share2/share.js"></script>-->
<!---->

<!---->
<!--<script>-->
<!--    function downloadJSAtOnload() {-->
<!--        var element_libs = document.createElement("script");-->
<!--        var element_main = document.createElement("script");-->
<!--        element_libs.src = "/frontend/js/libs.min.js";-->
<!--        element_libs.async = false;-->
<!--        element_main.src = "/frontend/js/main.min.js";-->
<!--        element_main.async = false;-->
<!--        document.body.appendChild(element_libs);-->
<!--        document.body.appendChild(element_main);-->
<!---->
<!--        add_css();-->
<!--    }-->
<!---->
<!--    if (window.addEventListener)-->
<!--        window.addEventListener("load", downloadJSAtOnload, false);-->
<!--    else if (window.attachEvent)-->
<!--        window.attachEvent("onload", downloadJSAtOnload);-->
<!--    else window.onload = downloadJSAtOnload;-->
<!---->
<!--    function add_css() {-->
<!--        var head = document.body-->
<!--            , link = document.createElement('link')-->
<!--            , link2 = document.createElement('link');-->
<!---->
<!--        link.type = 'text/css';-->
<!--        link.rel = 'stylesheet';-->
<!--        link.href = '/frontend/template/css/libs.min.css';-->
<!--        head.appendChild(link);-->
<!---->
<!--        link2.type = 'text/css';-->
<!--        link2.rel = 'stylesheet';-->
<!--        link2.href = '/frontend/template/css/main.min.css';-->
<!--        head.appendChild(link2);-->
<!--    }-->
<!---->
<!--</script>-->
*}

</body>
</html>