<?php

class Products {

    private $product;
    private $database;
    private $cart;

    public function __construct($id) {
        $this->product = null;
        $this->product['id'] = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $this->cart = new Cart(); 
        $this->database = new Database();
    }

    public function generateProductPage($name, $description) {
        try{
        $this->product['name'] = filter_var($name, FILTER_SANITIZE_STRING);
        $this->product['desc'] = filter_var($description, FILTER_SANITIZE_STRING);
        $this->generateCheckout(); 
        $this->generateProductImage();
        $this->product['manufacturer'] = "Manufacturer description will go here";
        $this->generateSpecs();
        $this->product['recommended'] = "recommended product list will go here";
        $this->product['othersViewed'] = "products viewed by others after this product will go here";
        return $this->product;
        
        } catch (Exception $ex) {
           //do something
            echo "error in products";
        }
    }

    private function generateProductImage() {
        $iteration = 0;
        $db = $this->database;
        $images = $db->select("SELECT * FROM ProductImages WHERE ProductId='{$this->product['id']}'");
       if($images->rowCount() >= 1)
       {
        foreach ($images as $productImage) {
            if ($productImage['mainPicture']) {
                $this->product['mainIMG'] = $productImage['url'];
                $this->product['smainIMG'] = $productImage['surl'];
            }
            $value = "IMG" . $iteration;
            $this->product[$value] = $productImage['url'];
            $this->product["s" . $value] = $productImage['surl'];

            if ($productImage['url'] == null) {
                $this->product[$value] = 'null';
            }
            if ($productImage['url'] == null) {
                $this->product["s" . $value] = 'null';
            }

            $iteration++;
        }
        if (!isset($this->product['mainIMG'])) {
            $this->product['mainIMG'] = $this->product["IMG0"];
            $this->product['smainIMG'] = $this->product["sIMG0"];
        }
       }
    }

    //grabs row from product spec db and runs through all relevent specs
    // returns html for product page
    private function generateSpecs() {
        $this->product['specs'] = '<ul>
        <li id="spec_type">Brand: Nike</li>
        <li id="spec_type">Material: 60% Cotton 40% Polyester</li>
        <li id="spec_type"></li>
        <li id="spec_type"></li>
        <li id="spec_type"></li>
        <li id="spec_type"></li>
    </ul>';
    }

    private function recommendedProducts() {
        
    }

    private function generateCheckout() {
        $this->product['recommendedseller'] = "MSD Merch";
        $this->product['recommendedsid'] = "1";
        $this->product['checkoutquantity'] = 50;
    }

    private function addToCart($productid = null, $productquantity = null) {
        if ($productid === null && $productquantity === null) {
            $productid = filter_input(INPUT_POST, 'productid', FILTER_SANITIZE_NUMBER_INT);
            $productquantity = filter_input(INPUT_POST, 'productquantity', FILTER_SANITIZE_NUMBER_INT);
        }
        $productid = filter_var($productid, FILTER_SANITIZE_NUMBER_INT);
        $productquantity = filter_var($productquantity, FILTER_SANITIZE_NUMBER_INT);
        //check if cart exists
        if ($this->cart->CartExists()) {
            $this->cart->AddToCart($productid, $productquantity);
            return true;
        } else {
            $this->cart->CreateCart();
            $this->cart->AddToCart($productID, $productquantity);
            return true;
        }
        return false;

        //add product to cart
    }

    private function removeFromCart($productid = null) {
        //check if cart exists (it should unless item has been paid for already)
        if ($productid === null) {
            $productid = filter_input(INPUT_POST, 'productid', FILTER_SANITIZE_NUMBER_INT);
        }
        $productid = filter_var($productid, FILTER_SANITIZE_NUMBER_INT);
        //check if cart exists
        if ($this->cart->CartExists()) {
            $this->cart->RemoveFromCart($productid);
            return true;
        } else {
            return false;
        }
        return false;
    }
    
    

}
