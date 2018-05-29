<?php
trait DH_DV_MixedIn {

    /****
    ** description -> Selects specified data from an array
    ** relies on methods -> Null

    ** Requires -> $array, $code
    ** string variables -> $code
    ** array variables -> $array
    ****/
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

    private function ValidatePHP_ID($idValue, $Method = NULL) {

        // run tests and set return message if needed
        if ($idValue == "" || $idValue == NULL) {
            $message = "ID does not have a value";
            $return = FALSE;

        } else if ( (is_numeric($idValue) == FALSE) ) {
            $message = "ID is not a number";
            $return = FALSE;

        } else if ( (floor($idValue) == $idValue) == FALSE) {
            $message = "ID is not an INT";
            $return = FALSE;

        } else if ( ($idValue >= 0) == FALSE) {
            $message = "ID is a negative number";
            $return = FALSE;

        } else {
            $return = TRUE;
        }

        // Test if the result was succesfull
        if ($return == FALSE) {
            throw new Exception("ERROR->[Invalid ID] MESSAGE->[$message] IDVALUE->[$idValue] METHOD->[$Method]");
            return FALSE;

        } else {
            return TRUE;
        }

    }
}


 ?>
