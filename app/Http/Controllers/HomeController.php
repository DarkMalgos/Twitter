<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\User;
use Illuminate\Http\Request;
use Auth;

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
    public function index(Tweet $tweet, User $users)
    {
        $tweets = $tweet->where('user_id', Auth::user()->id)->get();
        foreach ($tweets as $tweet) {
            $userId = $tweet->user_id;
            $user = $users->where('id', $userId)->get();

            if (sizeof($user) > 0) {
                $tweet->user_id = $user[0];
            }
        }
        //dd($tweets);
        return view('home')->withTweets($tweets);
    }

    public function user() {
        return view('home');
    }
}
