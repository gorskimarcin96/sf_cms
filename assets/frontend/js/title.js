const currentTitle = document.title;

window.onblur = function () { document.title = "Wróć do witryny | " + currentTitle; }
window.onfocus = function () { document.title = currentTitle; }