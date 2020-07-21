<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    /**
     * @response  {
     * "message": "success",
     * "data": [
     * {
     * "id": 1,
     * "category_id": 4,
     * "title": "introduction to css",
     * "shelf_no": 23,
     * "author_name": "kezel",
     * "quantity": 10,
     * "status": "available",
     * "is_active": 1,
     * "created_at": "2020-07-20T23:46:21.000000Z",
     * "updated_at": "2020-07-20T23:46:21.000000Z",
     * "category": {
     * "id": 4,
     * "key": "programming",
     * "name": "programming",
     * "created_at": "2020-07-20T22:53:18.000000Z",
     * "updated_at": "2020-07-20T22:53:18.000000Z"
     * }
     * }
     * ]
     * }
     *
     * @bodyParam token string required Bearer authorization token. Example: eyJ0eXAiOiJKV1Qi...
     * @return mixed
     */
    public function index()
    {
        $books = Book::all()->load('category');
//        $books = DB::table('books')
//            ->join('categories', 'books.category_id', '=', 'categories.id')
//            ->select('books.*', 'categories.name')
//            ->get();
        $response = ['message' => 'success', 'data' => $books];
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @author Maryfaith Mgbede <adaamgbede@gmail.com>
     *
     * @response {
     *  "status": "success",
     *  "message": "Book successfully added"
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
        $response = ['status' => 'success', 'message' => 'Book successfully added'];
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @author Maryfaith Mgbede <adaamgbede@gmail.com>
     *
     * @response {
     *  "status": "success",
     *  "message": "Book successfully deactivated"
     * }
     *
     * * @response 422 {
     *  "status": "error",
     *  "message": "Book not found"
     * }
     *
     * @response  422 {
     *  "errors": "failed validation"
     * }
     * @bodyParam id integer required The id of book. Example: 1
     */
    public function deactivateBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $book = Book::find($request->id);
        if (!$book) {
            return response(["status" => "error", "message" => "Book not found"], 422);
        }
        $book->is_active = Book::INACTIVE;
        $book->status = Book::STATUS_DEACTIVATE;

        if (!$book->save()) {
            $response = ['status' => 'error', 'message' => 'Could not deactivate book'];
            return response($response, 200);
        }

        $response = ['status' => 'success', 'message' => 'Book successfully deactivated'];
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @author Maryfaith Mgbede <adaamgbede@gmail.com>
     *
     * @response {
     *  "status": "success",
     *  "message": "Book successfully activated"
     * }
     *
     * * @response 422 {
     *  "status": "error",
     *  "message": "Book not found"
     * }
     *
     * @response  422 {
     *  "errors": "failed validation"
     * }
     * @bodyParam id integer required The id of book. Example: 1
     */
    public function activateBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $book = Book::find($request->id);
        if (!$book) {
            return response(["status" => "error", "message" => "Book not found"], 422);
        }

        $book->is_active = Book::ACTIVE;
        $book->status = Book::STATUS_AVAILABLE;

        if (!$book->save()) {
            $response = ['status' => 'error', 'message' => 'Could not activate book'];
            return response($response, 200);
        }

        $response = ['status' => 'success', 'message' => 'Book successfully activated'];
        return response($response, 200);
    }

    protected function showBook($id)
    {
        print_r($id);
    }
}
