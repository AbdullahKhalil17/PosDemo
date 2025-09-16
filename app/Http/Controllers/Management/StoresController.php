<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Stores;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function index()
    {
      $stores = Stores::select('id', 'name', 'address')->get();
      return view('store.index', compact('stores'));
    }



    public function edit($id)
    {
      $store = Stores::where('id', $id)
        ->select('id', 'name', 'address')->first();
      return view('store.edit', compact('store'));
    }
    
    public function create()
    {
      return view('store.store');
    }

    public function store(Request $request)
    {
      $request->validate([
          'name' => 'required|string|max:255',
          'address' => 'required|string|max:255'
      ]);
      try{
          Stores::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
          ]);
        return redirect()->route('stores.index')->with('success', 'تم حفظ بيانات الفرع بنجاح');
      } catch(\Exception $e) {
        return redirect()->route('stores.index')->with('error', $e->getMessage());
      }
    }

    public function update(Request $request, $id)
    {
      $request->validate([
          'name' => 'required|string|max:255',
          'address' => 'required|string|max:255'
      ]);
      try{
          Stores::where('id', $id)->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
          ]);
        return redirect()->route('stores.index')->with('success', 'تم حفظ بيانات الفرع بنجاح');
      } catch(\Exception $e) {
        return redirect()->route('stores.index')->with('error', $e->getMessage());
      }
    }



    public function destroy($id)
    {
      try {
        Stores::where('id', $id)->delete();
        return redirect()->route('stores.index')->with('success', 'تم حذف الفرع بنجاح');
      } catch (\Exception $e) {
        return redirect()->route('stores.index')->with('error', 'حدث خطأ أثناء حذف الفرع');
      }
    }
}
