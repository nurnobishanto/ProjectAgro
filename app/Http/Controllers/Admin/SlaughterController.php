<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\Slaughter;
use App\Models\PartyReceive;
use App\Models\SlaughterStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


class SlaughterController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale(session('locale'));
        $slaughters = Slaughter::orderBy('id','DESC')->get();
        if ($request->date){
            $slaughters = $slaughters->where('date',$request->date);
        }
        if ($request->status){
            $slaughters = $slaughters->where('status',$request->status);
        }
        return view('admin.slaughters.index',compact('slaughters'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $slaughters = Slaughter::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.slaughters.trashed',compact('slaughters'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.slaughters.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $cattle = Cattle::where('id',$request->tag_id)->where('status','active')->first();
        $cattle_cost = getCattleTotalCost($cattle);
        $other_cost = getTotalAvgExpenseCost();
        $amount = $cattle_cost['total'] + $other_cost['avg_cost'];
        return view('admin.slaughters.create',compact(['cattle','amount']));
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'cattle_id' => 'required|unique:slaughters',
            'slaughter_store_id' => 'required',
            'items' => 'required',
            'quantities' => 'required',
        ]);
        $cattle = Cattle::find($request->cattle_id);
        $cattle_cost = getCattleTotalCost($cattle);
        $other_cost = getTotalAvgExpenseCost($request->date);
        $total = $cattle_cost['total'] + $other_cost['avg_cost'];
        $sl = Slaughter::create([
            'unique_id' => $request->unique_id,
            'date' => $request->date,
            'cattle_id' => $request->cattle_id,
            'farm_id' => $cattle->farm_id,
            'slaughter_store_id' => $request->slaughter_store_id,
            'note' => $request->note,
            'status' => 'pending',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        $items = [];
        foreach ($request->items as $key => $item_id) {
            $quantity = $request->quantities[$key] ?? 0;
            $items[] = [
                'product_id' => $item_id,
                'quantity' => $quantity,
            ];
        }
        $sl->products()->sync($items);
        toastr()->success(__('global.created_success'),__('global.slaughter').__('global.created'));
        return redirect()->route('admin.slaughters.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter = Slaughter::find($id);
        $data = array();
        $data['slaughter'] = $slaughter;
        $data['cattle'] = $slaughter->cattle;
        $data['amount'] = $slaughter->amount;
        return view('admin.slaughters.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter = Slaughter::find($id);
        $data = array();
        $data['slaughter'] = $slaughter;
        $data['cattle'] = $slaughter->cattle;
        $data['amount'] = $slaughter->amount;
        return view('admin.slaughters.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'slaughter_store_id' => 'required',
            'items' => 'required',
            'quantities' => 'required',
        ]);

        $slaughter = Slaughter::find($id);
        $slaughter->unique_id = $request->unique_id;
        $slaughter->date = $request->date;
        $slaughter->slaughter_store_id = $request->slaughter_store_id;
        $slaughter->note = $request->note;
        $slaughter->updated_by = auth()->user()->id;
        $slaughter->update();
        $slaughter->products()->detach();
        $items = [];
        foreach ($request->items as $key => $item_id) {
            $quantity = $request->quantities[$key] ?? 0;
            $items[] = [
                'product_id' => $item_id,
                'quantity' => $quantity,
            ];
        }
        $slaughter->products()->sync($items);
        toastr()->success(__('global.updated_success'),__('global.slaughter').__('global.updated'));
        return redirect()->route('admin.slaughters.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter = Slaughter::find($id);
        $slaughter->delete();
        toastr()->warning($slaughter->name.__('global.deleted_success'),__('global.slaughter').__('global.deleted'));
        return redirect()->route('admin.slaughters.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $slaughter = Slaughter::withTrashed()->find($id);
        $slaughter->deleted_at = null;
        $slaughter->update();
        toastr()->success($slaughter->date.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.slaughters.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $slaughter = Slaughter::withTrashed()->find($id);
        $slaughter->forceDelete();
        toastr()->error(__('global.slaughter').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.slaughters.trashed');
    }
    public function approve ($id){
        $slaughter = Slaughter::find($id);
        if ($slaughter->status != 'success'){
            $cattle = $slaughter->cattle;
            $cattle->status = 'slaughtered';
            $cattle->update();
            foreach ($slaughter->products as $product){
                $sl_stock = SlaughterStock::where('slaughter_store_id',$slaughter->slaughter_store_id)->where('product_id',$product->id)->first();
                if ($sl_stock){
                    $preQty = $sl_stock->quantity;
                    $sl_stock->quantity = $preQty + $product->pivot->quantity;
                    $sl_stock->update();
                }else{
                    SlaughterStock::create([
                        'slaughter_store_id' => $slaughter->slaughter_store_id,
                        'product_id' => $product->id,
                        'quantity' => $product->pivot->quantity,
                    ]);
                }
            }
            $slaughter->status = 'success';
            $slaughter->update();
        }
        toastr()->success($slaughter->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.slaughters.index');
    }
    public function stocks(Request $request){
        $stocks = SlaughterStock::all();
        return view('admin.slaughters.stocks',compact(['stocks']));
    }

}
