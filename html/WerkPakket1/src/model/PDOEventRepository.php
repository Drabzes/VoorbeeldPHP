<?php

namespace model;

class PDOEventRepository implements EventRepository
{
    private $connection = null;
    private $resultArray = array();

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAllEvents()
    {
      try {
          $statement=$this->connection->query('SELECT * FROM events');
          $statement->setFetchMode(\PDO::FETCH_ASSOC);
          $statement->execute();
          $results=$statement->fetchall();

          $this->PutArrayInEvent($results);
          return $this->resultArray;
      } catch (\Exception $exception) {
             return 'test';
          }
    }

    public function getEventByEventId($id)
    {
       try {
           $eventId = $id;
           $statement = $this->connection->prepare('SELECT * FROM events WHERE event_id = :id');
           $statement->bindParam(':id', $eventId, \PDO::PARAM_INT);
           $statement->setFetchMode(\PDO::FETCH_ASSOC);
           $statement->execute();
           $results = $statement->fetchAll();

           $this->PutArrayInEvent($results);
           return $this->resultArray;

        } catch(\Exception $exception){
            return null;
        }
    }

    public function getEventByPersonId($id)
    {
      try {
          $personId=$id;
          $statement=$this->connection->prepare('SELECT * FROM events WHERE customer =:customerId');
          $statement->bindParam(':customerId', $personId, \PDO::PARAM_INT);
          $statement->setFetchMode(\PDO::FETCH_ASSOC);
          $statement->execute();
          $results=$statement->fetchall();

          $this->PutArrayInEvent($results);
          return $this->resultArray;
      } catch(\Exception $exception) {
          return null;
      }
    }

    public function getEventByDate($beginDate, $endDate)
    {
        try {
            $statement=$this->connection->prepare('SELECT * FROM events WHERE date BETWEEN :beginDate AND :endDate');
            $statement->bindParam(':beginDate', $beginDate,\PDO::PARAM_STR);
            $statement->bindParam(':endDate', $endDate, \PDO::PARAM_STR);
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $statement->execute();
            $results=$statement->fetchall();

            $this->PutArrayInEvent($results);
            return $this->resultArray;
        } catch(\Exception $exception) {
            return null;
        }
    }

    public function getEventByPersonIdByDate($id, $beginDate, $endDate)
    {
        try {
            $personId=$id;
            $statement=$this->connection->prepare('SELECT * FROM events WHERE customer =:personId AND date BETWEEN :beginDate AND :endDate');
            $statement->bindParam(':personId', $personId, \PDO::PARAM_INT);
            $statement->bindParam(':beginDate', $beginDate, \PDO::PARAM_STR);
            $statement->bindParam(':endDate', $endDate, \PDO::PARAM_STR);
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $statement->execute();
            $results=$statement->fetchall();

            $this->PutArrayInEvent($results);
            return $this->resultArray;
        } catch(\Exception $exception) {
            return null;
        }
    }

    public function createEvent(Event $event)
    {
        try {
        $statement=$this->connection->prepare('INSERT INTO events (customer, event_name, location, date) VALUES (:customerId, :eventName, :eventLocation, :eventDate)');
        $statement->bindValue(':customerId', $event->getCustomerId(), \PDO::PARAM_INT);
		$statement->bindValue(':eventName', $event->getName(), \PDO::PARAM_STR);
		$statement->bindValue(':eventLocation', $event->getLocation(), \PDO::PARAM_STR);
		$statement->bindValue(':eventDate', $event->getDate(), \PDO::PARAM_STR);
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$statement->execute();

		echo 'Nieuw event aangemaakt!';
        } catch(\Exception $exception) {
            return null;
        }
    }

    public function updateEvent(Event $event)
    {

    }

    public function removeEvent($id)
    {
       try {
           $eventId=$id;
           $statement=$this->connection->prepare('DELETE FROM events WHERE event_id = :eventId');
           $statement->bindParam(':eventId', $eventId, \PDO::PARAM_INT);
           $statement->setFetchMode(\PDO::FETCH_ASSOC);
           $statement->execute();

           if($statement->rowCount() >= 1) {
               http_response_code(200);
               echo 'Event Verwijdert!';
           } else {
               http_response_code(404);
           }

       } catch(\Exception $exception){
           http_response_code(500);
           echo $exception->getMessage();
       }
    }

    private function PutArrayInEvent($results){
        if(count($results) > 0) {
                foreach($results as $value){
                    $this->resultArray[] = new Event($value['event_id'], $value['customer'], $value['event_name'], $value['location'], $value['date']);
                }
        }
    }
}