$(document).ready(function() {
    var partner;

    if(getParameterByName('p') == 131) {
        setCookie('partner', '131');
    }

    partner = getCookie('partner');

    if(partner == 131){
        $('.js-phone').text('+375 33 313-43-32');
        $('.js-email').attr('href','mailto:sale@axora.by ').text('sale@axora.by');
        $('.js-partner-input').val(partner);
    }

    $('input, textarea').placeholder();

    $('form').each(function() {
        $(this).validate({
            errorElement: 'div'
        });
    });

    $('.order_call_link').on('click', function(e) {
        $('#order_call_block').slideToggle();
        e.preventDefault();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).hasClass('order_call_link') && $(e.target).parents('.order_call_link').length === 0 && !$(e.target).hasClass('order_call_block') && $(e.target).parents('.order_call_block').length === 0) {
            $('#order_call_block').slideUp();
        }
    });

    $('#services_link').on('click', function(e) {
        $('#popup_menu').slideToggle();
        e.preventDefault();
    });

    $('#popup_menu_close').on('click', function(e) {
        $('#popup_menu').slideUp();
        e.preventDefault();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).hasClass('services_link') && $(e.target).parents('.popup_menu').length === 0 && !$(e.target).hasClass('popup_menu')) {
            $('#popup_menu').slideUp();
        }
    });

    $('.seo_result:first-child').addClass('current');
    $('#another_result_link').on('click', function(e) {
        e.preventDefault();
        $('body,html').animate({'scrollTop':$('#works').offset().top});
        if ($('.seo_result').length > 1) {
            var cur = $('.seo_result.current');
            if (cur.next('.seo_result').length > 0) {
                $('.seo_result').removeClass('current');
                cur.next('.seo_result').addClass('current');
            } else {
                $('.seo_result').removeClass('current');
                $('.seo_result:first-child').addClass('current');
            }
        }
    });

    $('.context_case__tabs a').on('click', function(e) {
        e.preventDefault();
        $('.context_case__tabs a').removeClass('active');
        $(this).addClass('active');
        $('.context_case__content').hide();
        $($(this).attr('href')).show();
    });

    $('.works_cases__tabs a').on('click', function(e) {
        e.preventDefault();
        $('.works_cases__tabs a').removeClass('active');
        $(this).addClass('active');
        $('.work_case').hide();
        $($(this).attr('href')).show();
    });

    $('.next_case_link').on('click', function(e) {
        e.preventDefault();
        $('body,html').animate({'scrollTop':$('#works').offset().top});
        var active = $('.works_cases__tabs_link.active');
        $('.works_cases__tabs a').removeClass('active');
        if (active.next('.works_cases__tabs_link').length > 0) {
            active.next('.works_cases__tabs_link').addClass('active');
        } else {
            $('.works_cases__tabs_link').eq('.0').addClass('active');
        }
        $('.work_case').hide();
        $($('.works_cases__tabs_link.active').attr('href')).show();
    });
});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

jQuery.extend(jQuery.validator.messages, {
    required: "Это поле необходимо заполнить",
    remote: "Исправьте это поле чтобы продолжить",
    email: "Введите правильный email адрес.",
    url: "Введите верный URL.",
    date: "Введите правильную дату.",
    dateISO: "Введите правильную дату (ISO).",
    number: "Введите число.",
    digits: "Введите только цифры.",
    creditcard: "Введите правильный номер вашей кредитной карты.",
    equalTo: "Повторите ввод значения еще раз.",
    accept: "Пожалуйста, введите значение с правильным расширением.",
    maxlength: jQuery.format("Нельзя вводить более {0} символов."),
    minlength: jQuery.format("Должно быть не менее {0} символов."),
    rangelength: jQuery.format("Введите от {0} до {1} символов."),
    range: jQuery.format("Введите число от {0} до {1}."),
    max: jQuery.format("Введите число меньше или равное {0}."),
    min: jQuery.format("Введите число больше или равное {0}.")
});