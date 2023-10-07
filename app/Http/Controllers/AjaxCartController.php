<?php

namespace App\Http\Controllers;

use App\Models\CattleType;
use Illuminate\Http\Request;

class AjaxCartController extends Controller
{
    public function cattle_types(){
        $data =  CattleType::all();
        return response()->json($data);
    }
    public function cattle_type(Request $request){
        $cattle_type_id = $request->input('cattle_type_id');
        $data = CattleType::find($cattle_type_id);
        return response()->json($data->breeds);

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
}
