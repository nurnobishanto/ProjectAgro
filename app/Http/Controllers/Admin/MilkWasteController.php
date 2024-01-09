<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MilkStock;
use App\Models\MilkWaste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MilkWasteController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $milk_wastes = MilkWaste::orderBy('id','DESC')->get();
        return view('admin.milk_wastes.index',compact('milk_wastes'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'farm_id' => 'required',
        ]);
        App::setLocale(session('locale'));
        $farm_id = $request->farm_id;
        $stock = MilkStock::where('farm_id',$farm_id)->first();
        return view('admin.milk_wastes.create',compact(['farm_id','stock']));
    }
    public function edit($id)
    {
        App::setLocale(session('locale'));
        $milk_waste = MilkWaste::find($id);
        $stock = MilkStock::where('farm_id',$milk_waste->farm_id)->first();
        return view('admin.milk_wastes.edit',compact(['milk_waste','stock']));
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $milk_waste = MilkWaste::find($id);
        return view('admin.milk_wastes.show',compact('milk_waste'));
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required|unique:milk_wastes',
            'date' => 'required',
            'farm_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);

        $milk_waste = MilkWaste::create([
            'unique_id' => $request->unique_id,
            'date' => $request->date,
            'farm_id' => $request->farm_id,
            'quantity'=> $request->quantity??0,
            'unit_price'=> $request->unit_price??0,
            'total'=> ($request->quantity??0) * ($request->unit_price??0),
            'note' => $request->note,
            'status' => 'pending',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        toastr()->success($milk_waste->unique_id.__('global.created_success'),__('global.milk_waste').__('global.created'));
        return redirect()->route('admin.milk-wastes.index');
    }
    public function update(Request $request, $id){
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required|unique:milk_wastes,id,'.$id,
            'date' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);
        // Find the MilkWaste record to update
        $milk_waste = MilkWaste::findOrFail($id);

        // Update the fields of the MilkWaste record
        $milk_waste->update([
            'date' => $request->date,
            'quantity'=> $request->quantity??0,
            'unit_price'=> $request->unit_price??0,
            'total'=> ($request->quantity??0) * ($request->unit_price??0),
            'note' => $request->note,
            'updated_by' => auth()->user()->id,
        ]);

        toastr()->success($milk_waste->unique_id.__('global.updated_success'),__('global.milk_waste').__('global.updated'));
        return redirect()->route('admin.milk-wastes.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $milk_waste = MilkWaste::find($id);
        $milk_waste->delete();
        toastr()->warning($milk_waste->unique_id.__('global.deleted_success'),__('global.milk_waste').__('global.deleted'));
        return redirect()->route('admin.milk-wastes.index');
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $milk_wastes = MilkWaste::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.milk_wastes.trashed',compact('milk_wastes'));
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $milk_waste = MilkWaste::withTrashed()->find($id);
        $milk_waste->deleted_at = null;
        $milk_waste->update();
        toastr()->success($milk_waste->unique_id.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.milk-wastes.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $milk_waste = MilkWaste::withTrashed()->find($id);
        $milk_waste->forceDelete();
        toastr()->error(__('global.milk_waste').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.milk-wastes.trashed');
    }
    public function approve(Request $request,$id){
        $milk_waste = MilkWaste::find($id);

        $stock = MilkStock::where('farm_id', $milk_waste->farm_id)->first();
        if ($stock) {
            $stockQty = $stock->quantity;
            $wasteQty = $milk_waste->quantity;
            if ($stockQty >= $wasteQty) {
                $stock->decrement('quantity', $wasteQty);
                $milk_waste->save();


                $milk_waste->status = 'success';
                $milk_waste->update();

                toastr()->success(__('notification.milk_waste_has_been_approved'));
                return redirect()->back();

            }else{
                toastr()->error('Stock empty');
                return redirect()->back();
            }
        }else{
            toastr()->error('Stock empty');
            return redirect()->back();
        }
    }
}
