@extends('adminlte::page')

@section('title', __('global.balance_transfers'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.balance_transfers')}}</h1>
            @can('balance_transfer_create')
                <a href="{{route('admin.balance-transfers.create')}}" class="btn btn-primary mt-2">{{__('global.add_new')}}</a>
            @endcan
            @can('balance_transfer_delete')
                <a href="{{route('admin.balance-transfers.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.balance_transfers')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('balance_transfer_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.unique_id')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.from_account')}}</th>
                                <th>{{__('global.balance_transfer')}}</th>
                                <th>{{__('global.to_account')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.updated_at')}}</th>
                                <th>{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = 1; ?>
                            @foreach($balance_transfers as $balance_transfer)
                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td>{{$balance_transfer->unique_id}}</td>
                                    <td>{{$balance_transfer->date}}</td>
                                    <td>{{$balance_transfer->fromAccount->account_name??'--'}} ({{$balance_transfer->fromAccount->account_no??'--'}}) {{$balance_transfer->fromAccount->admin->name??'--'}}</td>
                                    <td>{{$balance_transfer->amount}}</td>
                                    <td>{{$balance_transfer->toAccount->account_name??'--'}} ({{$balance_transfer->toAccount->account_no??'--'}}) {{$balance_transfer->toAccount->admin->name??'--'}}</td>
                                    <td>{{$balance_transfer->status}}</td>
                                    <td>{{date_format($balance_transfer->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.balance-transfers.destroy', $balance_transfer->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('balance_transfer_view')
                                                <a href="{{route('admin.balance-transfers.show',['balance_transfer'=>$balance_transfer->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @if($balance_transfer->status == 'pending')
                                                @can('balance_transfer_update')
                                                    <a href="{{route('admin.balance-transfers.edit',['balance_transfer'=>$balance_transfer->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                                @endcan
                                                @can('balance_transfer_delete')
                                                    <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                                @endcan
                                                @can('balance_transfer_approve')
                                                    <a href="{{route('admin.balance-transfers.approve',['balance_transfer'=>$balance_transfer->id])}}" class="btn btn-primary btn-sm px-1 py-0"><i class="fa fa-thumbs-up"></i></a>
                                                @endcan
                                            @else
                                                <a href="{{route('admin.balance-transfers.show',['balance_transfer'=>$balance_transfer->id])}}" class="btn btn-info px-1 py-0 btn-sm">{{$balance_transfer->status}}</a>
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
                                <th>{{__('global.from_account')}}</th>
                                <th>{{__('global.balance_transfer')}}</th>
                                <th>{{__('global.to_account')}}</th>
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
