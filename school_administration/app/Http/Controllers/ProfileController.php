<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
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
        return view('profile', [
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request) {
        $user = Auth::User();
        $validated = $request->validate([
            'password_old' => ['required', 'string', 'min:8'],
            'password_new' => ['required', 'string', 'min:8', 'same:password_new_confirm'],
            'password_new_confirm' => ['required', 'string', 'min:8'],
        ]);

        if(Hash::make($validated['password_old']) == $user->password) {
            $user->password = Hash::make($validated['password_new']);
            $user->save();
            return redirect('settings')->with('status', 'Password updated successfully.');
        } else {
            return redirect('settings')->with('status', 'Authentication error.');
        }
    }
}
