<?php

function GenerateTable1($data) {

    function Head($data) {
        //table Collumn names
        $head = "<thead>";

            foreach ($data as $key => $value) {
                $row = "<tr>";
                    foreach ($value as $k => $v) {
                        $row .= "<th>" . $k . "</th>";
                    }
                $row .= "</tr>";

                $head .= $row;
                break;
            }
        $head .= "</thead>";
        return $head;
    }

    function Body($data) {
        //table Body
        $body = "<tbody>";
            foreach ($data as $key => $value) {
                $row = "<tr>";
                    foreach ($value as $k => $v) {
                        $row .= "<td>" . $value[$k] . "</td>";
                    }
                $row .= "</tr>";

                $body .= $row;
            }
        $body .= "</tbody>";
        return $body;
    }

    // var_dump($data);
    $table = "<table border='1'>" .  Head($data) . Body($data) . "</table>";

    return $table;
}

function GenerateTable2($columnNames) {

    function Head() {
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

    function Body($columnNames) {
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

    $button = "<button name='addproduct' value='1' class='generatedTableButton' type='submit'>Add product</button>";
    $table = "<form action='php/handle_create.php' method='post' ><table class='generatedTableCreate'>" .  Head() . Body($columnNames) . "</table>" . $button . "</form>";


    return $table;
}

function GenerateTableWithButtons($data) {

    function buttons($id) {
        $read   = "<td><a href='read_screen.php?id=$id' class='generatedTableButton'>Read</a></td>";
        $update = "<td><a href='update_screen.php?id=$id' class='generatedTableButton'>Update</a></td>";
        $delete = "<td><a href='php/handle_delete.php?id=$id' class='generatedTableButton'>Delete</a></td>";

        $buttons = $read . $update . $delete;
        return $buttons;
    }

    function head($data) {
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

    function body($data) {
        // table Body
        $body = "<tbody>";
            foreach ($data as $key => $value) {
                $row = "<tr>";
                    foreach ($value as $k => $v) {
                        $row .= "<td>" . $value[$k] . "</td>";
                    }
                $row .= buttons($value['product_id']);
                $row .= "<tr>";

                $body .= $row;
            }
        $body .= "</tbody>";
        return $body;
    }

    // var_dump($data);
    $table = "<table border='1' class='generatedTable'>" .  head($data) . body($data) . "</table>";

    return $table;
}
?>
