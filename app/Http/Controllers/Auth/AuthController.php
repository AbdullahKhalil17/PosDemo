<?php

namespace App\Http\Controllers\Auth;

use App\Models\Stores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
      $stores = Stores::select('id', 'name')->get();
      return view('auth.login', compact('stores'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
          'email' => 'required|email',
          'password' => 'required|min:6'
        ]);

        if(Auth::attempt($credentials)) {
          return redirect()->route('dashboard');
        }

        return back()->withErrors([
          'email' => 'البريد الالكتروني أو كلمة المرور غير صحيحة',
        ])->onlyInput('email');
    }



    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح');
    }


}
