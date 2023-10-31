<?php

namespace App\Http\Controllers;

use App\Models\Breeds;
use App\Models\Cattle;
use App\Models\CattleType;
use App\Models\Farm;
use App\Models\FeedingGroup;
use App\Models\Product;
use App\Models\Staff;
use Illuminate\Http\Request;

class AjaxCartController extends Controller
{
    public function farms(){
        $data =  Farm::all();
        return response()->json($data);
    }

    public function cattle_types(){
        $data =  CattleType::all();
        return response()->json($data);
    }
    public function farm_cattle_list(Request $request){
        $farm_id = $request->input('farm_id');
        $cattle_type_id = $request->input('cattle_type_id');
        $data =  Cattle::where('cattle_type_id',$cattle_type_id)->where('farm_id',$farm_id)->where('status','active')->get();
        return response()->json($data);
    }
    public function farm_medicine_list(Request $request){
        $farm_id = $request->input('farm_id');
        $products =  Product::where('type','cattle_medicine')->get();
        $data = [];
        foreach ($products as $product){
            $data[] = [
                'id' => $product->id,
                'name' => $product->name. ' ('.(getStock($farm_id, $product->id)->quantity ?? 0).' X '.$product->unit->code.' )'
            ];
        }
        return response()->json($data);
    }
    public function farm_staff_list(Request $request){
        $farm_id = $request->input('farm_id');
        $staff_list =  Staff::where('farm_id',$farm_id)->get();
        $data = [];
        foreach ($staff_list as $staff){
            $data[] = [
                'id' => $staff->id,
                'name' => $staff->name.' ('.__('global.'.$staff->pay_type).')',
            ];
        }
        return response()->json($data);
    }
    public function farm_dewormer_list(Request $request){
        $farm_id = $request->input('farm_id');
        $products =  Product::where('type','dewormer_medicine')->get();
        $data = [];
        foreach ($products as $product){
            $data[] = [
                'id' => $product->id,
                'name' => $product->name. ' ('.(getStock($farm_id, $product->id)->quantity ?? 0).' X '.$product->unit->code.' )'
            ];
        }

        return response()->json($data);
    }
    public function farm_vaccine_list(Request $request){
        $farm_id = $request->input('farm_id');
        $products =  Product::where('type','vaccination')->get();
        $data = [];
        foreach ($products as $product){
            $data[] = [
                'id' => $product->id,
                'name' => $product->name. ' ('.(getStock($farm_id, $product->id)->quantity ?? 0).' X '.$product->unit->code.' )'
            ];
        }

        return response()->json($data);
    }
    public function cattle_type(Request $request){
        $cattle_type_id = $request->input('cattle_type_id');
        $data = CattleType::find($cattle_type_id);
        return response()->json($data->breeds);

    }
    public function cattle_breed(Request $request){
        $breed_id = $request->input('breed_id');
        $data = Breeds::find($breed_id);
        return response()->json($data->cattles);

    }
    public function category(Request $request){
        $gender = $request->input('gender');
        // Define categories for male and female
        $maleCategories = [
            'sheep'=>__('global.sheep'),
            'bull'=>__('global.bull'),
            ];
        $femaleCategories = [
            'calf' => __('global.calf'),
            'dairy' => __('global.dairy'),
            'dry' => __('global.dry'),
            'pregnant' => __('global.pregnant'),
            ];

        // Determine the categories based on the gender
        $selectedCategories = ($gender === 'male') ? $maleCategories : $femaleCategories;

        return response()->json($selectedCategories);
    }

    public function get_feeding_farms(){
        $feeding_groups =  FeedingGroup::select('farm_id')->distinct('farm_id')->get();
        $farms = [];
        foreach ($feeding_groups as $feeding_group){
            $farms[] = [
                'farm_id' => $feeding_group->farm_id,
                'name' => $feeding_group->farm->name,
            ];
        }
        return response()->json($farms);
    }
    public function get_feeding_farms_cattle_types(Request $request){

        $farm_id = $request->input('farm_id');
        $feeding_groups =  FeedingGroup::select('farm_id','cattle_type_id')->where('farm_id',$farm_id)->distinct('cattle_type_id')->get();
        $cattle_types= [];
        foreach ($feeding_groups as $feeding_group){
            $cattle_types[] = [
                'cattle_type_id' => $feeding_group->cattle_type_id,
                'name' => $feeding_group->cattle_type->title,
            ];
        }
        return response()->json($cattle_types);
    }
    public function get_feeding_group_period(Request $request){
        $farm_id = $request->input('farm_id');
        $cattle_type_id = $request->input('cattle_type_id');
        $feeding_groups =  FeedingGroup::where('farm_id',$farm_id)->where('cattle_type_id',$cattle_type_id)->distinct('cattle_type_id')->get();
        $groups= [];
        foreach ($feeding_groups as $feeding_group){
            $groups[] = [
                'id' => $feeding_group->id,
                'name' => $feeding_group->feeding_category->name.' - '.$feeding_group->feeding_moment->name,
            ];
        }
        return response()->json($groups);
    }
}
