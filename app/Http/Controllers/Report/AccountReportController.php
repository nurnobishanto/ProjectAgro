<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Asset;
use App\Models\BalanceTransfer;
use App\Models\Expense;
use App\Models\OpeningBalance;
use App\Models\PartyReceive;
use App\Models\StaffPayment;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AccountReportController extends Controller
{
    public function assets(){
        App::setLocale(session('locale'));
        $data = array();
        $data['assets'] = Asset::where('status','success')->get();
        return view('report.account.assets',$data);
    }
    public function accounts(){
        App::setLocale(session('locale'));
        $data = array();
        $data['accounts'] = Account::where('status','success')->get();
        return view('report.account.accounts',$data);
    }
    public function opening_balances(){
        App::setLocale(session('locale'));
        $data = array();
        $data['opening_balances'] = OpeningBalance::where('status','success')->get();
        return view('report.account.opening_balances',$data);
    }
    public function balance_transfers(){
        App::setLocale(session('locale'));
        $data = array();
        $data['balance_transfers'] = BalanceTransfer::where('status','success')->get();
        return view('report.account.balance_transfers',$data);
    }
    public function expenses(){
        App::setLocale(session('locale'));
        $data = array();
        $data['expenses'] = Expense::where('status','success')->get();
        return view('report.account.expenses',$data);
    }
    public function staff_salary(){
        App::setLocale(session('locale'));
        $data = array();
        $data['staff_payments'] = StaffPayment::where('status','success')->get();
        return view('report.account.staff_salary',$data);
    }
    public function party_receive(){
        App::setLocale(session('locale'));
        $data = array();
        $data['party_receives'] = PartyReceive::where('status','success')->get();
        return view('report.account.party_receive',$data);
    }
    public function supplier_payment(){
        App::setLocale(session('locale'));
        $data = array();
        $data['supplier_payments'] = SupplierPayment::where('status','success')->get();
        return view('report.account.supplier_payment',$data);
    }
}
