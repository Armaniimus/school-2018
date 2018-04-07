<?php

trait DataValidator_FrontEnd {
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
}
?>
