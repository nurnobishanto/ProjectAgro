<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlaughterStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class SlaughterStoreController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $slaughter_stores = SlaughterStore::orderBy('id','DESC')->get();
        return view('admin.slaughter_stores.index',compact('slaughter_stores'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $slaughter_stores = SlaughterStore::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.slaughter_stores.trashed',compact('slaughter_stores'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.slaughter_stores.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'email|unique:slaughter_stores',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('slaughter_store-photo');
        }
        $slaughter_store = SlaughterStore::create([
            'name' =>$request->name,
            'phone' =>$request->phone,
            'email' =>$request->email,
            'company' =>$request->company,
            'address' =>$request->address,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
            'photo' =>$imagePath,
        ]);
        toastr()->success($slaughter_store->name.__('global.created_success'),__('global.slaughter_store').__('global.created'));
        return redirect()->route('admin.slaughter-stores.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_store = SlaughterStore::find($id);
        return view('admin.slaughter_stores.show',compact('slaughter_store'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_store = SlaughterStore::find($id);
        return view('admin.slaughter_stores.edit',compact(['slaughter_store']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_store = SlaughterStore::find($id);
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'email|unique:slaughter_stores,id,'.$id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $slaughter_store->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('slaughter_store-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $slaughter_store->name = $request->name;
        $slaughter_store->phone = $request->phone;
        $slaughter_store->email = $request->email;
        $slaughter_store->address = $request->address;
        $slaughter_store->company = $request->company;
        $slaughter_store->status = $request->status;
        $slaughter_store->photo = $imagePath;
        $slaughter_store->update();
        toastr()->success($slaughter_store->name.__('global.updated_success'),__('global.slaughter_store').__('global.updated'));
        return redirect()->route('admin.slaughter-stores.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_store = SlaughterStore::find($id);
        $slaughter_store->delete();
        toastr()->success($slaughter_store->name.__('global.deleted_success'),__('global.slaughter_store').__('global.deleted'));
        return redirect()->route('admin.slaughter-stores.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $slaughter_store = SlaughterStore::withTrashed()->find($id);
        $slaughter_store->deleted_at = null;
        $slaughter_store->update();
        toastr()->success($slaughter_store->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.slaughter-stores.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $slaughter_store = SlaughterStore::withTrashed()->find($id);
        $old_image_path = "uploads/".$slaughter_store->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $slaughter_store->forceDelete();
        toastr()->success(__('global.slaughter_store').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.slaughter-stores.trashed');
    }

}
