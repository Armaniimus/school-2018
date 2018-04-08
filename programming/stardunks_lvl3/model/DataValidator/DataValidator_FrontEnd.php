<?php

trait DataValidator_FrontEnd {
    public function GetHtmlValidateData($dataTypesArray = NULL) {
        if ($dataTypesArray == NULL) {
            $dataTypesArray = $this->dataTypesArray;
        }
        // return Html Validation shizzle

        for ($i=0; $i<count($dataTypesArray); $i++) {

            // int tests
            if (strpos($dataTypesArray[$i], 'int') !== false) {
                if (strpos($dataTypesArray[$i], 'tinyint') !== false) {
                    $dataTypesArray[$i] = $this->ValidateHTMLInt($dataTypesArray[$i], 'tiny');

                } else if (strpos($dataTypesArray[$i], 'smallint') !== false) {
                    $dataTypesArray[$i] = $this->ValidateHTMLInt($dataTypesArray[$i], 'small');

                } else if (strpos($dataTypesArray[$i], 'mediumint') !== false) {
                    $dataTypesArray[$i] = $this->ValidateHTMLInt($dataTypesArray[$i], 'medium');

                } else if (strpos($dataTypesArray[$i], 'bigint') !== false) {
                    $dataTypesArray[$i] = $this->ValidateHTMLInt($dataTypesArray[$i], 'big');

                } else if (strpos($dataTypesArray[$i], 'int') !== false) {
                    $dataTypesArray[$i] = $this->ValidateHTMLInt($dataTypesArray[$i], '');
                }
            }

            // StringTests
             else if (strpos($dataTypesArray[$i], 'varchar') !== false) {
                $dataTypesArray[$i] = $this-> ValidateHTMLVarchar($dataTypesArray[$i]);
            }

            // Double/decimal Number Tests
            else if (strpos($dataTypesArray[$i], 'decimal') !== false) {
                $dataTypesArray[$i] = $this->ValidateHTMLDecimal($dataTypesArray[$i]);
            }

            // Date/time tests
             else if (strpos($dataTypesArray[$i], 'date') !== false) {
                $dataTypesArray[$i] = $this->ValidateHTMLDate($dataTypesArray[$i]);
            }
        }
        return $dataTypesArray;
    }

    private function ValidateHTMLVarchar($data) {
        $data = $this->PrepValidateVarchar($data);
        $data = "type='text' maxlength='$data' pattern='[^\s$][A-Za-z0-9!@#$%\^&*\s.,:;]*'";

        return $data;
    }

    private function ValidateHTMLInt($data, $option = '') {

        if ($option === 'tiny') {
            $data = $this->PrepValidateTinyInt($data);

        } else if ($option === 'small') {
            $data = $this->PrepValidateSmallInt($data);

        } else if ($option === 'medium') {
            $data = $this->PrepValidateMediumInt($data);

        } else if ($option === '') {
            $data = $this->PrepValidateInt($data);

        } else if ($option === 'big') {
            $data = $this->PrepValidateBigInt($data);
        }

        // set min and max
        $min = $data["min"];
        $max = $data["max"];

        $data = "type='number' step='1' min='$min' max='$max'";
        return $data;
    }

    private function ValidateHTMLDecimal($data) {
        // get numericData
        $data = $this->prepValidateDecimal($data);

        // set decimal and max
        $decimal = $data["decimal"];
        $max = $data["max"];

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
}
?>
