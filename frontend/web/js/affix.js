$(function(){
    $(window).scroll(function() {
        var top = $(document).scrollTop();
        if (top > 200) $('.floating').addClass('fixed'); //200 - это значение высоты прокрутки страницы для добавления класс
        else $('.floating').removeClass('fixed');
    });
});

$('#subscribe_button').mouseover(function(){
    $(this).attr('class', 'btn btn-danger btn-lg');
    $(this).text('Отписаться');
});

$('#subscribe_button').mouseleave(function(){
    $(this).attr('class', 'btn btn-success btn-lg');
    $(this).text('Подписаны');
});