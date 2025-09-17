<?php

namespace App\Http\Controllers\Auth;

use App\Models\Shifts;
use App\Models\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'store_id' => 'required|exists:stores,id',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $openShift = Shifts::where('user_id', $user->id)
              ->whereNull('end_time')
              ->first();

            if ($openShift) {
                if ($openShift->store_id == $request->input('store_id')) {
                    return redirect()->route('dashboard');
                } else {
                    Auth::logout();
                    return redirect()->back()->with('error', 'يوجد شيفت مفتوح لك من قبل فى فرع أخر');
                }
            } else {
                Shifts::create([
                    'user_id' => $user->id,
                    'store_id' => $request->input('store_id'),
                    'start_time' => now(),
                    'opening_balance' => 0
                ]);
                return redirect()->route('dashboard')->with('success', 'تم فتح شيفت جديد بنجاح.');
            }
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
