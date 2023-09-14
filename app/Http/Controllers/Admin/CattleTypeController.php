<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CattleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class CattleTypeController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $cattle_types = CattleType::orderBy('id','DESC')->get();
        return view('admin.cattle_types.index',compact('cattle_types'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $cattle_types = CattleType::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.cattle_types.trashed',compact('cattle_types'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.cattle_types.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $cattle_type = CattleType::create([
            'title' =>$request->title,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
        ]);
        toastr()->success($cattle_type->title.__('global.created_success'),__('global.cattle_type').__('global.created'));
        return redirect()->route('admin.cattle-types.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_type = CattleType::find($id);
        return view('admin.cattle_types.show',compact('cattle_type'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_type = CattleType::find($id);
        return view('admin.cattle_types.edit',compact(['cattle_type']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $cattle_type = CattleType::find($id);
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $cattle_type->title = $request->title;
        $cattle_type->status = $request->status;
        $cattle_type->update();
        toastr()->success($cattle_type->title.__('global.updated_success'),__('global.cattle_type').__('global.updated'));
        return redirect()->route('admin.cattle-types.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_type = CattleType::find($id);
        $cattle_type->delete();
        toastr()->warning($cattle_type->name.__('global.deleted_success'),__('global.cattle_type').__('global.deleted'));
        return redirect()->route('admin.cattle-types.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $cattle_type = CattleType::withTrashed()->find($id);
        $cattle_type->deleted_at = null;
        $cattle_type->update();
        toastr()->success($cattle_type->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.cattle-types.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $cattle_type = CattleType::withTrashed()->find($id);
        $old_image_path = "uploads/".$cattle_type->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $cattle_type->forceDelete();
        toastr()->error(__('global.cattle_type').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.cattle-types.trashed');
    }

}
