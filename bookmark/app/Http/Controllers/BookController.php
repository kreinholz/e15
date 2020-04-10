<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arr;
use Str;
use App\Book;

class BookController extends Controller
{
    /**
    * GET /books/create
    * Display the form to add a new book
    */
    public function create(Request $request)
    {
        return view('books.create');
    }


    /**
    * POST /books
    * Process the form for adding a new book
    */
    public function store(Request $request)
    {
        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            'slug' => 'required|unique:books,slug|alpha_dash',
            'title' => 'required',
            'author' => 'required',
            'published_year' => 'required|digits:4',
            'cover_url' => 'url',
            'info_url' => 'url',
            'purchase_url' => 'required|url',
            'description' => 'required|min:255'
        ]);

        # Note: If validation fails, it will automatically redirect the visitor back to the form page
        # and none of the code that follows will execute.

        # Add the book to the database
        $newBook = new Book();
        $newBook->slug = $request->slug;
        $newBook->title = $request->title;
        $newBook->author = $request->author;
        $newBook->published_year = $request->published_year;
        $newBook->cover_url = $request->cover_url;
        $newBook->info_url = $request->info_url;
        $newBook->purchase_url = $request->purchase_url;
        $newBook->description = $request->description;
        $newBook->save();

        return redirect('/books/create')->with(['flash-alert' => 'Your book '.$newBook->title.' was added.']);
    }

    /**
     * GET /search
     */
    public function search(Request $request)
    {
        $request->validate([
            'searchTerms' => 'required',
            'searchType' => 'required',
        ]);

        # Note: if validation fails, it will redirect
        # back to `/` (page from which the form was submitted)
        
        # Start with an empty array of search results; books that
        # match our search query will get added to this array
        $searchResults = [];

        # Get the input values (default to null if no values exist)
        $searchTerms = $request->input('searchTerms', null);
        $searchType = $request->input('searchType', null);

        # Query the database for the input searchTerms, either by title or author
        # depending on the value of searchType--note, we don't have to worry about
        # case-sensitivity, as our database table is utf8mb4_unicode_ci (case insensitive)
        if ($searchType == 'title') {
            $searchResults = Book::where('title', 'LIKE', '%' . $searchTerms . '%')->get();
        }
        elseif ($searchType == 'author') {
            $searchResults = Book::where('author', 'LIKE', '%' . $searchTerms . '%')->get();
        }

        # Redirect back to the form with data/results stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
        return redirect('/')->with([
            'searchTerms' => $searchTerms,
            'searchType' => $searchType,
            'searchResults' => $searchResults
        ]);
    }


    /**
     * GET /list
     */
    public function list()
    {
        # TODO
        return view('books.list');
    }

    /**
     * GET /books
     * Show all the books in the library
     */
    public function index()
    {
        $books = Book::orderBy('title')->get();

        # Query database for new books
        //$newBooks = Book::orderByDesc('created_at')->orderBy('title')->limit(3)->get();

        # Or, filter out the new books from the existing $books Collection
        $newBooks = $books->sortByDesc('created_at')->take(3);
        
        return view('books.index')->with([
            'books' => $books,
            'newBooks' => $newBooks
        ]);
    }

    /**
     * GET /book/{slug}
     * Show the details for an individual book
     */
    public function show($slug)
    {
        $book = Book::where('slug', '=', $slug)->first();


        return view('books.show')->with([
            'book' => $book,
            'slug' => $slug,
        ]);
    }

    /**
     * GET /books/{slug}/edit
     */
    public function edit(Request $request, $slug)
    {
        $book = Book::where('slug', '=', $slug)->first();

        return view('books.edit')->with([
            'book' => $book
        ]);
    }

    /**
     * PUT /books/{$slug}
     */
    public function update(Request $request, $slug)
    {
        $book = Book::where('slug', '=', $slug)->first();

        $request->validate([
            'slug' => 'required|unique:books,slug,'.$book->id.'|alpha_dash',
            'title' => 'required',
            'author' => 'required',
            'published_year' => 'required|digits:4',
            'cover_url' => 'url',
            'info_url' => 'url',
            'purchase_url' => 'required|url',
            'description' => 'required|min:255'
        ]);

        $book->slug = $request->slug;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_year = $request->published_year;
        $book->cover_url = $request->cover_url;
        $book->info_url = $request->info_url;
        $book->purchase_url = $request->purchase_url;
        $book->description = $request->description;
        $book->save();

        return redirect('/books/'.$slug.'/edit')->with([
            'flash-alert' => 'Your changes were saved.'
        ]);
    }


    /**
    * DELETE /books/{$slug}
    */
    public function destroy(Request $request, $slug)
    {
        $book = Book::where('slug', '=', $slug)->first();

        $book->delete();

        return redirect('/books')->with([
            'flash-alert' => $book->title . ' was deleted.'
        ]);
    }

    /**
     * GET /filter/{$category}/{subcategory?}
     * Example demonstrating multiple parameters
     * Not a feature we're actually building, so I'm commenting out
     */
    /*
    public function filter($category, $subcategory = null)
    {
        $output = 'Here are all the books under the category '.$category;

        if ($subcategory) {
            $output .= ' and also the subcategory '.$subcategory;
        }

        return $output;
    }
    */
}