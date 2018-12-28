<?php
class Model {
    public $database;
    
    public function __construct() {
        echo "above";
        $this->database = new Database();
        echo "below";
    }
}