<?php

trait DataHandler_PrimaryMethods {
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

    public function SetUpdateQuery($tablename, $AssocArray, $idName = NULL, $idValue = NULL) {

        # collumnNames collection + idName and Value collection;
            // get the $columnNames;
            $columnNames = $this->GetColumnNames($tablename);

            // set idName if not supplied
            if ($idName == NULL) {
                echo "error1";
                $idName = $columnNames[0];
            }

            // set idValue if not supplied
            if ($idValue == NULL) {
                echo "error2";
                $idValue = $AssocArray[$idName];
            }

            // select the columnNames
            $columnNames = $this->SelectWithCodeFromArray($columnNames, "02");
        # end of collumnNames collection + idName and Value collection

        // validate the ID and throw an error if appropiate
        $this->ValidatePHP_ID($idValue, "SetUpdateQuery");

        // collect the set part for the Query
        $set = $this->SetRecordData_Assoc($columnNames, $AssocArray, 0);

        // set updateQuery
        $updateQuery = "UPDATE $tablename
        SET $set
        WHERE $idName = " . $idValue;

        return $updateQuery;
    }

    // requires ($updateQuery) or ($tableName + $AssocArray + $idValue + $idName)

    // string variables -> $updateQuery $tableName $idName
    // int variables -> $idValue
    // array variables -> $AssocArray
    public function UpdateData($updateQuery = NULL, $tableName = NULL, $AssocArray = NULL, $idValue = NULL, $idName = NULL) {

        if ($updateQuery == NULL) {
            if ($idValue == NULL || $idName == NULL) {
                throw new \Exception("Missing data to process the update request --[IdValue] --> $idValue  --[idName] -->$idName");
            }

            $updateQuery = $this->SetUpdateQuery($tablename, $AssocArray, $idValue, $idName);
        }

        // run updateQuery
        $result = $this->RunSqlQuery($updateQuery);

        if ($result && $idValue !== NULL) {
            $this->lastInsertedID = $idValue;
        }
    }

    // requires every parameter
    public function SetDeleteQuery($tablename, $idName, $idValue) {

        // Test if a valid id is provided and throw an error if appropiate
        $this->ValidatePHP_ID($idValue, "SetDeleteQuery");

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
}









?>
