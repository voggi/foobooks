<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App;
use App\Book;
use App\Utilities\Practice;
use Debugbar;
use Log;
use DB;
use IanLChapman\PigLatinTranslator\Parser;

class PracticeController extends Controller
{
    /**
     * Examples of collection magic
     */
    public function practice19()
    {
        $books = Book::all();
        # String
        # echo $books;
        # Array
        # foreach($books as $book) {
        #     dump($book['title']);
        # }
        # Object
        foreach ($books as $book) {
            dump($book->title);
        }
    }

    /**
     * Examples shown in Week 12, Part 1 when discussing Collections
     */
    public function practice18()
    {
        #$results = Book::find(1);
        #$results = Book::orderBy('title')->first();
        #$results = Book::all();
        #$results = Book::orderBy('title')->get();
        #$results = Book::where('author', 'F. Scott Fitzgerald')->get();
        #$results = Book::where('author', 'Virginia Wolf')->get();
        #$results = Book::limit(1)->get();
        #$results = Book::get();
        #$books = Book::orderBy('id', 'desc')->get();
        #$book = $books->first();
        $results = DB::table('books')->get();

        dump($results);
    }

    /**
     * [BONUS]
     * Find any books by the author “J.K. Rowling” and update the author name to be “JK Rowling”.
     */
    public function practice17()
    {
        Book::dump();
        # Approach # 1
        # Get all the books that match the criteria
        $books = Book::where('author', '=', 'J.K. Rowling')->get();
        $matches = $books->count();
        dump('Found ' . $matches . ' ' . str_plural('book', $matches) . ' that match this search criteria');
        if ($matches > 0) {
            # Loop through each book and update them
            foreach ($books as $book) {
                $book->author = 'JK Rowling';
                $book->save();
                # Underlying SQL: update `books` set `updated_at` = '20XX-XX-XX XX:XX:XX', `author` = 'JK Rowling' where `id` = '4'
            }
        }
        # Approach #2
        # More ideal - Requires 1 query instead of 3
        # Book::where('author', '=', 'J.K. Rowling')->update(['author' => 'JK Rowling']);
        Book::dump();
        Practice::resetDatabase();
    }

    /**
     * [5 of 5] Solution to query practice from Week 11 assignment
     * Remove all books authored by “J.K. Rowling”
     */
    public function practice16()
    {
        # Show books before we do the delete
        Book::dump();
        # Do the delete
        Book::where('author', 'LIKE', 'J.K. Rowling')->delete();
        dump('Deleted all books where author like J.K. Rowling');
        # Show books after the delete
        Book::dump();
        Practice::resetDatabase();
        # Underlying SQL: delete from `books` where `author` LIKE 'J.K. Rowling'
    }

    /**
     * [4 of 5] Solution to query practice from Week 11 assignment
     * Retrieve all the books in descending order according to published date
     */
    public function practice15()
    {
        $books = Book::orderByDesc('published_year')->get();
        Book::dump($books);
        # Underlying SQL: select * from `books` order by `published` desc
    }

    /**
     * [3 of 5] Solution to query practice from Week 11 assignment
     * Retrieve all the books in alphabetical order by title
     */
    public function practice14()
    {
        $books = Book::orderBy('title', 'asc')->get();
        Book::dump($books);
        # Underlying SQL: select * from `books` order by `title` asc
    }

    /**
     * [2 of 5] Solution to query practice from Week 11 assignment
     * Retrieve all the books published after 1950.
     */
    public function practice13()
    {
        $books = Book::where('published_year', '>', 1950)->get();
        Book::dump($books);
        # Underlying SQL: select * from `books` where `published` > '1950'
    }

    /**
     * [1 of 5] Solution to query practice from Week 11 assignment
     * Retrieve the last 2 books that were added to the books table.
     */
    public function practice12()
    {
        $books = Book::orderBy('id', 'desc')->limit(2)->get();
        # Alternative approach using the `latest` convenience method:
        # $books = Book::latest()->limit(2)->get();
        Book::dump($books);
        # Underlying SQL: select * from `books` order by `id` desc limit 2
    }

    public function practice11()
    {
        // Retrieve the last 2 books that were added to the books table.
        $books = Book::latest()->take(2)->get();

        // Retrieve all the books published after 1950.
        //$books = Book::where('published_year', '>', '1950')->get();

        // Retrieve all the books in alphabetical order by title.
        //$books = Book::orderBy('title')->get();

        // Retrieve all the books in descending order according to published date.
        //$books = Book::orderBy('published_year', 'desc')->get();

        // Remove any/all books by the author “J.K. Rowling”.
        //$books = Book::where('author', '=', 'J.K. Rowling')->delete();

        if ($books->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($books as $book) {
                dump($book->title);
            }
        }
    }

    public function practice10()
    {
        # First get a book to delete
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump('Did not delete- Book not found.');
        } else {
            $book->delete();
            dump('Deletion complete; check the database to see if it worked...');
        }
    }

    public function practice9()
    {
        # First get a book to update
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump("Book not found, can't update.");
        } else {
            # Change some properties
            $book->title = 'The Really Great Gatsby';
            $book->published_year = '2025';

            # Save the changes
            $book->save();

            dump('Update complete; check the database to confirm the update worked.');
        }
    }

    public function practice8()
    {
        $book = new Book();
        $books = $book->where('title', 'LIKE', '%Harry Potter%')->get();

        if ($books->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($books as $book) {
                dump($book->title);
            }
        }
    }

    public function practice7()
    {
        # Instantiate a new Book Model object
        $book = new Book();

        # Set the properties
        # Note how each property corresponds to a field in the table
        $book->title = 'Harry Potter and the Sorcerer\'s Stone';
        $book->author = 'J.K. Rowling';
        $book->published_year = 1997;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $book->save();

        dump('Added: '.$book->title);
    }

    public function practice6()
    {
        Log::info('This is just a test.');
    }

    public function practice5()
    {
        $translator = new Parser();
        $translation = $translator->translate('Hello world!');
        dump($translation);
    }

    public function practice4()
    {
        $data = ['foo' => 'bar'];
        Debugbar::info($data);
        Debugbar::info('Current environment: '.App::environment());
        Debugbar::error('Error!');
        Debugbar::warning('Watch out…');
        Debugbar::addMessage('Another message', 'mylabel');

        return 'Demoing some of the features of Debugbar';
    }

    /**
     *
     */
    public function practice3()
    {
        echo Config::get('app.supportEmail');
        echo config('app.supportEmail');
        dump(config('database.connections.mysql'));
    }

    /**
     *
     */
    public function practice2()
    {
        dump(['a' => '123', 'b' => '456']);
    }

    /**
     *
     */
    public function practice1()
    {
        dump('This is the first example.');
    }

    /**
     * ANY (GET/POST/PUT/DELETE)
     * /practice/{n?}
     * This method accepts all requests to /practice/ and
     * invokes the appropriate method.
     * http://foobooks.loc/practice => Shows a listing of all practice routes
     * http://foobooks.loc/practice/1 => Invokes practice1
     * http://foobooks.loc/practice/5 => Invokes practice5
     * http://foobooks.loc/practice/999 => 404 not found
     */
    public function index($n = null)
    {
        $methods = [];

        # If no specific practice is specified, show index of all available methods
        if (is_null($n)) {
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    $methods[] = $method;
                }
            }
            return view('practice')->with(['methods' => $methods]);
        } # Otherwise, load the requested method
        else {
            $method = 'practice' . $n;
            return (method_exists($this, $method)) ? $this->$method() : abort(404);
        }
    }
}
