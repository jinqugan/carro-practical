<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SurveyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $response = Http::withToken('token')->get('http://carro.practical/api/v1/surveys/3');
        // $results = [];

        // if ($response->successful()) {
        //     $results = $response->json();
        // }

        // return view('form', compact('results'));
    }
}
