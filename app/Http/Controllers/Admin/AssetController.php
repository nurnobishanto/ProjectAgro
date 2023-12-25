<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class AssetController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $assets = Asset::orderBy('id','DESC')->get();
        return view('admin.assets.index',compact('assets'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $assets = Asset::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.assets.trashed',compact('assets'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.assets.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'account_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageFile = null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('asset-image');
        }
        $asset = Asset::create([
            'name' =>$request->name,
            'amount' =>$request->amount,
            'account_id' =>$request->account_id,
            'status' =>'pending',
            'note' =>$request->note,
            'image' =>$imageFile,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success($asset->name.__('global.created_success'),__('global.asset').__('global.created'));
        return redirect()->route('admin.assets.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $asset = Asset::find($id);

        return view('admin.assets.show',compact('asset'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $asset = Asset::find($id);
        return view('admin.assets.edit',compact(['asset']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $asset = Asset::find($id);
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'account_id' => 'required',
        ]);
        $imageFile = $asset->image??null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('asset-image');
            $old_image_path = "uploads/".$asset->image;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $asset->name = $request->name;
        $asset->amount = $request->amount;
        $asset->account_id = $request->account_id;
        $asset->status = 'pending';
        $asset->note = $request->note;
        $asset->image =$imageFile;
        $asset->updated_by = auth()->user()->id;
        $asset->update();
        toastr()->success($asset->name.__('global.updated_success'),__('global.asset').__('global.updated'));
        return redirect()->route('admin.assets.index');
    }

    public function approve($id)
    {
        $asset = Asset::find($id);

        if ($asset && $asset->status == 'pending') {
            $account = $asset->account;

            if ($account) {
                $account->current_balance -= $asset->amount;
                $account->save();

                $asset->status = 'success';
                $asset->save();

                toastr()->success('Asset approved successfully');
            } else {
                toastr()->error('Account not found');
            }
        } else {
            toastr()->error('Asset not found or already approved');
        }

        return redirect()->route('admin.assets.index');
    }


    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $asset = Asset::find($id);
        $asset->delete();
        toastr()->warning($asset->name.__('global.deleted_success'),__('global.asset').__('global.deleted'));
        return redirect()->route('admin.assets.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $asset = Asset::withTrashed()->find($id);
        $asset->deleted_at = null;
        $asset->update();
        toastr()->success($asset->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.assets.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $asset = Asset::withTrashed()->find($id);
        $old_image_path = "uploads/".$asset->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $asset->forceDelete();
        toastr()->error(__('global.asset').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.assets.trashed');
    }

}
