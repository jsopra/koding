(function($) {

    $('[data-social-login]').on('click', function(e) {
        e.preventDefault();
        var url = $('a.auth-link.' + $(this).data('social-name')).attr('href');
        window.open(url, 'auth', "width=900, height=700");
    });

})(jQuery);
