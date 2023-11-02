@extends('adminlte::page')

@section('title', __('global.create_slaughter_customer_receive'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_slaughter_customer_receive')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughter_customer-receives.index')}}">{{ __('global.slaughter_customer_receives')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_slaughter_customer_receive')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.slaughter_customer-receives.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger"> *</span></label>
                                    <input name="unique_id" readonly value="{{generateInvoiceId('SCR',\App\Models\SlaughterCustomer::class,'unique_id')}}" id="unique_id"  type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                    <input name="date" readonly id="date"  type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="slaughter_customer_id">{{__('global.select_slaughter_customer')}}<span class="text-danger"> *</span></label>
                                    <select name="slaughter_customer_id" class=" form-control" id="account_id">
                                        <option value="">{{__('global.select_slaughter_customer')}}</option>
                                        @foreach(getSlaughterCustomer() as $slaughter_customer)
                                            <option value="{{$slaughter_customer->id}}">{{$slaughter_customer->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
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
                                    <label for="type">{{ __('global.select_type')}}<span class="text-danger"> *</span></label>
                                    <select id="type" name="type"  class="form-control">
                                        <option value="receive">{{__('global.receive')}}</option>
                                        <option value="return">{{__('global.return')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="amount">{{ __('global.amount')}}<span class="text-danger"> *</span></label>
                                    <input id="amount" min="1" name="amount" type="number" class="form-control" placeholder="{{ __('global.enter_amount')}}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea id="note" name="note" rows="1" class="form-control">{{old('note')}}</textarea>
                                </div>
                            </div>

                        </div>

                        @can('slaughter_customer_receive_create')
                            <button class="btn btn-success" type="submit">{{ __('global.create')}}</button>
                        @endcan
                    </form>
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
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false
            });
        });
    </script>
@stop
