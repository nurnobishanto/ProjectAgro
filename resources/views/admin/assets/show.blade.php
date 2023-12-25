@extends('adminlte::page')

@section('title', __('global.view_asset'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_asset')}} - {{$asset->name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.assets.index')}}">{{__('global.assets')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_asset')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr><th>{{ __('global.asset')}}</th><td>{{$asset->name}}</td></tr>
                            <tr><th>{{ __('global.amount')}}</th><td>{{$asset->amount}}</td></tr>
                            <tr><th>{{ __('global.account')}}</th><td>{{$asset->account->bank_name??'--'}} {{$asset->account->account_name??'--'}}</td></tr>
                            <tr><th>{{ __('global.status')}}</th><td>{{__('global.'.$asset->status)}}</td></tr>
                            <tr><th>{{ __('global.note')}}</th><td>{!! $asset->note !!}</td></tr>
                            <tr><th>{{ __('global.photo')}}</th><td><img src="{{asset('uploads/'.$asset->image)}}" class="img-thumbnail w-25" ></td></tr>
                            <tr><th>{{ __('global.updated_at')}}</th><td>{{date_format($asset->updated_at,'d M y h:i A') }}</td></tr>
                            <tr><th>{{ __('global.updated_by')}}</th><td>{{$asset->updatedBy->name}}</td></tr>
                            <tr><th>{{ __('global.created_at')}}</th><td>{{date_format($asset->created_at,'d M y h:i A') }}</td></tr>
                            <tr><th>{{ __('global.created_by')}}</th><td>{{$asset->createdBy->name}}</td></tr>
                            </tbody>
                        </table>
                </div>
                <div class="card-footer">
                    <a href="{{route('admin.assets.index')}}" class="btn btn-success" >Go Back</a>
                    @if($asset->status === 'pending')
                        <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" class="d-inline">
                            @method('DELETE')
                            @csrf
                            @can('asset_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('asset_update')
                                <a href="{{route('admin.assets.edit',['asset'=>$asset->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                        </form>
                        @can('asset_approve')
                            <a href="{{route('admin.assets.approve',['asset'=>$asset->id])}}" class="btn btn-primary" ><i class="fa fa-thumbs-up"></i> Approve</a>
                        @endcan
                    @endif
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
