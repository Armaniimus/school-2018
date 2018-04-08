<?php

trait DataHandler_SecondaryMethods {
    public function CountDataResults($tablename, $where = "") {
        $SearchQuery = "SELECT " . "count" . "(*) FROM $tablename $where";
        return $this->RunSqlQuery($SearchQuery, 3);
    }

    // requires numbered arrays
    public function SetSearchWhere($whereData, $tablename = NULL, $columnNames = NULL, $option = 1) {

        // get columnNames based on $tablename or $columnNames
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

    public function CreatePagination($tablename, $resAmountPerPage, $where = "", $styleName, $currentPage = NULL, $optional = "") {
        $totalItems = $this->CountDataResults($tablename, $where);

        // Set total pagination numbers
        $restItems = $totalItems % $resAmountPerPage;
        $totalPagination = floor($totalItems / $resAmountPerPage);

        if ($restItems > 0) {
            $totalPagination++;
        }

        // generateTable
        $forStart = 0;
        $pageTable = [];
        if ($currentPage > 1) {
            $pageCount = $currentPage-1;
            $pageTable[0] = "<a class='$styleName $styleName--start $styleName--bothEnds' href='index.php?page=$pageCount" . $optional . "'>&lt;&lt;</a>";

            $forStart++;
            $totalPagination++;
        }


        $pageCount = 1;
        $currentPageCheck = $currentPage;
        if ($forStart == 0) {
            $currentPageCheck--;
        }

        for ($i=$forStart; $i<$totalPagination; $i++) {
            if (($currentPageCheck) == ($i) ) {
                $pageTable[$i] = "<a class='$styleName--Current'>$pageCount</a>";
                $pageCount++;

            } else {
                $pageTable[$i] = "<a class='$styleName' href='index.php?page=$pageCount" . $optional . "'>$pageCount</a>";
                $pageCount++;
            }
        }

        if ($currentPage < $totalPagination-1) {
            $pageCount = 1+$currentPage;
            $pageTable[$i] = "<a class='$styleName $styleName--end $styleName--bothEnds' href='index.php?page=$pageCount" . $optional . "'>&gt;&gt;</a>";
        }

        return $pageTable;
    }
}

?>
