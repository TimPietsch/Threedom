jQuery(document).ready(function(){
    jQuery('.menu-section-header').on('click', function(){
        jQuery(this).next('.menu-section').slideToggle('fast');
    });
});