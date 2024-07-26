let animationOffer = false;

function offer() {
    const timeout = 1000;
    animationOffer = true;

    function elementDecoration(i, decoration = 'underline') {
        $("#offer ul>li:eq(" + i + ")").css('text-decoration-color', decoration);
    }

    let offerLength = $('#offer ul>li').length;
    for (let i = 0; i < offerLength; i++) {
        if (i > 0) {
            setTimeout(elementDecoration, timeout * i, i - 1, 'transparent');
        }
        setTimeout(elementDecoration, timeout * i, i, '#fff');
    }
    setTimeout(elementDecoration, timeout * offerLength, offerLength - 1, 'transparent');
    setTimeout(function () {
        animationOffer = false;
    }, timeout * (offerLength));
}

$(document).ready(function () {
    let articles = [];
    let articlesNumber = $('.article').length;
    for (let i = 0; i < articlesNumber; i++) {
        articles.push(document.getElementById("article_" + i));
    }

    $(window).scroll(function () {
        if ($(document).scrollTop() < 100) {
            $('.navbar-brand > img').css('width', '70px');
        } else {
            $('.navbar-brand > img').css('width', '60px');
        }

        for (let i = 0; i < articlesNumber; i++) {
            if ($(window).height() / 4 < articles[i].getBoundingClientRect().top) {
                $("#article_" + i).css('width', '100%');
            } else {
                $("#article_" + i).css('width', '95%');
            }
        }

        if (
            !animationOffer &&
            ($(window).height() / 4) < document.getElementById('offer').getBoundingClientRect().top
        ){
            offer();
         }
    });
});
