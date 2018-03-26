<?php

    class DataHandler {
        private $conn;
        public $error;
        public $lastInsertedID;

        public function __construct($dbName, $username, $pass, $serverAdress, $dbType) {
            $this->conn = new PDO("$dbType:host=$serverAdress;dbname=$dbName", $username, $pass);

            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function __destruct() {
            $this->conn = NULL;
            $this->error = NULL;
            $this->lastInsertedID = NULL;
        }

        ###################
        # basic operations
        ###################
            public function SetCreateQuery($tableName, $inputColumnNames, $inputAssocArray) {

                // generate comma Seperated ColumnNames
                $sqlColumnNames = $this->GenerateSqlColumnNames($inputColumnNames);

                // generate Create record Data
                $recordData = $this->SetRecordData_Assoc($inputColumnNames, $inputAssocArray, 1);

                // Combines $recordData, $tableName and $sqlColumnNames to create the SQL query
                $sql = "INSERT INTO $tableName ($sqlColumnNames)
                VALUES ($recordData)";

                return $sql;
            }

            // supply $sqlQuery or ($tablename + $inputColumnNames + $inputAssocArray);
            public function CreateData($createQuery = NULL, $tableName = NULL, $inputColumnNames = NULL, $inputAssocArray = NULL) {
                // set the SQL Query if it isnt set
                if ($createQuery == NULL) {
                    $createQuery = $this->SetCreateQuery($tableName, $inputColumnNames, $inputAssocArray);
                }

                // try to add the record with pdo to the database
                $result = $this->RunSqlQuery($createQuery);

                // Set lastInsertedID
                if ($result) {
                    $this->lastInsertedID = $this->conn->lastInsertId();
                }
            }

            public function ReadData($readQuery) {
                return $this->RunSqlQuery($readQuery, 1);
            }

            public function ReadSingleData($readQuery) {
                return $this->RunSqlQuery($readQuery, 2);
            }

            public function SetUpdateQuery($tablename, $AssocArray, $idValue = NULL, $idName = NULL) {

                # collumnNames collection + idName and Value collection;
                    // get the $columNames;
                    $columnNames = $this->GetColumnNames($tablename);

                    // set idName if not supplied
                    if ($idName == NULL) {
                        $idName = $columnNames[0];
                    }

                    // set idValue if not supplied
                    if ($idValue == NULL) {
                        $idValue = $AssocArray[$idName];
                    }

                    // select the columnNames
                    $columnNames = $this->SelectWithCodeFromArray($columnNames, "02");
                # end of collumnNames collection + idName and Value collection

                // validate the ID and throw an error if appropiate
                $this->TestValid_ID($idValue, "SetUpdateQuery");

                // collect the set part for the Query
                $set = $this->SetRecordData_Assoc($columnNames, $AssocArray, 0);

                // set updateQuery
                $updateQuery = "UPDATE $tablename
                SET $set
                WHERE $idName = " . $idValue;

                return $updateQuery;
            }

            // requires ($updateQuery) or ($tableName + $AssocArray + $idValue + $idName)
            public function UpdateData($updateQuery = NULL, $tableName = NULL, $AssocArray = NULL, $idValue = NULL, $idName = "id") {

                if ($updateQuery == NULL) {
                    $updateQuery = $this->SetUpdateQuery($tablename, $AssocArray, $idValue, $idName);
                }

                // run updateQuery
                $result = $this->RunSqlQuery($updateQuery);

                if ($result && $idValue != NULL) {
                    $this->lastInsertedID = $idValue;
                }
            }

            // requires every parameter
            public function SetDeleteQuery($tablename, $idName, $idValue) {

                // Test if a valid id is provided and throw an error if appropiate
                $this->TestValid_ID($idValue, "SetDeleteQuery");

                // set $deleteQuery
                $deleteQuery =
                "DELETE
                FROM $tablename
                WHERE $idName = $idValue";

                return $deleteQuery;
            }

            // requires ($deleteQuery) or ($tablename + $idName + $idValue)
            public function DeleteData($deleteQuery = NULL, $tablename = NULL, $idName = NULL, $idValue = NULL) {

                if ($deleteQuery == NULL) {
                    $deleteQuery = $this->SetDeleteQuery($tablename, $idName, $idValue);
                }

                $this->RunSqlQuery($deleteQuery);
            }
        #### end of basic operations

        ##################
        # HelperFunctions
        ##################

            // returns a 2dimensional assoc array
            public function GetColumnNames($tablename) {
                try {
                    $localConn = $this->conn->prepare("SELECT * FROM $tablename LIMIT 0, 1");
                    $localConn->execute();
                    $queryRes = $localConn->fetch(PDO::FETCH_ASSOC);

                } catch(PDOException $e) {
                    throw new Exception("TABLENAME: $tablename ERROR: ". $e->getMessage() );
                }

                $data = [];
                $i = 0;
                foreach ($queryRes as $key => $value) {
                    $data[$i] = $key;
                    $i++;
                }

                return $data;
            }

            public function SelectWithCodeFromArray($array, $code) {
                $splittedCode = str_split($code);
                $return = []; // <--- is used to store the output data
                $y=0; // <--- is used to count in which position the next datapiece needs to go

                for ($i=0; $i<count($array); $i++) {
                    if ($splittedCode[$i] == 0) {

                    }
                    else if ($splittedCode[$i] == 1) {
                        $return[$y] = $array[$i];
                        $y++;
                    }
                    else if ($splittedCode[$i] == 2) {
                        //runs till the end of the array and writes everything inside the array
                        for ($i=$i; $i<count($array); $i++) {
                            $return[$y] = $array[$i];
                            $y++;
                        }
                    }
                    else if ($splittedCode[$i] == 3) {
                        //runs till the end of the array and writes nothings
                        for ($i=$i; $i<count($array); $i++) {

                        }
                    }
                }
                return $return;
            }

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

            /* extract only specified data from the assoc array
            ** and convert assoc array to Numb array */
            private function ExtractData($inputColumnNames, $inputAssocArray) {
                $sqlNumberedArray = [];
                for ($i=0; $i<count($inputColumnNames); $i++) {
                    $sqlNumberedArray[$i] = $inputAssocArray[$inputColumnNames[$i] ];
                }
                return $sqlNumberedArray;
            }

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

            private function GenerateSqlColumnNames($Nr_Arr_ColNames) {
                //Generates $sqlColumnNames
                $sqlColumnNames = $Nr_Arr_ColNames[0];
                for ($i=1; $i<count($Nr_Arr_ColNames); $i++) {
                    $sqlColumnNames .= "," . $Nr_Arr_ColNames[$i];
                }
                return $sqlColumnNames;
            }
        #### end of HelperFunctions

        ########################
        # validation operations
        ########################
            private function TestValid_ID($idValue, $Method = NULL) {

                // run tests and set return message if needed
                if ($idValue == "" || $idValue == NULL) {
                    $message = "ID does not have a value";
                    $return = FALSE;

                } else if ( (is_numeric($idValue) == FALSE) ) {
                    $message = "ID is not a number";
                    $return = FALSE;

                } else if ( (floor($idValue) == $idValue) == FALSE) {
                    $message = "ID is not an INT";
                    $return = FALSE;

                } else if ( ($idValue >= 0) == FALSE) {
                    $message = "ID is a negative number";
                    $return = FALSE;

                } else {
                    $return = TRUE;
                }

                // Test if the result was succesfull
                if ($return == FALSE) {
                    throw new Exception("ERROR->[Invalid ID] MESSAGE->[$message] IDVALUE->[$idValue] METHOD->[$Method]");
                    return FALSE;

                } else {
                    return TRUE;
                }

            }
        #### end of validation operations

        ######################
        # Other operations
        ######################
            public function CountDataResults($tablename, $where = "") {
                $SearchQuery = "SELECT " . "count" . "(*) FROM $tablename $where";
                return $this->RunSqlQuery($SearchQuery, 3);
            }

            // requires numbered arrays
            public function SetSearchWhere($whereData, $tablename = NULL, $columnNames = NULL, $option = 1) {

                // get columnNames based on $tablename or $columNames
                if ($columnNames === NULL || !empty($tablename) ) {
                    $columnNames = $this->GetColumnNames($tablename);
                } else {
                    throw new Exception("No Useable parameters given");
                }

                $where = "";
                for ($i=0; $i<count($columnNames); $i++) {
                    if ($option == 0) {
                        $whereDataLoop = $whereData[$i];

                    } else if ($option == 1) {
                        $whereDataLoop = $whereData;

                    } else {
                        throw new Exception("wrong option selected in SetCreateWhere");
                    }

                    //if there is no data inside $selectdata then add nothing to the where statement.
                    if ($whereDataLoop == "") {

                    //else if there is Data inside $selectdata but no where statement yet then
                    //(set the where statement and add the first condition)
                    } else if ($whereDataLoop <> "" && $where == "") {
                        $where = " WHERE " . $columnNames[$i] . ' LIKE "%' . $whereDataLoop . '%"';

                    //else if there is data and an already existing where statement
                    } else {
                        $where .= " OR " . $columnNames[$i] . ' LIKE "%' . $whereDataLoop . '%"';
                    }
                }
                return $where;
            }

            // $tablename requires a string
            // $wheredate requires a numbered array
            // $columnNames requires a numbered array but is optional
            public function SetSearchQuery($tablename, $whereData, $limit, $columnNames = NULL, $where = NULL) {

                if ($columnNames == NULL) {
                    $columnNames = $this->GetColumnNames($tablename);
                }

                if ($where == NULL) {
                    $where = $this->SetSearchWhere($whereData, $tablename, $columnNames, 1);
                }

                $selectColNames = $this->GenerateSqlColumnNames($columnNames);

                $sql = "SELECT $selectColNames
                FROM $tablename
                $where
                $limit";

                return $sql;
            }

            public function createPagination($tablename, $resAmountPerPage, $where = "", $optional = "") {
                $totalItems = $this->CountDataResults($tablename, $where);

                $restItems = $totalItems % $resAmountPerPage;
                $totalPagination = floor($totalItems / $resAmountPerPage);

                if ($restItems > 0) {
                    $totalPagination++;
                }

                // generateTable
                $table = "<table><tr>";
                for ($i=1; $i <= $totalPagination; $i++) {
                    $table .= "<td> <a href='index.php?page=$i" . $optional . "'>$i</a> </td>";
                }
                $table .= "</tr></table>";

                return $table;
            }
        #### end of other operations
    }
 ?>
