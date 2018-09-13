<?php

class product_model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_product($product_id = 'null', $product_name = 'null') {
        $page_obj = null;
        if ($product_id != 'null') {
            $id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);
            if ($this->checkCache($product_id)) {
                $page_obj = $this->grabCache($product_id);
            } else {
                $db = $this->database;
                $query = $db->select("SELECT * FROM product WHERE id='{$id}'");
                if ($db->getRowCount($query) == 1) {
                    $page_obj = $this->generate_page($query);
                    $this->createCache($product_id, $page_obj);
                }
            }
        }
        if ($page_obj == null) {
            $page_obj = $this->generate_404();
        }
        //todo:: update page viewcount
        return $page_obj;
    }

    private function generate_page($query) {
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $id = $fetch['id'];
        $name = $fetch['name'];
        $description = $fetch['description'];
        $product = new Products($id);
        $productObj = $product->generateProductPage($name, $description);
        return $productObj;
    }

    private function generate_404() {
        return "Whoops.. Something went wrong with your request.";
    }

    private function checkCache($product_id) {

        return file_exists($filename);
    }
    //write to db then have another server update the cache
    private function createCache($product_id, $file_info) {
        $dir = "/cache/product/";
        mkdir($dir, 0744);

        $filename = $dir . $product_id . ".html";
      //  file_put_contents($filename, $file_info);
    }

    private function grabCache($product_id) {
        $filename = "/cache/product/" . $product_id . ".html";
        return file_get_contents($filename);
    }

}

?>