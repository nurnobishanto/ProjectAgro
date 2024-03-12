<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


class StaffPaymentController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $staff_payments = StaffPayment::orderBy('id','DESC')->get();
        return view('admin.staff_payments.index',compact('staff_payments'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $staff_payments = StaffPayment::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.staff_payments.trashed',compact('staff_payments'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.staff-payments.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $staff = Staff::find($request->staff_id);
        $today = date('d/m/Y',strtotime(now()));
        return view('admin.staff_payments.create',compact(['staff','today']));
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'staff_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        $date = date('y-m-d',strtotime($request->date));
        $canPay = true;
        $staff =  Staff::find($request->staff_id);
        $paymentType = $staff->pay_type;
        if ($paymentType === 'daily') {
            // Check if a daily payment has already been made today
            $dailyPayment = StaffPayment::where('staff_id', $staff->id)
                ->where('pay_type', 'daily')
                ->where('date', $date)
                ->first();

            if ($dailyPayment->amount >= $staff->salary) {
                $canPay =  false;
            }
        }elseif ($paymentType === 'monthly') {
            // Check if a payment has already been made this month
            $startOfMonth = Carbon::parse($date)->startOfMonth();
            $endOfMonth = Carbon::parse($date)->endOfMonth();

            $monthlyPayment = StaffPayment::where('staff_id', $staff->id)
                ->where('pay_type', 'monthly')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->get();

            if ($monthlyPayment->sum('amount') >= $staff->salary) {
                $canPay = false;
            }
        }elseif ($paymentType === 'yearly') {
            // Check if a payment has already been made this year
            $startOfYear = Carbon::parse($date)->startOfYear();
            $endOfYear = Carbon::parse($date)->endOfYear();

            $yearlyPayment = StaffPayment::where('staff_id', $staff->id)
                ->where('pay_type', 'yearly')
                ->whereBetween('date', [$startOfYear, $endOfYear])
                ->get();

            if ($yearlyPayment->sum('amount') >= $staff->salary) {
                $canPay = false;
            }
        }
        if ($canPay){
            StaffPayment::create([
                'unique_id' => $request->unique_id,
                'date' => $date,
                'staff_id' => $request->staff_id,
                'account_id' => $request->account_id,
                'amount' => $request->amount,
                'pay_type' => $staff->pay_type,
                'note' => $request->note,
                'status' => 'pending',
                'created_by' =>auth()->user()->id,
                'updated_by' =>auth()->user()->id,
            ]);
            toastr()->success(__('global.created_success'),__('global.staff_payment').__('global.created'));
        }else{
            toastr()->error(__('global.'.$paymentType).' '.__('global.payment_limit_reached'));
        }

        return redirect()->route('admin.staff-payments.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $staff_payment = StaffPayment::find($id);
        return view('admin.staff_payments.show',compact('staff_payment'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $staff_payment = StaffPayment::find($id);
        $staff = $staff_payment->staff;
        return view('admin.staff_payments.edit',compact(['staff_payment','staff']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));

        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        $date = date('y-m-d',strtotime($request->date));
        $canPay = true;
        $staff_payment = StaffPayment::find($id);
        $paymentType = $staff_payment->pay_type;
        $staff = Staff::find($staff_payment->staff_id);

        if ($paymentType === 'daily') {
            // Check if a daily payment has already been made today
            $dailyPayment = StaffPayment::where('staff_id', $staff_payment->staff_id)
                ->where('pay_type', 'daily')
                ->where('id', '!=' ,$staff_payment->id)
                ->where('date', $date)
                ->first();
            if ($dailyPayment->amount >= $staff->salary) {
                $canPay =  false;
            }
        }elseif ($paymentType === 'monthly') {
            // Check if a payment has already been made this month
            $startOfMonth = Carbon::parse($date)->startOfMonth();
            $endOfMonth = Carbon::parse($date)->endOfMonth();

            $monthlyPayment = StaffPayment::where('staff_id', $staff_payment->staff_id)
                ->where('pay_type', 'monthly')
                ->where('id', '!=' ,$staff_payment->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->get();

            if ($monthlyPayment->sum('amount') >= $staff->salary) {
                $canPay = false;
            }
        }elseif ($paymentType === 'yearly') {
            // Check if a payment has already been made this year
            $startOfYear = Carbon::parse($date)->startOfYear();
            $endOfYear = Carbon::parse($date)->endOfYear();

            $yearlyPayment = StaffPayment::where('staff_id', $staff_payment->staff_id)
                ->where('pay_type', 'yearly')
                ->where('id', '!=' ,$staff_payment->id)
                ->whereBetween('date', [$startOfYear, $endOfYear])
                ->get();

            if ($yearlyPayment->sum('amount') >= $staff->salary) {
                $canPay = false;
            }
        }
        if ($canPay){
            $staff_payment->date = $date;
            $staff_payment->account_id = $request->account_id;
            $staff_payment->amount = $request->amount;
            $staff_payment->note = $request->note;
            $staff_payment->status = 'pending';
            $staff_payment->updated_by = auth()->user()->id;
            $staff_payment->update();
            toastr()->success($staff_payment->name.__('global.updated_success'),__('global.staff_payment').__('global.updated'));
        }else{
            toastr()->error(__('global.'.$paymentType).' '.__('global.payment_limit_reached'));
        }


        return redirect()->route('admin.staff-payments.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $staff_payment = StaffPayment::find($id);
        $staff_payment->delete();
        toastr()->warning($staff_payment->name.__('global.deleted_success'),__('global.staff_payment').__('global.deleted'));
        return redirect()->route('admin.staff-payments.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $staff_payment = StaffPayment::withTrashed()->find($id);
        $staff_payment->deleted_at = null;
        $staff_payment->update();
        toastr()->success($staff_payment->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.staff-payments.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $staff_payment = StaffPayment::withTrashed()->find($id);
        $staff_payment->forceDelete();
        toastr()->error(__('global.staff_payment').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.staff-payments.trashed');
    }

    public function approve ($id){
        $sp = StaffPayment::find($id);

        if ($sp->status != 'success'){
            $account = $sp->account;
            $account->current_balance = $account->current_balance - $sp->amount;
            $account->update();
            $sp->status = 'success';
            $sp->update();
        }
        toastr()->success($sp->unique_id.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.staff-payments.index');
    }

}
