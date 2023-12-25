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
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="account_id">{{ __('global.select_account')}}<span class="text-danger"> *</span></label>
                                    <select id="account_id" name="account_id" class="select2 form-control">
                                        <option value="">{{ __('global.select_account')}}</option>
                                        @foreach(getAccountList() as $account)
                                            <option @if($account->id == $asset->account_id) selected @endif value="{{$account->id}}">{{$account->account_name}} {{$account->account_no}} {{$account->admin->name??'--'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea id="note" name="note" class="form-control" placeholder="{{ __('global.enter_note')}}">{{$asset->note}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">{{ __('global.photo')}}</label>
                                    <input id="image" name="image" type="file" class="form-control" onchange="previewImage()" >
                                </div>
                                <img id="imagePreview" src="{{asset('uploads/'.$asset->image)}}" alt="Selected Image" class="img-thumbnail w-50" style="max-width: 100%;">
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
        $('.select2').select2({
            theme:'classic',
        });
    });
    function previewImage() {
        // Get the selected file input
        var input = document.getElementById('image');

        // Get the image preview element
        var imagePreview = document.getElementById('imagePreview');

        // Display the selected image in the preview element
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@stop
