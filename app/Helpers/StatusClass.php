<?php

namespace App\Helpers;


use App\Status;

class StatusClass
{
    public $statusMsg;
    public $statusCode;

    public function __construct($status_code)
    {
        $status = Status::where( 'code' ,$status_code)->first();
        $this->statusMsg = $status['message'];
        $this->statusCode = $status['code'];
    }

}

