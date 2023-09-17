<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BatchController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $batches = Batch::orderBy('id','DESC')->get();
        return view('admin.batches.index',compact('batches'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $batches = Batch::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.batches.trashed',compact('batches'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.batches.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required|unique:batches',
            'status' => 'required',
        ]);
        $batch = Batch::create([
            'name' =>$request->name,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
        ]);
        toastr()->success($batch->name.__('global.created_success'),__('global.batch').__('global.created'));
        return redirect()->route('admin.batches.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $batch = Batch::find($id);
        return view('admin.batches.show',compact('batch'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $batch = Batch::find($id);
        return view('admin.batches.edit',compact(['batch']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $batch = Batch::find($id);
        $request->validate([
            'name' => 'required|unique:batches,id,'.$id,
            'status' => 'required',
        ]);
        $batch->name = $request->name;
        $batch->status = $request->status;
        $batch->update();
        toastr()->success($batch->name.__('global.updated_success'),__('global.batch').__('global.updated'));
        return redirect()->route('admin.batches.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $batch = Batch::find($id);
        $batch->delete();
        toastr()->warning($batch->name.__('global.deleted_success'),__('global.batch').__('global.deleted'));
        return redirect()->route('admin.batches.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $batch = Batch::withTrashed()->find($id);
        $batch->deleted_at = null;
        $batch->update();
        toastr()->success($batch->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.batches.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $batch = Batch::withTrashed()->find($id);
        $old_image_path = "uploads/".$batch->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $batch->forceDelete();
        toastr()->error(__('global.batch').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.batches.trashed');
    }

}
