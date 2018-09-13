<?php
class Controller {
    public function __construct() {
        $this->view = new View();
    }

    public function loadModel($name) {

        $path = 'models/model.' . $name . '.php';

        if (file_exists($path)) {
            require_once 'models/model.' . $name . '.php';

            $modelName = $name . '_model';

            $this->model = new $modelName;
        }
    } 
}
?>