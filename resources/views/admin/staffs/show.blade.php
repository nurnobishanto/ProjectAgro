@extends('adminlte::page')

@section('title', __('global.view_staff'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_staff')}} - {{$staff->name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.staffs.index')}}">{{__('global.staffs')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_staff')}}</li>
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
                              <tr>
                                  <th width="250px">{{ __('global.farm')}}</th>
                                  <td>{{$staff->farm->name??'--'}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.pay_type')}}</th>
                                  <td>{{__('global.'.$staff->pay_type)}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.staff_name')}}</th>
                                  <td>{{$staff->name}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.phone')}}</th>
                                  <td>{{$staff->phone}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.address')}}</th>
                                  <td>{{$staff->address}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.status')}}</th>
                                  <td>{{$staff->status}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.created_at')}}</th>
                                  <td>{{$staff->createdBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($staff->created_at))}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.updated_at')}}</th>
                                  <td>{{$staff->updatedBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($staff->updated_at))}}</td>
                              </tr>
                          </table>
                      </div>
                        <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.staffs.index')}}" class="btn btn-success" >Go Back</a>
                            @can('staff_update')
                                <a href="{{route('admin.staffs.edit',['staff'=>$staff->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('staff_delete')
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
