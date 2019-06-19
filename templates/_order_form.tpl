<div class="modal fade" id="zakaz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="bg_content"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Оформить заказ</h4>
            </div>
            <div class="modal-body" data-type="onlineform"
                 data-result-text="Оставайтесь на связи, мы перезвоним Вам!">
                <span data-type="form-type" data-name="Новая онлайн заявка"></span>
                <span data-type="site" data-name="Дом Переездов"></span>
                <span id="form_name" data-type="form-text" data-name="Название формы ** Заказать услугу"></span>
                <span data-type="form-text"
                      data-name="Где находится ** Главная страница - блоки с услугами"></span>

                <p>Оставьте заявку на <b>бесплатный</b> обратный звонок, и ожидайте звонка оператора</p>

                <input
                        value=""
                        autocomplete="off"
                        data-necessarily="yes"
                        data-type="form-val"
                        data-id="name_sms"
                        data-name="Имя клиента"
                        class="input partext"
                        id="client_name"
                        placeholder="Ваше имя"
                        type="text"/>

                <input
                        value=""
                        autocomplete="off"
                        data-necessarily="yes"
                        data-type="form-val"
                        data-id="phone_sms"
                        data-name="Телефон"
                        class="input partext phone_mask"
                        placeholder="+7 (___) ___-____"
                        id="client_phone"
                        type="text"/>

                <div class="modal-footer">
                    <button type="button" class="btn sender">Заказать</button>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

