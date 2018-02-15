var landcodes = ["NL", "BE", "LU", "DU","FR"];
var btw = ["21%", "21%", "24%","19%","19.6%"];

document.getElementById('submit').addEventListener("click", getData)

function getData() {
    var hoeveelheid = document.getElementById('hoeveelheid').value
    var prijs = document.getElementById('prijs').value
    var landcode = document.getElementById('landcode').value

    runscript(hoeveelheid, prijs, landcode);
}

function korting(getal) {

    if (getal < 1000) {
    var korting = 1.03;
    }

    if (getal < 5000) {
    var korting = 1.03;
    }

    if (getal < 7000) {
    var korting = 1.03;
    }

    if (getal < 10000) {
    var korting = 1.03;
    }

    if (getal < 50000) {
    var korting = 1.03;
    }
    return(korting)
}

function Multiply(aantal, prijs) {
   return aantal * prijs;
}

function runscript(hoeveelheid, prijs, landcode) {
    var huidigGetal = Multiply(hoeveelheid, prijs);
    korting = korting(hoeveelheid)
    document.write(huidigGetal);
}
