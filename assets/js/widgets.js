(function ($) {

    var a = 'active';

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
                $(this).find('input:first').prop('checked', true).addClass('changed');
            }
        });

        $('.filter').find('.changed').each(function(){
            $(this).change().removeClass('changed');
        });

        $this.addClass('hidden');
    });

}(jQuery));