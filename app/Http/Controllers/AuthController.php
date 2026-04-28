<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            $general_chat = Channel::where(['title' => 'general', 'type' => 'text'])->first();
            return redirect()->route('channel', ['channel' => $general_chat->unique_id]);
        }
        return back()->with('failed', "The provided credentials do not match our records.");
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}