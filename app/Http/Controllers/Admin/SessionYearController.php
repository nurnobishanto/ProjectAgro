<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class SessionYearController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $session_years = SessionYear::orderBy('id','DESC')->get();
        return view('admin.session_years.index',compact('session_years'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $session_years = SessionYear::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.session_years.trashed',compact('session_years'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.session_years.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'year' => 'required|unique:session_years',
            'status' => 'required',
        ]);
        $session_year = SessionYear::create([
            'year' =>$request->year,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
        ]);
        toastr()->success($session_year->year.__('global.created_success'),__('global.session_year').__('global.created'));
        return redirect()->route('admin.session-years.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $session_year = SessionYear::find($id);
        return view('admin.session_years.show',compact('session_year'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $session_year = SessionYear::find($id);
        return view('admin.session_years.edit',compact(['session_year']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $session_year = SessionYear::find($id);
        $request->validate([
            'year' => 'required|unique:session_years,id,'.$id,
            'status' => 'required',
        ]);
        $session_year->year = $request->year;
        $session_year->status = $request->status;
        $session_year->update();
        toastr()->success($session_year->year.__('global.updated_success'),__('global.session_year').__('global.updated'));
        return redirect()->route('admin.session-years.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $session_year = SessionYear::find($id);
        $session_year->delete();
        toastr()->warning($session_year->name.__('global.deleted_success'),__('global.session_year').__('global.deleted'));
        return redirect()->route('admin.session-years.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $session_year = SessionYear::withTrashed()->find($id);
        $session_year->deleted_at = null;
        $session_year->update();
        toastr()->success($session_year->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.session-years.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $session_year = SessionYear::withTrashed()->find($id);
        $old_image_path = "uploads/".$session_year->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $session_year->forceDelete();
        toastr()->error(__('global.session_year').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.session-years.trashed');
    }

}
