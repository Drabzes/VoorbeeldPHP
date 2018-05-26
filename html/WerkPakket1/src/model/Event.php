<?php

namespace model;

class Event
{
    public $id;
    public $customerId;
    public $name;
    public $location;
    public $date;

    public function __construct($id, $customerId, $name, $location, $date)
    {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->name = $name;
        $this->location = $location;
        $this->date = $date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

}