$(function(){
    $(window).scroll(function() {
        var top = $(document).scrollTop();
        if (top > 200) $('.floating').addClass('fixed'); //200 - это значение высоты прокрутки страницы для добавления класс
        else $('.floating').removeClass('fixed');
    });
});

$('.subscribe-panel').on('mouseover', '.unsubscribe_button', function(){
    $(this).attr('class', 'btn btn-danger btn-lg unsubscribe_button subscribe');
    $(this).text('Отписаться');
});

$('.subscribe-panel').on('mouseleave', '.unsubscribe_button', function(){
    $(this).attr('class', 'btn btn-success btn-lg unsubscribe_button subscribe');
    $(this).text('Подписаны');
});