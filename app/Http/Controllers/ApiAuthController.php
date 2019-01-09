<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
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

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all() , [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    //     if($validator->fails())
    //     {
    //         return response()->json(['msg' => 'validation error' ,
    //         'errors' => $validator->errors()] , 400);
    //     }
    //     $cred = request(['email' , 'password']);
    //     if(!auth('api')->attempt($cred))
    //     {
    //         return response()->json(['msg' => 'unauthorized , you have wrong credentials'], 401);
    //     }

    //     $user = auth('api')->user();
    //     // if(!$user = User::where('email' , $request->email)->first())
    //     // {
    //     //     return response()->json(['msg' => 'invalid credentials']);
    //     // }
    //     // if(!Hash::check($request->password , $user->password))
    //     // {
    //     //     return response()->json(['msg' => 'invalid credentials']);
    //     // }
    //     // Auth::login($user);
    //     $token = $user->createToken('jwt')->accessToken;
    //     return response()->json(['access_token' => $token,
    //     'type' => 'Bearer']);
    // }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'username' => 'required|email',
            'password' => 'required|string',
            'client_id' => 'required',
            'client_secret' => 'required'
        ]);

        if($validator->fails())
        {
            $status_error = new StatusClass(2);
            return apiRes($status_error->statusMsg , $status_error->statusCode , $validator->errors());
        }
        $client = new Client;
        $result = $client->request( 'POST' ,url('/oauth/token') , [
            'form_params' => [
                'username' => $request->username,
                'password' => $request->password,
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                'grant_type' => 'password',
                'provider' => 'user',
            ]
        ]);
        if(!$result)
        {
            $status_invalid = new StatusClass(4);
            return apiRes($status_invalid->statusMsg , $status_invalid->statusCode);
        }
        $status_success = new StatusClass(1);
        return apiRes($status_success->statusMsg , $status_success->statusCode , $result);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->token()->revoke();
        return response()->json(['msg' => 'successfully logged out'] , 200);
    }

    public function user_details()
    {
        $user = Auth::guard('api')->user();
        return response()->json(['user' => $user] , 200);
    }
}
