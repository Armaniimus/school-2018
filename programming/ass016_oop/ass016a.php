<?php
    include "ass016.php";

    //Creates a new Object
    $vehicle = new vehicle;
    $vehicle->brand = 'Porsche';
    $vehicle->shape = 'Coupe';
    $vehicle->color = 'red';
    $vehicle->num_doors = 2;
    $vehicle->price = 100000;


    echo "This vehicle costs " . $vehicle->price . "<br />";
    echo "This vehicle has " . $vehicle->num_doors . " doors.<br />";
    echo $vehicle->Drive();



    //Creates a new Object
    echo "<br />";
    $vehicle2 = new vehicle;
    $vehicle2->brand = 'Mercedes';
    $vehicle2->shape = 'StationWagon';
    $vehicle2->color = 'Blue';
    $vehicle2->num_doors = 4;
    $vehicle2->price = 300000;

    echo "This vehicle costs " . $vehicle2->price . "<br />";
    echo "This vehicle has " . $vehicle2->num_doors . " doors.<br />";
    echo $vehicle2->Drive();
 ?>
