$('#new-review').submit(function (e) {
    e.preventDefault();
    $this = $(this);
    $.ajax({
        url: $this.attr('action'),
        method: $this.attr('method'),
        data: $this.serialize(),
        success: function (e) {
            $('.error').text(null);
            if (e.status == 'error') {
                for (error in e.errors) {
                    $('[name=' + error +']').siblings('.error').text(e.errors[error]);
                }
            } else {
                console.log(e);
                alert(e);
            }
        }
    })
});

$('#preview').click(function (e) {
    e.preventDefault();
    $this = $(this);
    $.ajax({
        url: '/preview',
        method: 'post',
        data: $('#new-review').serialize(),
        success: function (e) {
            let modal = $('#preview-window');
            modal.html(e.content);
        }
    });
    return false;

});