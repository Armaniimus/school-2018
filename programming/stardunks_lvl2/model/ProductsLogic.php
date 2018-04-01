<?php

require_once "DataHandler.php";
require_once "HtmlElements.php";
require_once "DataValidator.php";

class ProductsLogic {

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

    public function CreateProduct() {
        $tablename = "products";

        // set and select collumnNames
        $columnNames = $this->DataHandler->GetColumnNames($tablename);
        $columnNames = $this->DataHandler->SelectWithCodeFromArray($columnNames, "02");

        // convert product_price to the right format for the database
        $_POST["product_price"] = $this->ConvertNumericData(1, NULL, $_POST["product_price"]);

        // run insertQuery
        $this->DataHandler->CreateData(NULL, $tablename, $columnNames, $_POST);

        return $this->DataHandler->lastInsertedID;
    }

    public function GenerateCreateForm() {
        $columnNames =   $this->DataHandler->GetColumnNames("products", "02");
        $dataTypes =    $this->DataHandler->GetTableTypes("products", 0, "02");
        $required =     $this->DataHandler->GetTableNullValues("products", 0, "02");

        $table = $this->HtmlElements->GenerateFormTable($columnNames, $dataTypes, $required, 0);

        return $table;
    }

    public function ReadProduct($page = 1) {
        if ($page > 0) {
            $page--;
        } else {
            $page = 0;
        }
        $start = $page * 5;

        $returnArray = [];
        $sql = "SELECT * FROM `products` LIMIT $start, 5 ";


        // Create a second Method *** NOT DRY
        $data = $this->DataHandler->ReadData($sql);
        $data = $this->ConvertNumericData(0, $data);

        $returnArray[0] = $this->HtmlElements->GenerateButtonedTable($data);
        $returnArray[1] = $this->DataHandler->CreatePagination("products", 5);

        return $returnArray;
    }

    public function ReadSingleProduct($id, $option = 0) {
        $sql = "SELECT * FROM `products` WHERE `product_id` = $id";
        $data = $this->DataHandler->ReadData($sql);
        $data = $this->ConvertNumericData(0, $data);

        if ($option == 0) {
            $data = $this->HtmlElements->GenerateButtonedTable($data);
        }

        return $data;
    }

    public function UpdateProduct() {
        $id = $_POST["product_id"];

        // convert product_price to right format for the database
        $_POST["product_price"] = $this->ConvertNumericData(1, NULL, $_POST["product_price"]);

        // set query
        $sql = $this->DataHandler->SetUpdateQuery("products", $_POST);

        // run update
        $this->DataHandler->UpdateData($sql);

        // Get resulting row
        $data = $this->ReadSingleProduct($id, 1);

        // format and return
        return $this->HtmlElements->GenerateButtonedTable($data);
    }

    public function GenerateUpdateForm() {
        $id = $_GET["id"];

        // get data array
        $data = $this->ReadSingleProduct($id, 1);
        $data = $data[0];
        $data["product_price"] = $this->ConvertNumericData(1, NULL, $data["product_price"]);

        // get table data
        $columnNames = $this->DataHandler->GetColumnNames("products");
        $dataTypes = $this->DataHandler->GetTableTypes("products", 0);
        $required = $this->DataHandler->GetTableNullValues("products", 0);

        $table = $this->HtmlElements->GenerateFormTable($columnNames, $dataTypes, $required, $data, 1, $id);

        return $table;
    }

    public function DeleteProduct($id) {
        $sql = "DELETE FROM `products` WHERE `product_id` = $id";
        return $this->DataHandler->DeleteData($sql);
    }

    public function SearchProduct($search, $page = 1) {
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

        // Create a second Method *** NOT DRY
        $data = $this->DataHandler->ReadData($sql);
        $data = $this->ConvertNumericData(0, $data);

        $returnArray[0] = $this->HtmlElements->GenerateButtonedTable($data);
        $returnArray[1] = $this->DataHandler->CreatePagination("products", 5, $where, "&op=search&search=" . $search );

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

    // $data needs to be an Array for
    private function ConvertNumericData($option = 0, $array = NULL, $string = NULL) {
        if ($option == 0) {

            // Loop and convert all shown data
            for ($i=0; $i < count($array); $i++) {
                $array[$i]["product_price"] = "&euro;" . $array[$i]["product_price"];
                $array[$i]["product_price"] = str_Replace(".", ",", $array[$i]["product_price"]);
            }
            return $array;

        } elseif ($option == 1 || $option == "update" || $option == "create") {
            // $data is a string
            $string = str_Replace(",", ".", $string);
            $string = str_Replace("&euro;", "", $string);
            $string = str_Replace("€", "", $string);

            return $string;
        }
    }
}

?>
