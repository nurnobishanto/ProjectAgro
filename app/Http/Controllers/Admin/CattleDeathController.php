<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignedCost;
use App\Models\Cattle;
use App\Models\CattleDeath;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


class CattleDeathController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale(session('locale'));
        $cattle_deaths = CattleDeath::orderBy('id','DESC')->get();
        if ($request->date){
            $cattle_deaths = $cattle_deaths->where('date',$request->date);
        }
        if ($request->status){
            $cattle_deaths = $cattle_deaths->where('status',$request->status);
        }
        return view('admin.cattle_deaths.index',compact('cattle_deaths'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $cattle_deaths = CattleDeath::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.cattle_deaths.trashed',compact('cattle_deaths'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.cattle-deaths.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $cattle = Cattle::where('id',$request->tag_id)->where('status','active')->first();
        $cattle_cost = getCattleTotalCost($cattle);
        $other_cost = getTotalAvgExpenseCost();
        $amount = $cattle_cost['total'] + $other_cost['avg_cost'];

        return view('admin.cattle_deaths.create',compact(['cattle','amount']));
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'date' => 'required',
            'cattle_id' => 'required|unique:cattle_deaths',
            'amount' => 'required',
        ]);
        $cattle = Cattle::where('id',$request->cattle_id)->where('status','active')->first();
        $cattle_cost = getCattleTotalCost($cattle);
        $other_cost = getTotalAvgExpenseCost($request->date);
        $total = $cattle_cost['total'] + $other_cost['avg_cost'];

        CattleDeath::create([
            'date' => $request->date,
            'cattle_id' => $request->cattle_id,
            'feeding_expense' => $cattle_cost['total'],
            'other_expense' => $other_cost['avg_cost'],
            'amount' => $total,
            'note' => $request->note,
            'status' => 'pending',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        toastr()->success(__('global.created_success'),__('global.cattle_death').__('global.created'));
        return redirect()->route('admin.cattle-deaths.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_death = CattleDeath::find($id);
        $data = array();
        $data['cattle_death'] = $cattle_death;
        $data['cattle'] = $cattle_death->cattle;
        $data['amount'] = $cattle_death->amount;
        return view('admin.cattle_deaths.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_death = CattleDeath::find($id);
        $data = array();
        $data['cattle_death'] = $cattle_death;
        $data['cattle'] = $cattle_death->cattle;
        $data['amount'] = $cattle_death->amount;
        return view('admin.cattle_deaths.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'date' => 'required',
            'cattle_id' => 'required',
            'amount' => 'required',
        ]);
        $cattle_death = CattleDeath::find($id);
        $cattle = $cattle_death->cattle;

        $cattle_cost = getCattleTotalCost($cattle);
        $other_cost = getTotalAvgExpenseCost($request->date);
        $total = $cattle_cost['total'] + $other_cost['avg_cost'];


        $cattle_death->date = $request->date;
        $cattle_death->feeding_expense = $cattle_cost['total'];
        $cattle_death->other_expense = $other_cost['avg_cost'];
        $cattle_death->amount = $total;
        $cattle_death->note = $request->note;
        $cattle_death->updated_by = auth()->user()->id;
        $cattle_death->update();

        toastr()->success(__('global.updated_success'),__('global.cattle_death').__('global.updated'));
        return redirect()->route('admin.cattle-deaths.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_death = CattleDeath::find($id);
        $cattle_death->delete();

        toastr()->warning($cattle_death->name.__('global.deleted_success'),__('global.cattle_death').__('global.deleted'));
        return redirect()->route('admin.cattle-deaths.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $cattle_death = CattleDeath::withTrashed()->find($id);

        $cattle_death->deleted_at = null;
        $cattle_death->update();
        toastr()->success($cattle_death->cattle->tag_id.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.cattle-deaths.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $cattle_death = CattleDeath::withTrashed()->find($id);
        $cattle_death->forceDelete();
        toastr()->error(__('global.cattle_death').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.cattle-deaths.trashed');
    }
    public function approve ($id){
        $cattle_death = CattleDeath::find($id);
        $cattle = $cattle_death->cattle;
        if ($cattle->status != 'active'){
            toastr()->error('Cattle is not active');
            return  redirect()->back();
        }

        AssignedCost::create([
            'date' => $cattle_death->date,
            'model' => 'CattleDeath',
            'model_id' => $id,
            'amount' => $cattle_death->other_expense,
        ]);

        $cattle->status = 'death';
        $cattle->death_date = $cattle_death->date;
        $cattle->death_reason = $cattle_death->note;
        $cattle->update();

        $cattle_death->status = 'approved';
        $cattle_death->update();

        toastr()->success($cattle_death->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.cattle-deaths.index');
    }

}
