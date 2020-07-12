<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @group  User Authentication
 *
 * APIs for managing users
 */
class ApiAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('logout');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @author Maryfaith Mgbede <adaamgbede@gmail.com>
     *
     * @response {
     *  "message": "success",
     *  "token": "eyJ0eXAiOiJKV1Qi..."
     * }
     *
     * @response  422 {
     *  "errors": "failed validation"
     * }
     *
     * @bodyParam  name string required The full name of the user. Example: John Doe
     * @bodyParam  email string required The email of the user. Example: abc@example.com
     * @bodyParam  password string required The password of the user. Example: 111111
     * @bodyParam  password_confirmation string required The password of the user. Example: 111111
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['message' => 'success', 'token' => $token];
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @author Maryfaith Mgbede <adaamgbede@gmail.com>
     *
     * @response {
     *  "message": "success",
     *  "user-type": "admin|user",
     *  "token": "eyJ0eXAiOiJKV1Qi..."
     * }
     *
     * @response  422 {
     *  "message": "Incorrect login credentials"
     * }
     *
     * @response  422 {
     *  "message": "This account does not exist"
     * }
     *
     * @bodyParam  email string required The email of the user. Example: abc@example.com
     * @bodyParam  password string required The password of the user. Example: 111111
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['message' => 'success', 'user-type' => $user->user_type, 'token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Incorrect login credentials"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'This account does not exist'];
            return response($response, 422);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @author Maryfaith Mgbede <adaamgbede@gmail.com>
     *
     * @response {
     *  "message": "You have been successfully logged out!"
     * }
     *
     * @bodyParam token string required Bearer authorization token. Example: eyJ0eXAiOiJKV1Qi...
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
