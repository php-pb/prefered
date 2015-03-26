<?php

define('VIEW_PATH', realpath(__DIR__ . '/../app/views'));

require __DIR__ . '/../vendors/Slim/Slim.php';
$config = require __DIR__ . '/../app/config.php';

$connection = function () use ($config) {
    try {
        yield new \PDO(sprintf(
            '%s:host=%s;dbname=%s',
            $config['db_connection']['driver'],
            $config['db_connection']['hostname'],
            $config['db_connection']['dbname']
        ),
            $config['db_connection']['user'],
            $config['db_connection']['password']
        );
    } catch (Exception $e) {
        exit($e->getMessage());
    }
};

$generator = $connection();

$app = new Slim();

//Page root:
/* List all room where the event is on. */
$app->get('/', function() use ($generator) {
    try {
        $stmt = $generator
            ->current()
            ->query('SELECT sala FROM palestra GROUP BY sala')
            ->fetchAll();
    } catch (Excepion $e) {
        $generator->throw(new Exception('Shit happens!'));
    }

    require VIEW_PATH . '/index.phtml';
});

//Page room:
//List all lecture per room;
$app->get('/:sala', function($sala) use ($generator) {
    try {
        $go = $generator
            ->current()
            ->prepare('SELECT id, nome, sala FROM palestra WHERE sala = :sala')
            ->execute([':sala' => $sala])
            ->fetchAll();

        require VIEW_PATH . '/sala.phtml';
    } catch (PDOException $e) {
        $generator->throw($e);
    }
});

//Page lecture:
//List the specific lecture;
$app->get('/palestra/:id', function($id) use ($generator) {
    try {
        $go = $generator
            ->current()
            ->prepare('SELECT * FROM palestra WHERE id = :id')
            ->execute([':id' => $id])
            ->fetchAll();

        require VIEW_PATH . '/palestra.phtml';
    } catch (PDOException $e) {
        $generator->throw($e);
    }
});

//Page vote:
//Get the vote of the user, based in your preferences;
$app->get('/palestra/:id/:voto', function($id, $voto) use ($generator) {
    try {
        $stmt = $generator
            ->current()
            ->prepare('SELECT * FROM voto WHERE palestra_id = :id')
            ->execute([':id' => $id]);

        $generator
            ->current()
            ->prepare('UPDATE voto SET :voto = :voto + 1 WHERE palestra_id = :id')
            ->execute([
                ':id' => $id,
                ':voto' => $voto,
            ]);

    } catch (PDOException $e) {
        $generator->throw($e);
    }

    require VIEW_PATH . '/obrigado.phtml';
});

$app->run();
