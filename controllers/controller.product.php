<?php

class product extends Controller {

    public function main() {
        $this->view->title = " | Website";
        $this->view->stylesheet = "product.css";
        $this->getProduct();
        $this->view->render('product/main');
    }

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
        $temp = filter_input(INPUT_POST, 'auth', FILTER_SANITIZE_NUMBER_INT);
        if (Sessions::get('pageGen') == $temp) {
            $this->loadModel('product');
            $product['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

            $product['id'] =  filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            if (!isset($product['id'])) {
                echo "Invalid Product ID";
            } else {
                $product['outputproduct'] = $this->model->get_product($product['id'], $product['name']);
                echo json_encode($product);
            }
        } else {
            echo "Invalid Authorization Token";
        }
    }

    public function jsTest() {
        Sessions::set('js', 'true');
        echo "i heard";
    }

    private function grab_product_noJS($id, $name) {
        $this->loadModel('product');
        return $this->model->get_product($id, $name);
    }

}

?>