@extends('adminlte::page')

@section('title', __('global.update_product'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_product')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">{{ __('global.products')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_product')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.products.update',['product'=>$product->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
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
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">{{ __('global.product_name')}}<span class="text-danger"> *</span></label>
                                    <input id="name" name="name" type="text" value="{{$product->name}}" class="form-control" placeholder="{{ __('global.product_name')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="code">{{ __('global.product_code')}}<span class="text-danger"> *</span></label>
                                    <input id="code" name="code" type="text" value="{{$product->code}}" class="form-control" placeholder="{{ __('global.product_code')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type">{{__('global.select_type')}}<span class="text-danger"> *</span></label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="">{{__('global.select_type')}}</option>
                                        <option value="cattle_meal"  @if($product->type === 'cattle_meal') selected @endif>{{__('global.cattle_meal')}}</option>
                                        <option value="cattle_medicine" @if($product->type === 'cattle_medicine') selected @endif>{{__('global.cattle_medicine')}}</option>
                                        <option value="dewormer_medicine" @if($product->type === 'dewormer_medicine') selected @endif>{{__('global.dewormer_medicine')}}</option>
                                        <option value="vaccination" @if($product->type === 'vaccination') selected @endif>{{__('global.vaccination')}}</option>
                                        <option value="slaughter_item" @if($product->type === 'slaughter_item') selected @endif>{{__('global.slaughter_item')}}</option>
                                        <option value="milk_collection" @if($product->type === 'milk_collection') selected @endif>{{__('global.milk_collection')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit_id">{{__('global.select_unit')}}<span class="text-danger"> *</span></label>
                                    <select name="unit_id" class="form-control" id="product_id">
                                        <option value="">{{__('global.select_unit')}}</option>
                                        @foreach($units as $unit)
                                            <option value="{{$unit->id}}" @if($product->unit_id === $unit->id) selected @endif>{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_price">{{ __('global.purchase_price')}}<span class="text-danger"> *</span></label>
                                    <input id="purchase_price" type="text" name="purchase_price" value="{{$product->purchase_price}}" class="form-control" placeholder="{{ __('global.purchase_price')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sale_price">{{ __('global.sale_price')}}<span class="text-danger"> *</span></label>
                                    <input id="sale_price" type="text" name="sale_price" value="{{$product->sale_price}}" class="form-control" placeholder="{{ __('global.sale_price')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alert_quantity">{{ __('global.alert_quantity')}}<span class="text-danger"> *</span></label>
                                    <input id="alert_quantity" type="number" name="alert_quantity" value="{{$product->alert_quantity}}" class="form-control" placeholder="{{ __('global.alert_quantity')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($product->status === 'active') selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate" @if($product->status === 'deactivate') selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">{{ __('global.photo')}}</label>
                                    <input id="image" type="file" name="image"  class="form-control" placeholder="{{ __('global.image')}}">
                                    <input name="image_old" value="{{$product->image}}" class="d-none">
                                    <img src="{{asset('uploads/'.$product->image)}}" alt="" class="img-thumbnail"/>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description">{{ __('global.description')}}</label>
                                    <textarea id="description" name="description"  class="form-control" placeholder="{{ __('global.description')}}">{{$product->description}}</textarea>
                                </div>
                            </div>

                        </div>

                        @can('product_update')
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
