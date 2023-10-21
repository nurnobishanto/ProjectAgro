@extends('adminlte::page')

@section('title', __('global.update_account'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_account')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.accounts.index')}}">{{ __('global.accounts')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_account')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.accounts.update',['account'=>$account->id])}}" method="POST" enctype="multipart/form-data" id="account-form">
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
                                    <label for="admin_id">{{ __('global.select_admin')}} <span class="text-danger"> *</span></label>
                                    <select id="admin_id" name="admin_id" class="form-control select2" >
                                        <option value="">{{ __('global.select_admin')}} </option>
                                        @foreach(getAdmins() as  $admin)
                                            <option value="{{$admin->id}}" @if($admin->id == $account->admin_id) selected @endif>{{ $admin->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="bank_name">{{ __('global.bank_name')}} <span class="text-danger"> *</span></label>
                                    <input id="bank_name" name="bank_name" class="form-control" value="{{$account->bank_name}}" placeholder="{{ __('global.enter_bank_name')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="account_name">{{ __('global.account_name')}} <span class="text-danger"> *</span></label>
                                    <input id="account_name" name="account_name" class="form-control" value="{{$account->account_name}}" placeholder="{{ __('global.enter_account_name')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="account_no">{{ __('global.account_no')}} <span class="text-danger"> *</span></label>
                                    <input id="account_no" name="account_no" class="form-control" value="{{$account->account_no}}" placeholder="{{ __('global.enter_account_no')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="account_type">{{ __('global.select_account_type')}} <span class="text-danger"> *</span></label>
                                    <select id="account_type" name="account_type" class="form-control select2" >
                                        <option value="">{{ __('global.select_account_type')}} </option>
                                        @foreach(getAccountType() as  $key => $type)
                                            <option value="{{$key}}" @if($key == $account->account_type) selected @endif>{{ $type}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="status">{{ __('global.select_status')}} <span class="text-danger"> *</span></label>
                                    <select id="status" name="status" class="form-control select2" >
                                        <option value="">{{ __('global.select_status')}} </option>
                                        <option value="pending" @if('pending' == $account->status) selected @endif>{{ __('global.pending')}} </option>
                                        <option value="active" @if('active' == $account->status) selected @endif>{{ __('global.active')}} </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @can('account_update')
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
        $('.select2').select2({
            theme : 'classic'
        });
    });

</script>
@stop
