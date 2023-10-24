<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cattle;
use App\Models\Farm;
use App\Models\Party;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index(){
        App::setLocale(session('locale'));
        $data = array();
        $data['all_cattle_count'] = Cattle::all();
        $data['accounts'] = Account::all();
        $data['parties'] = Party::all();
        $data['suppliers'] = Supplier::all();
        $data['farms'] = Farm::all();

        return view('admin.dashboard',$data);
    }
}
