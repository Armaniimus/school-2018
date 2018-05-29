<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="master.css">
    <link rel="stylesheet" href="grid-v1.2.css">
</head>
<body>

<div class="header">
  <h1>Chania</h1>
</div>

<div class="row">
    <div class="col-xs-3 float">
        <a href="https://placeholder.com"><img src="http://via.placeholder.com/234x60"></a>
    </div>
    <div class="col-xs-12 col-s-9 float menu">
        <ul class="col-xs-12 col-s-6 float-r">
            <li class="col-xs-12 col-s-3 float" onclick="contentSwitch('flight.html')">The Flight</li>
            <li class="col-xs-12 col-s-3 float" onclick="contentSwitch('city.html')">The City</li>
            <li class="col-xs-12 col-s-3 float" onclick="contentSwitch('island.html')">The Island</li>
            <li class="col-xs-12 col-s-3 float" onclick="contentSwitch('food.html')">The Food</li>
        </ul>
    </div>

</div>

<div class="row">

    <!-- <div class="col-s-3 float menu">
        <ul>
            <li onclick="contentSwitch('flight.html')">The Flight</li>
            <li onclick="contentSwitch('city.html')">The City</li>
            <li onclick="contentSwitch('island.html')">The Island</li>
            <li onclick="contentSwitch('food.html')">The Food</li>
        </ul>
    </div> -->

    <div class="col-xs-12 col-s-9 float" id="main-content"></div>

    <div class="col-xs-12 col-s-3 float right">
        <div class="aside">
            <h2>What?</h2>
            <p>Chania is a city on the island of Crete.</p>
            <h2>Where?</h2>
            <p>Crete is a Greek island in the Mediterranean Sea.</p>
            <h2>How?</h2>
            <p>You can reach Chania airport from all over Europe.</p>
        </div>
    </div>
</div>

<div class="footer">
    <p>Resize the browser window to see how the content respond to the resizing.</p>
</div>

<script src="javascript.js"></script>

<script>
    contentSwitch('city.html');
</script>

</body>
</html>
