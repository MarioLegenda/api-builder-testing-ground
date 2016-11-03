$(document).ready(function() {
    $('.item-title').click(function(evn) {
        evn.preventDefault();

        var showHide = $(this).next();

        if (showHide.hasClass('hide')) {
            showHide.removeClass('hide');
            showHide.addClass('show');
        } else if (showHide.hasClass('show')) {
            showHide.removeClass('show');
            showHide.addClass('hide');
        }

        return false;
    });
});