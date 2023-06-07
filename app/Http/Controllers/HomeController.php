<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $participantCount = Participant::count();
        return view('home', compact('participantCount'));
    }
    public function editProfile()
    {
        $user = User::get()[0];
        return view('dashboard.profile.edit', compact('user'));
    }
    public function saveProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:10',
            'c_password' => 'required|same:password'
        ]);
        $user = User::get()[0];
        $user->update([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('home')->with('success' , 'Profile saved successfully');   
    }
}
