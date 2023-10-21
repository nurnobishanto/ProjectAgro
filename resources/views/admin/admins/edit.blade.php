@extends('adminlte::page')

@section('title', __('global.update_admin'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_admin')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.admins.index')}}">{{ __('global.admins')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_admin')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.admins.update',['admin'=>$admin->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <input id="name" name="name" value="{{$admin->name}}" class="form-control" placeholder="{{ __('global.enter_full_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{ __('global.email_address')}}</label>
                                    <input id="email" name="email" value="{{$admin->email}}" class="form-control" placeholder="{{ __('global.enter_email_address')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">{{ __('global.password')}}</label>
                                    <input id="password" type="password" name="password" class="form-control" placeholder="{{ __('global.enter_password')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('global.confirm_password')}}</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="{{ __('global.enter_confirm_password')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">{{ __('global.select_roles')}}</label>
                                    <select name="roles[]" class="select2 form-control" id="role" multiple="true">
                                        <option value="">{{ __('global.select_roles')}}</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->name}}" @if(checkAdminRole($admin,$role->name)) selected @endif>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ __('global.select_status')}}</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($admin->status == 'active') selected @endif>{{ __('global.active')}}</option>
                                        <option value="deactivate" @if($admin->status == 'deactivate') selected @endif>{{ __('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">{{ __('global.select_photo')}}</label>
                                    <input name="old_photo" value="{{$admin->photo}}" class="d-none">
                                    <input name="photo" type="file" class="form-control" id="photo">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <img src="{{asset('uploads/'.$admin->photo)}}" alt="Selected Image" id="selected-image" style="max-height: 150px">
                            </div>

                        </div>

                        @can('admin_update')
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
