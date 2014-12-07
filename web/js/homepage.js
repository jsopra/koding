$('document').ready(function() {
   $('.status-preview-button').on('click', function() {
       var el = $('.status-preview-holder');
       if (el.hasClass('hide')) {
           el.hide().removeClass('hide');
       }
       el.slideToggle();
   })
});
