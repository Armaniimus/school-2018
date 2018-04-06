<?php

/**
 *
 */
class DataValidator {
    private $dataTypesArray;
    private $nullDataArray;
    private $columnNames;

    public function __construct($columnNames = NULL, $dataTypesArray = NULL, $nullDataArray = NULL) {
        $this->dataTypesArray = $dataTypesArray;
        $this->nullDataArray = $nullDataArray;
        $this->columnNames = $columnNames;
    }

    public function GetHtmlValidateData($dataTypesArray = NULL) {
        if ($dataTypesArray == NULL) {
            $dataTypesArray = $this->dataTypesArray;
        }
        // return Html Validation shizzle

        for ($i=0; $i<count($dataTypesArray); $i++) {
            if (strpos($dataTypesArray[$i], 'int') !== false) {
                $dataTypesArray[$i] = $this->ValidateHTMLInt($dataTypesArray[$i]);

            } else if (strpos($dataTypesArray[$i], 'varchar') !== false) {
                $dataTypesArray[$i] = $this-> ValidateHTMLVarchar($dataTypesArray[$i]);

            } else if ( (strpos($dataTypesArray[$i], 'decimal') !== false) || (strpos($dataTypesArray[$i], 'double') !== false) ) {
                $dataTypesArray[$i] = $this->ValidateHTMLDoubleOrDecimal($dataTypesArray[$i]);

            } else if (strpos($dataTypesArray[$i], 'date') !== false) {
                $dataTypesArray[$i] = $this->ValidateHTMLDate($dataTypesArray[$i]);
            }
        }
        return $dataTypesArray;
    }

    private function ValidateHTMLVarchar($data) {
        $data = str_replace("varchar(", "", $data);
        $data = str_replace(")", "", $data);
        $data = "type='text' maxlength='$data' pattern='[^\s$][A-Za-z0-9!@#$%\^&*\s.,:;]*'";

        return $data;
    }

    private function ValidateHTMLInt($data) {
        if (strpos($data, 'unsigned') !== false){
            $max = 4294967295;
            $min = 0;
        } else {
            $max = 	2147483647;
            $min = -2147483648;
        }
        $data = "type='number' step='1' min='$min' max='$max'";
        return $data;
    }

    private function ValidateHTMLDoubleOrDecimal($data) {
        // get numericData
        $splittedData = $this->prepValidateDecimal_Double($data);

        // set decimal
        $decimal = 0.1 ** $splittedData[1];

        // set max
        $multiplier = $splittedData[0]-$splittedData[1];
        $max = 10 ** $multiplier;
        $max = $max - $decimal;

        $data = "type='number' max='$max' step='$decimal'";
        return $data;

    }

    private function ValidateHTMLDate($data) {
        $data = "type='date'";
        return $data;
    }

    public function ValidateHTMLNotNull($nullDataArray = NULL, $selectCode = NULL) {

        if ($nullDataArray == NULL) {
            $nullDataArray = $this->nullDataArray;
        }

        if ($selectCode !== NULL) {
            $nullDataArray = $this->SelectWithCodeFromArray($nullDataArray, $selectCode);
        }

        for ($i=0; $i < count($nullDataArray); $i++) {
            if (strpos($nullDataArray[$i], 'YES') !== false) {
                $nullDataArray[$i] = "";

            } else if (strpos($nullDataArray[$i], 'NO') !== false) {
                $nullDataArray[$i] = "required";
            }
        }

        return $nullDataArray;
    }

    public function ValidatePHPRequired($assocArray, $nullDataArray = NULL, $columnNames = NULL, $selectCode = NULL) {
        if ($nullDataArray == NULL) {
            $nullDataArray = $this->nullDataArray;
        }

        if ($columnNames == NULL) {
            $columnNames = $this->columnNames;
        }

        if ($selectCode !== NULL) {
            $columnNames = $this->SelectWithCodeFromArray($columnNames, $selectCode);
            $nullDataArray = $this->SelectWithCodeFromArray($nullDataArray, $selectCode);
        }

        for ($i=0; $i<count($columnNames); $i++) {
            // test each columnName inside assoc array one at a time

            if ($nullDataArray[$i] == "YES") {
                continue;
            }

            else if ($nullDataArray[$i] == "NO") {
                if (!isset($assocArray[$columnNames[$i]])) {
                    return FALSE;
                }
                $test = $this->TestIfNotEmpty( $assocArray[$columnNames[$i]] );

                // if one of the tests fails return false
                if ($test == FALSE) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    private function TestMinimalLength($length, $string = "") {
        if (strlen($string) < $length) {
            return FALSE;

        } else {
            return TRUE;
        }
    }

    private function TestMaximumLength($length, $string = "") {
        if (strlen($string) > $length) {
            return FALSE;

        } else {
            return TRUE;
        }
    }

    private function ValidatePHPFloat($string) {
        return is_numeric($string);
    }

    private function prepValidateDecimal_Double($data) {
        $data = str_replace("decimal(", "", $data);
        $data = str_replace("double(", "", $data);
        $data = str_replace(")", "", $data);
        $splittedData = explode(",", $data);

        return $splittedData;
    }

    private function ValidatePHPDecimal_Double($string, $data) {
        if (is_numeric($string) ) {
            // get numericData
            $splittedData = $this->prepValidateDecimal_Double($data);

            // set decimal
            $decimal = 0.1 ** $splittedData[1];

            // set max
            $multiplier = $splittedData[0]-$splittedData[1];
            $max = 10 ** $multiplier;
            $max = $max - $decimal;

            if (($string < $max) == FALSE) {
                return FALSE;

            } else if ((($string*1) == round($string, 2)) == FALSE) {
                return FALSE;

            } else {
                return TRUE;
            }

        } else {
            return FALSE;
        }
    }

    private function ValidatePHPInt($string) {
        if (is_numeric($string) && floor($string) == $string) {
            return TRUE;

        } else {
            return FALSE;
        }
    }

    private function ValidatePHPBoolean($string) {
        if ($string == '1' || $string == 1 || $string === TRUE ||
        $string == '0' || $string == 0 || $string === FALSE) {
            return TRUE;

        } else {
            return FALSE;
        }
    }

    private function TestIfEmail() {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
          return TRUE;

        } else {
          return FALSE;
        }
    }

    private function TestIfNotEmpty($string) {
        $string = trim($string);

        if ( !isset($string) || $string == "" ) {
            return FALSE;

        } else {
            return TRUE;
        }

    }

    private function TestIfNoHtmlChars($string, $option = 0) {
        // forbid htmlChars
        if ($option == 0) {
            if (htmlspecialchars($string) == $string) {
                return TRUE;

            } else {
                return FALSE;
            }

        // convert HtmlChars
        } else if ($option == 1) {
            return htmlspecialchars($string);

        // allow html chars Not recomended
        } else if ($option == 2) {
            return $string;

        // if a wrong option is selected
        } else {
            throw new Exception("Wrong option selected in HtmlSpecialChars", $option);

        }
    }

    public function SelectWithCodeFromArray($array, $code) {
        $splittedCode = str_split($code);
        $return = []; // <--- is used to store the output data
        $y=0; // <--- is used to count in which position the next datapiece needs to go

        for ($i=0; $i<count($array); $i++) {
            if ($splittedCode[$i] == 0) {

            }
            else if ($splittedCode[$i] == 1) {
                $return[$y] = $array[$i];
                $y++;
            }
            else if ($splittedCode[$i] == 2) {
                //runs till the end of the array and writes everything inside the array
                for ($i=$i; $i<count($array); $i++) {
                    $return[$y] = $array[$i];
                    $y++;
                }
            }
            else if ($splittedCode[$i] == 3) {
                //runs till the end of the array and writes nothings
                for ($i=$i; $i<count($array); $i++) {

                }
            }
        }
        return $return;
    }
}
?>
