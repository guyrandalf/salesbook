<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.setting');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->route('user.setting')->with('message', 'Old password is incorrect')->with('type', 'error');
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return redirect()->route('user.setting')->with('message', 'Password Updated Successfully')->with('type', 'success');
    }
}
