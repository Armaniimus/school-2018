<?php
    /**
     *
     */
    class medewerker {
        public $werktBij;
        public $krijgtLoon;
        public function __construct() {
            $this->werktBij = "dit bedrijf";
            $this->krijgtLoon = "waar";
        }

        public function showInfoMain() {
            return "werkt bij " . $this->werktBij . "<br />" .
            "krijgt Loon = waar <br />";
        }
    }

    /**
     *
     */
    class marketeer extends medewerker {
        public $werktOpAfdeling;
        public function __construct() {
            $this->werktOpAfdeling = "marketing";
        }

        public function showInfo() {
            $mainInfo = $this->showInfoMain();
            return $mainInfo . "werkt op afdeling " . $this->werktOpAfdeling . "<br /><br />";
        }
    }

    /**
     *
     */
    class icter extends medewerker {
        public $werktOpAfdeling;
        public function __construct() {
            $this->werktOpAfdeling = "ict";
        }

        public function showInfo() {
            $mainInfo = $this->showInfoMain();
            return $mainInfo . "werkt op afdeling " . $this->werktOpAfdeling . "<br /><br />";
        }
    }

    /**
     *
     */
    class administratiefMedewerker extends medewerker {
        public $werktOpAfdeling;
        function __construct() {
            $this->werktOpAfdeling = "administractie";
        }

        public function showInfo() {
            $mainInfo = $this->showInfoMain();
            return $mainInfo . "werkt op afdeling " . $this->werktOpAfdeling . "<br /><br />";
        }
    }










 ?>
