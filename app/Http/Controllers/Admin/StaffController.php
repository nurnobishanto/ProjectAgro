<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class StaffController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $staffs = Staff::orderBy('id','DESC')->get();
        return view('admin.staffs.index',compact('staffs'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $staffs = Staff::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.staffs.trashed',compact('staffs'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.staffs.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'farm_id' => 'required',
            'name' => 'required',
            'phone' => 'unique:staff',
            'pay_type' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ]);
        $imageFile = null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('product-image');
        }
        $staff = Staff::create([
            'farm_id' =>$request->farm_id,
            'name' =>$request->name,
            'phone' =>$request->phone,
            'address' =>$request->address,
            'pay_type' =>$request->pay_type,
            'image' =>$imageFile,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success($staff->name.__('global.created_success'),__('global.staff').__('global.created'));
        return redirect()->route('admin.staffs.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $staff = Staff::find($id);

        return view('admin.staffs.show',compact('staff'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $staff = Staff::find($id);
        return view('admin.staffs.edit',compact(['staff']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $staff = Staff::find($id);
        $request->validate([
            'farm_id' => 'required',
            'name' => 'required',
            'phone' => 'unique:staff,id,'.$id,
            'pay_type' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ]);
        $imageFile = $product->image??null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('product-image');
            $old_image_path = "uploads/".$request->image_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $staff->farm_id = $request->farm_id;
        $staff->name = $request->name;
        $staff->phone = $request->phone;
        $staff->address = $request->address;
        $staff->pay_type = $request->pay_type;
        $staff->status = $request->status;
        $staff->image = $imageFile;
        $staff->updated_by = auth()->user()->id;
        $staff->update();
        toastr()->success($staff->name.__('global.updated_success'),__('global.staff').__('global.updated'));
        return redirect()->route('admin.staffs.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $staff = Staff::find($id);
        $staff->delete();
        toastr()->warning($staff->name.__('global.deleted_success'),__('global.staff').__('global.deleted'));
        return redirect()->route('admin.staffs.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $staff = Staff::withTrashed()->find($id);
        $staff->deleted_at = null;
        $staff->update();
        toastr()->success($staff->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.staffs.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $staff = Staff::withTrashed()->find($id);
        $old_image_path = "uploads/".$staff->image;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $staff->forceDelete();
        toastr()->error(__('global.staff').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.staffs.trashed');
    }

}
