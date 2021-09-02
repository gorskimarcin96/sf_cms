import { Carousel } from 'bootstrap';

window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');

const carousel = document.querySelector('#carousel');
new bootstrap.Carousel(carousel, {
    interval: 2000,
    wrap: false
});
