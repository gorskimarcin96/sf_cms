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

    $("#rand_password").click(function () {
        const password = generatePassword(
            $("#password_length").val(),
            $("#az").prop('checked'),
            $("#AZ").prop('checked'),
            $("#numbers").prop('checked'),
            $("#special_chars").prop('checked'),
        );

        $("#Password_password").val(password);
    });

    function generatePassword(passwordLength = 10, lower = true, upper = true, number = true, special = true) {
        const lowerChars = "abcdefghijklmnopqrstuvwxyz";
        const upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const numberChars = "0123456789";
        const specialChars = "!@#$%^&*?()[]<>";
        let allChars =
            + (lower ? lowerChars : '')
            + (upper ? upperChars : '')
            + (number ? numberChars : '')
            + (special ? specialChars : '');

        let password = '';

        for (let i = 1; i <= passwordLength; i++) {
            const char = Math.floor(Math.random()
                * allChars.length + 1);

            password += allChars.charAt(char)
        }

        return password;
    }
})