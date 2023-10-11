<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\CattleStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FatteningController extends Controller
{
    public function index(){
        App::setLocale(session('locale'));
        $fattenings = CattleStructure::orderBy('id','DESC')->get();
        return view('admin.fattenings.index',compact('fattenings'));
    }
    public function create(Request $request){
        $request->validate([
            'tag_id'=>'required',
            'breed_id'=>'required',
            'cattle_type_id'=>'required',
        ]);
        App::setLocale(session('locale'));
        $data = array();
        $data['cattle'] = Cattle::where('id',$request->tag_id)->first();
        $data['fattening'] = CattleStructure::where('cattle_id',$request->tag_id)->orderBy('date','desc')->orderBy('id','desc')->first();
        return view('admin.fattenings.create',$data);
    }
    public function store(Request $request){
        $request->validate([

        ]);
        // Handle gallery images upload
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('cattle-gallery');
            }
        }
        CattleStructure::create([
            'cattle_id' => $request->id,
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
        toastr()->success(__('global.created_success'),__('global.information').__('global.created'));
        return redirect()->back();
    }
    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $fattening = CattleStructure::find($id);
        $cattle = Cattle::find($fattening->cattle_id);
        $fattening->delete();
        toastr()->warning($cattle->name.' '.__('global.information').__('global.deleted_success'),__('global.information').__('global.deleted'));
        return redirect()->back();
    }
}
