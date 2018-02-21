<?php

    /**
     *
     */
    class boek {
        public $titel;
        public $aantalHoofdstukken;
        public $aantalBladzijden;
        public $uitgever;

        public function __construct($titel, $hoofdstukken, $bladzijden){
            $this->titel = $titel;
            $this->aantalHoofdstukken = $hoofdstukken;
            $this->aantalBladzijden = $bladzijden;
            $this->uitgever = "ArmaniimusBooks";
        }

        public function GetInfoBoek() {
            return "De titel is $this->titel <br />" .
            "Dit boek heeft $this->aantalHoofdstukken hoofdstukken <br />" .
            "Dit boek heeft $this->aantalBladzijden <br />" .
            "De uitgever is $this->uitgever <br />";
        }
    }

    /**
     *
     */
    class paperback extends boek {
        public $boekFormaat;

        public function __construct($titel, $hoofdstukken, $bladzijden) {
            $this->titel = $titel;
            $this->aantalHoofdstukken = $hoofdstukken;
            $this->aantalBladzijden = $bladzijden;
            $this->uitgever = "ArmaniimusBooks";
            $this->boekFormaat = "paperback";
        }

        public function GetInfoPaperback() {
            $mainInfo = $this->GetInfoBoek();
            return $mainInfo .
            "boekFormaat is $this->boekFormaat";
        }
    }

?>
