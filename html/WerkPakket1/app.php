<?php

require_once 'src/autoload.php';
use \model\PDOEventRepository;
use \view\EventJsonView;
use \view\EventJavaScriptView;
use \controller\EventController;
use \model\Event;

$user = 'root';
$password = 'vagrant';
$database='monkeyBusinessDatabase';
$pdo = null;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$database",
                    $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION);

    $eventPDORepository = new PDOEventRepository($pdo);
    //$eventJsonView = new EventJsonView();
    $eventJavaScriptView = new EventJavaScriptView();
    $eventController = new EventController($eventPDORepository, $eventJavaScriptView);

    $event = new Event(null, 3, 'seminarie PXL', 'Hasselt', '2017-05-23');

    $eventController->handleGetAllEvents();
    echo PHP_EOL . PHP_EOL;
    //$eventController->handleGetEventByEventId(4);
    echo PHP_EOL . PHP_EOL;
    //$eventController->handleGetEventByPersonId(2);
    echo PHP_EOL . PHP_EOL;
    //$eventController->handleGetEventByDate('2017-01-01', '2019-01-01');
    echo PHP_EOL . PHP_EOL;
    //$eventController->handleGetEventByPersonIdByDate(2, '2012-01-01', '2019-01-01');
    echo PHP_EOL . PHP_EOL;
    //$eventController->handleCreateEvent($event);
    echo PHP_EOL . PHP_EOL;
    //$eventController->handleDeleteEvent(6);
} catch (Exception $e){
    echo 'cannot connect to database';
}