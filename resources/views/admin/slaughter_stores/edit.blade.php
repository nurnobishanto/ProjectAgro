@extends('adminlte::page')

@section('title', __('global.update_slaughter_store'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_slaughter_store')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughter-stores.index')}}">{{ __('global.slaughter_stores')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_slaughter_store')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.slaughter-stores.update',['slaughter_store'=>$slaughter_store->id])}}" method="POST" enctype="multipart/form-data" id="slaughter_store-form">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('global.full_name')}}</label>
                                    <input id="name" value="{{$slaughter_store->name}}" name="name" class="form-control" placeholder="{{ __('global.enter_full_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ __('global.phone')}}</label>
                                    <input id="phone" value="{{$slaughter_store->phone}}" name="phone" class="form-control" placeholder="{{ __('global.enter_phone')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{ __('global.email_address')}}</label>
                                    <input id="email" value="{{$slaughter_store->email}}" name="email" type="email" class="form-control" placeholder="{{ __('global.enter_email_address')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">{{ __('global.address')}}</label>
                                    <input id="address" value="{{$slaughter_store->address}}" name="address" class="form-control" placeholder="{{ __('global.enter_address')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company">{{ __('global.company')}}</label>
                                    <input id="company" value="{{$slaughter_store->company}}" name="company" class="form-control" placeholder="{{ __('global.enter_company')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ __('global.select_status')}}</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="active" @if($slaughter_store->status == 'active') selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate" @if($slaughter_store->status == 'deactivate') selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">{{__('global.select_photo')}}</label>
                                    <input name="photo" type="file" class="form-control" id="photo" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="{{asset('uploads/'.$slaughter_store->photo)}}" alt="Selected Image" id="selected-image" style="max-height: 150px">
                            </div>

                        </div>

                        @can('slaughter_store_update')
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
        const imageForm = document.getElementById('slaughter_store-form');
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
