
<div class="modal fade" id="zakaz_auto_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="bg_content"></div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Заказать машину онлайн</h4>
            </div>
            <div class="modal-body" data-type="onlineform"
                 data-result-text="Спасибо! <br/> Мы перезвоним Вам в течении 5-ти минут!">
                <span data-type="form-type" data-name="Новая онлайн заявка"></span>
                <span data-type="site" data-name="ПеревозчикГрузов"></span>
                <span data-type="form-text" data-name="Название формы ** Заказать машину"></span>
                <span data-type="form-text"
                      data-name="Где находится ** Все страницы - форма вверху страницы"></span>


                <p>Наш сотрудник свяжется с Вами в течении 5-ти минут, <br>
                    для обсуждения деталей заказа.</p>

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
                    type="text" />

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
                    type="text" />

                <div class="modal-footer">
                    <button type="button" class="btn sender">Жду звонка</button>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
