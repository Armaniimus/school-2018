<?php
    trait DataValidator_Essentials {
        private function prepValidateDecimal($data) {
            $data = str_replace("decimal(", "", $data);
            $data = str_replace(")", "", $data);
            $splittedData = explode(",", $data);

            // set decimal
            $decimal = 0.1 ** $splittedData[1];

            // set max
            $multiplier = $splittedData[0]-$splittedData[1];
            $max = 10 ** $multiplier;
            $max = $max - $decimal;

            return ['decimal' => $decimal, 'max'=> $max];
        }

        private function PrepValidateVarchar($data) {
            $data = str_replace("varchar(", "", $data);
            $data = str_replace(")", "", $data);
            return $data;
        }

        private function PrepValidateChar($data) {
            $data = str_replace("char(", "", $data);
            $data = str_replace(")", "", $data);
            return $data;
        }

        private function PrepValidateTinyInt($data) {
            if (strpos($data, 'unsigned') !== false){
                $max = 255;
                $min = 0;
            } else {
                $max = 	127;
                $min = -128;
            }

            return ['min' => $min,'max'=> $max];
        }

        private function PrepValidateSmallInt($data) {
            if (strpos($data, 'unsigned') !== false){
                $max = 65535;
                $min = 0;
            } else {
                $max = 	32767;
                $min = -32768;
            }

            return ['min' => $min,'max'=> $max];
        }

        private function PrepValidateMediumInt($data) {
            if (strpos($data, 'unsigned') !== false){
                $max = 16777215;
                $min = 0;
            } else {
                $max = 	8388607;
                $min = -8388608;
            }

            return ['min' => $min,'max'=> $max];
        }

        private function PrepValidateInt($data) {
            if (strpos($data, 'unsigned') !== false){
                $max = 4294967295;
                $min = 0;
            } else {
                $max = 	2147483647;
                $min = -2147483648;
            }

            return ['min' => $min,'max'=> $max];
        }

        private function PrepValidateBigInt($data) {
            if (strpos($data, 'unsigned') !== false){
                $max = (2 ** 64)-1;
                $min = 0;
            } else {
                $max = 	(2 ** 63)-1;
                $min = (-2 ** 63);
            }

            return ['min' => $min,'max'=> $max];
        }
    }

?>
