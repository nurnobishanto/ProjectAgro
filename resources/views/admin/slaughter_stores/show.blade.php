@extends('adminlte::page')

@section('title', __('global.view_slaughter_store'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_slaughter_store')}} - {{$slaughter_store->name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughter-stores.index')}}">{{__('global.slaughter_stores')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_slaughter_store')}}</li>
            </ol>
        </div>

    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th width="200px">{{__('global.name')}}</th>
                                <th>{{__('global.value')}}</th>
                            </tr>
                            <tr>
                                <th>{{__('global.full_name')}}</th>
                                <td>{{$slaughter_store->name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.phone')}}</th>
                                <td>{{$slaughter_store->phone}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.email_address')}}</th>
                                <td>{{$slaughter_store->email}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.address')}}</th>
                                <td>{{$slaughter_store->address}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.company')}}</th>
                                <td>{{$slaughter_store->company}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.photo')}}</th>
                                <td><img src="{{asset('uploads/'.$slaughter_store->photo)}}" alt="{{$slaughter_store->name}}" class="img-thumbnail" style="max-height: 150px"></td>
                            </tr>
                            <tr>
                                <th>{{__('global.created_by')}}</th>
                                <td>{{$slaughter_store->createdBy->name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.status')}}</th>
                                <td>{{__('global.'.$slaughter_store->status)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                        <form action="{{ route('admin.slaughter-stores.destroy', $slaughter_store->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.slaughter-stores.index')}}" class="btn btn-success" >Go Back</a>
                            @can('slaughter_store_update')
                                <a href="{{route('admin.slaughter-stores.edit',['slaughter_store'=>$slaughter_store->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('slaughter_store_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
        function checkSinglePermission(idName, className,inGroupCount,total,groupCount) {
            if($('.'+className+' input:checked').length === inGroupCount){
                $('#'+idName).prop('checked',true);
            }else {
                $('#'+idName).prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        function checkPermissionByGroup(idName, className,total,groupCount) {
            if($('#'+idName).is(':checked')){
                $('.'+className+' input').prop('checked',true);
            }else {
                $('.'+className+' input').prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        $('#select_all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@stop
