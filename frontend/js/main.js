$(document).ready(function () {


    var touch = $('#touch-menu');
    var menu = $('.menu');

    $(touch).on('click', function (e) {
        e.preventDefault();
        menu.slideToggle();
    });

    $(window).resize(function () {
        var w = $(window).width();
        if (w > 767 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });


    $('body').on('click', '.add_feedback, #add_feedback', function () {
        $('#feedback_modal').modal();
    });

    $('body').on('click', '.order', function () {
        $('#zakaz').modal();
        form_name = $(this).parents('.homeblock').find('h3').text();
        $('#form_name').attr('data-name', 'Название формы ** ' + form_name)
        console.log(form_name);
    });




    // $("#town_start_id").chosen({
    //     search_contains: true,
    //     no_results_text: 'Ничего не найдено'
    // });


    $('body').on('click', '.open_all', function () {
        console.log($('.all_car_features').hasClass('hide_ul'));
        if ($('.all_car_features').hasClass('hide_ul')) {
            $('.all_car_features').removeClass('hide_ul');
            $('.all_car_features').addClass('show_ul');
            $('.all_car_features').show(300);
        } else {
            $('.all_car_features').addClass('hide_ul');
            $('.all_car_features').removeClass('show_ul');
            $('.all_car_features').hide(300);
        }
    });


    $('body').on('click', 'p[data-sort]', function () {
        if (document.location.href.indexOf('?') > 1) {
            link = document.location.href.substring(0, document.location.href.indexOf('?'));
        } else {
            link = document.location.href;
        }
        document.location.href = link + '?sort=' + $(this).data('sort');
    });


    $phone_input = 0;
    $user_click_change_calc_cats = 0;
    $user_click_change_calc_product = 0;

    $('a.fancybox').attr('data-fancybox-group', 'gallary').fancybox();


    function check_of_empty(el_parent) {
        yes = 1;
        $els = $(el_parent).find('[data-necessarily=yes]');
        $.each($els, function (index, value) {
            if ($.trim($($els).eq(index).val()) == '') {
                tblink_comments_sender(4, $($els).eq(index));
                yes = 0;
            }
        });
        return yes;
    }


    // Кнопка "Наверх"
    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            $('.site-button-up').fadeIn();
        } else {
            $('.site-button-up').fadeOut();
        }
    });

    $(window).trigger('scroll');

    $('.site-button-up').click(function () {
        $('body, html').animate({
            scrollTop: 0
        }, 500);

        return false;
    });


    // Кнопка "Наверх"
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
    });


    $('.saves_but').click(function () {
        form = $(this).parents('.modal-content');
        $inputs = $(form).find('[data-type="form-val"]');
        $text = $(form).find('[data-type="form-text"]');
        $select = $(form).find('[data-type="form-select"]');
        var values = [];
        var inputs = [];
        yes = true;
        button = $(this);

        $.each($text, function () {
            add_red_class($(this), false);
            if ($(this).data('necessarily') == 'yes') {
                if ($.trim($(this).val()) == '') {
                    add_red_class($(this), true);
                    yes = false;
                } else {
                    inputs[inputs.length] = $(this).attr('id');
                    values[values.length] = $(this).val();
                }
            } else {
                inputs[inputs.length] = $(this).attr('id');
                values[values.length] = $(this).val();
            }
        });
        $.each($inputs, function (index, value) {
            add_red_class($(this), false);
            if ($(this).data('necessarily') == 'yes') {
                if ($.trim($(this).val()) == '') {
                    add_red_class($(this), true);
                    yes = false;
                } else {
                    inputs[inputs.length] = $(this).attr('id');
                    values[values.length] = $(this).val();
                }
            } else {
                inputs[inputs.length] = $(this).attr('id');
                values[values.length] = $(this).val();
            }
        });
        $.each($select, function (index, value) {
            add_red_class($('#town_start_id_chosen a'), false);
            console.log($(this))
            select = $(this).find('option:selected').val();
            if (select == '' || select == 0) {
                add_red_class($('#town_start_id_chosen a'), true);
            } else {
                inputs[inputs.length] = $(this).attr('id');
                values[values.length] = select;
            }
        });
        if (yes == true) {
            $(form).find('.myform').hide();
            $proc = $(form).find('.process');
            $proc.fadeIn(400);
//            $(this).parents('.modal-content').find('.saves').animate({opacity: 0, display: 'none'}, 200);
            $(button).fadeOut(200);
            $.ajax({
                type: "POST",
                url: "/frontend/php/saves.php",
                dataType: 'json',
                data: {
                    name: $(button).attr('data-name'),
                    values: $.toJSON(values),
                    inputs: $.toJSON(inputs)
                },
                success: function (json) {
                    console.log(json);
                    if (json.result == '1') {
                        console.log($proc);
                        $proc.find('p').html('Спасибо за Ваш отзыв!');
                        $(button).fadeOut(100);
                    }
                },
                error: function (jqxhr, textStatus, error) {
                    $(this).parents('.modal-content').html("Ошибка: " + textStatus + ", " + error + ' ' + ' Данные: ' + jqxhr.responseText);
                    console.log("Ошибка: " + textStatus + ", " + error + ' ' + ' Данные: ' + jqxhr.responseText);
                }
            });
        }
    });



    function add_red_class(obj, status) {
        if (status == true) {
            $('#error').show(300);
            $(obj).addClass('red');
        } else {
            $(obj).removeClass('red');
        }
    }


    function number_format(number, decimals, dec_point, thousands_sep) {
        var n = number, prec = decimals;

        var toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return (Math.round(n * k) / k).toString();
        };

        n = !isFinite(+n) ? 0 : +n;
        prec = !isFinite(+prec) ? 0 : Math.abs(prec);
        var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
        var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

        var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec);
        //fix for IE parseFloat(0.55).toFixed(0) = 0;

        var abs = toFixedFix(Math.abs(n), prec);
        var _, i;

        if (abs >= 1000) {
            _ = abs.split(/\D/);
            i = _[0].length % 3 || 3;

            _[0] = s.slice(0, i + (n < 0)) +
                _[0].slice(i).replace(/(\d{3})/g, sep + '$1');
            s = _.join(dec);
        } else {
            s = s.replace('.', dec);
        }

        var decPos = s.indexOf(dec);
        if (prec >= 1 && decPos !== -1 && (s.length - decPos - 1) < prec) {
            s += new Array(prec - (s.length - decPos - 1)).join(0) + '0';
        }
        else if (prec >= 1 && decPos === -1) {
            s += dec + new Array(prec).join(0) + '0';
        }
        return s;
    }


    $('.sender').click(function () {
        form = $(this).parents('[data-type="onlineform"]');
        $inputs = $(form).find('[data-type="form-val"]');
        $text = $(form).find('[data-type="form-text"]');
        $checkbox = $(form).find('[data-type="form-check"]');
        $radio = $(form).find('[data-type="form-radio"]');
        $select = $(form).find('[data-type="form-select"]');
        var code = '';
        yes = true;
        $.each($text, function (index, value) {
            code += $(this).data('name') + ' ** ' + $.trim($(this).val()) + ' ;; ';
            console.log($($text).eq(index));
            console.log(code);

        });
        $.each($inputs, function (index, value) {
            if ($($inputs).eq(index).data('necessarily') == 'yes') {
                if ($($inputs).eq(index).hasClass('phone_mask') && $phone_input == 0) {
                    tblink_comments_sender(4, $($inputs).eq(index));
                    yes = false;
                }
                if ($.trim($($inputs).eq(index).val()) == '') {
                    tblink_comments_sender(4, $($inputs).eq(index));
                    yes = false;
                }
            }
            if (yes == true) {
                code += $($inputs).eq(index).data('name') + ' ** ' + $.trim($($inputs).eq(index).val()) + ' ;; ';
            }
        });
        $.each($select, function (index, value) {
            code += $($select).eq(index).data('name') + ' ** ' + $($select).eq(index).find('option:selected').text() + ' ;; ';
        });
        $.each($checkbox, function (index, value) {
            if ($($checkbox).eq(index).prop("checked") == true) {
                check = '<b>Да</b>';
            } else {
                check = '<b>Нет</b>';
            }
            code += $($checkbox).eq(index).data('text') + ' ** ' + check + ' ;; ';
        });
        $.each($radio, function (index, value) {
            if ($($radio).eq(index).prop("checked") == true) {
                check = '<b>Да</b>';
            } else {
                check = '-';
            }
            code += $($radio).eq(index).data('text') + ' ** ' + check + ' ;; ';
        });
        if (yes == true) {
            $.ajax({
                type: "POST",
                url: "/frontend/php/sender_form_universal.php",
                dataType: 'json',
                data: {
                    code: code,
                    form_type: $(form).find('[data-type="form-type"]').data('name'),
                    site: $(form).find('[data-type="site"]').data('name')
                },
                success: function (result) {
                    //                    $(form).html(result.result);
                    if (result.result == '1') {
                        $(form).html('<p class="result-text">' + $(form).data("result-text") + '</p>');
                    } else {
                        $(form).html('<p class="result-text">Ошибка отправки заявки! <br/>Пожалуйста, позвоните нам!</p>');
                    }
                },
                error: function (jqxhr, textStatus, error) {
                    $(form).html("Ошибка: " + textStatus + ", " + error + ' ' + ' Данные: ' + jqxhr.responseText);
                    console.log("Ошибка: " + textStatus + ", " + error + ' ' + ' Данные: ' + jqxhr.responseText);
                }
            });
        }
    });


    function tblink_comments_7(n, name) {
        if (n) {
            var obj = $(name);
            (obj.css('opacity') == '0') ? obj.stop(true).animate({opacity: '1'}, 50) : obj.animate({opacity: '0'}, 50)
            setTimeout(function () {
                n--;
                tblink_comments_7(n, $(name));
            }, 150);
        }
        ;
    };

    function tblink_comments_sender(n, name) {
        if (n) {
            var obj = $(name);
            (obj.css('opacity') == '0') ? obj.stop(true).animate({opacity: '1'}, 50) : obj.animate({opacity: '0'}, 50)
            setTimeout(function () {
                n--;
                tblink_comments_sender(n, $(name));
            }, 150);
        }
        ;
    };

    function tblink_comments_sender(n, name) {
        if (n) {
            var obj = $(name);
            (obj.css('opacity') == '0') ? obj.stop(true).animate({opacity: '1'}, 50) : obj.animate({opacity: '0'}, 50)
            setTimeout(function () {
                n--;
                tblink_comments_sender(n, $(name));
            }, 150);
        }
        ;
    };

    function declOfNum(number, titles) {
        cases = [2, 0, 1, 1, 1, 2];
        return titles[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];
    }

    $(".phone_mask").inputmask("+7 (999) 999-9999", {
        "oncomplete": function () {
            $phone_input = 1;
        },
        "onincomplete": function () {
            $phone_input = 0;
        },
        "oncleared": function () {
            $phone_input = 0;
        },
    });

    $('[data-click="close"]').click(function () {
        $(this).parent().fadeOut(300);
    });


    var client = {
        phone: '',
        company_name: $('#online_order').data('company-name')
    };


    function send_sms() {
        if ($phone_input == 1) {
            client['phone'] = $.trim($('#phone_number').val());

            if (client['phone'].length > 0) {
                $.ajax({
                    type: "POST",
                    url: "/frontend/system/send_sms.php",
                    dataType: 'json',
                    data: {
                        client: client
                    },
                    beforeSend: function () {
                        $('.cssload-container').fadeIn(400);
                    },
                    success: function (result) {
                        if (result['status'] == 'ok') {
                            $('#status_order').text('Спасибо, ваша заявка принята!');
                            $('#but_order').fadeOut(400);
                            $('#phone_number').fadeOut(400);
                        } else {
                            console.log(result);
                        }
                        $('.cssload-container').fadeOut(400);
                    },
                    error: function (jqxhr, textStatus, error) {
                        console.log("Ошибка: " + textStatus + ", " + error + ' ' + ' Данные: ' + jqxhr.responseText);
                        $('#status').text('Ошибка');
                    }
                });
            } else {
                console.log('Введите номер телефона!');
            }
        } else {
            $('#phone_number').tooltip('show');
            setTimeout(function () {
                $('#phone_number').tooltip('hide');
            }, 2500);


        }
    }


    $(document).on('click', '#but_order', function () {
        send_sms();
    });

    $("#phone_number").keyup(function (event) {
        if (event.keyCode == 13) {
            send_sms();
        }
    });



});


function myFunction(x) {
    x.classList.toggle("change");
}

