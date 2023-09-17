<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $admins = Admin::orderBy('id','DESC')->get();
        return view('admin.admins.index',compact('admins'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $admins = Admin::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.admins.trashed',compact('admins'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $roles = Role::where('name','!=','super_admin')->get();
        return view('admin.admins.create',compact(['roles']));
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed', // Use 'confirmed' for password confirmation
            'roles' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
        }
        $admin = Admin::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'status' =>$request->status,
            'photo' =>$imagePath,
            'password' => Hash::make($request->password) ,
        ]);
        $admin->syncRoles($request->roles);
        toastr()->success($admin->name.__('global.created_success'),__('global.admin').__('global.created'));

        return redirect()->route('admin.admins.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $admin = Admin::find($id);
        return view('admin.admins.show',compact('admin'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $admin = Admin::find($id);
        if(checkAdminRole($admin,'super_admin')){
            $roles = Role::all();
        }else{
            $roles = Role::where('name','!=','super_admin')->get();
        }

        return view('admin.admins.edit',compact(['admin','roles']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $admin = Admin::find($id);
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:admins,id,'.$id,
            'roles' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->password){
            $request->validate([
                'password' => 'confirmed',
            ]);
            $admin->password = Hash::make($request->password);
        }
        $imagePath = $admin->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->status = $request->status;
        $admin->photo = $imagePath;
        $admin->update();
        toastr()->success($admin->name.__('global.updated_success'),__('global.admin').__('global.updated'));
        if(!$admin->hasAnyRole([ 'super_admin'])){
            $admin->syncRoles([$request->roles]);
            toastr()->success($admin->name.__('global.updated_success'),__('global.admin').__('global.updated'));
        }else{
            toastr()->error(__('global.permission_denied_msg'),__('global.permission_denied'));
        }
        return redirect()->route('admin.admins.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $admin = Admin::find($id);
        if(!$admin->hasAnyRole([ 'super_admin'])){
            $admin->delete();
            toastr()->success(__('global.admin').__('global.deleted_success'),__('global.admin').__('global.deleted'));
        }else{
            toastr()->error(__('global.permission_denied_msg'),__('global.permission_denied'));
        }
        return redirect()->route('admin.admins.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $admin = Admin::withTrashed()->find($id);
        $admin->deleted_at = null;
        $admin->update();
        toastr()->success($admin->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.admins.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $admin = Admin::withTrashed()->find($id);
        $old_image_path = "uploads/".$admin->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $admin->forceDelete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.admins.trashed');
    }
    public function profile(){
        App::setLocale(session('locale'));
        $admin = auth()->user();
        return view('admin.admins.profile',compact(['admin']));
    }
    public function profile_update(Request $request){
        App::setLocale(session('locale'));
        $admin = auth()->user();
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:admins,id,'.$admin->id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->password){
            $request->validate([
                'password' => 'confirmed',
            ]);
            $admin->password = Hash::make($request->password);
        }

        $imagePath = $admin->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->photo = $imagePath;
        $admin->status = $request->status;
        $admin->update();
        toastr()->success($admin->name.__('global.updated_success'),__('global.admin').__('global.updated'));
        return redirect()->route('admin.profile');
    }
}
