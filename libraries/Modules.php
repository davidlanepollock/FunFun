<?php

class Modules {

   private $database;

    public function __construct($id) {
        $this->database = new Database();
    }

    public function recommendedProducts()
    {
        //input: user, current page
        
        $statement = "SELECT * FROM products p INNER JOIN pageviews pv ON p.id = pv.product_id WHERE (pv.product_from = :pid OR pv.product_to = :pid) AND pv.uid != :uid LIMIT 10";
        $query = $this->database->prepare($statement);
        $query->bindParam(':pid', $product_id);
        $query->bindParam(':uid', $user_id);
        if($query->execute())
        {
            return $this->createResult($query);
        }
        else
            {
            return $this->createError();
        }
                
    }
    public function recentlyViewed()
    {
        //input: user
        
        $statement = "SELECT * FROM products p INNER JOIN pageviews pv ON p.id = pv.product_id WHERE (pv.product_from = :pid OR pv.product_to = :pid) AND pv.uid != :uid LIMIT 10";
        $query = $this->database->prepare($statement);
        $query->bindParam(':pid', $product_id);
        $query->bindParam(':uid', $user_id);
        if($query->execute())
        {
            return $this->createResult($query);
        }
        else
            {
            return $this->createError();
        }
    }
    public function Advertisement()
    {
        //input: ad type, current page, user, etc
    }
    public function ProductDeals()
    {
        //input: user id, user category(category where user spends most time)
    }
    private function createResult($queryResult)
    {
        $count = 0;
        $output = null;
        foreach($queryResult as $result)
        {
            $output[$count]['product_id'] = $result['id'];
        }
    }
    private function createError()
    {
        $output = null;
        $output = "Error";
        return $output;
    }
    
}
