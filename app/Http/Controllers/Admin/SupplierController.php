<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class SupplierController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $suppliers = Supplier::orderBy('id','DESC')->get();
        return view('admin.suppliers.index',compact('suppliers'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $suppliers = Supplier::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.suppliers.trashed',compact('suppliers'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.suppliers.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'email|unique:suppliers',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('supplier-photo');
        }
        $supplier = Supplier::create([
            'name' =>$request->name,
            'phone' =>$request->phone,
            'email' =>$request->email,
            'company' =>$request->company,
            'status' =>$request->status,
            'previous_balance' =>$request->previous_balance??0,
            'current_balance' =>$request->previous_balance??0,
            'address' =>$request->address,
            'created_by' =>auth()->user()->id,
            'photo' =>$imagePath,
        ]);
        toastr()->success($supplier->name.__('global.created_success'),__('global.supplier').__('global.created'));
        return redirect()->route('admin.suppliers.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $supplier = Supplier::find($id);
        return view('admin.suppliers.show',compact('supplier'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $supplier = Supplier::find($id);
        return view('admin.suppliers.edit',compact(['supplier']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $supplier = Supplier::find($id);
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'email|unique:suppliers,id,'.$id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $supplier->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('supplier-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->company = $request->company;
        $supplier->status = $request->status;
        $supplier->photo = $imagePath;
        $supplier->update();
        toastr()->success($supplier->name.__('global.updated_success'),__('global.supplier').__('global.updated'));
        return redirect()->route('admin.suppliers.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $supplier = Supplier::find($id);
        $supplier->delete();
        toastr()->success($supplier->name.__('global.deleted_success'),__('global.supplier').__('global.deleted'));
        return redirect()->route('admin.suppliers.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $supplier = Supplier::withTrashed()->find($id);
        $supplier->deleted_at = null;
        $supplier->update();
        toastr()->success($supplier->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.suppliers.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $supplier = Supplier::withTrashed()->find($id);
        $old_image_path = "uploads/".$supplier->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $supplier->forceDelete();
        toastr()->success(__('global.supplier').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.suppliers.trashed');
    }

}
