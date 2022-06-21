(function ($) {
    var a = 'active';

    // no skroll
    var block = $('<div>').css({'height': '50px', 'width': '50px'}),
        indicator = $('<div>').css({'height': '200px'});

    $('body').append(block.append(indicator));
    var w1 = $('div', block).innerWidth();
    block.css('overflow-y', 'scroll');
    var w2 = $('div', block).innerWidth();
    $(block).remove();

    var scrollbar = w1 - w2;

    $(':root').css('--scroll', scrollbar + 'px');

    // Select
    if ($('select').length) {
        $('select').not('.checkout #billing_country, .checkout #billing_state, .modal-billing #billing_state').knotSelect();
    }

    $(".select select").on({
        'focus': function () {
            $(this).parent('.select').addClass('active');
        },
        "blur": function () {
            $(this).parent('.select').removeClass('active');
        },
        "keyup": function (e) {
            if (e.keyCode == 27)
                $(this).parent('.select').addClass('active');
        }
    });

    // Currency click
    $(document).on('click', '.header_price_currency svg', function () {
        var e = $(this);

        if (!e.hasClass(a)) {
            e.addClass(a).siblings('svg').removeClass(a);

            var currency_name = e.attr('data-name'),
                currency = $('.header_price_bottom'),
                currency_class = currency.attr('class').split(' ');

            $.each(currency_class, function (key, value) {
                if (value.indexOf('icon-') >= 0) {
                    currency.removeClass(value).addClass('icon-' + currency_name);
                }
            });
        }
    })

    // Metal header select open
    $(document).on('click', function (event) {
        if (($(event.target).closest('.header .select').length === 0 && $(event.target).closest('.header_price_metal .curent').length === 0) || $('.header').hasClass(a)) {
            $('.header').removeClass(a);
        } else {
            $('.header').addClass(a);
        }
    });

    // Bar
    $('.header_burger').on('click', function () {
        $(this).toggleClass(a);
        $('.header').toggleClass('burger_active');
        $('.burger_wrapper').slideToggle();
        $('html').toggleClass('html-hidden');
    });

    // Slider
    $(document).ready(function () {
        if ($('.main_slider').length) {
            $('.main_slider').slick({
                arrows: true,
                dots: true,
                infinite: true,
                slidesToShow: 1,
                // autoplay: true,
                autoplaySpeed: 4000,
                pauseOnFocus: false,
                pauseOnHover: false,
                // fade: true,
                responsive: [
                    {
                        breakpoint: 0,
                        settings: {
                            arrows: false,
                        }
                    },
                ]
            });
        }
        ;

        if ($('.buy_name .active_slider').length) {
            $('.buy_name .active_slider').slick({
                arrows: false,
                dots: false,
                infinite: true,
                slidesToShow: 1,
                fade: true,
                asNavFor: '.buy_name .slider'
            });
        }
        ;

        if ($('.buy_name .slider').length) {
            $('.buy_name .slider').slick({
                arrows: true,
                dots: false,
                infinite: true,
                slidesToShow: 4,
                asNavFor: '.buy_name .active_slider'
            });
        }
        ;
    });

    var slidStart = 0;

    $(window).on('scroll', {passive: true}, function () {
        $(document).ready(function () {
            if (slidStart === 0) {
                if ($('.browse_slider').length) {
                    $('.browse_slider').slick({
                        arrows: true,
                        dots: false,
                        infinite: true,
                        slidesToShow: 3,
                        centerMode: true,
                        appendArrows: $('.browse_arrows')
                    });
                }
                ;

                if ($('.feetback_slider').length) {
                    $('.feetback_slider').slick({
                        arrows: true,
                        dots: false,
                        infinite: true,
                        slidesToShow: 1,
                        fade: true,
                        appendArrows: $('.feetback_arrows')
                    });
                }
                ;

                if ($('.stay_slider').length) {
                    $('.stay_slider').slick({
                        arrows: false,
                        dots: false,
                        infinite: true,
                        slidesToShow: 2,
                        centerMode: true,
                    });
                }
                ;

                slidStart++;
            }
        })
    })

    // Range
    if ($('.range').length) {
        $('.range').each(function () {
            var range = $(this),
                range_min = Number(range.attr('data-min')),
                range_max = Number(range.attr('data-max')),
                input = range.siblings('.range__inputs').find('.range__input'),
                input_min = range.siblings('.range__inputs').find('.range__input-min'),
                input_max = range.siblings('.range__inputs').find('.range__input-max');

            range.slider({
                min: range_min,
                max: range_max,
                values: [input_min.val(), input_max.val()],
                range: true,
                stop: function (event, ui) {
                    input_min.val(range.slider('values', 0));
                    input_max.val(range.slider('values', 1));
                },
                slide: function (event, ui) {
                    input_min.val(range.slider('values', 0));
                    input_max.val(range.slider('values', 1));
                }
            })

            $(document).on('blur focus change', $(input), function () {
                var value1 = Number(input_min.val());
                var value2 = Number(input_max.val());

                if (value2 > range_max) {
                    value2 = range_max;

                    input_max.val(value2)
                }

                if (parseInt(value1) > parseInt(value2)) {
                    value1 = value2;

                    input_min.val(value1);
                    input_max.val(value2);
                }

                range.slider('values', 0, value1);
                range.slider('values', 1, value2);
            });
        })
    }

    // Filter choice
    $(document).on('click', '.filter_choice .more_items', function () {
        $(this).parent().addClass('visible');
    })

    $(document).on('click', '.filter_label.icon-arrow', function () {
        $(this).toggleClass(a).siblings('ul').slideToggle();
    })

    // Dropdown
    $(document).on('click', '.dropdown li', function (event) {
        var e = $(this);

        if ($(event.target).closest('.dropdown li > div').length === 0) {
            if (!e.hasClass(a)) {
                e.addClass(a).find('div').slideDown();
                e.siblings().removeClass(a).children('div').slideUp();
            } else {
                e.removeClass(a).children('div').slideUp();
            }
        }
        ;
    })

    // Amount
    $(document).ready(function () {
        $(document).on('click', '.amount__subtract', function () {
            let e = $(this).parent().children('input'),
                val = e.val() - 1;

            if (val > 0) {
                e.val(val).change();
            }
        })

        $(document).on('click', '.amount__add', function () {
            let e = $(this).parent().children('input'),
                val = Number(e.val()) + 1;

            e.val(val).change();
        })

        $(document).on('blur keyup keydown', '.amount input', function (event) {
            if (event.keyCode == 40 || event.keyCode == 38 || event.keyCode == undefined) {
                if ($(this).val().length == 0 || $(this).val() < 0) {
                    $(this).val('0')
                }
            }
        })
    });

    // Radio info cheked
    function radio_cheked(e, speed) {
        var e = $(e),
            id = e.attr('data-checked');

        if (id && e.is(':checked')) {
            $('#' + id).slideDown(speed).siblings().slideUp(speed);
        }
    }

    $(document).ready(function () {
        $('input[data-checked]:checked').each(function () {
            radio_cheked(this, 0);
        })
    })

    $(document).on('click', 'input[data-checked]', function () {
        radio_cheked(this);
    })

    $('.checkout_form_tab').on('click', function () {
        let $this = $(this);

        if (!$this.hasClass(a)) {
            let tab_name = $this.data('tab'),
                tab = $('.step-' + tab_name),
                $active_tab_btn = $('.checkout_form_tab.active'),
                active_tab_name = $active_tab_btn.data('tab'),
                active_tab = $('.step-' + active_tab_name);

            $active_tab_btn.removeClass(a);
            $this.addClass(a);
            tab.slideDown();
            active_tab.slideUp();
        }
    });

    // Steps
    $(document).on('click', '.faq_tab', function () {
        steps(this, 'faq');
    });

    $(document).on('click', '.cabinet_content_tab', function () {
        steps(this, 'billing');
    });

    function steps(e, step_name, all) {
        var e = $(e),
            step = $('.step-' + step_name).eq(e.index());

        if (!e.hasClass(a)) {
            e.addClass(a).siblings().removeClass(a);
            step.slideDown().siblings('.step-' + step_name).slideUp();
        }
    }

    // Total price
    /*$(document).ready(function () {
        let price = Number($('.checkout_total_price').text().replace(/[^+\d\.]/g, ''));

        if (price >= 5000) {
            $('.checkout_total_left').addClass('icon icon-total');
        }
    })*/

    // Modal
    $(document).on('click', '.modal-link', function (e) {
        e.preventDefault();

        let $this = $(this),
            name = $this.data('modal-name'),
            modal = '.modal-' + name;

        $('.modal').removeClass(a);
        $(modal).addClass(a);

        $('html').addClass('html-hidden');
    });

    $(document).on('click', '.modal_viel, .modal .close, .modal .close-btn', function () {
        $(this).parents('.modal').removeClass(a);
        $('html').removeClass('html-hidden');
    })

    // Cabinet
    $(document).on('click', '.cabinet_order_toggle', function () {
        $(this).toggleClass(a)
            .siblings('.cabinet_order_table').slideToggle();
    })

    // Copied
    $(document).on('click', '.copy__href', function (event) {
        event.preventDefault();

        var e = $(this),
            link = e.attr('data-href'),
            domain = 'bullionbypost.co.uk/account/login/?referral_code=';

        if (link.indexOf('https://') === -1) {
            link = 'https://' + domain + link;
        }

        if (!$(this).find('.input_copied').length) {
            var input = $('<input class="input_copied"/>').val(link);
            input.css({
                'position': 'absolute',
                'left': '-9999px'
            });
            $(this).append(input);
        }

        input = $(this).find('.input_copied');
        $(input[0]).val(link)
        input[0].select();
        input[0].setSelectionRange(0, 99999)
        document.execCommand('copy');
    })

    // auto update cart
    $(document).on('change', '.lock .qty', function (e) {
        update_cart();
    });

    function update_cart() {
        let update_cart_btn = $('[name=update_cart]'),
            is_disabled = update_cart_btn.attr('aria-disabled');

        if (is_disabled === 'true') {
            setTimeout(update_cart, 250);
        } else {
            update_cart_btn.trigger('click');
        }
    }

    // Cart terms validation
    $(document).on('click', '.lock .checkout-button', function (e) {
        e.preventDefault();

        let terms = $('#terms'),
            terms_wrapper = $('.lock_gold'),
            url = $(this).attr('href');

        if (!terms.is(':checked')) {
            terms_wrapper.addClass('lock_gold_error');
        } else {
            terms_wrapper.removeClass('lock_gold_error');
            window.location.href = url;
        }

    });

    // Checkout submit form button role
    $('#place_order_btn').on('click', function () {
        $('#place_order').click();
    });

    // Tabs
    $(document).on('click', '[data-tabs]', function () {
        var e = $(this),
            tabs = e.attr('data-tabs'),
            tab = e.attr('data-tab'),
            step = '#' + tabs + '-' + tab;

        e.addClass(a).siblings().removeClass(a);

        if (tab == 'all') {
            $('[data-id=' + tabs + ']').slideDown();
        } else {
            $(step).slideDown().siblings().slideUp();
        }

    })

    // Advanced Real-Time Chart Widget
    new TradingView.widget({
        "autosize": true,
        //"width": 980,
        //"height": 610,
        "symbol": "NASDAQ:AAPL",
        "interval": "D",
        "timezone": "Etc/UTC",
        "theme": "light",
        "style": "1",
        "locale": "en",
        "toolbar_bg": "#f1f3f6",
        "enable_publishing": false,
        "allow_symbol_change": true,
        "save_image": false,
        "container_id": "tradingview_real_time_chart"
    });

    // Symbol Overview Widget
    new TradingView.MediumWidget({
        "symbols": [
            [
                "Apple",
                "AAPL|1D"
            ],
            [
                "Google",
                "GOOGL|1D"
            ],
            [
                "Microsoft",
                "MSFT|1D"
            ]
        ],
        "chartOnly": false,
        "width": "100%",
        "height": "100%",
        "locale": "en",
        "colorTheme": "light",
        "isTransparent": false,
        "autosize": false,
        "showVolume": false,
        "hideDateRanges": false,
        "scalePosition": "right",
        "scaleMode": "Normal",
        "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
        "noTimeScale": false,
        "valuesTracking": "1",
        "chartType": "line",
        "fontColor": "#787b86",
        "gridLineColor": "rgba(42, 46, 57, 0.06)",
        "container_id": "tradingview_symbol_overview"
    });

    // Filters
    $(document).on('change', '.filter_input', function (e) {

        let field_name = $(this).attr('name'),
            field_value = $(this).val(),
            realtime_chart_data = {
                "width": 980,
                "height": 610,
                "symbol": "NASDAQ:AAPL",
                "timezone": "Etc/UTC",
                "theme": "light",
                "style": "1",
                "locale": "en",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "allow_symbol_change": true,
                "save_image": false,
                "container_id": "tradingview_real_time_chart"
            }

        if (field_name === 'period') {
            realtime_chart_data.range = field_value;
            $('#tradingview_33cdd').html();
            new TradingView.widget(realtime_chart_data);
        } else if (field_name === 'currency') {

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_object.ajaxurl,
                data: {
                    'action': 'live_price_filter',
                    'currency': field_value,
                    'weight': $('[name=weight]:checked').val()
                },
                success: function (response) {
                    $('.top_live_content_steps').replaceWith(response.live_content_steps_html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            });
        } else if (field_name === 'weight') {

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_object.ajaxurl,
                data: {
                    'action': 'live_price_filter',
                    'weight': field_value,
                    'currency': $('[name=currency]:checked').val()
                },
                success: function (response) {
                    $('.top_live_content_steps').replaceWith(response.live_content_steps_html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            });
        }

        $('.filter_clear').removeClass('hidden');

    });

    // Clear Filters
    $(document).on('click', '.filter_clear', function () {
        let $this = $(this);

        $('.filter_block').each(function () {
            if (!$(this).find('input:first').is(':checked')) {
                $(this).find('input').prop('checked', false);
                $(this).find('input:first').prop('checked', true).change();
            }
        });

        $this.addClass('hidden');
    });

    // Cart Payment method change
    $(document).on('change', '#cart-payment-form [name=payment_method]', function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_object.ajaxurl,
            data: {
                'action': 'suissevault_payment_method',
                'payment_method': $('input[name=payment_method]:checked').val(),
                'security': $('#payment-security').val(),
            },
            success: function (response) {

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    });

    // Cart Delivery method change
    $(document).on('change', '#cart-delivery-form [name=delivery_method], select[name="shipping"]', function () {
        let delivery_method = $('input[name=delivery_method]:checked').val(),
            data = {
                'action': 'suissevault_delivery_method',
                'delivery_method': delivery_method,
                'security': $('#delivery-security').val(),
            };

        if (delivery_method === 'shipping') {
            data.shipping_method = $('select[name="shipping"]').val();
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_object.ajaxurl,
            data: data,
            success: function (response) {

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    });

}(jQuery));