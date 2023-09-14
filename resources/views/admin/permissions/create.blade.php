@extends('adminlte::page')

@section('title', __('global.create_permission'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.create_permission')}}</h1>

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.permissions.index')}}">{{__('global.permissions')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.create_permission')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.permissions.store')}}" method="POST">
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
                        <div class="form-group">

                            <label for="name">{{__('global.name')}}</label>
                            <input name="name" type="text" required class="form-control" id="name" placeholder="{{__('global.enter_permission')}}">
                        </div>
                        <div class="form-group">
                            <label for="guard">{{__('global.guard')}}</label>
                            <input name="guard_name" id="guard" value="admin" required placeholder="{{__('global.enter_guard_name')}}" class="form-control">


                        </div>
                        <div class="form-group">
                            <label for="group">{{__('global.group')}}</label>
                            <input type="text" name="group_name" required  class="form-control" id="group" placeholder="{{__('global.enter_group')}}">
                        </div>
                        @can('permission_create')
                            <button class="btn btn-primary" type="submit">{{__('global.create')}}</button>
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
@section('toastr',true)
@section('css')

@stop

@section('js')


@stop
