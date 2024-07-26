const locale = $('html').attr('lang');
const currentTitle = document.title;

window.onblur = function () { document.title = (locale === 'pl' ? "Wróć do witryny | " : "Return to side | ") + currentTitle; }
window.onfocus = function () { document.title = currentTitle; }
