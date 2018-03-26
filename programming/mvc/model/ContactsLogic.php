<?php

require_once "DataHandler.php";
require_once "HtmlElements.php";

class ContactsLogic {
    private $DataHandler;
    private $HtmlElements;

    public function __construct($dbName, $username, $pass, $serverAdress, $dbType) {
        $this->DataHandler = new DbHandler($dbName, $username, $pass, $serverAdress, $dbType);
        $this->HtmlElements = new HtmlElements();
    }

    public function __destruct() {
        $this->DataHandler = null;
    }

    public function CreateContact() {
        $tablename = "contacts";
        $columnNames = $this->DataHandler->GetCollumnNames($tablename);
        $columnNames = $this->DataHandler->SelectWithCodeFromArray($columnNames, "02");

        $this->DataHandler->InsertIntoDatabase($tablename, $columnNames, $_POST);

        return $this->DataHandler->lastInsertedID;
    }

    public function ReadContact() {
        $sql = "SELECT * FROM `contacts` LIMIT 0, 30 ";
        $data = $this->DataHandler->ReadData($sql);
        return $this->HtmlElements->GenerateButtonedTable($data);
    }

    public function ReadSingleContact($id, $option = 0) {
        $sql = "SELECT * FROM `contacts` WHERE `id` = $id";
        $data = $this->DataHandler->ReadData($sql);

        if ($option == 0) {
            $data = $this->HtmlElements->GenerateButtonedTable($data);
        }

        return $data;
    }

    public function UpdateContact() {

            // set variables
            $id = $_POST["id"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $location = $_POST["location"];

            // set sql;
            $sql = "UPDATE `mvc`.`contacts`
            SET `name` = '$name', `phone` = '$phone', `email` = '$email', `location` = '$location'
            WHERE `id` = $id";

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
        $columnNames = $this->DataHandler->GetCollumnNames("contacts");
        $columnNames = $this->DataHandler->SelectWithCodeFromArray($columnNames, "02");

        // get data array
        $data = $this->ReadSingleContact($id, 1);
        $data = $data[0];

        $table = $this->HtmlElements->GenerateUpdateTable($columnNames, $data, $id);

        return $table;
    }

    public function DeleteContact($id) {
        $sql = "DELETE FROM `contacts` WHERE `contacts`.`ID` = $id";
        return $this->DataHandler->DeleteData($sql);
    }

    public function GenerateCreateForm() {
        $columnNames = $this->DataHandler->GetCollumnNames('contacts');
        $columnNames = $this->DataHandler->SelectWithCodeFromArray($columnNames, "02");

        return $this->HtmlElements->GenerateInputTable($columnNames);
    }
}

?>
