@extends('adminlte::page')

@section('title', __('global.create_milk_production'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_milk_production')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.milk-productions.index')}}">{{ __('global.milk_productions')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_milk_production')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <table class="table table-bordered">
                        <tr><th width="30%">{{__('global.farm')}}</th><td>{{$cattle->farm->name}}</td></tr>
                        <tr><th>{{__('global.cattle_type')}}</th><td>{{$cattle->cattle_type->title}}</td></tr>
                        <tr><th>{{__('global.tag_id')}}</th><td>{{$cattle->tag_id}}</td></tr>
                    </table>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.milk-productions.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger"> *</span></label>
                                    <input name="unique_id" readonly value="{{generateInvoiceId('MP',\App\Models\MilkProduction::class,'unique_id')}}" id="unique_id"  type="text" class="form-control">
                                    <input name="cattle_id" value="{{$cattle->id}}"  class="d-none">
                                    <input name="farm_id" value="{{$cattle->farm->id}}"  class="d-none">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                    <input name="date" readonly id="date" value="{{old('date',$today)}}" type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="quantity">{{ __('global.quantity')}} ({{__('global.ltr')}})<span class="text-danger"> *</span></label>
                                    <input  name="quantity" type="number" step="any" placeholder="{{__('global.enter_milk_quantity')}}" class="form-control" value="{{old('quantity')}}">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="moment">{{ __('global.select_moment')}}<span class="text-danger"> *</span></label>
                                    <select name="moment"  class="form-control">
                                        <option value="morning">{{__('global.morning')}}</option>
                                        <option value="evening">{{__('global.evening')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea name="note" rows="1" id="note"  type="text" class="form-control">{{old('note')}}</textarea>
                                </div>
                            </div>
                        </div>

                        @can('milk_production_create')
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
