<?php

class ProductsRouter {
    private $controller;

    public function __Construct() {
        require_once 'controller/productsController.php';
        $this->controller = new ProductsController("stardunks", "root", "");
    }

    public function __Destruct() {
        $controller = null;
    }

    public function handleRequest() {

        if (isset($_GET['op']) ) {
            $op = $_GET['op'];

        } else {
            $op = "";
        }

        switch ($op) {
            case 'create':
                $this->controller->collectCreateProducts();
                break;

            case 'update':
                $this->controller->collectUpdateProduct();
                break;

            case 'delete':
                if (isset($_GET['id']) ) {
                    $id = $_GET['id'];
                    $this->controller->collectDeleteProducts($id);
                }
                break;

            case 'search':
                $this->controller->collectSearchProducts();
                break;

            default:
                $this->controller->collectReadProducts();
                break;
        }
    }
}

?>
