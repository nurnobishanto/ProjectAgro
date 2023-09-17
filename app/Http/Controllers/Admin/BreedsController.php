<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Breeds;
use App\Models\CattleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BreedsController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $breeds = Breeds::orderBy('id','DESC')->get();
        return view('admin.breeds.index',compact('breeds'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $breeds = Breeds::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.breeds.trashed',compact('breeds'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $cattle_types = CattleType::where('status','active')->get();
        return view('admin.breeds.create',compact('cattle_types'));
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'cattle_type_id' => 'required',
            'status' => 'required',
        ]);
        $breed = Breeds::create([
            'name' =>$request->name,
            'cattle_type_id' =>$request->cattle_type_id,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
        ]);
        toastr()->success($breed->name.__('global.created_success'),__('global.breed').__('global.created'));
        return redirect()->route('admin.breeds.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $breed = Breeds::find($id);

        return view('admin.breeds.show',compact('breed'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $breed = Breeds::find($id);
        $cattle_types = CattleType::where('status','active')->get();
        return view('admin.breeds.edit',compact(['breed','cattle_types']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $breed = Breeds::find($id);
        $request->validate([
            'name' => 'required',
            'cattle_type_id' => 'required',
            'status' => 'required',
        ]);
        $breed->name = $request->name;
        $breed->cattle_type_id = $request->cattle_type_id;
        $breed->status = $request->status;
        $breed->update();
        toastr()->success($breed->name.__('global.updated_success'),__('global.breed').__('global.updated'));
        return redirect()->route('admin.breeds.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $breed = Breeds::find($id);
        $breed->delete();
        toastr()->warning($breed->name.__('global.deleted_success'),__('global.breed').__('global.deleted'));
        return redirect()->route('admin.breeds.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $breed = Breeds::withTrashed()->find($id);
        $breed->deleted_at = null;
        $breed->update();
        toastr()->success($breed->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.breeds.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $breed = Breeds::withTrashed()->find($id);
        $old_image_path = "uploads/".$breed->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $breed->forceDelete();
        toastr()->error(__('global.breed').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.breeds.trashed');
    }

}
