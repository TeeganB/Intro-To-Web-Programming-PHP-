<?php
    class database{
        private $host     = 'localhost';
        private $password = 'mysql';
        private $username = 'root';
        private $database = 'assignment1teeganbuttigieg';
        protected $connection;
        public function __construct(){
            if (!isset($this->connection)){
                $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
                if(!$this->connection){
                    echo "<p>Cannot Connect to Database<p/>";
                    exit;
                }
            }
            return $this->connection;
        }
    }
?>
