@extends('adminlte::page')

@section('title', __('global.supplier_payments'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.supplier_payments')}}</h1>
            @can('supplier_payment_create')
                <a href="{{route('admin.supplier-payments.create')}}" class="btn btn-primary mt-2">{{__('global.add_new')}}</a>
            @endcan
            @can('supplier_payment_delete')
                <a href="{{route('admin.supplier-payments.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.supplier_payments')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('supplier_payment_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.unique_id')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.account')}}</th>
                                <th>{{__('global.paid_amount')}}</th>
                                <th>{{__('global.supplier')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.updated_at')}}</th>
                                <th>{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = 1; ?>
                            @foreach($supplier_payments as $supplier_payment)
                                <tr>

                                    <td>{{$sl++}}</td>
                                    <td>{{$supplier_payment->unique_id}}</td>
                                    <td>{{$supplier_payment->date}}</td>
                                    <td>{{$supplier_payment->account->account_name??'--'}} ({{$supplier_payment->account->account_no??'--'}}) {{$supplier_payment->account->admin->name??'--'}}</td>
                                    <td>{{$supplier_payment->amount}}</td>
                                    <td>{{$supplier_payment->supplier->name}}</td>
                                    <td>{{$supplier_payment->status}}</td>
                                    <td>{{date_format($supplier_payment->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.supplier-payments.destroy', $supplier_payment->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('supplier_payment_view')
                                                <a href="{{route('admin.supplier-payments.show',['supplier_payment'=>$supplier_payment->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @if($supplier_payment->status == 'pending')
                                                @can('supplier_payment_update')
                                                    <a href="{{route('admin.supplier-payments.edit',['supplier_payment'=>$supplier_payment->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                                @endcan
                                                @can('supplier_payment_delete')
                                                    <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                                @endcan
                                                @can('supplier_payment_approve')
                                                    <a href="{{route('admin.supplier-payments.approve',['supplier_payment'=>$supplier_payment->id])}}" class="btn btn-primary btn-sm px-1 py-0"><i class="fa fa-thumbs-up"></i></a>
                                                @endcan
                                            @else
                                                <a href="{{route('admin.supplier-payments.show',['supplier_payment'=>$supplier_payment->id])}}" class="btn btn-info px-1 py-0 btn-sm">{{$supplier_payment->status}}</a>
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
                                <th>{{__('global.paid_amount')}}</th>
                                <th>{{__('global.supplier')}}</th>
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

        });

    </script>
@stop
