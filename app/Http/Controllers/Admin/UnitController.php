<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\CattleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class UnitController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $units = Unit::orderBy('id','DESC')->get();
        return view('admin.units.index',compact('units'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $units = Unit::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.units.trashed',compact('units'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.units.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'status' => 'required',
        ]);
        $unit = Unit::create([
            'name' =>$request->name,
            'code' =>$request->code,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
        ]);
        toastr()->success($unit->name.__('global.created_success'),__('global.unit').__('global.created'));
        return redirect()->route('admin.units.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $unit = Unit::find($id);

        return view('admin.units.show',compact('unit'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $unit = Unit::find($id);
        return view('admin.units.edit',compact(['unit']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $unit = Unit::find($id);
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'status' => 'required',
        ]);
        $unit->name = $request->name;
        $unit->code = $request->code;
        $unit->status = $request->status;
        $unit->update();
        toastr()->success($unit->name.__('global.updated_success'),__('global.unit').__('global.updated'));
        return redirect()->route('admin.units.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $unit = Unit::find($id);
        $unit->delete();
        toastr()->warning($unit->name.__('global.deleted_success'),__('global.unit').__('global.deleted'));
        return redirect()->route('admin.units.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $unit = Unit::withTrashed()->find($id);
        $unit->deleted_at = null;
        $unit->update();
        toastr()->success($unit->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.units.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $unit = Unit::withTrashed()->find($id);
        $old_image_path = "uploads/".$unit->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $unit->forceDelete();
        toastr()->error(__('global.unit').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.units.trashed');
    }

}
