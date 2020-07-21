<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @group  Book Category
 *
 * APIs for managing book categories
 */
class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'api.admin']);
    }

    /**
     * @response  {
     * "message": "success",
     * "data": [
     *  {
     * "id": 1,
     * "key": "fictions",
     * "name": "fictions",
     * "created_at": "2020-07-20T22:12:56.000000Z",
     * "updated_at": "2020-07-20T22:12:56.000000Z"
     * },
     * {
     * "id": 2,
     * "key": "sex-and-romance",
     * "name": "sex and romance",
     * "created_at": "2020-07-20T22:16:08.000000Z",
     * "updated_at": "2020-07-20T22:16:08.000000Z"
     * }
     * ]
     * }
     *
     * @bodyParam token string required Bearer authorization token. Example: eyJ0eXAiOiJKV1Qi...
     * @return mixed
     */
    public function index()
    {
        $categories = Category::all();
        $response = ['message' => 'success', 'data' => $categories];
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @author Maryfaith Mgbede <adaamgbede@gmail.com>
     *
     * @response {
     *  "message": "success"
     * }
     *
     * @response  422 {
     *  "errors": "failed validation"
     * }
     *
     * @bodyParam  name string required The full name of the user. Example: Fiction
     */
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $request['name'] = $request->name;
        $request['key'] = Str::slug($request->name);
        Category::create($request->toArray());
        $response = ['message' => 'success'];
        return response($response, 200);
    }
}
