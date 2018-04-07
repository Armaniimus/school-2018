<?php

trait DataHandler_HelperMethods {
    /****
    ** description -> Gets critical tabledata
    ** relies on methods -> RunSqlQuery()

    ** Requires -> $tablename
    ** string variables -> $tablename
    ****/
    private function SetTableData($tablename) {
        // run Query
        $getDataQuery = "show Fields FROM $tablename";
        $queryRes = $this->RunSqlQuery($getDataQuery, 1);

        // Set variables
        for ($i=0; $i<count($queryRes); $i++) {
            $this->tableData[$tablename]["columnNames"][$i] = $queryRes[$i]["Field"];
            $this->tableData[$tablename]["typeValues"][$i] = $queryRes[$i]["Type"];
            $this->tableData[$tablename]["nullValues"][$i] = $queryRes[$i]["Null"];
        }
    }

    /****
    ** description -> run a pdo database query
    ** relies on methods -> Null

    ** Requires -> $sqlQuery $option
    ** string variables -> $sqlQuery
    ** int variables -> $option
    ****/
    private function RunSqlQuery($sqlQuery, $option = 0) {

        try {
            $localConn = $this->conn->prepare($sqlQuery);

            // run the query and return true or false for non read functions
            if ($option == 0 || $option == "create" || $option == "update" || $option == "delete") {
                if ( $localConn->execute() ) {
                    return TRUE;
                };

            // run the query
            } else {
                $localConn->execute();
            }

            // Get an associative array for the readFunctions
            if ($option == 1 || $option == "readAll") {
                $return = $localConn->fetchAll(PDO::FETCH_ASSOC);

            } else if ($option == 2 || $option == "readSingle") {
                $return = $localConn->fetch(PDO::FETCH_ASSOC);

            } else if ($option == 3|| $option == "readColumn") {
                $return = $localConn->fetchColumn();
            }
        }

        catch(PDOException $e) {
            throw new Exception("SQL: $sqlQuery ERROR: ". $e->getMessage() );
            $return = false;
        }

        return $return;
    }

    /****
    ** description -> Sets insert data for the create query or set data for the updateQuery
    ** relies on methods -> Null

    ** Requires -> $colNames_nrArr, $AssocArray, $option
    ** assocArray variables -> $AssocArray
    ** nrArray variables -> $colNames_nrArr
    ** int variables -> $option
    ****/
    private function SetRecordData_Assoc($colNames_nrArr, $AssocArray, $option) {

        // Generate Set part for the update
        if ($option == 0 || $option == 'update') {
            $recordData = $colNames_nrArr[0] . " = " . $AssocArray[$colNames_nrArr[0]];
            for ($i=1; $i < count($colNames_nrArr); $i++) {
                $recordData .= ", " . $colNames_nrArr[$i] . " = '" . $AssocArray[$colNames_nrArr[$i]] . "'";
            }
        }

        // Generate Values part for the update (not tested)
        else if ($option == 1 || $option == 'create') {
            $recordData = "'" . $AssocArray[$colNames_nrArr[0]] . "'";

            for ($i=1; $i < count($colNames_nrArr); $i++) {
                $recordData .= "," . "'" . $AssocArray[$colNames_nrArr[$i]] . "'";
            }
        }

        return $recordData;
    }

    /****
    ** description -> sets the column names for the SELECT or UPDATE part in a query
    ** relies on methods -> Null

    ** Requires -> $Nr_Arr_ColNames
    ** nrArray variables -> $Nr_Arr_ColNames
    ****/
    private function GenerateSqlColumnNames($Nr_Arr_ColNames) {
        //Generates $sqlColumnNames
        $sqlColumnNames = $Nr_Arr_ColNames[0];
        for ($i=1; $i<count($Nr_Arr_ColNames); $i++) {
            $sqlColumnNames .= "," . $Nr_Arr_ColNames[$i];
        }
        return $sqlColumnNames;
    }

    /****
    ** description -> Gets tableTypes from the database
    ** relies on methods -> SetTableData() SelectWithCodeFromArray()

    ** Requires -> $tablename, $option
    ** Optional -> $selectionCode -> used to select only certaint fields from the array
    ** string variables -> $tablename $selectionCode
    ** int variables -> $option
    **
    ** global variables -> tableData[$tablename][typeValues] -> this gets set by SetTableData if not set allready
    ****/
    public function GetTableTypes($tablename, $selectionCode = NULL) {
        if (!isset($this->tableData[$tablename]["typeValues"]) ) {
            $this->SetTableData($tablename);
        }
        $data = $this->tableData[$tablename]["typeValues"];

        if ($selectionCode !== NULL) {
            $data = $this->SelectWithCodeFromArray($data, $selectionCode);
        }

        return $data;
    }

    /****
    ** description -> Gets from the database what fields cannot be null
    ** relies on methods -> SetTableData() SelectWithCodeFromArray()

    ** Requires -> $tablename, $option
    ** Optional -> $selectionCode -> used to select only certaint fields from the array
    ** string variables -> $tablename $selectionCode
    ** int variables -> $option
    **
    ** global variables -> tableData[$tablename][typeValues] -> this gets set by SetTableData if not set allready
    ****/
    public function GetTableNullValues($tablename, $selectionCode = NULL) {
        if (!isset($this->tableData[$tablename]["nullValues"]) ) {
            $this->SetTableData($tablename);
        }

        $data = $this->tableData[$tablename]["nullValues"];

        if ($selectionCode !== NULL) {
            $data = $this->SelectWithCodeFromArray($data, $selectionCode);
        }

        return $data;
    }


    /****
    ** description -> Gets tableTypes from the database
    ** relies on methods -> SetTableData() SelectWithCodeFromArray()

    ** Requires -> $tablename, $option
    ** Optional -> $selectionCode -> used to select only certaint fields from the array
    ** string variables -> $tablename $selectionCode
    ** int variables -> $option
    **
    ** global variables -> tableData[$tablename][typeValues] -> this gets set by SetTableData if not set allready
    ****/
    public function GetColumnNames($tablename, $selectionCode = NULL, $force = NULL) {

        $columnNamesAreSet = !isset($this->tableData[$tablename]["columnNames"]);
        if ($columnNamesAreSet || $force == 1) {
            $this->SetTableData($tablename);
        }

        $columnNames = $this->tableData[$tablename]["columnNames"];

        if ($selectionCode !== NULL) {
            $columnNames = $this->SelectWithCodeFromArray($columnNames, $selectionCode);
        }

        return $columnNames;
    }
}

?>
