const taxikosten = (function () {
    //singleton private shizzle
    let kilometers;

    const rekenEenheden = {
        gemiddeldeSnelheid: 60,
        prijsPerKM: 1,
        prijsPerMinuut: 0.25,
        prijsPerMinuutToeslag: 0.20,
        prijsToeslagWeekend: 0.15
    }

    const rit = {
        begin: 0,
        einde: 0,
        duur: 0
    }

    const kosten = {
        // BasisKosten
        km: 0,
        ritduur: 0,

        // toeslag kosten
        toeslag: {
            buitenKantoorUren: 0,
            weekend: 0
        },

        totaal: 0
    };

    function getData() {
        kilometers = document.getElementById('kilometers').value * 1;
        rit.begin = new Date(
            document.getElementById('begin-datum').value +
            " " +
            document.getElementById('begin-tijd').value
        );
    }

    function bereken() {
        // ritduur
        rit.duur = kilometers / rekenEenheden.gemiddeldeSnelheid * 60;
        rit.einde = new Date(rit.begin.getTime() + rit.duur * 60 * 1000) ;
        console.log(rit.einde)

        // kosten
        kosten.km = rekenEenheden.prijsPerKM * kilometers;
        kosten.ritduur = rit.duur * rekenEenheden.prijsPerMinuut;
        kosten.toeslag.buitenKantoorUren = berekenToeslagBuitenKantoorUren();
        kosten.toeslag.weekend = berekenToeslagWeekend();


        // totaal
        kosten.totaal = kosten.km +
            kosten.ritduur +
            kosten.toeslag.buitenKantoorUren +
            kosten.toeslag.weekend
        ;
    };

    function berekenToeslagBuitenKantoorUren() {
        kosten.toeslag.buitenKantoorUren = 0;
        let currentHour = new Date (rit.begin.getTime());

        for (let i = 0; i < rit.duur; i++) {
            if (currentHour.getHours() < 8 || currentHour.getHours() >= 18) {
                kosten.toeslag.buitenKantoorUren += rekenEenheden.prijsPerMinuutToeslag;

                currentHour = new Date(currentHour.getTime() + 60 * 1000);

                console.log(i)
                console.log(currentHour.getHours())
                console.log("toeslag totaal " + kosten.toeslag.buitenKantoorUren)
                console.log("toeslag per minuut " + rekenEenheden.prijsPerMinuutToeslag);
                console.log("")
            } else {
                console.log()
                currentHour = new Date(currentHour.getTime() + 60 * 1000);
            }
        }

        return kosten.toeslag.buitenKantoorUren;
    }

    function berekenToeslagWeekend() {
        kosten.toeslag.weekend = 0;
        let toeslag = false;
        let weekday = rit.begin.getDay();
        let uur = rit.begin.getHours();

        if (weekday == 0 || weekday == 6) {
            toeslag = true;
        }

        else if (weekday == 1 && uur < 7) {
            toeslag = true;
        }

        else if (weekday == 5 && uur >= 22) {
            toeslag = true;

        } else {
            toeslag = false;
        }

        if (toeslag == true) {
            kosten.toeslag.weekend += kosten.km;
            kosten.toeslag.weekend += kosten.ritduur;
            kosten.toeslag.weekend += kosten.toeslag.buitenKantoorUren;
            kosten.toeslag.weekend *= rekenEenheden.prijsToeslagWeekend;
        }
        return kosten.toeslag.weekend;
    }

    function printData() {
        // kilometer resultaten
        document.getElementById('result-kms').innerHTML = kilometers + "km";
        document.getElementById('result-prijs-per-km').innerHTML = rekenEenheden.prijsPerKM + "&euro;";
        document.getElementById('result-kilometer-totaal').innerHTML = kosten.km + "&euro;";

        // resultaten rit duur
        document.getElementById('result-gemiddelde-snelheid').innerHTML = rekenEenheden.gemiddeldeSnelheid + "km/h";
        document.getElementById('result-ritduur').innerHTML = rit.duur + "min";
        document.getElementById('result-ritduur-kosten').innerHTML = kosten.ritduur + "&euro;";
        document.getElementById('result-ritprijs-per-minuut').innerHTML = rekenEenheden.prijsPerMinuut + "&euro;";

        // resultaten toeslagen
        document.getElementById('result-toeslag-bijzonde-uren-per-minuut').innerHTML = rekenEenheden.prijsPerMinuutToeslag.toFixed(2) + "&euro;";
        document.getElementById('result-toeslag-bijzondere-uren').innerHTML = kosten.toeslag.buitenKantoorUren.toFixed(2) + "&euro;";

        document.getElementById('result-weekend-toeslag-%').innerHTML = (rekenEenheden.prijsToeslagWeekend * 100) + "%";
        document.getElementById('result-weekend-toeslag').innerHTML = kosten.toeslag.weekend.toFixed(2) + "&euro;";

        // resultaten Totaal
        document.getElementById('result-totaal').innerHTML = kosten.totaal.toFixed(2) + "&euro;";
    }

    // Public functions
    return {
        run: function() {
            console.log(document.getElementById('begin-datum').value);
            getData();
            bereken();

            toggleScreens();
            printData();
        },
    };
})();

function toggleScreens() {
    const invoer = document.getElementById('invoer-box');
    const result = document.getElementById('result-box');

    invoer.classList.toggle("hidden");
    result.classList.toggle("hidden");
};


(function setDefaultDateTime() {
    const dateNow = new Date(Date.now());
    const time = (function(dateNow) {
        let hours = dateNow.getHours().toString();
        let minutes = dateNow.getMinutes().toString();

        if (hours < 10) {
            hours = "0" + hours;
        }

        if (minutes < 10) {
            minutes = "0" + minutes;
        }

        return hours + ":" + minutes;
    })(dateNow);

    //set standard date
    document.getElementById('begin-datum').valueAsDate = dateNow;
    document.getElementById('begin-tijd').value = time;
})()



document.getElementById('nieuwe-berekening').addEventListener('click', toggleScreens);
document.getElementById('submit').addEventListener('click', taxikosten.run);
