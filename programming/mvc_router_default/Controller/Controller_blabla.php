<?php
    /**
     *
     */
    class Controller_blabla
    {
        function __construct($method, $params = FALSE) {
            $this->method = $method;
            if ($params != FALSE) {
                $this->params = $params;
            }
        }

        public function runController() {
            switch ($this->method) {
                case 'create':
                    return $this->create();
                    break;

                case 'update':
                    return $this->update();
                    break;

                case 'delete':
                    if (isset($this->params[0]) ) {
                        $id = $this->params[0];
                        return $this->delete($id);
                    } else {
                        return $this->read();
                    }
                    break;

                default:
                    return $this->read();
                    break;
            }
        }

        public function create() {
            return "The method create is called";
        }

        public function read() {
            return "The method read is called";
        }

        public function update() {
            return "The method update is called";
        }

        public function delete() {
            return "The method delete is called";
        }
    }
?>
