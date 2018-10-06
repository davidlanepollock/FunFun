<?php

class cart_model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_cart($user_id = 'null') {

        $page_obj = null;
        if ($product_id != 'null') {
            $id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);
            if ($this->checkCache($product_id)) {
                $page_obj = $this->grabCache($product_id);
            } else {
                $database = new Database();
                $user_id = Sessions::get('uid');
                if ($user_id == "") {
                    $user_id = -1;
                }
                $sessionID = Sessions::get('s_id');
                $query = $database->prepare("SELECT * FROM cart c INNER JOIN cartDesc cd ON c.id = cd.cart_id WHERE (c.user_id=:u_id OR c.session_id=:sid) AND c.cart_paid=0 AND cd.removedFromCart=0");
                if (isset($user_id)) {
                    $query->bindParam(':u_id', $user_id);
                }
                if (isset($sessionID)) {
                    $query->bindParam(':sid', $sessionID);
                }
//                if ($isset($user_id) || isset($sessionID)) {
                try {
                    if ($query->execute()) {
//                    if ($query->execute()) {
                        $obj = $this->create_result($query);
                    } else {
                        echo $query->errorCode();
                        echo $query->errorInfo();
                        echo 'here';
                    }
//                        $page_obj = $this->generate_page($query);
//                        $this->createCache($product_id, $page_obj);
//                    }else{
//                        echo "query failed";
//                    }}
                } catch (PDOException $e) {
                    echo $e;
                }
//            }else{
//                echo 'there';
//            }

                return $obj;
            }
        }
        if ($page_obj == null) {
            $page_obj = $this->generate_404();
        }
        //todo:: update page viewcount
        return $page_obj;
    }

    private function create_result($database_result) {
        $obj = null;
        $count = 0;
        $results = $database_result->fetchAll();
        foreach ($results as $result) {
            $obj[$count]['quantity'] = $result['quantity'];
            $obj[$count]['addedDate'] = $result['addedDate'];
            $obj[$count]['seller_id'] = $result['seller_id'];
            $obj[$count]['product_id'] = $result['product_id'];
            //grab product information
            $obj[$count]['product_info'] = $this->grab_product_info($result['product_id']);
            //grab seller information
            $count++;
        }
        return $obj;
    }

    private function grab_product_info($product_id) {
        $database = new Database();
        $product = null;
        $query = $database->prepare("SELECT * FROM product p INNER JOIN ProductImages pi ON p.id = pi.ProductId WHERE p.id = :product_id AND pi.MainPicture = 1 LIMIT 1");
        $query->bindParam(":product_id", $product_id);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $product['url'] = $result['url'];
            $product['name'] = $result['name'];
            return $product;
        } else {
//                         echo $query->errorCode();
//                        echo $query->errorInfo();
        }
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