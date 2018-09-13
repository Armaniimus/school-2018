<?php


/**
 * routs the url to the correct controller
 */
class Router {

    function __construct($rootUrlStart = 0) {
        // getPayload
        $url = $_SERVER['REQUEST_URI'];
        $packets = explode("/", $url);
        var_dump($packets);
        $this->return = $this->determineDestination($packets, $rootUrlStart);
    }

    /**
     * @param array packets
     * @return
     */
    public function determineDestination($packets, $rootUrlStart) {
        $filteredPackets = array_slice($packets, $rootUrlStart);
        return $this->sendToDestination($filteredPackets);
    }

    public function sendToDestination($packets) {

        try {
            // set up the name and path
            $ctrlName = $packets[0];
            $name = "Controller_$ctrlName";
            $path = "Controller/$name.php";
            require_once $path;

            //setup the params and run the controller
            if ($packets[1]) {
                $controller = new $name($packets[1]);
            } else {
                $controller = new $name();
            }
            return $controller->return;

        } catch(exeption $e) {
            return;
        }

    }
}
?>
