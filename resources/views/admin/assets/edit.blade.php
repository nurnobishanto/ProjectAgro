@extends('adminlte::page')

@section('title', __('global.update_asset'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_asset')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.assets.index')}}">{{ __('global.assets')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_asset')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.assets.update',['asset'=>$asset->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">{{ __('global.asset')}} <span class="text-danger"> *</span></label>
                                    <input id="name" name="name" class="form-control" value="{{$asset->name}}" placeholder="{{ __('global.enter_asset')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">{{ __('global.amount')}} <span class="text-danger"> *</span></label>
                                    <input id="amount" name="amount" class="form-control" value="{{$asset->amount}}" placeholder="{{ __('global.enter_amount')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">{{ __('global.select_status')}} <span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($asset->status == 'active') selected @endif>{{ __('global.active')}}</option>
                                        <option value="deactivate" @if($asset->status == 'deactivate') selected @endif>{{ __('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        @can('asset_update')
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
