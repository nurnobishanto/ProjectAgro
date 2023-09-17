<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;



class FarmController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $farms = Farm::orderBy('id','DESC')->get();
        return view('admin.farms.index',compact('farms'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $farms = Farm::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.farms.trashed',compact('farms'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.farms.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required|unique:farms',
            'phone' => 'required:tel',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
        }
        $farm = Farm::create([
            'name' =>$request->name,
            'phone' =>$request->phone,
            'address' =>$request->address,
            'created_by' => auth()->user()->id,
            'status' =>$request->status,
            'photo' =>$imagePath,
        ]);
        toastr()->success($farm->name.__('global.created_success'),__('global.farms').__('global.created'));

        return redirect()->route('admin.farms.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $farm = Farm::find($id);
        return view('admin.farms.show',compact('farm'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $farm = Farm::find($id);

        return view('admin.farms.edit',compact(['farm']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $farm = Farm::find($id);
        $request->validate([
            'name' => 'required|unique:farms,id,'.$id,
            'phone' => 'required:tel',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $farm->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $farm->name = $request->name;
        $farm->phone = $request->phone;
        $farm->address = $request->address;
        $farm->status = $request->status;
        $farm->photo = $imagePath;
        $farm->update();
        toastr()->success($farm->name.__('global.updated_success'),__('global.farms').__('global.updated'));
        return redirect()->route('admin.farms.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $farm = Farm::find($id);
        $farm->delete();
        toastr()->success(__('global.farms').__('global.deleted_success'),__('global.farms').__('global.deleted'));
        return redirect()->route('admin.farms.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $farm = Farm::withTrashed()->find($id);
        $farm->deleted_at = null;
        $farm->update();
        toastr()->success($farm->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.farms.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $farm = Farm::withTrashed()->find($id);
        $old_image_path = "uploads/".$farm->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $farm->forceDelete();
        toastr()->success(__('farm').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.farms.trashed');
    }

}
