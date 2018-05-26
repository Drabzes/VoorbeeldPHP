<?php

namespace view;

class EventJsonView implements View
{
    public function show($data)
    {

        header('Content-type: application/json');
        if (isset($data['event'])) {
            $event = $data['event'];
            echo json_encode($event);
        } else {
            echo '{test}';
        }
    }
}