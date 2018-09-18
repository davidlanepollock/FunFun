<?php

class Cart {

    private $cart;
    private $database;

    public function __construct() {
        $this->cart = null;
        $this->database = new Database();
    }

    public function AddToCart($productID, $quantity) {
        $user = Sessions::get('uid');
        try {
            if ($this->addproductToCart($productID, $quantity, $user)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo 'An error occured while adding to cart.';
            return false;
        }
    }

    public function RemoveFromCart() {
        $productID = filter_input(INPUT_POST, 'productID', FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
        $user = Sessions::get('uid');
        try {
            $this->removeproductFromCart($productID, $quantity, $user);
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
    private function addproductToCart($productID, $quantity, $user) {
        //grabs product info from product class
        try {
            //add product to cart
            $this->database->insert("INSERT INTO cartdesc (COLUMN NAMES) VALUES () ON"
                    . "DUPLICATE KEY UPDATE name='', age='' ");
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    private function removeproductFromCart($productID, $quantity, $user) {
        //check if cart exists ie: cartPaid = false(it should unless item has been paid for already)
        $this->database->delete("DELETE FROM cartdesc WHERE userid='', productid='', cartid=''");
        //removed product from cart
    }

    private function createproductCart($user) {
        //create cart based off of the user id
        $query = $this->database->select("SELECT * FROM cart WHERE userid='$user' AND cartPaid='FALSE'");
        if ($query->rowCount() == 0) {
            $this->database->insert("INSERT INTO cart () VALUES ()");
        } else {
            echo "There was an error with our system";
        }
    }

    //Should only be called after a purchase has taken place or and account has been deleted
    private function deleteproductCart($user, $cartid = null) {
        //delete cart based off of the user id and ensure its the oldest cart
        $query = $this->database->delete("DELETE FROM cart WHERE userid='$user' AND cartPaid='false'");
    }

}
