window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');

if ($('#carousel').length) {
    const carousel = document.querySelector('#carousel');
    new bootstrap.Carousel(carousel, {
        interval: 2000,
        wrap: false
    });
}
