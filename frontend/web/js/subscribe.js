$(document).ready(function() {
    $('.subscribe-panel').on('click', '.subscribe', function(){
        var link = $(this).parent();
        var id = link.attr('data-id');
        $.ajax({
            url: link.attr('data-url') ,
            type: "POST",
            data: {
                id:id
            },
            dataType: 'json', // Передаем ID нашей статьи
            success: function(result) {
                if (result.option == 'add'){
                    link.children().replaceWith('<button type="button" class="btn btn-success btn-lg unsubscribe_button subscribe">Подписаны </button>');
                } else if (result.option == 'delete'){
                    link.children().replaceWith('<button type="button" class="btn btn-info btn-lg subscribe">Подписаться </button>');
                }
            }
        });
    });
});