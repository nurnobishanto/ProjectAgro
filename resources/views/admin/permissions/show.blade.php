@extends('adminlte::page')

@section('title', __('global.view_permission'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_permission')}} - {{$permission->name}}</h1>

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.permissions.index')}}">{{__('global.permissions')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_permission')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

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
                            <input name="name" type="text" value="{{$permission->name}}" disabled required class="form-control" id="name" placeholder="{{__('global.enter_name')}}">
                        </div>
                        <div class="form-group">
                            <label for="guard">{{__('global.guard')}}</label>
                            <input type="text" name="guard_name" disabled required value="{{$permission->guard_name}}" class="form-control" id="guard" placeholder="{{__('global.enter_guard_name')}}">
                        </div>
                        <div class="form-group">
                            <label for="group">{{__('global.group')}}</label>
                            <input type="text" name="group_name" disabled required value="{{$permission->group_name}}" class="form-control" id="group" placeholder="{{__('global.enter_group')}}">
                        </div>
                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            @can('permission_view')
                                <a href="{{route('admin.permissions.index')}}" class="btn btn-info px-1 py-0 btn-sm">{{__('global.go_back')}}</a>
                            @endcan
                            @can('permission_update')
                                <a href="{{route('admin.permissions.edit',['permission'=>$permission->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                            @endcan
                            @can('permission_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                            @endcan
                        </form>

                </div>
            </div>
        </div>
    </div>
@stop
@section('toastr',true)
@section('plugins.Sweetalert2', true)
@section('css')

@stop

@section('js')
<script>
    function isDelete(button) {
        event.preventDefault();
        var row = $(button).closest("tr");
        var form = $(button).closest("form");
        Swal.fire({
            title: @json(__('global.deleteConfirmTitle')),
            text: @json(__('global.deleteConfirmText')),
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: @json(__('global.deleteConfirmButtonText')),
            cancelButtonText: @json(__('global.deleteCancelButton')),
        }).then((result) => {
            console.log(result)
            if (result.value) {
                // Trigger the form submission
                form.submit();
            }
        });
    }
</script>

@stop
