$(function () {
    $('#short-url').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                $('.alert-success').html('Short url successfully created <a href="'+ data +'">'+ data +'</a>').show()
                $('.alert-danger').hide()
            },
            error: function (jqXHR, exception) {
                let err = JSON.parse(jqXHR.responseText)

                $('.alert-danger').html(err.message).show()
                $('.alert-success').hide()
            }
        });
    });

    $('.datepicker').datepicker();
})

