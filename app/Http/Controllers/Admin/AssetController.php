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
            'status' => 'required',
        ]);
        $asset = Asset::create([
            'name' =>$request->name,
            'amount' =>$request->amount,
            'status' =>$request->status,
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
            'status' => 'required',
        ]);
        $asset->name = $request->name;
        $asset->amount = $request->amount;
        $asset->status = $request->status;
        $asset->updated_by = auth()->user()->id;
        $asset->update();
        toastr()->success($asset->name.__('global.updated_success'),__('global.asset').__('global.updated'));
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
