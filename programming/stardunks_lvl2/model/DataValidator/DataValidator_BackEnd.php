<?php

trait DataValidator_BackEnd {

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
}
?>
