<?php
    require_once 'DataHandler_PrimaryMethods.php';
    require_once 'DataHandler_SecondaryMethods.php';
    require_once 'DataHandler_HelperMethods.php';
    require_once 'MixedIns/DH_DV_MixedIn.php';
    class DataHandler {
        private $conn;
        public $error;
        public $lastInsertedID;
        public $dbName;
        private $tableData;

        public function __construct($dbName, $username, $pass, $serverAdress, $dbType) {
            $this->tableData = [];
            $this->dbName = $dbName;
            $this->conn = new PDO("$dbType:host=$serverAdress;dbname=$dbName", $username, $pass);

            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function __destruct() {
            $this->conn = NULL;
            $this->error = NULL;
            $this->lastInsertedID = NULL;
            $this->dbName = NULL;
            $this->tableData = NULL;
        }
        use DataHandler_PrimaryMethods;
        use DataHandler_HelperMethods;
        use DataHandler_SecondaryMethods;
        use DH_DV_MixedIn;
    }
 ?>
