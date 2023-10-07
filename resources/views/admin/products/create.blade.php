@extends('adminlte::page')

@section('title', __('global.create_product'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_product')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">{{ __('global.products')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_product')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">{{ __('global.product_name')}}<span class="text-danger"> *</span></label>
                                    <input id="name" name="name" type="text" value="{{old('name')}}" class="form-control" placeholder="{{ __('global.product_name')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="code">{{ __('global.product_code')}}<span class="text-danger"> *</span></label>
                                    <input id="code" name="code" type="text" value="{{old('code')??productCodeGenerate()}}" class="form-control" placeholder="{{ __('global.product_code')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type">{{__('global.select_type')}}<span class="text-danger"> *</span></label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="">{{__('global.select_type')}}</option>
                                        <option value="cattle_meal">{{__('global.cattle_meal')}}</option>
                                        <option value="milk_collection">{{__('global.milk_collection')}}</option>
                                        <option value="cattle_medicine">{{__('global.cattle_medicine')}}</option>
                                        <option value="dewormer_medicine">{{__('global.dewormer_medicine')}}</option>
                                        <option value="vaccination">{{__('global.vaccination')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit_id">{{__('global.select_unit')}}<span class="text-danger"> *</span></label>
                                    <select name="unit_id" class="form-control" id="unit_id">
                                        <option value="">{{__('global.select_unit')}}</option>
                                        @foreach($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_price">{{ __('global.purchase_price')}}<span class="text-danger"> *</span></label>
                                    <input id="purchase_price" type="text" name="purchase_price" value="{{old('purchase_price')}}" class="form-control" placeholder="{{ __('global.purchase_price')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sale_price">{{ __('global.sale_price')}}<span class="text-danger"> *</span></label>
                                    <input id="sale_price" type="text" name="sale_price" value="{{old('sale_price')}}" class="form-control" placeholder="{{ __('global.sale_price')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alert_quantity">{{ __('global.alert_quantity')}}<span class="text-danger"> *</span></label>
                                    <input id="alert_quantity" type="number" name="alert_quantity" value="{{old('alert_quantity')}}" class="form-control" placeholder="{{ __('global.alert_quantity')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active">{{__('global.active')}}</option>
                                        <option value="deactivate">{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">{{ __('global.photo')}}</label>
                                    <input id="image" type="file" name="image" value="{{old('image')}}" class="form-control" placeholder="{{ __('global.image')}}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description">{{ __('global.description')}}</label>
                                    <textarea id="description" name="description"  class="form-control" placeholder="{{ __('global.description')}}">{{old('description')}}</textarea>
                                </div>
                            </div>

                        </div>

                        @can('product_create')
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
            $('.select2').select2({
                theme:'classic',
            });
        });
    </script>
@stop
