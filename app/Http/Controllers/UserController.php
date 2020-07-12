<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @response  {
     *  "id": 1,
     *  "name": "Adaa Mgbede",
     *  "email": "adaamgbede@gmail.com",
     *  "user_type": "admin",
     *  "email_verified_at": null,
     *  "created_at": null,
     *  "updated_at": null
     * }
     * @bodyParam token string required Bearer authorization token. Example: eyJ0eXAiOiJKV1Qi...
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $request->user();
    }
}
