<?php
//ini_set("display_errors", 1);
require "../vendors/Slim/Slim.php";
require "../app/Connection.php";

$slim = new Slim();

//Page root:
//List all room where the event is on.
$slim->get('/', function(){
    $link = Connection::getConnection();
    $sql = "SELECT sala
            FROM palestra
            GROUP BY sala";
    $stmt = $link->query($sql)
                 ->fetchAll();
    require '../app/views/index.phtml';
});

//Page room:
//List all lecture per room;
$slim->get('/:sala', function($sala){
    $link = Connection::getConnection();
    $sql = "SELECT id, nome, sala
            FROM palestra
            WHERE sala = :sala";
    $param = array(":sala"=>$sala);
    
    try {
        $stmt = $link->prepare($sql);
        $stmt->execute($param);
        $go = $stmt->fetchAll();
        require '../app/views/sala.phtml';
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
    
});

//Page lecture:
//List the specific lecture;
$slim->get('/palestra/:id', function($id){
    $link = Connection::getConnection();
    $sql = "SELECT *
            FROM palestra
            WHERE id = :id";
    $param = array(":id"=>$id);
    try {
        $stmt = $link->prepare($sql);
        $stmt->execute($param);
        $go = $stmt->fetchAll();
        require '../app/views/palestra.phtml';
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
});

//Page vote:
//Get the vote of the user, based in your preferences;
$slim->get('/palestra/:id/:voto', function($id,$voto){
    $link = Connection::getConnection();
    
    $sql = "SELECT *
            FROM voto
            WHERE palestra_id = :id";
    
    $param = array(":id"=>$id);
    
    try {
        $stmt = $link->prepare($sql)
                     ->execute($param);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
     
    try{
        $sql = "UPDATE voto
                SET :voto = :voto + 1
                WHERE palestra_id = :id";
        $link->prepare($sql)
             ->execute(array(":id"=>$id, ":voto"=>$voto));

        require '../app/views/obrigado.phtml';
    } catch (PDOException $e) {
        $e->getMessage();
    }
});

$slim->run();