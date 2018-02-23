<?php
// echo "<table style='border: solid 1px black;'>";
// echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";
//
// class TableRows extends RecursiveIteratorIterator {
//     function __construct($it) {
//         parent::__construct($it, self::LEAVES_ONLY);
//     }
//
//     function current() {
//         return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
//     }
//
//     function beginChildren() {
//         echo "<tr>";
//     }
//
//     function endChildren() {
//         echo "</tr>" . "\n";
//     }
// }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDBPFO";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // var_dump($stmt);
    // var_dump()
    // echo "<br />";
    // var_dump($stmt->fetchAll());
    // foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    //     echo $v;
    // }
    echo "<table border='1'>";

        echo "<thead>";
            foreach ($stmt as $key => $value) {
                echo "<tr>";
                    foreach ($value as $k => $v) {
                        echo "<th>" . $k . "</th>";
                    }
                echo "</tr>";
                break;
            }
        echo "</thead>";

        echo "<tbody>";
            foreach ($stmt as $key => $value) {
                echo "<tr>";
                    foreach ($value as $k => $v) {
                        echo "<td>" . $value[$k] . "</td>";
                    }
                echo "<tr>";
            }
        echo "</tbody>";

    echo "</table>";

    // foreach ($stmt->fetchAll() as $key => $value) {
    //     foreach ($value as $k => $v) {
    //         echo $value[$k] . " ";
    //
    //     }
    //     echo "<br />";
    // }

    // foreach ($stmt->fetchAll() as $k => $v) {
    //     echo "<pre>";
    //     var_dump($v);
    //     echo "</pre>";
    // }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
// echo "</table>";
?>
