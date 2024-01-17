<?php

namespace App\Http\Controllers;
use App\Models\Book;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books= Book::orderBy('id', 'DESC')->paginate(2); //select all
        //$books = Book::select('title','desc')->get();
        //$books = Book::where('id','=>',2)->get();
        //$books = Book::select('title','desc')->where('id','>=',1)->orderBy('id','DESC')->get();
        //dd($books);
        return view('books.index',compact('books'));
    }
    public function show($id)
    {
        //Book::where('id','=',$id)->first();   
        $book = Book::findOrFail($id); 
        return view('books.show', compact('book'));
    }
    public function create()
    {
        return view('books.create');
    }
    public function store(Request $request)
    {
        $title = $request->title;
        $desc = $request->desc;
        Book::create([
            'title' => $title,
            'desc' => $desc
        ]);
        return redirect(route('books.index'));
    }
    public function edit($id)
    {
        //Book::where('id','=',$id)->first();   
        $book = Book::findOrFail($id); 
        return view('books.edit', compact('book'));
    }
    public function update(Request $request)
    {
        $title = $request->title;
        $desc = $request->desc;
        Book::where('id','=',$request->id)->update([
            'title' => $title,
            'desc' => $desc
        ]);    
        return redirect(route('books.index'));
    }

}
