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
      // return $shift;
      return view('shifts.close-shift', compact('shift'));
    }

    public function close(Request $request, $shiftId)
    {
        $request->validate([
          'actual_balance' => 'required|numeric|min:0'
        ]);

        $shift = Shifts::with(['transactions' => function($query) {
          $query->select('id', 'shift_id', 'amount');
        }])->whereNull('end_time')->findOrFail($shiftId);

        //amount transaction
        $amountTransaction = $shift->transactions->sum('amount');
        // actual balance in shift and user 
        $balanceUser = $request->input('actual_balance', $shift->actual_balance); 
        // expected balance
        $expected_balance  = $amountTransaction +  $shift->opening_balance;;

        $difference = $balanceUser - $expected_balance;

        $shift->update([
          'end_time' => now(),
          'closing_balance' => $balanceUser,
          'difference' => $difference
        ]);

        if($difference == 0 ){ 
          $message = "تم إغلاق الشيفت بنجاح";
        } elseif($difference > 0) {
          $message = "تم إغلاق الشيفت - يوجد فائض بقيمة {$difference}";
        } else {
          $message = "تم إغلاق الشيفت - يوجد عجز بقيمة " . abs($difference);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', $message);
    }
}
