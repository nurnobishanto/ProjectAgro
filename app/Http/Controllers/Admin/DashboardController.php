<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index(){
        App::setLocale(session('locale'));
        $data = array();
        return view('admin.dashboard',$data);
    }
}
