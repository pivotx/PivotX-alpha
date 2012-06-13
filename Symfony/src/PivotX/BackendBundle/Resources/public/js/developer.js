
$(function(){
    $('table.developer .btn-group a').on('click', function(e){
        e.preventDefault();
        var show = $(this).attr('data-show');
        var el = $(this).closest('td').find('.'+show);

        if (el.is(':visible')) {
            $(this).closest('div').removeClass('on-row-active');
            $(this).closest('div').find('a').removeClass('active');
            $(this).closest('td').find('.toggles').hide();
            el.hide();
        }
        else {
            $(this).closest('div').addClass('on-row-active');
            $(this).closest('div').find('a').removeClass('active');
            $(this).addClass('active');
            $(this).closest('td').find('.toggles').hide();
            el.show();
        }
    });
});

$(window).load(function(){
    prettyPrint();
});
