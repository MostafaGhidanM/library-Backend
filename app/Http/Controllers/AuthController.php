<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register()
    {
        return view(
            'auth.register'
        );
    }
    public function handleRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:50|min:5',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        //login
        Auth::login($user);

        return redirect(route('books.index'));
    }
    public function login()
    {
        return view(
            'auth.login'
        );
    }
    public function handleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:50|min:5',
        ]);
        $is_login = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$is_login) {
            return back();
        }
        return redirect(route('books.index'));
    }
    public function logout()
    {
        Auth::logout();
        return back();
    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        $email = $user->email;
        $db_user = User::where('email', '=', $email)->first();
        if ($db_user == null) {
            $register_user = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make('654321'),
                'oauth-token' => $user->token,
            ]);
            Auth::login($register_user);
        } else {
            Auth::login($db_user);
        }
        return redirect(route('books.index'));
    }
}
