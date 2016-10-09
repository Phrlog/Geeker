$('.answer').click(function (event) { // нажатие на кнопку - выпадает модальное окно
    event.preventDefault();

    var modalContainer = $('#my-modal');
    var modalBody = modalContainer.find('.modal-body');
    $('#my-modal').modal('show');
    var link = $(this);
    var id = link.attr('data-id');
    $.ajax({
        url: link.attr('data-url'),
        type: "POST",
        data: {
            id:id
        },
        success: function (data) {
            $('.modal-body').html(data);
            modalContainer.modal({show: true});
        }
    });
});

$(document).on("submit", '.signup-form', function (e) {
    e.preventDefault();

    var form = $(this);
    var formdata = false;
    if (window.FormData){
        formdata = new FormData(form[0]);
    }
    $.ajax({
        url: form.attr('data-url'),
        type: "POST",
        data:  formdata ? formdata : form.serialize(),
        contentType : false,
        processData: false,
        success: function (result) {
            console.log(result);
            var modalContainer = $('#my-modal');
            var modalBody = modalContainer.find('.modal-body');
            var insidemodalBody = modalContainer.find('.gb-user-form');

            if (result.status == 'Успех') {
                insidemodalBody.html(result).hide(); //
                //$('#my-modal').modal('hide');
                $('#success').html("<div class='alert alert-success'>");
                $('#success > .alert-success').append("<strong>Ваш твит отправлен.</strong>");
                $('#success > .alert-success').append('</div>');

                setTimeout(function () { // скрываем modal через 4 секунды
                    $("#my-modal").modal('hide');
                }, 4000);
            }
            else {
                modalBody.html(result).hide().fadeIn();
            }
        }
    });
});
