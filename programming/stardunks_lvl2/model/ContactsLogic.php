<?php

require_once "DataHandler.php";
require_once "HtmlElements.php";
require_once "DataValidator.php";

class ContactsLogic {
    private $DataHandler;
    private $HtmlElements;
    private $DataValidator;

    public function __construct($dbName, $username, $pass, $serverAdress, $dbType) {
        $this->DataHandler = new DataHandler($dbName, $username, $pass, $serverAdress, $dbType);
        $this->DataValidator = new DataValidator();
        $this->HtmlElements = new HtmlElements();
    }

    public function __destruct() {
        $this->DataHandler = NULL;
        $this->DataValidator = NULL;
        $this->HtmlElements = NULL;

    }

    public function CreateContact() {
        $tablename = "products";

        // set and select collumnNames
        $columnNames = $this->DataHandler->GetColumnNames($tablename);
        $columnNames = $this->DataHandler->SelectWithCodeFromArray($columnNames, "02");

        // run insertQuery
        $this->DataHandler->CreateData(NULL, $tablename, $columnNames, $_POST);

        return $this->DataHandler->lastInsertedID;
    }

    public function GenerateCreateForm() {
        $columnNames = $this->DataHandler->GetColumnNames('products');
        $columnNames = $this->DataHandler->SelectWithCodeFromArray($columnNames, "02");

        return $this->HtmlElements->GenerateInputTable($columnNames);
    }

    public function ReadContact($page = 1) {
        if ($page > 0) {
            $page--;
        } else {
            $page = 0;
        }
        $start = $page * 5;

        $returnArray = [];
        $sql = "SELECT * FROM `products` LIMIT $start, 5 ";
        $data = $this->DataHandler->ReadData($sql);

        $returnArray[0] = $this->HtmlElements->GenerateButtonedTable($data);
        $returnArray[1] = $this->DataHandler->createPagination("products", 5);

        return $returnArray;
    }

    public function ReadSingleContact($id, $option = 0) {
        $sql = "SELECT * FROM `products` WHERE `product_id` = $id";
        $data = $this->DataHandler->ReadData($sql);

        if ($option == 0) {
            $data = $this->HtmlElements->GenerateButtonedTable($data);
        }

        return $data;
    }

    public function UpdateContact() {
        $id = $_POST["product_id"];
        $sql = $this->DataHandler->SetUpdateQuery("products", $_POST);

        // run update
        $this->DataHandler->UpdateData($sql);

        // Get resulting row
        $data = $this->ReadSingleContact($id, 1);

        // format and return
        return $this->HtmlElements->GenerateButtonedTable($data);
    }

    public function GenerateUpdateForm() {
        $id = $_GET["id"];

        // get columnNames
        $columnNames = $this->DataHandler->GetColumnNames("products");
        $columnNames = $this->DataHandler->SelectWithCodeFromArray($columnNames, "02");

        // get data array
        $data = $this->ReadSingleContact($id, 1);
        $data = $data[0];

        $table = $this->HtmlElements->GenerateUpdateTable($columnNames, $data, $id);

        return $table;
    }

    public function DeleteContact($id) {
        $sql = "DELETE FROM `products` WHERE `product_id` = $id";
        return $this->DataHandler->DeleteData($sql);
    }

    public function SearchContact($search, $page = 1) {
        if ($page > 0) {
            $page--;
        } else {
            $page = 0;
        }
        $start = $page * 5;

        $returnArray = [];
        $limit = "LIMIT $start, 5 ";

        $where = $this->DataHandler->SetSearchWhere($search, "products", NULL, 1);
        $sql = $this->DataHandler->SetSearchQuery('products', $search, $limit, NULL, NULL);
        $data = $this->DataHandler->ReadData($sql);

        $returnArray[0] = $this->HtmlElements->GenerateButtonedTable($data);
        $returnArray[1] = $this->DataHandler->createPagination("products", 5, $where, "&op=search&search=" . $search );

        return $returnArray;
    }

    public function TestDataSubmitted($option = 0) {
        // Test if post is set
        if (!isset($_POST) ) {
            return FALSE;
        }

        // get column names
        $columnNames = $this->DataHandler->GetColumnNames('products');

        // if Fit the Array to the selected option
        if ($option == 1 || $option == "Create") {
            $columnNames = $this->DataHandler->SelectWithCodeFromArray($columnNames, "02");
        }

        // test and return result
        return $this->DataValidator->LoopCheckNotEmpty($columnNames, $_POST);
    }
}

?>
