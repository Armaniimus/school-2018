// Even heel snel zonder documentatie
function loadPage(href) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", href, false);
    xmlhttp.send();
    return xmlhttp.responseText;
}


function contentSwitch(href) {
    document.getElementById('main-content').innerHTML = loadPage("partials/" + href);
}
