<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\User;

class ListController extends Controller
{
    /**
     * GET /list
     */
    public function show(Request $request)
    {
        $books = $request->user()->books->sortByDesc('pivot.created_at');

        return view('lists.show')->with(['books' => $books]);
    }

    /**
     * GET /list/{slug?}/add
     */
    public function add($slug)
    {
        $book = Book::findBySlug($slug);

        # TODO: Handle case where book isn't found for the given slug

        return view('lists.add')->with(['book' => $book]);
    }

    /**
     * POST /list/{slug?}/add
     */
    public function save(Request $request, $slug)
    {
        # TODO: Validate incoming data, making sure they entered a note

        $book = Book::findBySlug($slug);

        # Add book to user's list
        # (i.e. Create a new row in the book_user table)
        $request->user()->books()->save($book, ['notes' => $request->notes]);

        return redirect('/list')->with([
            'flash-alert' => 'The book ' .$book->title. ' was added to your list.'
        ]);
    }

    # PUT /list/{slug}
    public function update(Request $request, $slug)
    {
        $user = User::where('id', '=', $request->user()->id)->first();
        
        $book = $user->books()->where('slug', '=', $slug)->first();

        # Update and save the notes for this relationship
        $book->pivot->notes = $request->notes;
        $book->pivot->save();

        return redirect('/list')->with([
            'flash-alert' => 'The notes for ' .$book->title. ' were updated.'
        ]);
    }

    #DELETE /list/{slug}
    public function destroy(Request $request, $slug)
    {
        $book = Book::findBySlug($slug);

        $book->users()->detach();

        $book->delete();

        return redirect('/books')->with([
            'flash-alert' => '“' . $book->title . '” was removed.'
        ]);
    }
}
