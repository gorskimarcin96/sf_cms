$(".phone-number").on("click", function () {
    const current = $(this);
    $.get(route_phone_number, function (data) {
        current.text(data.phone_number);
    });
});
