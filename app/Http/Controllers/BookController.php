<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group  Book Category
 *
 * APIs for managing book categories
 */
class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'api.admin']);
    }

    public function index()
    {
        $books = Book::all();
        $response = ['message' => 'success', 'data' => $books];
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
     * @bodyParam  author_name string required The author name of the book. Example: John Doe
     * @bodyParam  title string required The title the book. Example: Introduction to PHP
     * @bodyParam  category_id integer required The category ID. Example: 1
     * @bodyParam  shelf_no integer required The shelf number of the book. Example: 20
     * @bodyParam  quantity integer required The quantity of book. Example: 6
     */
    public function createBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'category_id' => 'required|numeric',
            'author_name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'shelf_no' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        Book::create($request->all());
        $response = ['message' => 'success'];
        return response($response, 200);
    }
}
