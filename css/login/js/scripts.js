$(document).ready(function () {

    $("#bill").on("click", function () {
        document.getElementById("google_hidden").value = $("#google").val();
        document.getElementById("yandex_hidden").value = $("#yandex").val();
    });
    /**
     * FancyBox
     * @see  http://fancyapps.com/fancybox/
     */
    $('.js-popup-link').fancybox({
        padding: 0,
        wrapCSS: 'fancybox-popup'
    });

    $('.js-popup-close').click(function (e) {
        e.preventDefault();
        $.fancybox.close();
    });

    /**
     * Form Styler
     * @see  http://dimox.name/jquery-form-styler/
     */
    $('.js-styler').styler();

    $('.js-validation-form').each(function () {
        var $form = $(this);
        $form.validate();
    });

    $('.js-recovery-form').validate({
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: url_path+"/css/login/js/sendmail.php",
                data: $(form).serialize(),
                success: function (client) {

                    form.reset();
                    $.fancybox.close();
                    $.fancybox.open('#recovery-send-window', {
                        'padding': 0
                    });

                    if (client == '1') {
                        $("#change1").text('Пароль отправлен на Вашу почту.');
                    }
                    else {
                        $("#change1").text("Клиент с таким e-mail не найден.");
                    }
                }
            });
        }
    });


    /**
     * Form Validation
     * @see  http://jqueryvalidation.org/validate/
     */


    /**
     * UI Slider
     * @see  http://jqueryui.com/slider/
     */
    var averageSum = document.getElementById('sum').value;
    if (averageSum === '0')
        averageSum = 100000;
    var yandex_summ_min = 0,
        yandex_summ_max = 5000,
        yandex_summ_value = 305;
    if ($("#last_yandex").val() !== '') {
        yandex_summ_value = $("#last_yandex").val();
    }

    var yandex_days_min = 0,
        yandex_days_max = yandex_summ_max / (1.3 * averageSum),
        yandex_days_value = yandex_summ_value / (1.3 * averageSum);

    var google_summ_min = 0,
        google_summ_max = 50000,
        google_summ_value = 305;
    var remember=0;
    if ($("#last_google").val() !== '') {
        google_summ_value = $("#last_google").val();
    }
    /* Yandex Сумма */
    $('.js-yd-s-range').slider({
        range: 'min',
        min: yandex_summ_min,
        max: yandex_summ_max,
        value: yandex_summ_value,
        step: 1,
        slide: function (event, ui) {
            $('.js-yd-s-input').val(number_format(ui.value));
            $('.js-yd-d-range').slider('option', 'value', get_yandex_days(ui.value));
            block_button();
        },
        change: function (event, ui) {
            $('.js-yd-s-input').val(number_format(ui.value));
            block_button();
        }
    });

    $('.js-yd-s-input').val(number_format($('.js-yd-s-range').slider('value')));

    $('.js-yd-s-input').on('change blur', function () {
        var value = number_format_clear($(this).val());
        $('.js-yd-s-range').slider('option', 'value', value);
        $('.js-yd-d-range').slider('option', 'value', get_yandex_days(value));
        block_button();
    });


    /* Yandex Период */
    $('.js-yd-d-range').slider({
        range: 'min',
        min: yandex_days_min,
        max: yandex_days_max,
        value: yandex_days_value,
        step: 1,
        slide: function (event, ui) {
            $('.js-yd-d-input').val(number_format(ui.value));
            $('.js-yd-s-range').slider('option', 'value', get_yandex_summ(ui.value));
            block_button();
        },
        change: function (event, ui) {
            $('.js-yd-d-input').val(number_format(ui.value));
            block_button();
        }
    });

    $('.js-yd-d-input').val(number_format($('.js-yd-d-range').slider('value')));

    $('.js-yd-d-input').on('change blur', function () {
        var value = number_format_clear($(this).val());
        $('.js-yd-d-range').slider('option', 'value', value);
        $('.js-yd-s-range').slider('option', 'value', get_yandex_summ(value));
        block_button();
    });


    /* Google Сумма */
    $('.js-g-s-range').slider({
        range: 'min',
        min: google_summ_min,
        max: google_summ_max,
        value: google_summ_value,
        step: 5,
        slide: function (event, ui) {
            $('.js-g-s-input').val(number_format(ui.value));
            block_button();
        },
        change: function (event, ui) {
            $('.js-g-s-input').val(number_format(ui.value));
            block_button();
        }
    });

    $('.js-g-s-input').val(number_format($('.js-g-s-range').slider('value')));

    $('.js-g-s-input').on('change blur', function () {
        var value = number_format_clear($(this).val());
        $('.js-g-s-range').slider('option', 'value', value);
        block_button();
    });


    $('.js-integar-input').keypress(function (e) {
        if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
        block_button();
    });

    $('.js-integar-input').keyup(function (e) {
        if (e.which !== 37 && e.which !== 39) {
            $(this).val(number_format($(this).val()));
        }
        block_button();
    });

    $('.js-integar-input').focus(function () {
        remember=this.value;
        this.value='';
    });

    $('.js-integar-input').focusout(function () {
        if(this.value==="")
        {
            this.value=remember;
            remember=0;
        }
    });

    function get_yandex_days(summ) {
        return summ / (1.3 * averageSum);
    }

    function get_yandex_summ(days) {
        return days * 1.3 * averageSum;
    }

    function number_format(str) {
        return str.toString().replace(/(\s)+/g, '').replace(/(\d{1,3})(?=(?:\d{3})+$)/g, '$1 ');
    }

    function number_format_clear(str) {
        return str.replace(/ /g, '');
    }

    function block_button() {
        if ($("#google").val() === '0' && $("#yandex").val() === '0') {
            document.getElementById("bill").disabled = true;
            document.getElementById("msg_sum").className = 'msg_sum';
        }
        else {
            document.getElementById("bill").disabled = false;
            document.getElementById("msg_sum").className = 'msg_sum_hidden';
        }
    }

});

/**
 * Русификатор Form Validation
 */
jQuery.extend(jQuery.validator.messages, {
    required: "Обязательное поле",
    remote: "Исправьте это поле",
    email: "Некорректный e-mail",
    url: "Некорректный url",
    date: "Некорректная дата",
    dateISO: "Некорректная дата (ISO)",
    number: "Некорректное число",
    digits: "Cимволы 0-9",
    creditcard: "Некорректный номер карты",
    equalTo: "Не совпадает с предыдущим значением",
    accept: "Недопустимое расширение",
    maxlength: jQuery.validator.format("Максимум {0} символов"),
    minlength: jQuery.validator.format("Минимум {0} символов"),
    rangelength: jQuery.validator.format("Минимум {0} и максимумт {1} символов"),
    range: jQuery.validator.format("Допустимо знаечение между {0} и {1}"),
    max: jQuery.validator.format("Допустимо значение меньше или равное {0}"),
    min: jQuery.validator.format("Допустимо значение больше или равное {0}")
});