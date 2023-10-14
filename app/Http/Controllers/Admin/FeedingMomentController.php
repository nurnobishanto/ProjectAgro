<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedingMoment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class FeedingMomentController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $feeding_moments = FeedingMoment::orderBy('id','DESC')->get();
        return view('admin.feeding_moments.index',compact('feeding_moments'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $feeding_moments = FeedingMoment::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.feeding_moments.trashed',compact('feeding_moments'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.feeding_moments.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required|unique:feeding_moments',
            'status' => 'required',
        ]);
        $feeding_moment = FeedingMoment::create([
            'name' =>$request->name,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success($feeding_moment->name.__('global.created_success'),__('global.feeding_moment').__('global.created'));
        return redirect()->route('admin.feeding-moments.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_moment = FeedingMoment::find($id);

        return view('admin.feeding_moments.show',compact('feeding_moment'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_moment = FeedingMoment::find($id);
        return view('admin.feeding_moments.edit',compact(['feeding_moment']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $feeding_moment = FeedingMoment::find($id);
        $request->validate([
            'name' => 'required|unique:feeding_moments',
            'status' => 'required',
        ]);
        $feeding_moment->name = $request->name;
        $feeding_moment->status = $request->status;
        $feeding_moment->updated_by = auth()->user()->id;
        $feeding_moment->update();
        toastr()->success($feeding_moment->name.__('global.updated_success'),__('global.feeding_moment').__('global.updated'));
        return redirect()->route('admin.feeding-moments.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_moment = FeedingMoment::find($id);
        $feeding_moment->delete();
        toastr()->warning($feeding_moment->name.__('global.deleted_success'),__('global.feeding_moment').__('global.deleted'));
        return redirect()->route('admin.feeding-moments.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $feeding_moment = FeedingMoment::withTrashed()->find($id);
        $feeding_moment->deleted_at = null;
        $feeding_moment->update();
        toastr()->success($feeding_moment->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.feeding-moments.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $feeding_moment = FeedingMoment::withTrashed()->find($id);
        $feeding_moment->forceDelete();
        toastr()->error(__('global.feeding_moment').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.feeding-moments.trashed');
    }

}
