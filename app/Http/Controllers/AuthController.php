<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'firstname' => 'required|string:max:50',
            'lastname' => 'required|string:max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('message', 'Account created successfully.')->with('type', 'success');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'rep') {
                return redirect()->route('rep.dashboard');
            }
        }
        return redirect()->route('login')->with('message', 'Invalid Credentials')->with('type', 'error');
    }

    public function forgot()
    {
        return view('auth.password');
    }

    public function forgotPass(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = sha1(uniqid());

        $user->update([
            'password_reset_token' => $token,
            'password_reset_token_expiry' => now()->addHours(1),
        ]);

        $this->sendResetLinkEmail($user, $token);

        return redirect()->route('login')->with('message', 'Password reset link sent to your email')->with('type', 'success');
    }

    private function sendResetLinkEmail($user, $token)
    {
        $resetLink = route('password.reset', ['token' => $token]);
        Mail::to($user->email)->send(new ResetPasswordMail($resetLink));
    }
}
