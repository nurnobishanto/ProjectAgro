<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class PartyController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $parties = Party::orderBy('id','DESC')->get();
        return view('admin.parties.index',compact('parties'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $parties = Party::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.parties.trashed',compact('parties'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.parties.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'email|unique:parties',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('party-photo');
        }
        $party = Party::create([
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
        toastr()->success($party->name.__('global.created_success'),__('global.party').__('global.created'));
        return redirect()->route('admin.parties.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $party = Party::find($id);
        return view('admin.parties.show',compact('party'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $party = Party::find($id);
        return view('admin.parties.edit',compact(['party']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $party = Party::find($id);
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'email|unique:parties,id,'.$id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $party->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('party-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $party->name = $request->name;
        $party->phone = $request->phone;
        $party->email = $request->email;
        $party->address = $request->address;
        $party->company = $request->company;
        $party->status = $request->status;
        $party->photo = $imagePath;
        $party->update();
        toastr()->success($party->name.__('global.updated_success'),__('global.party').__('global.updated'));
        return redirect()->route('admin.parties.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $party = Party::find($id);
        $party->delete();
        toastr()->success($party->name.__('global.deleted_success'),__('global.party').__('global.deleted'));
        return redirect()->route('admin.parties.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $party = Party::withTrashed()->find($id);
        $party->deleted_at = null;
        $party->update();
        toastr()->success($party->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.parties.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $party = Party::withTrashed()->find($id);
        $old_image_path = "uploads/".$party->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $party->forceDelete();
        toastr()->success(__('global.party').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.parties.trashed');
    }

}
