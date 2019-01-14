<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Helpers\StatusClass;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkResponse(Request $request , $response)
    {
        $status_success = new StatusClass(1);
        return apiRes($status_success->statusMsg , $status_success->statusCode , ['success' => $response]);
    }


    public function sendResetLinkFailedResponse(Request $request , $response)
    {
        $status_validation = new StatusClass(2);
        return apiRes($status_validation->statusMsg , $status_validation->statusCode , ['email' => $response]);
    }

}
