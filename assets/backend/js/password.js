$(document).ready(function () {
    $(".show-password").click(function () {
        const button = $(this);
        const inputGroup = button.parent();
        const alerts = inputGroup.prev();
        const id = inputGroup.parent().parent().data('id');
        const field = button.prev();
        const passwordOutput = inputGroup.next();

        $.post({
            url: button.data('url'),
            data: {
                id,
                pin: field.val()
            },
            success: function (response) {
                passwordOutput.removeClass('d-none');
                passwordOutput.find(' input').val(response.password);
                inputGroup.remove();
            },
            error: function (response) {
                alerts.html(`<div class="alert alert-danger p-2 mb-1">${response.responseJSON.error}</div>`);

            }
        });
    });

    $(".copy-password").click(function () {
        const alerts = $(this).parent().prev();
        const password = $(this).prev().val();

        navigator.clipboard.writeText(password);
        alerts.html('<div class="alert alert-info p-2">Password is copied.</div>');
    });
})