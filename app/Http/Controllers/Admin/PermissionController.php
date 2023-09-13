<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;



class PermissionController extends Controller
{
    public function index(){
        App::setLocale(session('locale'));
        $permissions =  Permission::orderBy('id','DESC')->get();
        return view('admin.permissions.index',compact('permissions'));
    }
    public function create(){
        App::setLocale(session('locale'));
        return view('admin.permissions.create');
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'name'=>'required|unique:permissions|min:3',
            'guard_name'=>'required|min:3',
            'group_name'=>'required|min:3',
        ]);
        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'group_name' => $request->group_name,
        ]);
        toastr()->success($request->name. __('global.created_success'),__('menu.permissions').__('global.created'));
        return redirect()->route('admin.permissions.index');
    }
    public function destroy($id){
        App::setLocale(session('locale'));
        Permission::find($id)->delete();
        toastr()->error( __('global.deleted_success'),__('menu.permissions').__('global.deleted'));
        return redirect()->route('admin.permissions.index');
    }
    public function edit($id){
        App::setLocale(session('locale'));
        $permission = Permission::find($id);
        return view('admin.permissions.edit',compact('permission'));
    }
    public function update(Request $request,$id){
        App::setLocale(session('locale'));
        $request->validate([
            'name'=>'required|unique:permissions,name,'.$id.'|min:3',
            'guard_name'=>'required|min:3',
            'group_name'=>'required|min:3',
        ]);
        $permission = Permission::where('id',$id)->first();
        $permission->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'group_name' => $request->group_name,
        ]);
        toastr()->success($request->name. __('global.updated_success'),__('menu.permissions').__('global.updated'));
        return redirect()->back();
    }
    public function show($id){
        App::setLocale(session('locale'));
        $permission = Permission::find($id);
        return view('admin.permissions.show',compact('permission'));
    }
}
