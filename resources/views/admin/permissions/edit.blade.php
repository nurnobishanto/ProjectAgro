@extends('adminlte::page')

@section('title', __('global.update_permission'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.update_permission')}} - {{$permission->name}}</h1>

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.permissions.index')}}">{{__('global.permissions')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.update_permission')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.permissions.update',['permission'=>$permission->id])}}" method="POST">
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
                        <div class="form-group">
                            <label for="name">{{__('global.name')}}</label>
                            <input name="name" type="text" value="{{$permission->name}}" required class="form-control" id="name" placeholder="{{__('global.enter_permission')}}">
                        </div>
                        <div class="form-group">
                            <label for="guard">{{__('global.guard')}}</label>
                            <input value="{{$permission->guard_name}}" placeholder="{{__('global.enter_guard_name')}}" name="guard_name" id="guard" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="group">{{__('global.group')}}</label>
                            <input type="text" name="group_name" required value="{{$permission->group_name}}" class="form-control" id="group" placeholder="{{__('global.enter_group')}}">
                        </div>
                        @can('permission_update')
                            <button class="btn btn-primary" type="submit">{{__('global.update')}}</button>
                        @endcan

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('toastr',true)
@section('css')

@stop

@section('js')


@stop
