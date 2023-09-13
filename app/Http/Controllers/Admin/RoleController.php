<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index(){
        App::setLocale(session('locale'));
        $user=Auth::user();
        if($user->hasAnyRole([ 'super_admin'])){
            $roles =  Role::orderBy('id','DESC')->get();
        }else{
            $roles = Role::where('name','!=','super_admin')->get();
        }
        return view('admin.roles.index',compact('roles'));
    }
    public function show($id){
        App::setLocale(session('locale'));
        $role =  Role::where('id',$id)->first();
        $permissions = Permission::orderBy('id','DESC')->get();
        $all_permissions = Permission::orderBy('id','DESC')->get();
        $permissions_groups = Permission::select('group_name')->groupBy('group_name')->get();
        return view('admin.roles.show',compact(['role','permissions','permissions_groups','all_permissions']));
    }
    public function create(){
        App::setLocale(session('locale'));
        $permissions = Permission::orderBy('id','DESC')->get();
        $permissions_groups = Permission::select('group_name')->groupBy('group_name')->get();
        return view('admin.roles.create',compact(['permissions','permissions_groups']));
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'name'=>'required|unique:roles|min:3',
            'guard_name'=>'required|min:3',
        ]);
        $role =  Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);
        $role->syncPermissions($request->permissions);
        toastr()->success($request->name. __('global.created_success'),__('menu.roles').__('global.created'));
        return redirect()->route('admin.roles.index');
    }
    public function edit($id){
        App::setLocale(session('locale'));
        $role =  Role::where('id',$id)->first();
        $permissions = Permission::where('guard_name',$role->guard_name)->get();
        $all_permissions = Permission::where('guard_name',$role->guard_name)->get();
        $permissions_groups = Permission::select('group_name')->groupBy('group_name')->where('guard_name',$role->guard_name)->get();
        return view('admin.roles.edit',compact(['role','permissions','permissions_groups','all_permissions']));
    }
    public function update(Request $request,$id){
        App::setLocale(session('locale'));
        $request->validate([
            'name'=>'required|min:3',

        ]);
        $role = Role::where('id',$id)->first();
        $role->update([
            'name' => $request->name,

        ]);

        $role->syncPermissions($request->permissions);
        toastr()->success($request->name. __('global.updated_success'),__('menu.roles').__('global.updated'));
        return redirect()->back();
    }
    public function destroy($id){
        App::setLocale(session('locale'));
        Role::find($id)->delete();
        toastr()->error( __('global.deleted_success'),__('menu.roles').__('global.deleted'));
        return redirect()->route('admin.roles.index');
    }

}
