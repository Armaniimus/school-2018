<?php

class vehicle {
    /*** Set public variables ***/
    public $color;
    public $num_doors;
    public $price;
    public $shape;
    public $brand;

    /*** The constructor ***/
    public function __construct() {
        echo "About this vehicle.<br />";
    }

    // /*** a Method to show the number of doors. ***/
    // public function ShowPrice() {
    //     return "This vehicle costs " . $this->price . "<br />";
    // }
    //
    // /*** a Method to show the number of doors. ***/
    // public function ShowNumberOfDoors() {
    //     return " This vehicle has " . $this->num_doors . " doors.<br />";
    // }

    /*** a Method to drive the vehicle. ***/
    public function Drive() {
        return "VRRROOOOOOOOOM!!! <br />";
    }


} /***end of class ***/

class motorcycle extends vehicle {

    public $handlebars;
    public $numSidecars;

    public function setHandlebars($handlebarType) {
        $this->handlebars = $handlebarType;
    }

    public function setSideCar($numSidecars) {
        $this->numSidecars = $numSidecars;
    }

    /**
    *
    *
    *
    *
    *
    */
    public function ShowSidecar () {
        return 'This motorcycle has ' . $this->numSidecars . ' sideCars <br />';
    }
} /*** end of class ***/







?>
