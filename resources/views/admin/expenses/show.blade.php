@extends('adminlte::page')

@section('title', __('global.view_expense'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_expense')}} - {{$expense->date}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.expenses.index')}}">{{__('global.expenses')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_expense')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">{{ __('global.select_date')}} <span class="text-danger"> *</span></label>
                                        <input id="date" disabled name="date" value="{{$expense->date}}" type="text" readonly class="form-control datepicker" placeholder="{{ __('global.select_date')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_id">{{ __('global.account')}} <span class="text-danger"> *</span></label>
                                       <div>
                                           {{$expense->account->bank_name??'--'}},
                                           {{$expense->account->account_name??'--'}},
                                           {{$expense->account->account_no??'--'}},
                                           {{__('global.'.$expense->account->account_type)??'--'}}<br>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expense_category_id">{{ __('global.select_expense_category')}} <span class="text-danger"> *</span></label>
                                        <input class="form-control" disabled value="{{$expense->expense_category->name??'--'}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">{{ __('global.amount')}}<span class="text-danger"> *</span></label>
                                        <input id="amount" type="number" step="any" disabled value="{{$expense->amount}}" name="amount" class="form-control" placeholder="{{ __('global.amount')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="note">{{ __('global.note')}}</label>
                                        <textarea disabled id="note"  name="note" class="form-control" placeholder="{{ __('global.enter_note')}}">{{$expense->note}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <img src="{{asset('uploads/'.$expense->photo)}}" alt="Updated Image" id="selected-image" class="img-thumbnail" style="max-height: 150px">
                                </div>
                            </div>
                            <a href="{{route('admin.expenses.index')}}" class="btn btn-success" >Go Back</a>
                            @if($expense->status == 'pending')

                        <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST">
                            @method('DELETE')
                            @csrf

                            @can('expense_update')
                                <a href="{{route('admin.expenses.edit',['expense'=>$expense->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('expense_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('expense_approve')
                                <a href="{{route('admin.expenses.approve',['expense'=>$expense->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
                            @endcan
                        </form>
                            @endif

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
@section('plugins.Sweetalert2', true)

