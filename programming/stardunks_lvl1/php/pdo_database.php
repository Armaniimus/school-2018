<?php

$servername = "localhost";
$dbname = "stardunks";
$username = "Stardunks";
$password = "";

function DB_connect() {
    global $servername, $dbname, $username, $password;

    return $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
}

function DB_ReadIntoAssoc($sql) {
    try {
        $conn = DB_connect();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $endRes = $stmt->fetchAll();

        // print_r($endRes[0]);
        // var_dump($endRes);
        $conn = null;
        return $endRes;
    }

    catch(PDOException $e) {
        $conn = null;
        return "Error: " . $e->getMessage();
    }
}

function GetCollumnNames($tablename) {
    try {
        $conn = DB_connect();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM $tablename");
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $endRes = $stmt->fetch();

        $conn = null;
    }

    catch(PDOException $e) {
        $conn = null;
        throw "Error: " . $e->getMessage();
        return false;
    }

    $data = [];
    $i = 0;
    foreach ($endRes as $key => $value) {
        $data[$i] = $key;
        $i++;
    }

    return $data;
}

function SelectWithCodeFromArray($array, $code) {
    $bC = str_split($code);
    $collN = []; // <--- is used to store the output data
    $y=0; // <--- is used to count in which position the next datapiece needs to go

    for ($i=0; $i<count($array); $i++) {
        if ($bC[$i] == 0) {

        }
        else if ($bC[$i] == 1) {
            $collN[$y] = $array[$i];
            $y++;
        }
        else if ($bC[$i] == 2) {
            //runs till the end of the array and writes everything inside the array
            for ($i=$i; $i<count($array); $i++) {
                $collN[$y] = $array[$i];
                $y++;
            }
        }
        else if ($bC[$i] == 3) {
            //runs till the end of the array and writes nothings
            for ($i=$i; $i<count($array); $i++) {

            }
        }
    }
    return $collN;
}

function InsertIntoDatabase($tableName, $inputColumnNames, $inputAssocArray) {

    ###
    # private functions InsertIntoDatabase function
    function Priv__ExtractData($inputColumnNames, $inputAssocArray) {
        // extract data from $inputAssocArray with provided columnNames
        $sqlAssocArray = array();
        for ($i=0; $i<count($inputColumnNames); $i++) {
            $sqlAssocArray[$i] = $inputAssocArray[$inputColumnNames[$i] ];
        }
        return $sqlAssocArray;
    }

    function Priv__TestIfEmpty($inputColumnNames, $sqlAssocArray) {
        // tests if all fields are filled
        $emptyTest = "true";
        for ($i=0; $i<count($inputColumnNames); $i++) {
            if ($sqlAssocArray[$i] == "") {
                $emptyTest = "false";
            }
        }
        return $emptyTest;
    }

    function Priv__GenerateSqlColumnNames($inputColumnNames) {
        //Generates $sqlColumnNames
        $sqlColumnNames = $inputColumnNames[0];
        for ($i=1; $i<count($inputColumnNames); $i++) {
            $sqlColumnNames .= "," . $inputColumnNames[$i];
        }
        return $sqlColumnNames;
    }

    function Priv__SetRecordData($sqlArray, $inputColumnNames) {
        //Adds datafields to records till the last datafield is reached
        $recordData = "'" . $sqlArray[0] . "'";
        for ($i=1; $i<count($inputColumnNames); $i++) {
            $recordData .= "," . "'" . $sqlArray[$i] . "'";
        }
        return $recordData;
    }

    function Priv__SetInsertQuery($tableName, $sqlColumnNames, $recordData) {
        //Combines $recordData, $tableName and $sqlColumnNames to create the SQL query
        $sql = "INSERT INTO $tableName ($sqlColumnNames)
        VALUES ($recordData)";

        return $sql;
    }

    ###
    # active code InsertIntoDatabase functionF

    // set numbered array and set $emptytest
    $sqlArray = Priv__ExtractData($inputColumnNames, $inputAssocArray);
    $emptyTest = Priv__TestIfEmpty($inputColumnNames, $sqlArray);

    //if tests where succesfull create sql query
    if ($emptyTest == 'true') {

        // set the SQL Query
        $sqlColumnNames = Priv__GenerateSqlColumnNames($inputColumnNames);
        $recordData = Priv__SetRecordData($sqlArray, $inputColumnNames);
        $sql = Priv__SetInsertQuery($tableName, $sqlColumnNames, $recordData);

        // try to add the record with pdo to the database
        try {
            $conn = DB_connect();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // use exec() because no results are returned
            $conn->exec($sql);
            $return = TRUE;

        } catch(PDOException $e) {
            /*enable line herunder for debugging*/
            $return = "?alert=" . $sql . "<br>" . $e->getMessage();
        }
        $conn = null;

    //if not all fields are returbn a getString that not all fields are filled
    } if ($emptyTest != 'true') {
        $return = "?alert=Fill in the whole form";
    }

    //return true or a $_GET string with the error;
    return $return;
}

function SimpleWhere($whereKey, $whereValue) {

    //where = this value
    $where = "$whereKey = '$whereValue'";
    return $where;
}

/***************************************
    F11; D:connect(); S(999)
    Status: 999 not tested
    FunctionDescription:
        creates a simple set statements
    Variables input:
        $setKeyColumn expects a string
        $setNewValue expects a string
*/
function updateSet($setKeyColumn, $setNewValue) {

    //creates the set statement
    $set = "$setKeyColumn = '$setNewValue'";
    return $set;
}

function DB_getResultCount($tableName) {
    $conn = DB_connect();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT count(*) FROM $tableName");
    $stmt->execute();

    $resultCount = $stmt->fetchColumn();

    // print_r($endRes[0]);
    // var_dump($endRes);
    $conn = null;
    return $resultCount;
}

function DB_Delete($tableName, $recordId, $recordUniqueIdentifier = "id") {

    $sql = "DELETE FROM $tableName WHERE $recordUniqueIdentifier=$recordId";
    try {
        $conn = DB_connect();

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // use exec() because no results are returned
        $conn->exec($sql);
        $return = TRUE;

    } catch(PDOException $e) {
        /*enable line herunder for debugging*/
        $return = "?alert=" . $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
}

?>
