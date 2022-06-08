(function ($) {

    // AJAX login
    $('form#login').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,
            data: {
                'action': 'ajax_login',
                'username': $('form#login #username').val(),
                'password': $('form#login #password').val(),
                'security': $('form#login #security').val(),
            },
            success: function (response) {
                form_errors('form#login', response);
                form_redirect(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    });

    // AJAX register
    $('form#register').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,
            data: {
                'action': 'ajax_register',
                'title': $('form#register #title').val(),
                'initial': $('form#register #initial').val(),
                'billing_phone': $('form#register #billing_phone').val(),
                'where': $('form#register #where').val(),
                'password': $('form#register #password').val(),
                'billing_country': $('form#register #billing_country').val(),
                'first_name': $('form#register #first_name').val(),
                'last_name': $('form#register #last_name').val(),
                'birth_day': $('form#register #birth_day').val(),
                'birth_month': $('form#register #birth_month').val(),
                'birth_year': $('form#register #birth_year').val(),
                'email': $('form#register #email').val(),
                'confirm_password': $('form#register #confirm_password').val(),
                'billing_address_1': $('form#register #billing_address_1').val(),
                'newsletter': $('form#register #newsletter').val(),
                'g_recaptcha_response': $('form#register #g-recaptcha-response').val(),
                'security': $('form#register #signonsecurity').val(),
            },
            success: function (response) {
                form_errors('form#register', response);
                form_redirect(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    });

    function form_errors(form, response) {
        let $form = $(form);
        $form.find('.input').removeClass('error');
        $form.find('.error_text').remove();

        if (response.errors && response.errors.length > 0) {
            $.each(response.errors, function (i) {
                let input_id = this.input_id,
                    input = $form.find('#' + input_id),
                    message = this.message;

                input.after('<span class="error_text">' + message + '</span>');
                input.parent('.input').addClass('error');
            });
        }
    }

    function form_redirect(response) {
        if (response.loggedin == true) {
            document.location.href = ajax_auth_object.redirecturl;
        }
    }

}(jQuery));