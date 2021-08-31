<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::User();

        $articles = DB::Table('website_news')->get();
        $latest_article = DB::Table('website_news')->orderBy('id', 'desc')->first();

        return view('home', [
            'user' => $user,
            'articles' => $articles,
            'latest_article' => $latest_article,
        ]);
    }
}
