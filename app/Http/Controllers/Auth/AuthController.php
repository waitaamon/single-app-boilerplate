<?php

namespace App\Http\Controllers\Auth;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\Auth\LoginFormRequest;
use App\Http\Requests\Auth\RegisterFormRequest;

/**
 * @property JWTAuth auth
 */
class AuthController extends Controller
{
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function login(LoginFormRequest $request){

        try{
            if(!$token = $this->auth->attempt($request->only('email','password'))){
                return response()->json([
                    'errors' => [
                        'root' => 'Incorrect username or password.'
                    ]
                ], 401);
            }
        }catch (JWTException $e){
            return response()->json([
                'errors' => [
                    'root' => 'Incorrect username or password.'
                ]
            ], $e->getStatusCode());
        }

        //response with jwt
        //respond with user data

        return response()->json([
            'data' => $request->user(),
            'meta' => [
                'token' => $token
            ]
        ], 200);
    }

    public function register(RegisterFormRequest $request){

        //validate


        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'idNumber' => $request->idNumber,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        //attempt auth

        $token = $this->auth->attempt($request->only('email', 'password'));


        //response with jwt
        //respond with user data

        return response()->json([
            'data' => $user,
            'meta' => [
                'token' => $token
            ]
        ], 200);


    }


    public function logout(){

        $this->auth->invalidate($this->auth->getToken());

        return response( null, 200);
    }


    public function user(Request $request){

        return response()->json([
            'data' => $request->user()
        ]);
    }

}
