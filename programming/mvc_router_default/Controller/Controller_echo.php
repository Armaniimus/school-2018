<?php

    /**
     *
     */
    class Controller_echo
    {
        function __construct($method, $params = FALSE) {
            $this->method = $method;
            if ($params != FALSE) {
                $this->params = implode("/", $params);
            } else {
                $this->params = "are not defined";
            }
        }

        public function runController() {
            $message = "Method = " . $this->method . " and params are " . $this->params;
            return $message;
        }
    }

?>
