<?php

namespace App\Http\Controllers\Management;

use App\Models\Shifts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShiftsController extends Controller
{
    public function index()
    {
      $shift = Shifts::with('user')->where('user_id', auth()->id())
      ->whereNull('end_time')->first();
      return view('shifts.close-shift', compact('shift'));
    }

    public function close(Request $request)
    {
        $request->validate([
            'actual_balance' => 'required|numeric|min:0',
        ]);

        $shift = Shifts::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->first();

        $shift->update([
            'end_time' => now(),
            'actual_balance' => $request->actual_balance,
        ]);
        
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard')->with('success', 'تم إغلاق الشيفت بنجاح');
    }
}
