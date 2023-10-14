<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class FeedingCategoryController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $feeding_categories = FeedingCategory::orderBy('id','DESC')->get();
        return view('admin.feeding_categories.index',compact('feeding_categories'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $feeding_categories = FeedingCategory::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.feeding_categories.trashed',compact('feeding_categories'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.feeding_categories.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required|unique:feeding_categories',
            'status' => 'required',
        ]);
        $feeding_category = FeedingCategory::create([
            'name' =>$request->name,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success($feeding_category->name.__('global.created_success'),__('global.feeding_category').__('global.created'));
        return redirect()->route('admin.feeding-categories.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_category = FeedingCategory::find($id);

        return view('admin.feeding_categories.show',compact('feeding_category'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_category = FeedingCategory::find($id);
        return view('admin.feeding_categories.edit',compact(['feeding_category']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $feeding_category = FeedingCategory::find($id);
        $request->validate([
            'name' => 'required|unique:feeding_categories',
            'status' => 'required',
        ]);
        $feeding_category->name = $request->name;
        $feeding_category->status = $request->status;
        $feeding_category->updated_by = auth()->user()->id;
        $feeding_category->update();
        toastr()->success($feeding_category->name.__('global.updated_success'),__('global.feeding_category').__('global.updated'));
        return redirect()->route('admin.feeding-categories.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_category = FeedingCategory::find($id);
        $feeding_category->delete();
        toastr()->warning($feeding_category->name.__('global.deleted_success'),__('global.feeding_category').__('global.deleted'));
        return redirect()->route('admin.feeding-categories.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $feeding_category = FeedingCategory::withTrashed()->find($id);
        $feeding_category->deleted_at = null;
        $feeding_category->update();
        toastr()->success($feeding_category->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.feeding-categories.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $feeding_category = FeedingCategory::withTrashed()->find($id);
        $feeding_category->forceDelete();
        toastr()->error(__('global.feeding_category').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.feeding-categories.trashed');
    }

}
