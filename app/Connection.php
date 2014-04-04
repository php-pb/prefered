<?php
class Connection extends PDO {
    
    const DNS = 'mysql:host=localhost; dbname=prefered';
    const USER = 'root';
    const PWD = '123456';
    
    private static $conn;

    protected function Connection($dns,$user, $password){
        try {
            self::$conn = parent::__construct(self::DNS, self::USER, self::PWD);
        } catch (PDOException $ex) {
            echo "Connection fail: ".$ex->getMessage();
            return FALSE;
        }
    }
    
    public function __destruct() {
        self::$conn = FALSE;        
    }
    
    public static function getConnection() {
        if(self::$conn == NULL){
            self::$conn = new Connection(self::DNS, self::USER, self::PWD);
        }
        return self::$conn;
    }
}