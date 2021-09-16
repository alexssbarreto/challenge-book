<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function store(BookRequest $request)
    {
        return Book::create($request->validated());
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return $book;
    }

    public function destroy(Request $request, Book $book)
    {
        $book->delete();

        response()->json(null, Response::HTTP_BAD_REQUEST);
    }
}
