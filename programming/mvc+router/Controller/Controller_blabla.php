<?php
    /**
     *
     */
    class Controller_blabla
    {
        function __construct($method = NULL) {
            switch ($method) {
                case 'create':
                    $this->return = $this->create();
                    break;

                case 'update':
                    $this->return = $this->update();
                    break;

                case 'delete':
                    if (isset($_GET['id']) ) {
                        $id = $_GET['id'];
                        $this->return = $this->delete($id);
                    } else {
                        $this->return = $this->read();
                    }
                    break;

                default:
                    $this->return = $this->read();
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
