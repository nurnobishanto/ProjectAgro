<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Asset;
use App\Models\BalanceTransfer;
use App\Models\BulkCattleSale;
use App\Models\Cattle;
use App\Models\CattleSale;
use App\Models\Expense;
use App\Models\MilkSale;
use App\Models\OpeningBalance;
use App\Models\PartyReceive;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Sale;
use App\Models\SlaughterSale;
use App\Models\StaffPayment;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AccountReportController extends Controller
{
    public function income_expenditure_report(Request $request){
        App::setLocale(session('locale'));
        $data = array();
        $data['filter'] = 0;
        if ($request->from_date && $request->to_date){
            $data['filter'] = 1;
            $data['from_date'] = $request->from_date;
            $data['to_date'] = $request->to_date;

            $milkSaleData = MilkSale::select('date', 'total as milk_sale_amount')
                ->whereBetween('date', [$request->from_date, $request->to_date])
                ->orderBy('date', 'asc')->where('status','success')
                ->get();
            $cattleSaleData = CattleSale::select('date', 'amount as cattle_sale_amount')
                ->whereBetween('date', [$request->from_date, $request->to_date])
                ->orderBy('date', 'asc')->where('status','success')
                ->get();
            $bulkCattleSaleData = BulkCattleSale::select('date', 'amount as bulk_cattle_sale_amount')
                ->whereBetween('date', [$request->from_date, $request->to_date])
                ->orderBy('date', 'asc')->where('status','success')
                ->get();

            $slaughterSaleData = SlaughterSale::select('date', 'grand_total as slaughter_sale_amount')
                ->whereBetween('date', [$request->from_date, $request->to_date])
                ->orderBy('date', 'asc')->where('status','success')
                ->get();


            $cattleData = Cattle::select('purchase_date as date', 'purchase_price as amount' ,'category')
                ->whereBetween('purchase_date', [$request->from_date, $request->to_date])
                ->orderBy('date', 'asc')
                ->get();


            $expenseData = Expense::select('date', 'amount','expense_category_id')
                ->with('expense_category')
                ->whereBetween('date', [$request->from_date, $request->to_date])
                ->orderBy('date', 'asc')->where('status','success')
                ->get();

            $staffPaymentData = StaffPayment::select('date','amount','staff_id')
                ->with('staff')
                ->whereBetween('date', [$request->from_date, $request->to_date])
                ->orderBy('date', 'asc')->where('status','=','success')
                ->get();
            $purchaseProductData = Purchase::select(
                'purchase_date as date',
                DB::raw('paid + due as amount') // Calculate the sum of 'paid' and 'due'
            )
                ->with('purchaseProducts')
                ->whereBetween('purchase_date', [$request->from_date, $request->to_date])
                ->where('status', '=', 'success')
                ->orderBy('purchase_date', 'asc')
                ->get();
            $saleProductData = Sale::select(
                'sale_date as date',
                DB::raw('paid + due as amount') // Calculate the sum of 'paid' and 'due'
            )
                ->with('purchaseProducts')
                ->whereBetween('sale_date', [$request->from_date, $request->to_date])
                ->where('status', '=', 'success')
                ->orderBy('sale_date', 'asc')
                ->get();





            // Merge all three collections and sort them by date
            $data['merged_sale'] = collect()
                ->merge($milkSaleData)
                ->merge($cattleSaleData)
                ->merge($slaughterSaleData)
                ->merge($bulkCattleSaleData)
                ->merge($saleProductData)
                ->sortBy('date')
                ->values()
                ->all();

            $data['merged_expenses'] = collect()
                ->merge($staffPaymentData)
                ->merge($expenseData)
                ->merge($purchaseProductData)
                ->merge($cattleData)
                ->sortBy('date')
                ->values()
                ->all();


            $data['total_income'] = $milkSaleData->sum('milk_sale_amount') + $cattleSaleData->sum('cattle_sale_amount') + $bulkCattleSaleData->sum('bulk_cattle_sale_amount')+ $slaughterSaleData->sum('slaughter_sale_amount');
            $data['total_expense'] = $staffPaymentData->sum('amount') + $expenseData->sum('amount') + $purchaseProductData->sum('amount') +$cattleData->sum('amount');


        }

        return view('report.account.income_expenditure_report',$data);


    }
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
