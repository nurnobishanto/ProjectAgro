@extends('adminlte::page')

@section('title', __('global.update_balance_transfer'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_balance_transfer')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.balance-transfers.index')}}">{{ __('global.balance_transfers')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_balance_transfer')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.balance-transfers.update',['balance_transfer'=>$balance_transfer->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
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
                                    <input name="unique_id" readonly value="{{$balance_transfer->unique_id}}" id="unique_id"  type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                    <input name="date" value="{{$balance_transfer->date}}" readonly id="date"  type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="amount">{{ __('global.balance_transfer')}}<span class="text-danger"> *</span></label>
                                    <input id="amount" name="amount" value="{{$balance_transfer->amount}}" type="number" class="form-control" placeholder="{{ __('global.enter_balance_transfer')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="from_account_id">{{__('global.select_from_account')}}<span class="text-danger"> *</span></label>
                                    <select name="from_account_id" class=" form-control" id="from_account_id">
                                        <option value="">{{__('global.select_from_account')}}</option>
                                        @foreach(getAccountList() as $fromAccount)
                                            <option value="{{$fromAccount->id}}" @if($fromAccount->id == $balance_transfer->from_account_id) selected @endif>{{$fromAccount->account_name}} ({{$fromAccount->account_no}}) {{$fromAccount->admin->name??'--'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="to_account_id">{{__('global.select_to_account')}}<span class="text-danger"> *</span></label>
                                    <select name="to_account_id" class=" form-control" id="to_account_id">
                                        <option value="">{{__('global.select_to_account')}}</option>
                                        @foreach(\App\Models\Account::where('status','active')->get() as $toAccount)
                                            <option value="{{$toAccount->id}}" @if($toAccount->id == $balance_transfer->to_account_id) selected @endif>{{$toAccount->account_name}} ({{$toAccount->account_no}}) {{$toAccount->admin->name??'--'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea id="note" name="note" rows="1" class="form-control">{{$balance_transfer->note}}</textarea>
                                </div>
                            </div>

                        </div>

                        @can('balance_transfer_update')
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
