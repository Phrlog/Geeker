$(document).ready(function() {
    $(".like").click(function() {
        var link = $(this);
        var id = link.attr('data-id');
        $.ajax({
            url: link.attr('data-url') ,
            type: "POST",
            data: {
                id:id
            },
            dataType: 'json', // Передаем ID нашей статьи
            success: function(result) {
                $('#'+ id).children('span').text(result.count);
                if (result.option == 'add'){
                    $('#'+ id).children('button').children('i').addClass('like');
                } else if (result.option == 'delete'){
                    $('#'+ id).children('button').children('i').removeClass('like');
                }
            }
        });
    });
});