<?php

Class HtmlElements {
    private $data;
    private $columnNames;

    public function __Construct() {

    }

    private function ButtonedTableButtons($id) {
        $read   = "<td class='button'><a href='index.php?id=$id&op=read'    class='generatedTableButton'>   <i class='fas fa-book buttonIconColor'></i>    Read    </a></td>";
        $update = "<td class='button'><a href='index.php?id=$id&op=update'  class='generatedTableButton'>   <i class='fas fa-edit buttonIconColor'></i>  Update  </a></td>";
        $delete = "<td class='button'><a href='index.php?id=$id&op=delete'  class='generatedTableButton'>   <i class='fas fa-trash buttonIconColor'></i>   Delete  </a></td>";

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

    public function GenerateFormTable($columnNames, $types, $required, $data, $option = 0, $id = NULL) {

        // Set Diffrent options Create and Update
        if ($option == 0 || $option == "create") {
            $i = 0;
            $openingLines = "<form action='index.php?op=create' method='post' >";

            $closingLines = "<button name='addproduct' value='1' class='generatedTableButton' type='submit'> <i class='fas buttonIconColor fa-plus'></i> Add product</button>";
            $closingLines .= "</form>";

        } else if ($option == 1 || $option == "update") {
            $i = 1;
            $openingLines = "<form action='index.php?op=update' method='post' >";
            $openingLines .= "<input type='hidden' name='" . $columnNames[0] . "' value='$id'>";

            $closingLines = "<button name='UpdateSubmit' value='1' class='generatedTableButton' type='submit'> <i class='fas buttonIconColor fa-edit'></i> Update</button>";
            $closingLines .= "</form>";
        }

        // set head
        $head = "
        <thead>
            <tr>
                <th>ColumnNames</th>
                <th>InputFields</th>
            </tr>
        </thead>";


        // set Body
        $body = "<tbody>";
        for ($i; $i<count($columnNames); $i++) {
            $row = "
            <tr>
                <td>" . $columnNames[$i] . "</td>
                <td> <input name='" . $columnNames[$i] . "'" . $types[$i] . " value='". $data[$columnNames[$i]] . "'" . $required[$i] . "/> </td>
            </tr>";
            $body .= $row;
        }
        $body .= "</tbody>";


        // Combine the Table
        $table =
            $openingLines .
            "<table border='1' class='generatedTableCreate'>" .
                $head .
                $body .
            "</table>" .
            $closingLines;

        return $table;
    }
}

?>
