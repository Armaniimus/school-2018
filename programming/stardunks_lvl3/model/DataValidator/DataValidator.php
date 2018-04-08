<?php
    require_once 'DataValidator_FrontEnd.php';
    require_once 'DataValidator_BackEnd.php';
    require_once 'DataValidator_Essentials.php';

    class DataValidator {
        private $dataTypesArray;
        private $nullDataArray;
        private $columnNames;

        public function __construct($columnNames = NULL, $dataTypesArray = NULL, $nullDataArray = NULL) {
            $this->dataTypesArray = $dataTypesArray;
            $this->nullDataArray = $nullDataArray;
            $this->columnNames = $columnNames;
        }
        use DataValidator_FrontEnd;
        use DataValidator_BackEnd;
        use DataValidator_Essentials;
        use DH_DV_MixedIn; //uses the mixedin defined in -> "dataHandler/MixedIns/DH_DV_MixedIn";
}
?>
