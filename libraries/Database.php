<?php

class Database extends PDO {

    private $DATABASE_TYPE = 'mysql';
    private $DATABASE_HOST = '';
    private $DATABASE_PORT = '';
    private $DATABASE_NAME = '';
    private $DATABASE_USER = '';
    private $DATABASE_PASS = ''; 
    public $link = NULL;

    public function __construct() {
        if ($this->link == Null) {
            try {
                $this->link = parent::__construct($this->DATABASE_TYPE . ':host=' . $this->DATABASE_HOST . ';port='. $this->DATABASE_PORT .';dbname=' . $this->DATABASE_NAME, $this->DATABASE_USER, $this->DATABASE_PASS);
                return $this->link;
            } catch (PDOException $e) {                
                echo "here";
                die($e->getMessage());
            }
        }
    }

    public static function select($sql) {
        if (empty($sql) != true) {
            $database = new Database();
            $query = $database->prepare($sql);
            $query->execute();

            return $query;
        }
    }

    public static function getRowCount($query) {
        return $query->rowCount();
    }

    public static function insert($table, $values = array()) {
        $database = new Database();
        if (empty($table) != true) {
            $insert = $database->prepare("INSERT INTO {$table} VALUES('" . implode("','", $values) . "')");
            $insert->execute();

            return $insert;
        }
    }

    public static function insertBasic($sql) {
        $database = new Database;
        if (empty($sql) != true) {
            $insert = $database->prepare($sql);
            $insert->execute();

            return $insert;
        }
    }

    public function insertByArray($sql = array()) {
        foreach ($sql as $s) {
            $database = new Database;
            $insert = $database->prepare($sql);

            return true;
        }
    }

    public static function update($sql) {
        $database = new Database;
        if (empty($sql) != true) {
            $update = $database->prepare($sql);
            $update->execute();

            return $update;
        }
    }

    public static function delete($sql) {
        $database = new Database;
        if (empty($sql) != true) {
            $delete = $database->prepare($sql);
            $delete->execute();

            return $delete;
        }
    }
    public static function clean($data){
        $newdata = trim(strip_tags(stripslashes($data)));
        return $newdata;
    }

}

?>