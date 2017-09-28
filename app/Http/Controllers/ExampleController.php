<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function jwtSample()
    {
        return 'jwtsample';
        # code...
    }

    public function nojwtSample()
    {
        return 'nojwtsample';
        # code...
    }

    //
}
