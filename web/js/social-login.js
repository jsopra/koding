(function($) {
    
    $('[data-social-login]').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        $('a.auth-link.' + $this.data('social-name')).trigger('click');
    });
    
})(jQuery);