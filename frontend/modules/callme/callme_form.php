<section>
    <div class="container">
        <div class="modal fade callme_modal" tabindex="-1" role="dialog" aria-labelledby="modal_callme_label"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modal_callme_label">Обратный звонок</h4>
                    </div>
                    <div class="modal-body">
                        <div id="callme_form">
                            <h5 style="margin-top: 0px;">Наш менеджер свяжется<br> Вами в течение 5 минут!</h5>

                            <input
                                    type="hidden"
                                    id="callme_form_p_date"
                                    value="p_date"
                                    data-title="Дата"
                                    data-field="date"
                                    data-massive-element-type="input"/>

                            <input
                                    type="hidden"
                                    id="callme_form_p_time"
                                    value="p_time"
                                    data-title="Время"
                                    data-field="time"
                                    data-massive-element-type="input"/>


                            <input
                                    type="hidden"
                                    id="callme_form_otdel"
                                    value="<?php echo $otdel_name; ?>"
                                    data-massive-element-type="input"
                                    data-title="Отдел"
                                    data-field="otdel"
                            />


                            <input
                                    type="hidden"
                                    id="callme_form_h_site"
                                    value="null"
                                    data-massive-element-type="input"
                                    data-site="<?php echo $company_name; ?>"/>

                            <input
                                    type="hidden"
                                    id="callme_form_h_form_type"
                                    value="null"
                                    data-massive-element-type="input"
                                    data-form-type="Обратный звонок"/>


                            <input
                                    type="hidden"
                                    id="callme_form_tab"
                                    value="null"
                                    data-massive-element-type="input"
                                    data-tab="callme"/>


                            <input
                                    type="text"
                                    id="callme_form_v_name_user"
                                    class="form-control"
                                    placeholder="Ваше имя"
                                    data-required-field="yes"
                                    data-necessarily="true"
                                    data-field="name"
                                    data-title="Имя клиента"
                                    data-massive-element-type="input"
                            />

                            <input
                                    type="text"
                                    id="callme_form_v_phone_user"
                                    class="form-control input partext phone_mask"
                                    placeholder="+7 (___) ___-____"
                                    data-necessarily="true"
                                    data-field="phone"
                                    data-required-field="yes"
                                    data-title="Телефон"
                                    data-massive-element-type="input"

                            />


                            <div id="button_callme_form" class="btn but">Заказать звонок</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>