<?php

require_once 'model/ContactsLogic.php';

class ContactsController {
    private $ContactsLogic;

    public function __Construct($dbName, $username, $pass, $serverAdress = "localhost", $dbType = "mysql" ) {
        $this->ContactsLogic = new ContactsLogic($dbName, $username, $pass, $serverAdress, $dbType);
    }

    public function __Destruct() {
        $this->ContactsLogic = NULL;
    }

    // data gets extracted from the $_POST
    public function collectCreateContacts() {
        if (isset($_POST["phone"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["location"]) ) {
            // sumbit the form
            $lastID = $this->ContactsLogic->CreateContact();

            // run a read
            $this->collectSingleReadContact($lastID);
        } else {
            // Show the form
            $content = $this->ContactsLogic->GenerateCreateForm();
            require_once 'view/create.php';
        }
    }

    public function collectReadContacts() {
        // run the read
        if ( !empty($_GET["id"] ) && $_GET["id"] > -1 ) {
            $content = $this->ContactsLogic->ReadSingleContact($_GET["id"]);
            require_once 'view/readSingle.php';

        } else {
            $content = $this->ContactsLogic->ReadContact();
            require_once 'view/read.php';
        }
    }

    private function collectSingleReadContact($id) {
        // run singleRead
        $content = $this->ContactsLogic->ReadSingleContact($id);
        require_once 'view/readSingle.php';
    }

    // not done
    public function collectUpdateContact() {

        // check if Data is submitted
        if (isset($_POST["id"]) && isset($_POST["phone"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["location"]) ) {
            // Run the update
            $content = $this->ContactsLogic->UpdateContact();
            require_once 'view/readSingle.php';

        // Check if There is an Id in the url
        } else if ( isset($_GET["id"]) ) {
            // Set the id
            $id = $_GET['id'];

            // Show the form
            $content = $this->ContactsLogic->GenerateUpdateForm($id);
            require_once 'view/update.php';

        } else {
            // run a regular read
            $_GET["id"] = -1;
            $this->collectReadContacts();
        }


    }

    public function collectDeleteContacts($id) {
        // Run Delete
        $result = $this->ContactsLogic->DeleteContact($id);

        // run Read
        $_GET["id"] = -1;
        $this->collectReadContacts();
    }
}
 ?>
