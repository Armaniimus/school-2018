<html>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <title>ass0003</title>
        <link rel="stylesheet" href="css/grid.css">
        <link rel="stylesheet" href="css/main.css">
        <!-- <link rel="stylesheet" href="css/font_awsome/fa-brands.min.css">
        <link rel="stylesheet" href="css/font_awsome/fa-regular.min.css">
        <link rel="stylesheet" href="css/font_awsome/fa-solid.min.css">
        <link rel="stylesheet" href="css/font_awsome/fontawesome.min.css"> -->
        <link rel="stylesheet" href="css/font_awsome/fontawesome-all.min.css">


    </head>
    <body>

    <?php
    // Font Awesome v. 4.6.
    include("font_awsome.php");
    // $icons[12];
    function fontAwsomeRondomizer($icons) {
        $fifteenDecimalsSums = [225, 15, 1];
        $fitheenDecimals = ["0","1","2","3","4","5","6","7","8","9","a","b","c","d","e"];

        while (true) {
            $random = rand(0, count($icons)-1);
            $testArray = [$random];

            //Set first search char
            $result = "f";

            //Set second search char
            $mathContainer = floor($random / $fifteenDecimalsSums[0]);
            $result .= $fitheenDecimals[$mathContainer];
            $random = ($random - $mathContainer*$fifteenDecimalsSums[0]);
            $testArray[1] = $mathContainer;

            //Set third search char
            $mathContainer = floor($random / $fifteenDecimalsSums[1]);
            $result .= $fitheenDecimals[$mathContainer];
            $random = ($random - $mathContainer*$fifteenDecimalsSums[1]);
            $testArray[2] = $mathContainer;

            //Set fourth search char
            $mathContainer = floor($random / $fifteenDecimalsSums[2]);
            $result .= $fitheenDecimals[$mathContainer];
            $random = ($random - $mathContainer*$fifteenDecimalsSums[2]);
            $testArray[3] = $mathContainer;


            $result2 = array_search("$result", $icons);

            if ($result2 != "") {
                return [$result, $result2, $testArray];
            }
        }
    }
    // print_r(fontAwsomeRondomizer($icons));

    function boxes($times, $icons) {
        $colomn = 1;
        $result = "";
        $colors = ["#1abc9c","#2ecc71","#3498db","#9b59b6","#34495e","#7f8c8d","#bdc3c7","#c0392b","#d35400","#f39c12","#8e44ad"];
        for ($i=0; $i<=$times; $i++) {
            $currentIcon = fontAwsomeRondomizer($icons);
            $y = $i;
            if ($y < count($colors)-1) {
                $color = $colors[$y];
            } else {
                for($y=$i; $y>count($colors)-1; $y-=count($colors)-1) {

                }
                $color = $colors[$y];
            }
            $result .= "<div class='box float col-12 col-m-6 col-la-4 col-h-3' style='background-color:$color'><i class='blackicon fa " . $currentIcon[1] . "'></i></div>";

        }
        return $result;
    }
    echo boxes(12, $icons);

    ?>

    </body>
</html>
