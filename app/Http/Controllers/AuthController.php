<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }
        return back()->with('failed', "The provided credentials do not match our records.");
    }

    public function register(){
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'max:255'],
            'username' => ['required', 'min:8', 'max:255', 'unique:users,username', 'alpha_num', 'regex:/^[a-zA-Z]/'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed'],
        ]);
        $user = User::first();
        User::create([
            'name'     => $request->name,
            'username' => strtolower($request->username),
            'email'    => $request->email,
            'password' => $request->password,
            'is_admin' => !$user ? true : false,
            'is_super_admin' => !$user ? true : false,
        ]);
        return back()->with('success', 'Account has been created!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function google_login(){
        return Socialite::driver('google')->redirect();
    }

    public function google_auth(){
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('email', $googleUser->email)->first();
        if ($user) {
            $user->update([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
        } else {
            $user = User::create([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'google_avatar' => $googleUser->avatar,
                'password' => $this->randomPassword()
            ]);
        }
        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('home');
    }

    private function randomPassword()
    {
        $alphabet = 'abcdefghijklmno_-+=pqrs#()tuvwxyz*&ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 30; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}