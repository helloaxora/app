$(document).ready(function () {
    $("#date").on("click", "#search", function () {

        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url_path+"/css/styles/js/table.php",
            data: ({
                type: "search", campaign: $("#campaign").val(), currency: $("#currency").val(),
                numberOfDays: $("#numberOfDays").val(), period: $("#period").val()
            }),
            success: function (data) {
                searchSuccess(data)
            }
        });
    });

    $("#stat-section").on("click", "#search_section1,#search_section2,#search_section3", function () {

        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url_path+"/css/styles/js/table.php",
            data: ({
                type: "search", campaign: $("#campaign").val(), currency: $("#currency").val(),
                numberOfDays: $("#numberOfDays").val(), period: $("#period").val()
            }),
            success: function (data) {
                searchSuccess(data)
            }
        });
    });

    function searchSuccess(data) {
        var responsedata = $.parseJSON(data);
        document.getElementById("table").innerHTML = responsedata.table;
        document.getElementById("search").className = "search-context-link is-active";
        document.getElementById("context").className = "search-context-link";
        document.getElementById("search_section1").className = "search-context-link is-active";
        document.getElementById("search_section2").className = "search-context-link is-active";
        document.getElementById("search_section3").className = "search-context-link is-active";
        document.getElementById("context_section1").className = "search-context-link";
        document.getElementById("context_section2").className = "search-context-link";
        document.getElementById("context_section3").className = "search-context-link";

        document.getElementById("shows").innerHTML = responsedata.stat.shows;
        document.getElementById("clicks").innerHTML = responsedata.stat.clicks;
        document.getElementById("ctr").innerHTML = responsedata.stat.ctr;
        document.getElementById("avPrice").innerHTML = responsedata.stat.avPrice;
        document.getElementById("sum").innerHTML = responsedata.stat.sum;

        $("#type").val("search");
    }

    $("#date").on("click", "#context", function () {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url_path+"/css/styles/js/table.php",
            data: ({
                type: "context", campaign: $("#campaign").val(), currency: $("#currency").val(),
                numberOfDays: $("#numberOfDays").val(), period: $("#period").val()
            }),
            success: function (data) {
                contextSuccess(data)
            }
        });
    });

    $("#stat-section").on("click", "#context_section1,#context_section2,#context_section3", function () {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url_path+"/css/styles/js/table.php",
            data: ({
                type: "context", campaign: $("#campaign").val(), currency: $("#currency").val(),
                numberOfDays: $("#numberOfDays").val(), period: $("#period").val()
            }),
            success: function (data) {
                contextSuccess(data)
            }
        });
    });

    function contextSuccess(data) {

        var responsedata = $.parseJSON(data);

        document.getElementById("table").innerHTML = responsedata.table;

        document.getElementById("search").className = "search-context-link";
        document.getElementById("context").className = "search-context-link is-active";
        document.getElementById("search_section1").className = "search-context-link";
        document.getElementById("search_section2").className = "search-context-link";
        document.getElementById("search_section3").className = "search-context-link";

        document.getElementById("context_section1").className = "search-context-link is-active";
        document.getElementById("context_section2").className = "search-context-link is-active";
        document.getElementById("context_section3").className = "search-context-link is-active";

        document.getElementById("shows").innerHTML = responsedata.stat.shows;
        document.getElementById("clicks").innerHTML = responsedata.stat.clicks;
        document.getElementById("ctr").innerHTML = responsedata.stat.ctr;
        document.getElementById("avPrice").innerHTML = responsedata.stat.avPrice;
        document.getElementById("sum").innerHTML = responsedata.stat.sum;

        $("#type").val("context");
    }


    $("#stat_section").on("click", "#month", function () {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url_path+"/css/styles/js/statistics_section.php",
            data: ({
                campaign: $("#campaign").val(), currency: $("#currency").val(), period: "month",
                type: $("#type").val()
            }),
            success: function (data) {
                var responsedata = $.parseJSON(data);
                document.getElementById("shows").innerHTML = responsedata.shows;
                document.getElementById("clicks").innerHTML = responsedata.clicks;
                document.getElementById("ctr").innerHTML = responsedata.ctr;
                document.getElementById("avPrice").innerHTML = responsedata.avPrice;
                document.getElementById("sum").innerHTML = responsedata.sum;

                document.getElementById("day").className = "period-select-block__nav-link";
                document.getElementById("week").className = "period-select-block__nav-link";
                document.getElementById("month").className = "period-select-block__nav-link is-active";

                document.getElementById("period_day").className = "campaign-main-statistics-table__title hide";
                document.getElementById("period_week").className = "campaign-main-statistics-table__title hide";
                document.getElementById("period_month").className = "campaign-main-statistics-table__title";

                $("#period").val("month");
            }
        });
    });

    $("#stat_section").on("click", "#day", function () {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url_path+"/css/styles/js/statistics_section.php",
            data: ({
                campaign: $("#campaign").val(), currency: $("#currency").val(), period: "day",
                type: $("#type").val()
            }),
            success: function (data) {
                var responsedata = $.parseJSON(data);
                document.getElementById("shows").innerHTML = responsedata.shows;
                document.getElementById("clicks").innerHTML = responsedata.clicks;
                document.getElementById("ctr").innerHTML = responsedata.ctr;
                document.getElementById("avPrice").innerHTML = responsedata.avPrice;
                document.getElementById("sum").innerHTML = responsedata.sum;

                document.getElementById("day").className = "period-select-block__nav-link is-active";
                document.getElementById("week").className = "period-select-block__nav-link";
                document.getElementById("month").className = "period-select-block__nav-link";

                document.getElementById("period_day").className = "campaign-main-statistics-table__title";
                document.getElementById("period_week").className = "campaign-main-statistics-table__title hide";
                document.getElementById("period_month").className = "campaign-main-statistics-table__title hide";

                $("#period").val("day");
            }
        });
    });

    $("#stat_section").on("click", "#week", function () {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url_path+"/css/styles/js/statistics_section.php",
            data: ({
                campaign: $("#campaign").val(), currency: $("#currency").val(), period: "week",
                type: $("#type").val()
            }),
            success: function (data) {
                var responsedata = $.parseJSON(data);
                document.getElementById("shows").innerHTML = responsedata.shows;
                document.getElementById("clicks").innerHTML = responsedata.clicks;
                document.getElementById("ctr").innerHTML = responsedata.ctr;
                document.getElementById("avPrice").innerHTML = responsedata.avPrice;
                document.getElementById("sum").innerHTML = responsedata.sum;

                document.getElementById("day").className = "period-select-block__nav-link";
                document.getElementById("week").className = "period-select-block__nav-link is-active";
                document.getElementById("month").className = "period-select-block__nav-link";

                document.getElementById("period_day").className = "campaign-main-statistics-table__title hide";
                document.getElementById("period_week").className = "campaign-main-statistics-table__title";
                document.getElementById("period_month").className = "campaign-main-statistics-table__title hide";

                $("#period").val("week");
            }
        });
    });

    var partner;

    if (getParameterByName('p') == 131) {
        setCookie('partner', '131');
    }

    partner = getCookie('partner');

    if (partner == 131) {
        $('.js-phone').attr('href', 'tel:+375333134332').text('+375 33 313-43-32');
        $('.js-email').attr('href', 'mailto:sale@axora.by').text('sale@axora.by');
        $('.js-partner-input').val(partner);
    }

    /**
     * OWL Carousel
     * @see  http://owlgraphic.com/owlcarousel/
     */
    $('.ctx-4__slider').owlCarousel({
        singleItem: true,
        autoHeight: true,
        afterAction: function () {
            $('.js-result-nav-link').removeClass('is-active');
            $('.js-result-nav-item').eq(this.owl.currentItem).find('.js-result-nav-link').addClass('is-active');
        }
    });

    var slider_owl = $('.ctx-4__slider').data('owlCarousel');
    $('.js-result-nav-link').click(function (e) {
        e.preventDefault();
        slider_owl.goTo($(this).closest('.js-result-nav-item').index());
    });

    /**
     * FancyBox
     * @see  http://fancyapps.com/fancybox/
     */
    $('.js-popup-link').fancybox({
        padding: 0,
        wrapCSS: 'fancybox-popup'
    });

    $('.js-gallery-link').fancybox({
        padding: 0,
        wrapCSS: 'fancybox-gallery'
    });

    $('.js-fancy-img-link').fancybox({
        fitToView: false,
        wrapCSS: 'fancybox-img-gallery'
    });

    $('.js-fancy-link').fancybox();

    /**
     * Form Validation
     * @see  http://jqueryvalidation.org/validate/
     */
    $('.js-validation-form').each(function () {
        var $form = $(this);
        $form.validate();
    });

    $('.js-tab-menu-link').click(function (e) {
        e.preventDefault();
        var $current_link = $(this);
        if (!$current_link.hasClass('is-active')) {
            var $current_index = $current_link.closest('.js-tab-menu-item').index();
            var $tab = $current_link.closest('.js-tab');
            var $tab_item = $tab.find('.js-tab-item');
            var $tab_menu_links = $tab.find('.js-tab-menu-link');

            $tab_menu_links.removeClass('is-active');
            $current_link.addClass('is-active');

            $tab_item.hide();
            $tab_item.eq($current_index).fadeIn();
        }
    });

    var video = $('.js-video')[0];

    $('.js-video-link').click(function (e) {
        e.preventDefault();
        $(this).fadeOut();
        video.play();
    });

    $('.js-video-play-link').click(function (e) {
        e.preventDefault();
        $('.js-video-play-link').removeClass('is-active');
        $(this).addClass('is-active');
        $('.js-video-link').fadeOut();
        video.currentTime = $(this).data('time');
        video.play();
    });

    $('.side-panel-target').click(function (e) {
        e.preventDefault();
        $('html').addClass('is-panel-opened');
    });

    $('.side-panel__close').click(function (e) {
        e.preventDefault();
        $('html').removeClass('is-panel-opened');
    });

    $('.js-target-link').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({scrollTop: $($(this).attr('href')).offset().top}, 700);
    });

    $('.video-wrapper').click(function () {
        $(this).addClass('is-played');
        var iframe = $(this).find('iframe');
        iframe.attr('src', iframe.attr('src') + '?autoplay=1');
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