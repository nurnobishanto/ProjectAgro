<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignedCost;
use App\Models\Cattle;
use App\Models\MilkProduction;
use App\Models\MilkStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class MilkProductionController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale(session('locale'));
        $milk_productions = MilkProduction::orderBy('id','DESC')->get();
        if ($request->date){
            $milk_productions = $milk_productions->where('date',$request->date);
        }
        if ($request->status){
            $milk_productions = $milk_productions->where('status',$request->status);
        }
        return view('admin.milk_productions.index',compact('milk_productions'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $milk_productions = MilkProduction::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.milk_productions.trashed',compact('milk_productions'));
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
        $today =  date('Y-m-d',strtotime(now()));
        return view('admin.milk_productions.create',compact(['cattle','today']));
    }

    public function store(Request $request)
    {

        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'cattle_id' => 'required|unique:slaughters',
            'farm_id' => 'required',
            'quantity' => 'required',
            'moment' => 'required',
        ]);
        $cattle = Cattle::find($request->cattle_id);

        $mp = MilkProduction::where('date',$request->date)
            ->where('cattle_id',$request->cattle_id)
            ->where('moment',$request->moment)
            ->first();
        if (!$mp){
            MilkProduction::create([
                'unique_id' => $request->unique_id,
                'date' => $request->date,
                'cattle_id' => $request->cattle_id,
                'farm_id' => $cattle->farm_id,
                'quantity' => $request->quantity,
                'moment' => $request->moment,
                'note' => $request->note,
                'status' => 'pending',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
        }

        toastr()->success(__('global.created_success'),__('global.milk_production').__('global.created'));
        return redirect()->route('admin.milk-productions.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $milk_production = MilkProduction::find($id);
        $data = array();
        $data['milk_production'] = $milk_production;
        $data['cattle'] = $milk_production->cattle;
        return view('admin.milk_productions.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $milk_production = MilkProduction::find($id);
        $data = array();
        $data['milk_production'] = $milk_production;
        $data['cattle'] = $milk_production->cattle;

        return view('admin.milk_productions.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'date' => 'required',
            'quantity' => 'required',
            'moment' => 'required',
        ]);

        $milk_production = MilkProduction::find($id);

        $mp = MilkProduction::where('date',$request->date)
            ->where('cattle_id',$milk_production->cattle_id)
            ->where('moment',$request->moment)
            ->first();
        if (!$mp){
            $milk_production->date = $request->date;
            $milk_production->moment = $request->moment;
        }
        $milk_production->quantity = $request->quantity;
        $milk_production->note = $request->note;
        $milk_production->updated_by = auth()->user()->id;
        $milk_production->update();

        toastr()->success(__('global.updated_success'),__('global.milk_production').__('global.updated'));
        return redirect()->route('admin.milk-productions.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $milk_production = MilkProduction::find($id);
        $milk_production->delete();
        toastr()->warning($milk_production->unique_id.__('global.deleted_success'),__('global.milk_production').__('global.deleted'));
        return redirect()->route('admin.milk-productions.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $milk_production = MilkProduction::withTrashed()->find($id);
        $milk_production->deleted_at = null;
        $milk_production->update();
        toastr()->success($milk_production->unique_id.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.milk-productions.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $milk_production = MilkProduction::withTrashed()->find($id);
        $milk_production->forceDelete();
        toastr()->error(__('global.milk_production').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.milk-productions.trashed');
    }
    public function approve ($id){
        $milk_production = MilkProduction::find($id);
        if ($milk_production->status != 'success'){
            $milk_stock = MilkStock::where('farm_id',$milk_production->farm_id)->first();
            if (!$milk_stock){
                $milk_stock = MilkStock::create([
                    'farm_id' => $milk_production->farm_id,
                    'quantity' => 0.0,
                ]);
            }
            $milk_stock->increment('quantity', $milk_production->quantity);
            $milk_stock->update();

            $milk_production->status = 'success';
            $milk_production->save();

        }
        toastr()->success($milk_production->unique_id.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.milk-productions.index');
    }
}
