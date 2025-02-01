<?php
    require_once 'database.php';
    class crud extends database{
        public function __construct(){
            parent::__construct();
        }

        public function  execute($query){
            $result = $this->connection->query($query);
            if ($result == false){
                echo "<p>Could not execute</p>";
                return false;
            } else {
                return true;
            }
        }
        public function escape_string($value){
            return $this->connection->real_escape_string($value);
        }
    }

?>