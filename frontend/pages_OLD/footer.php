<noindex>
    <?php include_once($root . '/frontend/modules/callme/callme_form.php'); ?>

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

                            <!--                        <select-->
                            <!--                                data-type="form-select"-->
                            <!--                                data-table-field="town_start_id"-->
                            <!--                                data-placeholder="Поиск..."-->
                            <!--                                class="chosen-select"-->
                            <!--                                id="town_start_id"-->
                            <!--                                tabindex="13">-->
                            <!--                            <option value=""></option>-->
                            <!--                            --><?php
                            ////                            if ($page_id <> 1233 && $page_parent_id <> 1233) {
                            ////                                if (strpos($page_name, '    ') !== false) {
                            ////                                    $select_town = $page_parent_id;
                            ////                                } else {
                            ////                                    $select_town = $page_id;
                            ////                                }
                            ////                            }
                            ////
                            //                            ?>
                            <!--                        </select>-->

                            <!--                        <select-->
                            <!--                                id="town_start_id"-->
                            <!--                                data-type="form-select"-->
                            <!--                                tabindex="13">-->
                            <!--                            <option value="">Выбрать...</option>-->
                            <!--                            --><?php
                            //                            if ($page_id <> 1233 && $page_parent_id <> 1233) {
                            //                                if (strpos($page_name, '    ') !== false) {
                            //                                    $select_town = $page_parent_id;
                            //                                } else {
                            //                                    $select_town = $page_id;
                            //                                }
                            //                            }
                            //                            include_once $root . '/cms/forms/feedback/wiget_get_towns.php';
                            //                            ?>
                            <!--                        </select>-->
                            <!--                        <p id="ticket"><span class="necess">(!) </span> Если нужного населенного пункта нет с списке,-->
                            <!--                            пожалуйста, выберете Ваш район.</p>-->
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
                © <?php $a = getdate();
                echo $a['year']; ?>. Все права защищены. Копирование с сайта запрещено.
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