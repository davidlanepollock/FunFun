<?php

class product extends Controller {

    public function main() {
        $this->view->title = " | Website";
        $this->view->stylesheet = "product.css";
        $this->getProduct();
        $this->view->render('product/main');
    }
    //checks if js is enabled, if so sends an auth token to call dynamically
    // upon page load by call function grab_product
    public function getProduct() {
        $this->view->js = true;
        $product = $this->grabUrl();
        $this->view->product_name = $product['name'];
        $this->view->product_id = $product['id'];
        $this->view->auth = null;
        if (Sessions::get('js') == 'false') {
            $this->view->js = false;
            $this->view->product = $this->grab_product_noJS($this->view->product_id, $this->view->product_name);
        } else {
            $pageGen = rand();
            Sessions::set('pageGen', $pageGen);
            $this->view->auth = $pageGen;
        }
        return false;
    }

    private function grabUrl() {
        $product = null;
        $product['name'] = filter_input(INPUT_GET, 'product_name', FILTER_SANITIZE_STRING);
        if (!isset($product['name'])) {
            $product['name'] = 'null';
        }
        $product['id'] = intval(filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT));
        if (!isset($product['id'])) {
            $product['id'] = 'null';
        }
        return $product;
    }

    public function grab_product() {

        try {
            $temp = filter_input(INPUT_POST, 'auth', FILTER_SANITIZE_NUMBER_INT);
            if (Sessions::get('pageGen') == $temp) {
                $this->loadModel('product');
                $product['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $product['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                if (!isset($product['id'])) {
                    echo "Invalid Product ID";
                } else {
                    $product['outputproduct'] = $this->model->get_product($product['id'], $product['name']);
                    echo json_encode($product);
                }
            } else {
                echo "Invalid Authorization Token";
            }
        } catch (Exception $ex) {
            echo "error in controller;";
        }
    }

    public function add_cart($product_id = null, $seller_id = null, $quantity = null) {
        if ($product_id == null && $seller_id == null) {
            $product_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $seller_id = filter_input(INPUT_POST, 'sid', FILTER_SANITIZE_NUMBER_INT);
        } else {
            $product_id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);
            $seller_id = filter_var($seller_id, FILTER_SANITIZE_NUMBER_INT);
        }
        if ($quantity == null) {
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
        } else {
            $quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT);
        }
        if ($product_id != null && $seller_id != null) {
            if ($quantity == null || $quantity == '') {
                $quantity = 1;
            }
            try {
                //add to cart
                $cart = new Cart();
                if($cart->AddToCart($product_id, $seller_id, $quantity))
                {
                    $obj = "Product Added To Cart";
                }else{
                    $obj = "Product Not Added To Cart";
                }
                echo json_encode($obj);
            } catch (Exception $ex) {
                echo "An error occured: " . $ex;
            }
        } else {
            echo "no product or seller id";
        }
    }
    public function remove_cart()
    {
        $productID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $sellerID = filter_input(INPUT_POST, 'sid', FILTER_SANITIZE_NUMBER_INT);
        try {
                //remove from cart
                $cart = new Cart();
                if($cart->RemoveFromCart($product_id, $seller_id))
                {
                    $obj = "Product Added To Cart";
                }else{
                    $obj = "Product Not Added To Cart";
                }
                echo json_encode($obj);
            } catch (Exception $ex) {
                echo "An error occured: " . $ex;
            }
    }
    public function jsTest() {
        Sessions::set('js', 'true');
        echo "js enabled";
    }

    private function grab_product_noJS($id, $name) {
        $this->loadModel('product');
        return $this->model->get_product($id, $name);
    }

}

?>