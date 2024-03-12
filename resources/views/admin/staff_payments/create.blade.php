@extends('adminlte::page')

@section('title', __('global.create_staff_payment'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_staff_payment')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.staff-payments.index')}}">{{ __('global.staff_payments')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_staff_payment')}}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @can('staff_payment_create')
                <div class="card-body">
                    <form action="{{route('admin.staff-payments.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @csrf
                        @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <input class="d-none" value="{{$staff->id}}" name="staff_id">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200px">{{__('global.farm')}}</th>
                                <td>{{$staff->farm->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.staff_name')}}</th>
                                <td>{{$staff->name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.pay_type')}}</th>
                                <td>{{__('global.'.$staff->pay_type)}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.salary')}}</th>
                                <td>{{getSetting('currency')}} {{$staff->salary}} </td>
                            </tr>
                            <tr>
                                <th>{{__('global.joining_date')}}</th>
                                <td>{{$staff->joining_date}} </td>
                            </tr>
                        </table>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger"> *</span></label>
                                    <input name="unique_id" readonly value="{{generateInvoiceId('STP',\App\Models\StaffPayment::class,'unique_id')}}" id="unique_id"  type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                    <input name="date" value="{{$today}}" readonly id="date"  type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="account_id">{{__('global.select_account')}}<span class="text-danger"> *</span></label>
                                    <select name="account_id" class=" form-control" id="account_id">
                                        <option value="">{{__('global.select_account')}}</option>
                                        @foreach(getAccountList() as $account)
                                            <option value="{{$account->id}}">{{$account->account_name}} ({{$account->account_no}}) {{$account->admin->name??'--'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="amount">{{ __('global.amount')}}<span class="text-danger"> *</span></label>
                                    <input min="1" id="amount" name="amount" type="number" step="any" class="form-control" placeholder="{{ __('global.enter_amount')}}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea id="note" name="note" class="form-control">{{old('note')}}</textarea>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-success" type="submit">{{ __('global.create')}}</button>
                    </form>
                </div>
                @endcan
                <div class="card-footer table-responsive">
                    <caption class="caption-top">Latest 10 Salary</caption>
                    <table id="paymentList" class="table table-bordered ">
                        <thead>
                        <tr>
                            <th>{{__('global.sl')}}</th>
                            <th>{{__('global.unique_id')}}</th>
                            <th>{{__('global.date')}}</th>
                            <th>{{__('global.amount')}}</th>
                            <th>{{__('global.account')}}</th>
                            <th>{{__('global.status')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $psl = 1; @endphp
                        @foreach($staff->staff_payments()->orderBy('created_at', 'desc')->get() as $payment)
                        <tr>
                            <td>{{$psl++}}</td>
                            <td>{{$payment->unique_id}}</td>
                            <td>{{$payment->date}}</td>
                            <td>{{$payment->amount}}</td>
                            <td>{{$payment->account->bank_name??'-'}} ({{$payment->account->account_name??'-'}})</td>
                            <td>{{__('global.'.$payment->status)}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{__('global.sl')}}</th>
                            <th>{{__('global.unique_id')}}</th>
                            <th>{{__('global.date')}}</th>
                            <th>{{__('global.amount')}}</th>
                            <th>{{__('global.account')}}</th>
                            <th>{{__('global.status')}}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <strong>{{__('global.developed_by')}} <a href="https://soft-itbd.com">{{__('global.soft_itbd')}}</a>.</strong>
    {{__('global.all_rights_reserved')}}.
    <div class="float-right d-none d-sm-inline-block">
        <b>{{__('global.version')}}</b> {{env('DEV_VERSION')}}
    </div>
@stop
@section('plugins.toastr',true)
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
@section('plugins.Select2',true)
@section('css')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: black;
    }
</style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('select').select2({
                theme:'classic',
            });
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                viewMode: "days",
                minViewMode: "days",
                autoclose: true
            });
            $("#paymentList").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: true,
                ordering: false,
                info: true,
                paging: true,
                buttons: [
                    {
                        extend: 'copy',
                        text: '{{ __('global.copy') }}',
                    },
                    {
                        extend: 'csv',
                        text: '{{ __('global.export_csv') }}',
                    },
                    {
                        extend: 'excel',
                        text: '{{ __('global.export_excel') }}',
                    },
                    {
                        extend: 'pdf',
                        text: '{{ __('global.export_pdf') }}',
                    },
                    {
                        extend: 'print',
                        text: '{{ __('global.print') }}',
                    },
                    {
                        extend: 'colvis',
                        text: '{{ __('global.colvis') }}',
                    }
                ],
                pagingType: 'full_numbers',
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    paginate: {
                        first: "{{ __('global.first') }}",
                        previous: "{{ __('global.previous') }}",
                        next: "{{ __('global.next') }}",
                        last: "{{ __('global.last') }}",
                    }
                }
            });
        });
    </script>
@stop
