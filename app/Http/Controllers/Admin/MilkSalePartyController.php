<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MilkSaleParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MilkSalePartyController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $milk_sale_parties = MilkSaleParty::orderBy('id','DESC')->get();
        return view('admin.milk_sale_parties.index',compact('milk_sale_parties'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $milk_sale_parties = MilkSaleParty::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.milk_sale_parties.trashed',compact('milk_sale_parties'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.milk_sale_parties.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('milk_sale_party_photo');
        }
        $milk_sale_party = MilkSaleParty::create([
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
        toastr()->success($milk_sale_party->name.__('global.created_success'),__('global.milk_sale_party').__('global.created'));
        return redirect()->route('admin.milk-sale-parties.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $milk_sale_party = MilkSaleParty::find($id);
        return view('admin.milk_sale_parties.show',compact('milk_sale_party'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $milk_sale_party = MilkSaleParty::find($id);
        return view('admin.milk_sale_parties.edit',compact(['milk_sale_party']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $milk_sale_party = MilkSaleParty::find($id);
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $milk_sale_party->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('milk_sale_party_photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $milk_sale_party->name = $request->name;
        $milk_sale_party->phone = $request->phone;
        $milk_sale_party->email = $request->email;
        $milk_sale_party->address = $request->address;
        $milk_sale_party->company = $request->company;
        $milk_sale_party->status = $request->status;
        $milk_sale_party->photo = $imagePath;
        $milk_sale_party->update();
        toastr()->success($milk_sale_party->name.__('global.updated_success'),__('global.milk_sale_party').__('global.updated'));
        return redirect()->route('admin.milk-sale-parties.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $milk_sale_party = MilkSaleParty::find($id);
        $milk_sale_party->delete();
        toastr()->success($milk_sale_party->name.__('global.deleted_success'),__('global.milk_sale_party').__('global.deleted'));
        return redirect()->route('admin.milk-sale-parties.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $milk_sale_party = MilkSaleParty::withTrashed()->find($id);
        $milk_sale_party->deleted_at = null;
        $milk_sale_party->update();
        toastr()->success($milk_sale_party->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.milk-sale-parties.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $milk_sale_party = MilkSaleParty::withTrashed()->find($id);
        $old_image_path = "uploads/".$milk_sale_party->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $milk_sale_party->forceDelete();
        toastr()->success(__('global.milk_sale_party').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.milk-sale-parties.trashed');
    }
}
