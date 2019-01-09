<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $status = new Status;
        // $status->message = "success";
        // $status->code = 1;
        // $status->save();

        // $status = new Status;
        // $status->message = "valdiation error";
        // $status->code = 2;
        // $status->save();

        // $status = new Status;
        // $status->message = "unauthorized";
        // $status->code = 3;
        // $status->save();

        // $status = new Status;
        // $status->message = "invalid credentials";
        // $status->code = 4;
        // $status->save();

        // $status = new Status;
        // $status->message = "model not found";
        // $status->code = 5;
        // $status->save();

        // $status = new Status;
        // $status->message = "method not allowed";
        // $status->code = 6;
        // $status->save();

        // $status = new Status;
        // $status->message = "oauth invalid credentials";
        // $status->code = 7;
        // $status->save();

        $status = new Status;
        $status->message = "internal server error";
        $status->code = 8;
        $status->save();
        
    }
}
