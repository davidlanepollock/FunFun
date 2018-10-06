<?php

class Cart {

    private $cart;
    private $database;
    private $cartid;

    public function __construct() {
        $this->cart = null;
        $this->database = new Database();
    }

    public function AddToCart($productID, $sellerID, $quantity) {
        try {
            $this->CreateCart();
            if ($this->addproductToCart($productID, $quantity, $sellerID)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo 'An error occured while adding to cart.';
            return false;
        }
    }

    public function RemoveFromCart($productID, $sellerID) {
        $productID = filter_var($productID, FILTER_SANITIZE_NUMBER_INT);
        $sellerID = filter_var($sellerID, FILTER_SANITIZE_NUMBER_INT);
        $user = Sessions::get('uid');
        $sessionID = Sessions::get('s_id');
        try {
            if($user == "")
            {
                $user = -1;
            }
            
            if ($this->getCartID($user, $sessionID)) {
                return $this->removeproductFromCart($productID, $sellerID);
            } else {
                // couldnt get cart id;
            }
        } catch (Exception $ex) {
            echo 'An error occured while adding to cart.';
        }
    }

    public function DeleteCart() {
        try {
            $user = Sessions::get('uid');
            $this->deleteproductCart($user);
        } catch (Exception $ex) {
            echo 'An error occured while deleted cart.';
        }
    }

    public function CreateCart() {
        try {
            $user = Sessions::get('uid');
            $this->createproductCart($user);
        } catch (Exception $ex) {
            echo 'An error occured while deleted cart.';
        }
    }

    public function CartExists() {
        $id = filter_input(INPUT_SESSION, 'uid', FILTER_SANITIZE_NUMBER_INT);
        return $this->doescartExists($id);
    }

    private function doescartExists($id) {
        $query = $this->database->select("SELECT * FROM cart WHERE uid='$id' AND cartpaid='false'");
        if ($query->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

//cart should already exist and be checked before calling this function
    private function addproductToCart($uproductID, $uquantity, $usellerID) {
//grabs product info from product class
        $productID = filter_var($uproductID, FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_var($uquantity, FILTER_SANITIZE_NUMBER_INT);
        $sellerID = filter_var($usellerID, FILTER_SANITIZE_NUMBER_INT);
        echo $sellerID;
        $userID = Sessions::get('uid');
        try {
//add product to cart
            $query = $this->database->prepare("INSERT INTO cartDesc (cart_id, product_id, quantity, seller_id) VALUES (:c_id, :p_id, :quant, :s_id) ON DUPLICATE KEY UPDATE seller_id = :s_id, quantity = :quant, removedFromCart=0");
            $query->bindParam(":s_id", $sellerID);
            $query->bindParam(":p_id", $productID);
            $query->bindParam(":quant", $quantity);
            $query->bindParam(":c_id", $this->cartid);
            if ($query->execute()) {
                return true;
            } else {
                /*
                 * Error Logging Here: echo "uh oh..";
                  echo $query->errorCode();
                  print_r($query->errorInfo());
                  echo $sellerID . $productID . $quantity . $this->cartid;
                 */
                return false;
            }
        } catch (Exception $e) {
            // additional error logging here
            //echo $e->getMessage();
        }
    }

    private function removeproductFromCart($productID, $sellerID) {
//check if cart exists ie: cartPaid = false(it should unless item has been paid for already)
        try {
            $cartID = filter_var($this->cartid, FILTER_SANITIZE_NUMBER_INT);
            echo Sessions::get('uid') . Sessions::get('uid');
            $query = $this->database->prepare("UPDATE cartDesc SET removedFromCart=1 WHERE seller_id= :s_id AND product_id= :p_id AND cart_id= :c_id");
            $query->bindParam(":s_id", $sellerID);
            $query->bindParam(":p_id", $productID);
            $query->bindParam(":c_id", $cartID);
            echo $this->cartid;
            echo "s=" . $sellerID . "p=". $productID;
            if ($query->execute()) {
                return true;
                echo "hah";
            } else {
                echo $query->errorCode() . $query->errorInfo();
                echo "nah";
                /*
                 * Error Logging Here: echo "uh oh..";
                  echo $query->errorCode();
                  print_r($query->errorInfo());
                  echo $sellerID . $productID . $quantity . $this->cartid;
                 */
                return false;
            }
        } catch (Exception $e) {
            // additional error logging here
            //echo $e->getMessage();
        }
    }

    private function createproductCart($user) {
//create cart based off of the user id
        if($user =="")
        {
            $user = null;
        }
        $session_id = Sessions::get('s_id');
        try {
            $query = $this->database->prepare("SELECT * FROM cart WHERE (user_id=:u_id OR session_id=:s_id) AND cart_paid='0'");
            $query->bindParam(":u_id", $user);
            $query->bindParam(":s_id", $session_id);
            $query->execute();
            if ($query->rowCount() == 0) {
                $insert_query = $this->database->prepare("INSERT INTO cart (user_id, session_id) VALUES (:u_id, :s_id)");
                $insert_query->bindParam(":u_id", $user);
                $insert_query->bindParam(":s_id", $session_id);
                $insert_query->execute();
                echo "Cart Created";
            } else {
                $output = $query->fetch(PDO::FETCH_ASSOC);
                $this->cartid = $output['id'];
                echo $this->cartid;
                echo "Cart Already Exists";
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    private function getCartID($user, $session_id) {
        if($user == "")
        {
            $user = -1;
        }
        $query = $this->database->prepare("SELECT * FROM cart WHERE (user_id=:u_id OR session_id=:s_id) AND cart_paid='0'");
        $query->bindParam(":u_id", $user);
        $query->bindParam(":s_id", $session_id);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->cartid = $result['id'];
            return true;
        } else {
            return false;
        }
    }

//Should only be called after a purchase has taken place or and account has been deleted
    private function deleteproductCart($user, $cartid = null) {
//delete cart based off of the user id and ensure its the oldest cart
        $query = $this->database->delete("DELETE FROM cart WHERE userid='$user' AND cartPaid='false'");
    }

}
