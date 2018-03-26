<?php

Class HtmlElements {
    private $data;
    private $columnNames;

    public function __Construct() {

    }

    private function ButtonedTableButtons($id) {
        $read   = "<td class='button'><a href='index.php?id=$id&op=read'    class='generatedTableButton'>Read</a></td>";
        $update = "<td class='button'><a href='index.php?id=$id&op=update'  class='generatedTableButton'>Update</a></td>";
        $delete = "<td class='button'><a href='index.php?id=$id&op=delete'  class='generatedTableButton'>Delete</a></td>";

        $buttons = $read . $update . $delete;
        return $buttons;
    }

    private function ButtonedTableHead($data) {
        // table Collumn names
        $head = "<thead>";

            foreach ($data as $key => $value) {
                $row = "<tr>";
                    foreach ($value as $k => $v) {
                        $row .= "<th>" . $k . "</th>";
                    }
                    $row .= "<th colspan='3'>Actions</th>";
                $row .= "</tr>";

                $head .= $row;
                break;
            }
        $head .= "</thead>";
        return $head;
    }

    private function ButtonedTableBody($data) {
        // table Body
        $body = "<tbody>";
            foreach ($data as $key => $value) {
                $row = "<tr>";
                    foreach ($value as $k => $v) {
                        $row .= "<td>" . $value[$k] . "</td>";
                    }
                $row .= $this->ButtonedTableButtons($value['product_id']);
                $row .= "<tr>";

                $body .= $row;
            }
        $body .= "</tbody>";
        return $body;
    }

    public function GenerateButtonedTable($data) {
        $table = "<table border='1' class='generatedTable'>" .  $this->ButtonedTableHead($data) . $this->ButtonedTableBody($data) . "</table>";
        return $table;
    }

    private function InputTableHead() {
        //table Collumn names
        $head = "
            <thead>
            <tr>
        ";

        $head .= "
            <th>CollumnName</th>
            <th>InputFields</th>
        ";

        $head .= "
            </tr>
            </thead>
        ";

        return $head;
    }

    private function InputTableBody($columnNames) {
        //table Body
        $body = "<tbody>";
            foreach ($columnNames as $key => $value) {
                $row = "<tr>";

                $row .= "
                    <td>$value</td>
                    <td> <input name='$value'/> </td>
                ";
                // break;

                $row .= "</tr>";
                $body .= $row;
            }

        $body .= "</tbody>";
        return $body;
    }

    public function GenerateInputTable($columnNames) {

        $button = "<button name='addproduct' value='1' class='generatedTableButton' type='submit'>Add product</button>";

        $table = "
            <form action='index.php?op=create' method='post' >
                <table border='1' class='generatedTableCreate'>"
                    . $this->InputTableHead()
                    . $this->InputTableBody($columnNames)
                . "</table>"
                . $button
            . "</form>
        ";

        return $table;
    }

    private function UpdateTableHead() {
        //table Collumn names
        $head = "
            <thead>
            <tr>
        ";

        $head .= "
            <th>CollumnName</th>
            <th>InputFields</th>
        ";

        $head .= "
            </tr>
            </thead>
        ";

        return $head;
    }

    private function UpdateTableBody($columnNames, $data) {
        //table Body
        $body = "<tbody>";
            foreach ($columnNames as $key => $value) {
                $row = "<tr>";

                $row .= "
                    <td>$value</td>
                    <td> <input name='$value' value='". $data[$value] ."'/> </td>
                ";

                $row .= "</tr>";
                $body .= $row;
            }

        $body .= "</tbody>";
        return $body;
    }

    public function GenerateUpdateTable($columnNames, $data, $id) {
        // set hidden ID Field update
        $hiddenField = "<input type='hidden' name='product_id' value='$id'>";

        $button = "<button name='UpdateSubmit' value='1' class='generatedTableButton' type='submit'>Update</button>";

        $table = "
            <form action='index.php?op=update' method='post' >" .
                $hiddenField ."
                <table border='1' class='generatedTableCreate'>"
                    . $this->UpdateTableHead()
                    . $this->UpdateTableBody($columnNames, $data)
                . "</table>"
                . $button
            . "</form>
        ";

        return $table;
    }
}

?>
