<?php

namespace App\Helpers;


use App\Status;

class StatusClass
{
    public $statusMsg;
    public $statusCode;

    public function __construct($status_id)
    {
        $status = Status::find($status_id);
        $this->statusMsg = $status['message'];
        $this->statusCode = $status['code'];
    }

}

