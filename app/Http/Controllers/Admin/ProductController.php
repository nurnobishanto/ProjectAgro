<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class ProductController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $products = Product::orderBy('id','DESC')->get();
        return view('admin.products.index',compact('products'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $products = Product::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.products.trashed',compact('products'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $units =  Unit::all();
        return view('admin.products.create',compact(['units']));
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products',
            'type' => 'required',
            'unit_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'status' => 'required',
        ]);
        $imageFile = null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('product-image');
        }
        $product = Product::create([
            'name' =>$request->name,
            'code' =>$request->code,
            'type' =>$request->type,
            'unit_id' =>$request->unit_id,
            'purchase_price' =>$request->purchase_price??0,
            'sale_price' =>$request->sale_price??0,
            'alert_quantity' =>$request->alert_quantity??0,
            'image' =>$imageFile,
            'description' =>$request->description,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
        ]);
        toastr()->success($product->name.__('global.created_success'),__('global.product').__('global.created'));
        return redirect()->route('admin.products.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $product = Product::find($id);
        return view('admin.products.show',compact('product'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $product = Product::find($id);
        $units =  Unit::all();
        return view('admin.products.edit',compact(['units','product']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));

        $product = Product::find($id);
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'type' => 'required',
            'unit_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'status' => 'required',
        ]);
        $imageFile = $product->image??null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('product-image');
            $old_image_path = "uploads/".$request->image_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $product->name = $request->name;
        $product->code = $request->code;
        $product->type = $request->type;
        $product->unit_id = $request->unit_id;
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->description = $request->description;
        $product->image = $imageFile;
        $product->status = $request->status;
        $product->update();
        toastr()->success($product->name.__('global.updated_success'),__('global.product').__('global.updated'));
        return redirect()->route('admin.products.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $product = Product::find($id);
        $product->delete();
        toastr()->warning($product->name.__('global.deleted_success'),__('global.product').__('global.deleted'));
        return redirect()->route('admin.products.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $product = Product::withTrashed()->find($id);
        $product->deleted_at = null;
        $product->update();
        toastr()->success($product->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.products.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $product = Product::withTrashed()->find($id);
        $old_image_path = "uploads/".$product->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $product->forceDelete();
        toastr()->error(__('global.product').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.products.trashed');
    }

}
