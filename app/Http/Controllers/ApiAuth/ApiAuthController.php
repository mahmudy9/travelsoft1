<?php

namespace App\Http\Controllers\ApiAuth;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Helpers\StatusClass;

class ApiAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware(['passport_auth'])->except(['sign_up' , 'login']);
    }

    public function sign_up(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|string|max:190|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|string|confirmed'
        ]);
        if($validator->fails())
        {
            $status_error = new StatusClass(2);
            return apiRes($status_error->statusMsg , $status_error->statusCode , $validator->errors());
        }
        $user = new User(['name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)]);
        $user->save();
        $status_success = new StatusClass(1);
        return apiRes($status_success->statusMsg , $status_success->statusCode);
    }


    public function logout(Request $request)
    {
        $request->$user()->token()->revoke();
        Auth::guard('api')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        $status_success = new StatusClass(1);
        return apiRes($status_success->statusMsg , $status_success->statusCode);
    }

    public function user_details()
    {
        $user = Auth::guard('api')->user();
        $status_success = new StatusClass(1);
        return apiRes($status_success->statusMsg , $status_success->statusCode , $user);
    }
}
