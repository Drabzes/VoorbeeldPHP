<?php

namespace model;

interface EventRepository
{
    public function getAllEvents();
    public function getEventByEventId($id);
    public function getEventByPersonId($id);
    public function getEventByDate($beginDate, $endDate);
    public function getEventByPersonIdByDate($id, $beginDate, $endDate);
    public function createEvent(Event $event);
    public function updateEvent(Event $event);
    public function removeEvent($id);
}