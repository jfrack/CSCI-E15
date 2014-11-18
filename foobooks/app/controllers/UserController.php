<?php

class UserController extends BaseController {


    public function __construct() {
        # Put anything here that should happen before any of the other actions
        # all routes submitted via POST to have the csrf before filter
        $this->beforeFilter('csrf', array('on' => 'post'));
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

    }
}