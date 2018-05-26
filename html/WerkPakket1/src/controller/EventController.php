<?php

namespace controller;

use model\EventRepository;
use view\View;
class EventController
{
    private $eventRepository;
    private $view;

    public function __construct(EventRepository $eventRepository, View $view)
    {
        $this->eventRepository = $eventRepository;
        $this->view = $view;
    }

    public function handleGetAllEvents()
    {
        $event = $this->eventRepository->getAllEvents();
        $this->view->show(['event' =>$event]);
    }

    public function handleGetEventByEventId($id)
    {
        $event = $this->eventRepository->getEventByEventId($id);
        $this->view->show(['event' =>$event]);
    }

    public function handleGetEventByPersonId($id)
    {
        $event = $this->eventRepository->getEventByPersonId($id);
        $this->view->show();
    }

    public function handleGetEventByDate($beginDate, $endDate)
    {
        $event = $this->eventRepository->getEventByDate($beginDate, $endDate);
        $this->view->show();
    }

    public function handleGetEventByPersonIdByDate($id, $beginDate, $endDate)
    {
        $event = $this->eventRepository->getEventByPersonIdByDate($id, $beginDate, $endDate);
        $this->view->show();
    }

    public function handleCreateEvent($event)
    {
        $this->eventRepository->createEvent($event);
    }

    public function handleDeleteEvent($id)
    {
        $this->eventRepository->removeEvent($id);
    }

}