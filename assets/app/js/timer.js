const locale = $('html').attr('lang');

function timer() {
    let time = new Date();

    let second = '' + time.getSeconds();
    second = second.padStart(2, '0');
    let minute = '' + time.getMinutes();
    minute = minute.padStart(2, '0');
    let hour = '' + time.getHours();
    hour = hour.padStart(2, '0');

    document.getElementById("clock").innerHTML = " | " + hour + ":" + minute + ":" + second;
    if (second === '00' && minute === '00' && hour === '00') {
        dater();
    }
}

function dater() {
    let time = new Date();

    let day = time.getDate();
    let month = time.getMonth();
    let year = 1900 + time.getYear();

    const monthNamesPl = ['styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień'];
    const monthNamesEn = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

    document.getElementById("dater").innerHTML = day + " " + (locale === 'pl' ? monthNamesPl[month] : monthNamesEn[month]) + " " + year;
}

if (document.getElementById("dater")) {
    dater();
    setInterval(timer, 1000);
}
