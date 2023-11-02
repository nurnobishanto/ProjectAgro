@extends('adminlte::page')

@section('title', __('global.view_slaughter_customer_receive'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_slaughter_customer_receive')}} - {{$slaughter_customer_receive->unique_id}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughter_customer-receives.index')}}">{{__('global.slaughter_customer_receives')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_slaughter_customer_receive')}}</li>
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
                                  <th>{{ __('global.unique_id')}}</th>
                                  <td>{{$slaughter_customer_receive->unique_id}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.date')}}</th>
                                  <td>{{$slaughter_customer_receive->date}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.slaughter_customer')}}</th>
                                  <td>{{$slaughter_customer_receive->slaughter_customer->name??'--'}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.account')}}</th>
                                  <td>{{$slaughter_customer_receive->account->account_name??'--'}} ({{$slaughter_customer_receive->account->account_no??'--'}}) {{$slaughter_customer_receive->account->admin->name??'--'}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.type')}}</th>
                                  <td>{{__('global.'.$slaughter_customer_receive->type)}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.amount')}}</th>
                                  <td>{{$slaughter_customer_receive->amount}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.note')}}</th>
                                  <td>{{$slaughter_customer_receive->note}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.created_by')}}</th>
                                  <td>{{$slaughter_customer_receive->createdBy->name??'--'}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.updated_by')}}</th>
                                  <td>{{$slaughter_customer_receive->updatedBy->name??'--'}}</td>
                              </tr>
                          </table>
                      </div>

                        <form action="{{ route('admin.slaughter_customer-receives.destroy', $slaughter_customer_receive->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.slaughter_customer-receives.index')}}" class="btn btn-success" >Go Back</a>
                            @if($slaughter_customer_receive->status == 'pending')
                            @can('slaughter_customer_receive_update')
                                <a href="{{route('admin.slaughter_customer-receives.edit',['slaughter_customer_receife'=>$slaughter_customer_receive->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('slaughter_customer_receive_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('slaughter_customer_receive_approve')
                                <a href="{{route('admin.slaughter_customer-receives.approve',['slaughter_customer_receive'=>$slaughter_customer_receive->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
                            @endcan
                            @endif
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
