<?php
ini_set("display_errors", 1);
require "../vendors/Slim/Slim.php";
require "../app/Connection.php";

$slim = new Slim();

//Page root:
//List all room where the event is on.
$slim->get('/', function(){
    $conn = new Connection();
    $sql = "SELECT sala
            FROM palestra
            GROUP BY sala";
    $stmt = $conn->getConnection()
                ->query($sql)
                ->fetchAll();

    require '../app/views/index.phtml';
});

//Page room:
//List all lecture per room;
$slim->get('/:sala', function($sala){
    $conn = new Connection();
    $sql = "SELECT id, nome, sala
            FROM palestra
            WHERE sala = :sala";
    $stmt = $conn->getConnection()
                ->query($sql)
                ->bindParam(':sala', $sala)
                ->fetchAll();
    require "../app/view/sala.phtml";
});

//Page lecture:
//List the specific lecture;
$slim->get('/palestra/:id', function($id){
    $conn = new Connection();
    $sql = "SELECT *
            FROM palestra
            WHERE id = :id";
    $stmt = $conn->getConnection()
                ->query($sql)
                ->bindParam(':id', $id)
                ->fetch();
    require "../app/view/palestra.phtml";
});

//Page vote:
//Get the vote of the user, based in your preferences;
$slim->get('/palestra/:id/:voto', function($id,$voto){
    $conn = new Connection();
    $sql = "SELECT *
            FROM voto
            WHERE palestra_id = :id";
    $stmt = $conn->getConnection()
            ->query($sql)
            ->bindParam(":id", $id)
            ->fetch();
    if(!($stmt)){
        $sql = "INSERT INTO voto
                VALUES(:id, 0, 0 )";
        $conn->getConnection()
             ->query($sql)
             ->execute(array(':id'=>$id, ':voto'=>$voto));
    }

    $sql = "UPDATE voto
            SET :voto = :voto + 1
            WHERE palestra_id = :id";
    $conn->getConnection()
         ->query($sql)
         ->execute(array(":id"=>$id, ":voto"=>$voto));

    require '../app/views/obrigado.phtml';
});

$slim->run();