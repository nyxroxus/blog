jQuery.noConflict()
jQuery(document).ready(function(){
    (function($){
    $('#wd-click').click(function(){
        $('#wd-info').slideToggle();
    });
    })(jQuery);
});
