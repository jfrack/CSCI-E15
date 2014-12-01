<?php

class UserController extends BaseController {


    public function __construct() {
        # Put anything here that should happen before any of the other actions

        # Make sure BaseController gets called
        parent::__construct();

        # Only logged in users should have access to this controller
        #$this->beforeFilter('auth');
    }

    # GET: http://localhost/user
    public function getIndex() {

    }

    # GET: http://localhost/user/signup
    public function getSignup() {

    }

    # POST: http://localhost/user/signup
    public function postSignup() {

    }

    # GET: http://localhost/user/login
    public function getLogin() {
        return View::make('login');
    }

    # POST: http://localhost/user/login
    public function postLogin() {

        # form validation
        $rules = array(
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()) {
            return Redirect::to('user/login')
                    ->with('flash_message', 'Login failed; please try again.')
                    ->withInput()
                    ->withErrors($validator);
        }

        return '<h1>from postLogin()</h1>';
    }

     # GET: http://localhost/user/logout
    public function getLogout() {
        # Log out
        Auth::logout();

        # Send them to the homepage
        return Redirect::to('user/login');
    }
}