<?php

namespace App\Http\Controllers;

use Hash;
use Config;
use Validator;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use App\User;

class AuthenticateController extends Controller{

    public function index(){
	    $users = User::all();
	    return $users;
    }

    protected function createToken($user){

        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + (2 * 7 * 24 * 60 * 60)
        ];
        return JWT::encode($payload, Config::get('app.token_secret'));
    }


    
    public function unlink(Request $request, $provider){

        $user = User::find($request['user']['sub']);
        if (!$user)
        {
            return response()->json(['message' => 'User not found']);
        }
        $user->$provider = '';
        $user->save();
        
        return response()->json(array('token' => $this->createToken($user)));
    }


    
    public function login(Request $request){

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', '=', $email)->first();
        if (!$user)
        {
            return response()->json(['message' => 'Wrong email and/or password'], 401);
        }
        if (Hash::check($password, $user->password))
        {
            unset($user->password);
            return response()->json(['token' => $this->createToken($user)]);
        }
        else
        {
            return response()->json(['message' => 'Wrong email and/or password'], 401);
        }
    }
    
    public function signup(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 400);
        }
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response()->json(['token' => $this->createToken($user)]);
    }

}
