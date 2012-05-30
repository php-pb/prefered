<?php

class Connection {
    public function getConnection(){
        return new PDO('mysql:host=localhost;dbname=prefered', 'root', '123456');
    }
}