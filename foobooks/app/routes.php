<?php

use Paste\Pre;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('/books', function() {
	return 'Here are all the books...';
});

Route::get('/books/{category}', function($category) {
	return 'Here are all the books in the ' . $category . ' category.';
});

Route::get('/practice', function() {
	echo App::environment();
});

Route::get('/get-environment',function() {

    echo "Environment: " . App::environment();
});

Route::get('/trigger-error',function() {

    # Class Foobar should not exist, so this should create an error
    $foo = new Foobar;
});

Route::get('mysql-test', function() {

    # Print environment
    echo 'Environment: '.App::environment().'<br>';

    # Use the DB component to select all the databases
    $results = DB::select('SHOW DATABASES;');

    # If the "Pre" package is not installed, you should output using print_r instead
    echo Pre::render($results);

});

# /app/routes.php
Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    }
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';
});

Route::get('/practice-creating', function() {

    # Instantiate a new Book model class
    $book = new Book();

    # Set
    $book->title = 'The Great Gatsby';
    $book->author = 'F. Scott Fiztgerald';
    $book->published = 1925;
    $book->cover = 'http://img2.imagesbn.com/p/9780743273565_p0_v4_s114x166.JPG';
    $book->purchase_link = 'http://www.barnesandnoble.com/w/the-great-gatsby-francis-scott-fitzgerald/1116668135?ean=9780743273565';

    # This is where the Eloquent ORM magic happens
    $book->save();

    return 'A new book has been added! Check your database to see...';

});

Route::get('/practice-reading', function() {

    # The all() method will fetch all the rows from a Model/table
    $books = Book::all();

    # Make sure we have results before trying to print them...
    if($books->isEmpty() != TRUE) {

        # Typically we'd pass $books to a View, but for quick and dirty demonstration, let's just output here...
        foreach($books as $book) {
            echo $book->title.'<br>';
        }
    }
    else {
        return 'No books found';
    }

});

Route::get('/practice-reading-one-book', function() {

    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    if($book) {
        return $book->title;
    }
    else {
        return 'Book not found.';
    }

});

Route::get('/practice-updating', function() {

    # First get a book to update
    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    # If we found the book, update it
    if($book) {

        # Give it a different title
        $book->title = 'The Really Great Gatsby';

        # Save the changes
        $book->save();

        return "Update complete; check the database to see if your update worked...";
    }
    else {
        return "Book not found, can't update.";
    }

});

Route::get('/practice-deleting', function() {

    # First get a book to delete
    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    # If we found the book, delete it
    if($book) {

        # Goodbye!
        $book->delete();

        return "Deletion complete; check the database to see if it worked...";

    }
    else {
        return "Can't delete - Book not found.";
    }

});

Route::get('/signup',
    array(
        'before' => 'guest',
        function() {
            return View::make('signup');
        }
    )
);

Route::post('/signup',
    array(
        'before' => 'csrf',
        function() {

            $user = new User;
            $user->email    = Input::get('email');
            $user->password = Hash::make(Input::get('password'));

            # Try to add the user
            try {
                $user->save();
            }
            # Fail
            catch (Exception $e) {
                return Redirect::to('/signup')->with('flash_message', 'Sign up failed; please try again.')->withInput();
            }

            # Log the user in
            Auth::login($user);

            return Redirect::to('/list')->with('flash_message', 'Welcome to Foobooks!');

        }
    )
);

Route::get('/login',
			array (
				'before' => 'guest',
				'uses' => 'UserController@getLogin'
			)
);

# single route that will handle every action in a controller
Route::controller('user', 'UserController');

Route::resource('tag', 'TagController');

/*
Route::get('/login',
    array(
        'before' => 'guest',
        function() {
            return View::make('login');
        }
    )
);
*/

Route::post('/login',
    array(
        'before' => 'csrf',
        function() {

            $credentials = Input::only('email', 'password');

            if (Auth::attempt($credentials, $remember = true)) {
                return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
            }
            else {
                return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again.');
            }

            return Redirect::to('login');
        }
    )
);

Route::get('/logout', function() {

    # Log out
    Auth::logout();

    # Send them to the homepage
    return Redirect::to('/');

});

Route::get('/list/{format?}',
    array(
        'before' => 'auth',
        function($format = 'html') {
            # rest of your list code goes here...
            return 'List Route:';
        }
    )
);

Route::get('/unpacking-sessions-and-cookies', function() {
# Log in check
if(Auth::check())
echo "You are logged in: ".Auth::user();
else
echo "You are not logged in.";
echo "<br><br>";
# Cookies
echo "<h1>Your Raw, encrypted Cookies</h1>";
echo Paste\Pre::render($_COOKIE,'');
# Decrypted cookies
echo "<h1>Your Decrypted Cookies</h1>";
echo Paste\Pre::render(Cookie::get(),'');
echo "<br><br>";
# All Session files
echo "<h1>All Session Files</h1>";
$files = File::files(app_path().'/storage/sessions');
foreach($files as $file) {
if(strstr($file,Cookie::get('laravel_session'))) {
echo "<div style='background-color:yellow'><strong>YOUR SESSION FILE:</strong><br>";
}
else {
echo "<div>";
}
echo "<strong>".$file."</strong>:<br>".File::get($file)."<br>";
echo "</div><br>";
}
echo "<br><br>";
# Your Session Data
$data = Session::all();
echo "<h1>Your Session Data</h1>";
echo Paste\Pre::render($data,'Session data');
echo "<br><br>";
# Token
echo "<h1>Your CSRF Token</h1>";
echo Form::token();
echo "<script>document.querySelector('[name=_token]').type='text'</script>";
echo "<br><br>";
});

