<?php

namespace oliverbj\cwreporter\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        //Call config here if needed
    }

    public function index()
    {
        return view('cwreporter::home');
    }
}
