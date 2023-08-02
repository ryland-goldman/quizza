$('.dropdown').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdown-menu').slideToggle(300);
    });
    $('.dropdown').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdown-menu').slideUp(300);
    });


$('.dropdown-menu li').click(function () {
  location.href = "https://" + $(this).parents('.dropdown').find('input').val() + ".quizza.org/";
}); 