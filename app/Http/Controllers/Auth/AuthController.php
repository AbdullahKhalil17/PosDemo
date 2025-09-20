<?php

namespace App\Http\Controllers\Auth;

use App\Models\Shifts;
use App\Models\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Safes;
use App\Models\User;
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'store_id' => 'required|exists:stores,id',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if($user->role === "cashier") {
              $route = 'salesInvoice.index';
            } else {
              $route = 'dashboard';
            }

            $openShift = Shifts::where('user_id', $user->id)->whereNull('end_time')->first();
            
            // check shift
            if ($openShift) {
              if ($openShift->store_id != $request->input('store_id')) {
                  Auth::logout();
                  return redirect()->back()->with('error', 'يوجد شيفت معلق في فرع آخر. الرجاء إغلاقه أولاً.');
              } else {
                  return redirect()->route($route)->with('success', 'مرحباً بعودتك! ما زال شيفتك في نفس الفرع مفتوحاً.');
              }
            }
            // create shift 
            $safe_id = Safes::where('store_id', $request->input('store_id'))->first();
            Shifts::create([
                'user_id' => $user->id,
                'store_id' => $request->input('store_id'),
                'start_time' => now(),
                'opening_balance' => 0,
                'safe_id' => $safe_id->id,
            ]);
            return redirect()->route($route)->with('success', 'تم فتح شيفت جديد بنجاح.');
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