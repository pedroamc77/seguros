<?php
    class db{

        private $dbHost = 'localhost';
        private $dbUser = 'root';
        private $dbName = 'seguros';
        private $dbPass = '';

        // private $dbHost = 'localhost';
        // private $dbUser = 'ibritek_seguros';
        // private $dbName = 'ibritek_royers';
        // private $dbPass = 'royers@calvette#';
    
        public function connectionDB() {
            $mysqlConnect = "mysql:host=".$this->dbHost.";dbname=".$this->dbName;
            $dbConnection = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }
    }