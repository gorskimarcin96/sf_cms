$(document).ready(function () {
    $(".cv-save").click(function () {
        $.post({
            url: $(this).data('url'),
            data: {data: $('#cv_cv').val()},
            success: () => $('#cv').attr('src', $('#cv').attr('src') + '?')
        });
    });

    $(".cv-revert").click(function () {
        $.get({
            url: $(this).data('url'),
            success: response => $('#cv_cv').val(response.data)
        });
    });
});
