@extends('adminlte::page')

@section('title', __('global.update_supplier_payment'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_supplier_payment')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.supplier-payments.index')}}">{{ __('global.supplier_payments')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_supplier_payment')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.supplier-payments.update',['supplier_payment'=>$supplier_payment->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
                        @method('PUT')
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
                                    <input name="unique_id" readonly value="{{$supplier_payment->unique_id}}" id="unique_id"  type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                    <input name="date" value="{{$supplier_payment->date}}" readonly id="date"  type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="supplier_id">{{__('global.select_supplier')}}<span class="text-danger"> *</span></label>
                                    <select name="supplier_id" class=" form-control" id="account_id">
                                        <option value="">{{__('global.select_supplier')}}</option>
                                        @foreach(getSuppliers() as $supplier)
                                            <option value="{{$supplier->id}}" @if($supplier->id == $supplier_payment->supplier_id) selected @endif>{{$supplier->name}} </option>
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
                                            <option value="{{$account->id}}" @if($account->id == $supplier_payment->account_id) selected @endif>{{$account->account_name}} ({{$account->account_no}}) {{$account->admin->name??'--'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="amount">{{ __('global.supplier_payment')}}<span class="text-danger"> *</span></label>
                                    <input id="amount" name="amount" value="{{$supplier_payment->amount}}" type="number" class="form-control" placeholder="{{ __('global.enter_supplier_payment')}}">
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea id="note" name="note" rows="1" class="form-control">{{$supplier_payment->note}}</textarea>
                                </div>
                            </div>

                        </div>

                        @can('supplier_payment_update')
                            <button class="btn btn-success" type="submit">{{ __('global.update')}}</button>
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
        $('.select2').select2();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const imageForm = document.getElementById('supplier-form');
        const selectedImage = document.getElementById('selected-image');

        imageForm.addEventListener('change', function () {
            const fileInput = this.querySelector('input[type="file"]');
            const file = fileInput.files[0];

            if (file) {
                const imageUrl = URL.createObjectURL(file);
                selectedImage.src = imageUrl;
                selectedImage.style.display = 'block';
            } else {
                selectedImage.src = '';
                selectedImage.style.display = 'none';
            }
        });
    });
</script>
@stop
