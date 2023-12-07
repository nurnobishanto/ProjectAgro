<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Breeds;
use App\Models\Cattle;
use App\Models\CattleStructure;
use App\Models\CattleType;
use App\Models\Farm;
use App\Models\SessionYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CattleController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $cattles = Cattle::orderBy('id','DESC')->get();
        return view('admin.cattles.index',compact('cattles'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $cattles = Cattle::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.cattles.trashed',compact('cattles'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $data = array();
        $data['session_years'] = SessionYear::where('status','active')->get();
        $data['farms'] = Farm::where('status','active')->get();
        $data['batches'] = Batch::where('status','active')->get();
        $data['cattle_types'] = CattleType::where('status','active')->get();
        $data['breeds'] = Breeds::where('status','active')->get();
        $data['mother_cattle'] = Cattle::where('status','active')->where('gender','female')->get();
        return view('admin.cattles.create',$data);
    }


    public function store(Request $request)
    {

        App::setLocale(session('locale'));
        $request->validate([
            'session_year_id' => 'required',
            'farm_id' => 'required',
            'tag_id' => 'required|unique:cattle',
            'entry_date' => 'required',
            'shade_no' => 'required',
            'is_purchase' => 'required',
            'purchase_date' => 'required',
            'dob' => 'required',
            'batch_id' => 'required',
            'cattle_type_id' => 'required',
            'breed_id' => 'required',
            'gender' => 'required',
            'category' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ]);
        if ($request->is_purchase == 1){
            $request->validate([
                'supplier_id' => 'required',
            ]);
        }

        $imagePath = null;
        if($request->file('image')){
            $imagePath = $request->file('image')->store('cattle-image');
        }
        // Handle gallery images upload
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('cattle-gallery');
            }
        }
        $cattle = Cattle::create([
            'session_year_id' => $request->session_year_id,
            'farm_id' => $request->farm_id,
            'tag_id' => $request->tag_id,
            'entry_date' => $request->entry_date,
            'shade_no' => $request->shade_no,
            'is_purchase' => $request->is_purchase,
            'purchase_price' => $request->purchase_price??0,
            'purchase_date' => $request->purchase_date,
            'dob' => $request->dob,
            'batch_id' => $request->batch_id,
            'cattle_type_id' => $request->cattle_type_id,
            'breed_id' => $request->breed_id,
            'gender' => $request->gender,
            'category' => $request->category,
            'status' =>$request->status,
            'parent_id' =>$request->parent_id,
            'dairy_date' =>$request->dairy_date,
            'last_dairy_date' =>$request->last_dairy_date,
            'total_child' =>$request->total_child,
            'pregnant_date' =>$request->pregnant_date,
            'pregnant_no' =>$request->pregnant_no,
            'delivery_date' =>$request->delivery_date,
            'problem' =>$request->problem,
            'death_reason' =>$request->death_reason,
            'death_date' =>$request->death_date,
            'sold_date' =>$request->sold_date,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
            'image' => $imagePath,
        ]);
        if ($request->is_purchase == 1){
            $cattle->supplier_id = $request->supplier_id;
            $cattle->update();
        }

        CattleStructure::create([
            'cattle_id' => $cattle->id,
            'date' =>  date('Y-m-d', strtotime(today())),
            'weight' => $request->weight,
            'height' => $request->height,
            'width' => $request->width,
            'health' => $request->health,
            'color' => $request->color,
            'foot' => $request->foot,
            'images' => $galleryPaths,
            'created_by' =>auth()->user()->id,
        ]);
        toastr()->success($cattle->tag_id.__('global.created_success'),__('global.cattle').__('global.created'));
        return redirect()->route('admin.cattles.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $cattle = Cattle::find($id);
        return view('admin.cattles.show',compact('cattle'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $data = array();
        $cattle = Cattle::find($id);
        $data['cattle'] = $cattle;
        $data['session_years'] = SessionYear::where('status','active')->get();
        $data['farms'] = Farm::where('status','active')->get();
        $data['batches'] = Batch::where('status','active')->get();
        $data['cattle_types'] = CattleType::where('status','active')->get();
        $data['breeds'] = Breeds::where('status','active')->where('cattle_type_id',$cattle->cattle_type_id)->get();
        $data['mother_cattle'] = Cattle::where('status','active')->where('gender','female')->get();
        return view('admin.cattles.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $cattle = Cattle::find($id);
        $request->validate([
            'session_year_id' => 'required',
            'farm_id' => 'required',
            'tag_id' => 'required|unique:cattle,id,'.$id,
            'entry_date' => 'required',
            'shade_no' => 'required',
            'is_purchase' => 'required',
            'purchase_date' => 'required',
            'dob' => 'required',
            'batch_id' => 'required',
            'cattle_type_id' => 'required',
            'breed_id' => 'required',
            'gender' => 'required',
            'category' => 'required',
            'status' => 'required',
        ]);
        $cattle->session_year_id = $request->session_year_id;
        $cattle->farm_id = $request->farm_id;
        $cattle->tag_id = $request->tag_id;
        $cattle->entry_date = $request->entry_date;
        $cattle->shade_no = $request->shade_no;
        $cattle->is_purchase = $request->is_purchase;
        $cattle->supplier_id = $request->supplier_id;
        $cattle->purchase_price = $request->purchase_price??0;
        $cattle->purchase_date = $request->purchase_date;
        $cattle->dob = $request->dob;
        $cattle->batch_id = $request->batch_id;
        $cattle->cattle_type_id = $request->cattle_type_id;
        $cattle->breed_id = $request->breed_id;
        $cattle->gender = $request->gender;
        $cattle->category = $request->category;
        $cattle->parent_id = $request->parent_id;
        $cattle->dairy_date = $request->dairy_date;
        $cattle->last_dairy_date = $request->last_dairy_date;
        $cattle->total_child = $request->total_child;
        $cattle->pregnant_date = $request->pregnant_date;
        $cattle->pregnant_no = $request->pregnant_no;
        $cattle->delivery_date = $request->delivery_date;
        $cattle->problem = $request->problem;
        $cattle->death_reason = $request->death_reason;
        $cattle->death_date = $request->death_date;
        $cattle->sold_date = $request->sold_date;
        $cattle->updated_by = auth()->user()->id;

        $cattle->status = $request->status;
        $cattle->update();
        toastr()->success($cattle->title.__('global.updated_success'),__('global.cattle').__('global.updated'));
        return redirect()->route('admin.cattles.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $cattle = Cattle::find($id);
        $cattle->delete();
        toastr()->warning($cattle->name.__('global.deleted_success'),__('global.cattle').__('global.deleted'));
        return redirect()->route('admin.cattles.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $cattle = Cattle::withTrashed()->find($id);
        $cattle->deleted_at = null;
        $cattle->update();
        toastr()->success($cattle->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.cattles.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $cattle = Cattle::withTrashed()->find($id);
        $structures = CattleStructure::where('cattle_id',$cattle->id)->get();
        foreach ($structures as $structure) {
            $imagePaths = $structure->images;
            foreach ($imagePaths as $path) {
                $old_path = "uploads/".$path;
                if (file_exists($old_path)) {
                    @unlink($old_path);
                }
            }
            $structure->delete();
            $structure->forceDelete();
        }
        $old_image_path = "uploads/".$cattle->image;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }

        $cattle->forceDelete();

        toastr()->error(__('global.cattle').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.cattles.trashed');
    }

}
