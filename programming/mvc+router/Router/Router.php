<?php
/**
 * routs the url to the correct controller
 */
class Router {

    function __construct($rootUrlStart = 0) {
        // getPayload
        $url = $_SERVER['REQUEST_URI'];
        $packets = explode("/", $url);
        // var_dump($packets);
        $this->return = $this->determineDestination($packets, $rootUrlStart);

        if ($this->return == FALSE) {
            $this->return = 404;
        }
    }

    /**
     * @param array packets
     * @return
     */
    public function determineDestination($packets, $rootUrlStart) {
        $filteredPackets = array_slice($packets, $rootUrlStart);

        // set up the name and path
        $ctrlName = array_shift($filteredPackets);
        $name = "Controller_$ctrlName";
        $path = "Controller/$name.php";

        // check if destination exists
        if (file_exists ($path) ) {
            require_once $path;
            return $this->sendToDestination($filteredPackets, $path, $name);

        } else {
            return FALSE;
        }
    }

    public function sendToDestination($packets, $path, $name) {
        // split the packets into params and methods
        $method = array_shift($packets);
        $params = $packets;

        //setup the params and run the controller
        if (isset($method) && $method) {
            if (isset($params[0]) && $params[0]) {
                $controller = new $name($method, $params);
            } else {
                $controller = new $name($method);
            }
        } else {
            return FALSE;
        }

        return $controller->runController();
    }
}
?>
