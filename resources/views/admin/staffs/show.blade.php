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
                                  <th>{{ __('global.salary')}}</th>
                                  <td>{{$staff->salary}}</td>
                              </tr>
                              <tr>
                                  <th>{{ __('global.joining_date')}}</th>
                                  <td>{{$staff->joining_date}}</td>
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
                <div class="card-footer">
                    <h5 class="card-title">{{__('global.staff_payments')}}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>{{__('global.unique_id')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.account')}}</th>
                                <th>{{__('global.amount')}}</th>
                                <th>{{__('global.type')}}</th>
                                <th>{{__('global.staff')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.updated_at')}}</th>
                                <th>{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($staff->staff_payments as $staff_payment)
                                <tr>
                                    <td>{{$staff_payment->unique_id}}</td>
                                    <td>{{$staff_payment->date}}</td>
                                    <td>{{$staff_payment->account->account_name??'--'}} ({{$staff_payment->account->account_no??'--'}}) {{$staff_payment->account->admin->name??'--'}}</td>
                                    <td>{{$staff_payment->amount}}</td>
                                    <td>{{__('global.'.$staff_payment->pay_type)}}</td>
                                    <td>{{$staff_payment->staff->name??'--'}}</td>
                                    <td>{{__('global.'.$staff_payment->status)}}</td>
                                    <td>{{date_format($staff_payment->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.staff-payments.destroy', $staff_payment->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('staff_payment_view')
                                                <a href="{{route('admin.staff-payments.show',['staff_payment'=>$staff_payment->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @if($staff_payment->status == 'pending')
                                                @can('staff_payment_update')
                                                    <a href="{{route('admin.staff-payments.edit',['staff_payment'=>$staff_payment->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                                @endcan
                                                @can('staff_payment_delete')
                                                    <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                                @endcan
                                                @can('staff_payment_approve')
                                                    <a href="{{route('admin.staff-payments.approve',['staff_payment'=>$staff_payment->id])}}" class="btn btn-primary btn-sm px-1 py-0"><i class="fa fa-thumbs-up"></i></a>
                                                @endcan
                                            @else
                                                <a href="{{route('admin.staff-payments.show',['staff_payment'=>$staff_payment->id])}}" class="btn btn-info px-1 py-0 btn-sm">{{$staff_payment->status}}</a>
                                            @endif

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('css')

@stop

@section('js')
    <script>
        $(".datatable").DataTable({
            dom: 'Bfrtip',
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            searching: true,
            ordering: true,
            info: true,
            paging: true,
            buttons: [
                {
                    extend: 'copy',
                    text: '{{ __('global.copy') }}',
                },
                {
                    extend: 'csv',
                    text: '{{ __('global.export_csv') }}',
                },
                {
                    extend: 'excel',
                    text: '{{ __('global.export_excel') }}',
                },
                {
                    extend: 'pdf',
                    text: '{{ __('global.export_pdf') }}',
                },
                {
                    extend: 'print',
                    text: '{{ __('global.print') }}',
                },
                {
                    extend: 'colvis',
                    text: '{{ __('global.colvis') }}',
                }
            ],
            pagingType: 'full_numbers',
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                paginate: {
                    first: "{{ __('global.first') }}",
                    previous: "{{ __('global.previous') }}",
                    next: "{{ __('global.next') }}",
                    last: "{{ __('global.last') }}",
                }
            }
        });
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
