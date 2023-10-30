@extends('adminlte::page')

@section('title', __('global.update_cattle_sale'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_cattle_sale')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.cattle-sales.index')}}">{{ __('global.cattle_sales')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_cattle_sale')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="">
                        <li><strong>{{__('global.farm')}} :</strong> {{$bulk_cattle_sale->farm->name}}</li>
                        <li><strong>{{__('global.cattle_type')}} :</strong> {{$bulk_cattle_sale->cattle_type->title}}</li>
                    </ul>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.bulk-cattle-sales.update',['bulk_cattle_sale'=>$bulk_cattle_sale->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
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
                                    <input name="unique_id" readonly value="{{$bulk_cattle_sale->unique_id}}" id="unique_id"  type="text" class="form-control">

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                    <input name="date" readonly id="date" value="{{$bulk_cattle_sale->date}}" type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="party_id">{{ __('global.select_party')}}<span class="text-danger"> *</span></label>
                                    <select id="party_id" name="party_id" class="form-control">
                                        <option value="">{{ __('global.select_party')}}</option>
                                        @foreach(getPartyList() as $party )
                                            <option value="{{$party->id}}"  @if($party->id == $bulk_cattle_sale->party_id) selected @endif>{{$party->name}} {{$party->phone}} {{$party->address}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="account_id">{{ __('global.select_account')}}<span class="text-danger"> *</span></label>
                                    <select id="account_id" name="account_id" class="form-control">
                                        <option value="">{{ __('global.select_account')}}</option>
                                        @foreach(getAccountList() as $account)
                                            <option value="{{$account->id}}" @if($account->id == $bulk_cattle_sale->account_id) selected @endif>{{$account->account_name}} {{$account->account_no}} {{$account->admin->name??'--'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="amount">{{ __('global.sale_price')}}<span class="text-danger"> *</span></label>
                                    <input name="amount" value="{{$bulk_cattle_sale->amount}}" id="amount"  type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="paid">{{ __('global.paid')}}</label>
                                    <input name="paid" value="{{$bulk_cattle_sale->paid}}" id="paid"  type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="due">{{ __('global.due')}}</label>
                                    <input name="due" value="{{$bulk_cattle_sale->due}}" readonly id="due" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="expense">{{ __('global.expense')}}</label>
                                    <input name="expense" value="{{$bulk_cattle_sale->expense}}" id="expense" type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea name="note" rows="1" id="note"  type="text" class="form-control">{{$bulk_cattle_sale->note}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="cattle_list">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{__('global.cattle_list')}}</h5>
                                    <a href="#cattle_list" class="badge badge-success mx-2" id="toggleAllButton">Select All</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width="80px">{{__('global.select')}}</th>
                                                <th>{{__('global.tag_id')}}</th>
                                                <th>{{__('global.gender')}}</th>
                                                <th>{{__('global.batch_no')}}</th>
                                                <th>{{__('global.session_year')}}</th>
                                                <th>{{__('global.weight')}}</th>
                                                <th>{{__('global.height')}}</th>
                                                <th>{{__('global.width')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($cattles as $cattle)
                                                <tr>
                                                    <td><input type="checkbox" name="cattles[]" @if ($bulk_cattle_sale->cattles->contains($cattle->id)) checked @endif  value="{{$cattle->id}}" class="form-control form-check"></td>
                                                    <td>{{$cattle->tag_id}}</td>
                                                    <td>{{__('global.'.$cattle->gender)}}</td>
                                                    <td>{{$cattle->batch->name}}</td>
                                                    <td>{{$cattle->session_year->year}}</td>
                                                    <td>{{getLatestCattleStructure($cattle->id,'weight')}} <sup>{{__('global.kg')}}</sup></td>
                                                    <td>{{getLatestCattleStructure($cattle->id,'height')}} <sup>{{__('global.inch')}}</sup></td>
                                                    <td>{{getLatestCattleStructure($cattle->id,'width')}} <sup>{{__('global.inch')}}</sup></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @can('cattle_sale_update')
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
@section('plugins.Sweetalert2',true)
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
            theme:'classic',
        });
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            showButtonPanel: false
        });
        priceCalculate();
        $('#amount,#paid').on('input',function () {
            priceCalculate();
        });

    });
    function priceCalculate(){
        var sale_price = parseFloat($('#amount').val());
        var paid = parseFloat($('#paid').val());

        sale_price = isNaN(sale_price) ? 0 : sale_price;
        paid = isNaN(paid) ? 0 : paid;

        $('#due').val(sale_price - paid);
    }
</script>
@stop
