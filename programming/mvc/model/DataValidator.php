<?php

/**
 *
 */
class DataValidator {

    public function __construct() {

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

    private function TestIfNumeric($string) {
        if (is_numeric($string)) {
            return TRUE;

        } else {
            return FALSE;
        }
    }

    private function TestIfInt($string) {
        if (is_numeric($string) && floor($string) == $string) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function TestIfBoolean($string) {
        if ($string == '1' || $string == 1 || $string == TRUE ||
        $string == '0' || $string == 0 || $string == FALSE) {
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

        if (empty($string) ) {
            return FALSE;

        } else {
            return TRUE;
        }

    }

    private function TestIfNoHtmlChars($string, $option == 0) {
        // forbid htmlChars
        if ($option == 0) {
            if (htmlspecialchars($string) == $string) {
                return TRUE;

            } else {
                return FALSE
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

    private function Trim($string) {
        return trim($string);
    }

}


 ?>
