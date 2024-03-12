@extends('adminlte::page')

@section('title', __('global.update_staff'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_staff')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.staffs.index')}}">{{ __('global.staffs')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_staff')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.staffs.update',['staff'=>$staff->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
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
                                    <label for="farm_id">{{ __('global.select_farm')}}<span class="text-danger"> *</span></label>
                                    <select id="farm_id" name="farm_id" class="form-control">
                                        <option value="">{{ __('global.select_farm')}}</option>
                                        @foreach(getFarms() as $farm)
                                            <option value="{{$farm->id}}" @if($staff->farm_id == $farm->id) selected @endif>{{$farm->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="pay_type">{{ __('global.select_pay_type')}}<span class="text-danger"> *</span></label>
                                    <select id="pay_type" name="pay_type" class="form-control">
                                        <option value="">{{ __('global.select_pay_type')}}</option>
                                        @foreach(getPayType() as $key => $type)
                                            <option value="{{$key}}" @if($staff->pay_type == $key) selected @endif>{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('global.staff_name')}}<span class="text-danger"> *</span></label>
                                    <input id="name" name="name" value="{{$staff->name}}" class="form-control" placeholder="{{ __('global.staff_name')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="phone">{{ __('global.phone')}}<span class="text-danger"> *</span></label>
                                    <input id="phone" name="phone" value="{{$staff->phone}}" class="form-control" placeholder="{{ __('global.enter_phone')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="salary">{{ __('global.salary')}}<span class="text-danger"> *</span></label>
                                    <input id="salary" name="salary" value="{{old('salary',$staff->salary)}}" class="form-control" placeholder="{{ __('global.salary')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="joining_date">{{ __('global.joining_date')}}<span class="text-danger"> *</span></label>
                                    <input id="joining_date" readonly type="text" name="joining_date" value="{{old('joining_date',$staff->joining_date)}}" class="form-control datepicker" placeholder="{{ __('global.joining_date')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="address">{{ __('global.address')}}<span class="text-danger"> *</span></label>
                                    <input id="address" name="address" value="{{$staff->address}}" class="form-control" placeholder="{{ __('global.enter_address')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="image">{{ __('global.image')}}<span class="text-danger"> *</span></label>
                                    <input id="image" name="image" type="file" value="{{$staff->image}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($staff->status == 'active') selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate"  @if($staff->status == 'deactivate') selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <img src="{{asset('uploads/'.$staff->image)}}" class="img-thumbnail img-lg" />
                                </div>
                            </div>
                        </div>
                        @can('staff_update')
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
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        viewMode: "days",
        minViewMode: "days",
        autoclose: true
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
