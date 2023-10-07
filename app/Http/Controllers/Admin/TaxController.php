<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class TaxController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $taxes = Tax::orderBy('id','DESC')->get();
        return view('admin.taxes.index',compact('taxes'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $taxes = Tax::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.taxes.trashed',compact('taxes'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.taxes.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'tax' => 'required',
            'status' => 'required',
        ]);
        $tax = Tax::create([
            'name' =>$request->name,
            'tax' =>$request->tax,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
        ]);
        toastr()->success($tax->name.__('global.created_success'),__('global.tax').__('global.created'));
        return redirect()->route('admin.taxes.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $tax = Tax::find($id);

        return view('admin.taxes.show',compact('tax'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $tax = Tax::find($id);
        return view('admin.taxes.edit',compact(['tax']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $tax = Tax::find($id);
        $request->validate([
            'name' => 'required',
            'tax' => 'required',
            'status' => 'required',
        ]);
        $tax->name = $request->name;
        $tax->tax = $request->tax;
        $tax->status = $request->status;
        $tax->update();
        toastr()->success($tax->name.__('global.updated_success'),__('global.tax').__('global.updated'));
        return redirect()->route('admin.taxes.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $tax = Tax::find($id);
        $tax->delete();
        toastr()->warning($tax->name.__('global.deleted_success'),__('global.tax').__('global.deleted'));
        return redirect()->route('admin.taxes.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $tax = Tax::withTrashed()->find($id);
        $tax->deleted_at = null;
        $tax->update();
        toastr()->success($tax->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.taxes.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $tax = Tax::withTrashed()->find($id);
        $old_image_path = "uploads/".$tax->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $tax->forceDelete();
        toastr()->error(__('global.tax').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.taxes.trashed');
    }

}
