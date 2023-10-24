@extends('adminlte::page')

@section('title', __('global.global_setting'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.global_setting')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.global_setting')}}</li>
            </ol>

        </div>
    </div>
@stop
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.update_global_setting')}}" method="POST" enctype="multipart/form-data" id="code_setting">
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
                                    <label for="site_name">{{ __('global.site_name')}}</label>
                                    <input id="site_name" value="{{getSetting('site_name')}}"  name="site_name" class="form-control" placeholder="{{__('global.site_name')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="currency">{{ __('global.currency')}}</label>
                                    <input id="currency" value="{{getSetting('currency')}}" name="currency" class="form-control" placeholder="{{__('global.currency')}}">
                                </div>
                            </div>


                        </div>

                        @can('global_setting_manage')
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
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            toastr.now();
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageForm = document.getElementById('site_setting');

            const site_faviconImage = document.getElementById('selected-site_favicon');
            const site_logoImage = document.getElementById('selected-site_logo');

            imageForm.addEventListener('change', function () {
                const site_favicon = this.querySelector('input[name="site_favicon"]').files[0];
                const site_logo = this.querySelector('input[name="site_logo"]').files[0];
                if (site_favicon) {
                    site_faviconImage.src = URL.createObjectURL(site_favicon);
                }
                if (site_logo) {
                    site_logoImage.src = URL.createObjectURL(site_logo);
                }
            });
        });
    </script>
@stop
