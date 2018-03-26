<?php
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

}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
