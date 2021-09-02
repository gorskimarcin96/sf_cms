$(document).ready(function () {
    $(".cv-save").click(function () {
        $.post({
            url: $(this).data('url'),
            data: {data: CKEDITOR.instances['cv_cv'].getData()},
            success: function () {
                const src = $('#cv').attr('src');
                $('#cv').attr('src', src + '?');
            }
        });
    });

    $(".cv-revert").click(function () {
        $.get({
            url: $(this).data('url'),
            success: function (response) {
                CKEDITOR.instances['cv_cv'].setData(response.data);
            }
        });
    });
})