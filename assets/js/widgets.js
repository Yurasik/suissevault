(function ($) {

    // Advanced Real-Time Chart Widget
    let TradingWidget = new TradingView.widget({
        //"autosize": true,
        "width": 980,
        "height": 610,
        "symbol": "NASDAQ:AAPL",
        //"interval": "D",
        "range": "3D",
        "timezone": "Etc/UTC",
        "theme": "light",
        "style": "1",
        "locale": "en",
        "toolbar_bg": "#f1f3f6",
        "enable_publishing": false,
        "allow_symbol_change": true,
        "save_image": false,
        "container_id": "tradingview_33cdd"
    });

    console.log(TradingWidget)

    $('.price-axis-currency-label-vSuZFrDG').click()

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
                "container_id": "tradingview_33cdd"
            }

        if ( field_name === 'period' ){
            if ( field_value === 'live' ) {
                realtime_chart_data.interval = "D";
            } else {
                realtime_chart_data.range = field_value;
            }

            $('#tradingview_33cdd').html();
            new TradingView.widget(realtime_chart_data);
        }

    })

}(jQuery));