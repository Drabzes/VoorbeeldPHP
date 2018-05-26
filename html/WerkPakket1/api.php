<?php

require_once 'src/autoload.php';
require_once 'vendor/autoload.php';

use \model\PDOEventRepository;
use \view\EventJsonView;
use \view\EventJavaScriptView;
use \controller\EventController;

$user = 'root';
$password = 'vagrant';
$database='monkeyBusinessDatabase';
$pdo = null;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$database",
        $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);

    $PDOEventRepository = new PDOEventRepository($pdo);

    $eventJsonView = new EventJsonView();
    $eventController = new EventController($PDOEventRepository, $eventJsonView);

    $router = new AltoRouter();
    $router->setBasePath('/WerkPakket1');

    $router->map('GET', '/events',
        function() use ($eventController) {
            $eventController->handleGetAllEvents();
    });

    $router->map('GET', '/events/[i:id]',
        function($id) use ($eventController) {
            $eventController->handleGetEventByEventId($id);
        });

    $router->map('DELETE', '/events/[i:id]',
        function($id) use ($eventController) {
            $eventController->handleDeleteEvent($id);
        });

    $router->map('GET', '/events/person/[i:personId]',
        function($personId) use ($eventController) {
            $eventController->handleGetEventByPersonId($personId);
        });

    $router->map('GET', '/events/?from=[*:beginDate]&until=[*:endDate]',
        function($beginDate, $endDate) use ($eventController) {
            $eventController->handleGetEventByDate($beginDate, $endDate);
        });

    $router->map('GET', '/person/[i:personId]/events/?from=[*:beginDate]&until=[*:endDate',
        function($personId, $beginDate, $endDate) use ($eventController) {
            $eventController->handleGetEventByPersonIdByDate($personId, $beginDate, $endDate);
        });

    $match = $router->match();
    if($match && is_callable( $match['target'])){
        call_user_func_array($match['target'], $match['params']);
    } else {
        header( $_SERVER["SERVER_PROTOCOL"] . ' 404 ERROR Not Found');
    }
} catch (Exception $exception){
    return $exception;
}