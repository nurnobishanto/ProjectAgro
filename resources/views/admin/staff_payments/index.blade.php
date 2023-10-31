@extends('adminlte::page')

@section('title', __('global.staff_payments'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.staff_payments')}}</h1>
            @can('staff_payment_delete')
                <a href="{{route('admin.staff-payments.trashed')}}" class="btn btn-danger">{{__('global.trash_list')}}</a>
            @endcan
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.staff_payments')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('staff_payment_list')
                <div class="card">
                    @can('staff_payment_create')
                    <div class="card-header">
                       <form action="{{route('admin.staff-payments.create')}}" method="GET">
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
                                       <label for="farm_id">{{__('global.farm')}} <span class="text-danger"> *</span></label>
                                       <select id="farm_id" name="farm_id" class="form-control" >

                                       </select>
                                   </div>
                               </div>
                               <div class="col-lg-3 col-md-4 col-sm-6">
                                   <div class="form-group">
                                       <label for="staff_id">{{__('global.staff')}} <span class="text-danger"> *</span></label>
                                       <select id="staff_id" name="staff_id" class="form-control" >
                                           <option value="">{{__('global.select_staff')}}</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="col-lg-3 col-md-4 col-sm-6 align-self-end">
                                   <div class="form-group">
                                       <input type="submit" value="{{__('global.add_new')}}" class="form-control btn-primary" >
                                   </div>
                               </div>
                           </div>
                       </form>
                    </div>
                    @endcan
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
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
                            <?php $sl = 1; ?>
                            @foreach($staff_payments as $staff_payment)
                                <tr>

                                    <td>{{$sl++}}</td>
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
                            <tfoot>
                            <tr>
                                <th>{{__('global.sl')}}</th>
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
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endcan

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
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
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

        $(document).ready(function() {
            $("#adminsList").DataTable({
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
            loadFarms();
            $('#farm_id').change(function() {
                var farm_id = $(this).val();
                if (farm_id ) {
                    loadStaffList(farm_id);
                } else {
                    $('#staff_id').empty();
                    $('#staff_id').append($('<option>', {
                        value: '',
                        text: '{{ __('global.select_staff')}}'
                    }));
                }
            });

        });
        function loadFarms() {
            $.ajax({
                url: '{{route('farms')}}', // Replace with your server URL
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var farm_id = $('#farm_id');
                    farm_id.empty();
                    farm_id.append($('<option>', {
                        value: '',
                        text: '{{ __('global.select_farm')}}'
                    }));
                    $.each(data, function(key, value) {
                        farm_id.append($('<option>', {
                            value: value.id,
                            text: value.name
                        }));
                    });
                }
            });
        }
        function loadStaffList(farm_id) {
            $.ajax({
                url: '{{route('farm_staff_list')}}', // Replace with your server URL
                method: 'GET',
                dataType: 'json',
                data: {
                    farm_id:farm_id,
                },
                success: function(data) {
                    var staff_id = $('#staff_id');
                    staff_id.empty();
                    staff_id.append($('<option>', {
                        value: '',
                        text: '{{ __('global.select_staff')}}'
                    }));
                    $.each(data, function(key, value) {
                        staff_id.append($('<option>', {
                            value: value.id,
                            text: value.name
                        }));
                    });
                }
            });
        }
    </script>
@stop
