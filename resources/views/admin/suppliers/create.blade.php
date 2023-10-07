@extends('adminlte::page')

@section('title', __('global.create_supplier'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_supplier')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.suppliers.index')}}">{{ __('global.suppliers')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_supplier')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.suppliers.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="name">{{ __('global.full_name')}} <span class="text-danger"> *</span></label>
                                    <input id="name" name="name" class="form-control" placeholder="{{ __('global.enter_full_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="previous_balance">{{ __('global.previous_balance')}}</label>
                                    <input id="previous_balance" type="number" name="previous_balance" class="form-control" placeholder="{{ __('global.previous_balance')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ __('global.phone')}} <span class="text-danger"> *</span></label>
                                    <input id="phone" name="phone" class="form-control" placeholder="{{ __('global.enter_phone')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{ __('global.email_address')}} <span class="text-danger"> *</span></label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="{{ __('global.enter_email_address')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">{{ __('global.address')}}</label>
                                    <input id="address" name="address" class="form-control" placeholder="{{ __('global.enter_address')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company">{{ __('global.company')}}</label>
                                    <input id="company" name="company" class="form-control" placeholder="{{ __('global.enter_company')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">{{__('global.select_photo')}}</label>
                                    <input name="photo" type="file" class="form-control" id="photo" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="" alt="Selected Image" id="selected-image" style="display: none;max-height: 150px">
                            </div>

                        </div>

                        @can('supplier_create')
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
            $('.select2').select2();
        });
        document.addEventListener('DOMContentLoaded', function () {
            const imageForm = document.getElementById('admin-form');
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
