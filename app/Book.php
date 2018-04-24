<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /*
    * Dump the essential details of books to the page
    * Used when practicing queries and you want to quickly see the books in the database
    * Can accept a Collection of books, or if none is provided, will default to all books
    */
    public static function dump($books = null)
    {
        # Empty array that will hold all our book data
        $data = [];
        # Determine if we should use $books as was passed to this method
        # or query for all books
        if (is_null($books)) {
            # Query for all the books
            $books = self::all();
        }
        # Load the data array with the book info we want
        foreach ($books as $book) {
            $data[] = $book->title.' by '.$book->author;
        }
        dump($data);
    }
}
