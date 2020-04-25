<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BookTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testBookAdd()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->visit('http://e15bookmark.loc')
                    ->click('@register-link')
                    ->type('@name-input', 'Joe Smith')
                    ->type('@email-input', 'joe@gmail.com')
                    ->type('@password-input', 'helloworld')
                    ->type('@password-confirm-input', 'helloworld')
                    ->click('@register-button')
                    ->visit('http://e15bookmark.loc/books/create')
                    ->type('#slug', 'the-greatest-book-ever-written')
                    ->type('#title', 'The Greatest Book Ever Written')
                    ->select('author_id') # select a random author by omitting 2nd parameter
                    ->type('#published_year', '2020')
                    ->type('#cover_url', 'http://www.google.com')
                    ->type('#info_url', 'http://en.wikipedia.org/wiki/the-greatest-book-ever-written')
                    ->type('#purchase_url', 'http://www.amazon.com')
                    ->type('description', 'The Martian is a 2011 science fiction novel written by Andy Weir. It was his debut novel under his own name. It was originally self-published in 2011; Crown Publishing purchased the rights and re-released it in 2014. The story follows an American astronaut, Mark Watney, as he becomes stranded alone on Mars in the year 2035 and must improvise in order to survive.')
                    ->click('@add-button')
                    ->visit('http://e15bookmark.loc/books')
                    ->assertSee('The Greatest Book Ever Written');
        });
    }
}
