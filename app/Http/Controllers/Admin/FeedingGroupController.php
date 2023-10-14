<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedingGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class FeedingGroupController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale(session('locale'));

        $feeding_groups = FeedingGroup::orderBy('id','DESC')->get();
        if ($request->farm_id){
            $feeding_groups = $feeding_groups->where('farm_id',$request->farm_id);
        }
        if ($request->cattle_type_id){
            $feeding_groups = $feeding_groups->where('cattle_type_id',$request->cattle_type_id);
        }
        if ($request->feeding_category_id){
            $feeding_groups = $feeding_groups->where('feeding_category_id',$request->feeding_category_id);
        }
        if ($request->feeding_moment_id){
            $feeding_groups = $feeding_groups->where('feeding_moment_id',$request->feeding_moment_id);
        }
        return view('admin.feeding_groups.index',compact('feeding_groups'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $feeding_groups = FeedingGroup::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.feeding_groups.trashed',compact('feeding_groups'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.feeding_groups.create');
    }

    public function store(Request $request)
    {

        App::setLocale(session('locale'));
        $request->validate([
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
            'feeding_category_id' => 'required',
            'feeding_moment_id' => 'required',
            'status' => 'required',
        ]);
        $feeding_group = FeedingGroup::where('farm_id',$request->farm_id)
            ->where('cattle_type_id',$request->cattle_type_id)
            ->where('feeding_category_id',$request->feeding_category_id)
            ->where('feeding_moment_id',$request->feeding_moment_id)->first();

            if (!$feeding_group){
                $feeding_group=  FeedingGroup::create([
                    'farm_id' =>$request->farm_id,
                    'cattle_type_id' =>$request->cattle_type_id,
                    'feeding_category_id' =>$request->feeding_category_id,
                    'feeding_moment_id' =>$request->feeding_moment_id,
                    'status' =>$request->status,
                    'created_by' =>auth()->user()->id,
                    'updated_by' =>auth()->user()->id,
                ]);
                $feeding_group->products()->sync($request->items);
                toastr()->success(__('global.created_success'),__('global.feeding_group').__('global.created'));
            }
        return redirect()->route('admin.feeding-groups.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_group = FeedingGroup::find($id);

        return view('admin.feeding_groups.show',compact('feeding_group'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_group = FeedingGroup::find($id);
        return view('admin.feeding_groups.edit',compact(['feeding_group']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $feeding_group = FeedingGroup::find($id);
        $request->validate([
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
            'feeding_category_id' => 'required',
            'feeding_moment_id' => 'required',
            'status' => 'required',
        ]);
        $feeding_group->farm_id = $request->farm_id;
        $feeding_group->cattle_type_id = $request->cattle_type_id;
        $feeding_group->feeding_category_id = $request->feeding_category_id;
        $feeding_group->feeding_moment_id = $request->feeding_moment_id;
        $feeding_group->status = $request->status;
        $feeding_group->updated_by = auth()->user()->id;
        $feeding_group->update();
        $feeding_group->products()->sync($request->items);
        toastr()->success(__('global.updated_success'),__('global.feeding_group').__('global.updated'));
        return redirect()->route('admin.feeding-groups.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $feeding_group = FeedingGroup::find($id);
        $feeding_group->delete();
        toastr()->warning($feeding_group->name.__('global.deleted_success'),__('global.feeding_group').__('global.deleted'));
        return redirect()->route('admin.feeding-groups.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $feeding_group = FeedingGroup::withTrashed()->find($id);
        $feeding_group->deleted_at = null;
        $feeding_group->update();
        toastr()->success($feeding_group->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.feeding-groups.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $feeding_group = FeedingGroup::withTrashed()->find($id);
        $feeding_group->products()->detach();
        $feeding_group->forceDelete();
        toastr()->error(__('global.feeding_group').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.feeding-groups.trashed');
    }

}
