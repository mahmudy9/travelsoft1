<?php

namespace App\Http\Controllers\ApiAuth;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Response;
use App\Helpers\StatusClass;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;

class AccessTokenController extends ATC
{
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            //get username (default is :email)
            // $username = $request->getParsedBody()['username'];

            //get user
            //change to 'email' if you want
            // $user = User::where('email', '=', $username)->first();

            //generate token
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"]))
            {
                $status_oautherror1 = new StatusClass(7);
                return apiRes($status_oautherror1->statusMsg , $status_oautherror1->statusCode);

            }
            $status = new StatusClass(1);
            return apiRes($status->statusMsg , $status->statusCode , array($data));
            //add access token to user
            // $user = collect($user);
            // $user->put('expires_in', $data['expires_in']);
            // $user->put('refresh_token', $data['refresh_token']);
            // $user->put('access_token', $data['access_token']);

            // $status = new StatusClass(1);
            // return apiRes($status->statusMsg , $status->statusCode , array($user));
        }
        catch (ModelNotFoundException $e) { // email notfound
            //return error message
            $status_notfound = new StatusClass(5);
            return apiRes($status_notfound->statusMsg , $status_notfound->statusCode);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
            $status_oautherror = new StatusClass(7);
            return apiRes($status_oautherror->statusMsg , $status_oautherror->statusCode);
        }
        catch (Exception $e) {
            ////return error message
            $status_server = new StatusClass(8);
            return apiRes($status_server->statusMsg , $status_server->statusCode);
        }
    }
}