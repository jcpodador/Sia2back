<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show(Book $book) {
        return response()->json($book,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $books = Book::where('title','like',"%$request->key%")
            ->orWhere('summary','like',"%$request->key%")->get();

        return response()->json($books, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'string|required',
            'author' => 'string|required',
            'summary' => 'string|required',
            'contained_in' => 'numeric',
            'price' => 'numeric|required',
        ]);

        try {

            $book =  Book::create([
                "title" => $request->title,
                "author"=> $request->author,
                "summary"=>$request->summary,
                "price"=>$request->price,
                "user_id"=>auth()->user()->id,

            ]);

            return response()->json($book, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Book $book) {
        try {
            $book->update($request->all());
            return response()->json($book, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Book $book) {
        $book->delete();
        return response()->json(['message'=>'Book deleted.'],202);
    }

    public function index() {
        $books = Book::where('user_id', auth()->user()->id)->orderBy('title')->get();
        return response()->json($books, 200);
    }
}

