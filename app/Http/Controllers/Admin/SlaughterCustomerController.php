<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlaughterCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class SlaughterCustomerController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $slaughter_customers = SlaughterCustomer::orderBy('id','DESC')->get();
        return view('admin.slaughter_customers.index',compact('slaughter_customers'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $slaughter_customers = SlaughterCustomer::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.slaughter_customers.trashed',compact('slaughter_customers'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.slaughter_customers.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'email|unique:slaughter_customers',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('slaughter_customer-photo');
        }
        $slaughter_customer = SlaughterCustomer::create([
            'name' =>$request->name,
            'phone' =>$request->phone,
            'email' =>$request->email,
            'company' =>$request->company,
            'balance' =>0,
            'address' =>$request->address,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
            'photo' =>$imagePath,
        ]);
        toastr()->success($slaughter_customer->name.__('global.created_success'),__('global.slaughter_customer').__('global.created'));
        return redirect()->route('admin.slaughter-customers.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_customer = SlaughterCustomer::find($id);
        return view('admin.slaughter_customers.show',compact('slaughter_customer'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_customer = SlaughterCustomer::find($id);
        return view('admin.slaughter_customers.edit',compact(['slaughter_customer']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_customer = SlaughterCustomer::find($id);
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'email|unique:slaughter_customers,id,'.$id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $slaughter_customer->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('slaughter_customer-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $slaughter_customer->name = $request->name;
        $slaughter_customer->phone = $request->phone;
        $slaughter_customer->email = $request->email;
        $slaughter_customer->address = $request->address;
        $slaughter_customer->company = $request->company;
        $slaughter_customer->status = $request->status;
        $slaughter_customer->photo = $imagePath;
        $slaughter_customer->update();
        toastr()->success($slaughter_customer->name.__('global.updated_success'),__('global.slaughter_customer').__('global.updated'));
        return redirect()->route('admin.slaughter-customers.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_customer = SlaughterCustomer::find($id);
        $slaughter_customer->delete();
        toastr()->success($slaughter_customer->name.__('global.deleted_success'),__('global.slaughter_customer').__('global.deleted'));
        return redirect()->route('admin.slaughter-customers.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $slaughter_customer = SlaughterCustomer::withTrashed()->find($id);
        $slaughter_customer->deleted_at = null;
        $slaughter_customer->update();
        toastr()->success($slaughter_customer->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.slaughter-customers.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $slaughter_customer = SlaughterCustomer::withTrashed()->find($id);
        $old_image_path = "uploads/".$slaughter_customer->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $slaughter_customer->forceDelete();
        toastr()->success(__('global.slaughter_customer').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.slaughter-customers.trashed');
    }

}
