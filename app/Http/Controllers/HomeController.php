<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        //dd($tweets);
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

    public function user(Request $request, $id, Tweet $tweet, User $users) {
        if (Auth::user()->id !== $id) {
            $userProfile = $users->where('id', $id)->get();
            //get follow user
        } else {
            $userProfile = Auth::user();
        }
        $tweets = $tweet->where('user_id', $id)->get();
        foreach ($tweets as $tweet) {
            $userId = $tweet->user_id;
            $user = $users->where('id', $userId)->get();

            if (sizeof($user) > 0) {
                $tweet->user_id = $user[0];
            }
        }
        return view('profile')->withTweets($tweets)->withUsers($userProfile[0]);
    }

    public function editUser() {
        return view('edit');
    }

    public function updateUser(Request $request) {
        request()->validate([
            'username' => 'required',
            'email' => 'required',
        ]);

        $avatar = $request->file('avatar');
        $extension = $avatar->getClientOriginalExtension();
        Storage::disk('public')->put($avatar->getFilename().'.'.$extension,  File::get($avatar));

        $user = User::find(Auth::user()->id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->avatar = $avatar->getFilename().'.'.$extension;
        $user->save();
        
        return redirect('/users/'.Auth::user()->id);
    }
}
