@extends('adminlte::page')

@section('title', __('global.purchases'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.purchases')}}</h1>
            @can('purchase_create')
                <a href="{{route('admin.purchases.create')}}" class="btn btn-primary mt-2">{{__('global.add_new')}}</a>
            @endcan
            @can('purchase_delete')
                <a href="{{route('admin.purchases.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.purchases')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('purchase_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th >{{__('global.sl')}}</th>
                                <th width="200px">{{__('global.date')}}</th>
                                <th width="300px">{{__('global.invoice_no')}}</th>
                                <th width="200px">{{__('global.supplier')}}</th>
                                <th width="200px">{{__('global.farm')}}</th>
                                <th width="200px">{{__('global.products')}}</th>
                                <th width="200px">{{__('global.total')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th width="120px">{{__('global.updated_at')}}</th>
                                <th width="200px">{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $sl = 1; ?>
                            @foreach($purchases as $purchase)
                                <tr>

                                    <td>{{$sl++}}</td>
                                    <td>{{$purchase->purchase_date}}</td>
                                    <td>{{$purchase->invoice_no}}</td>
                                    <td>{{$purchase->supplier->name??'--'}}</td>
                                    <td>{{$purchase->farm->name??'--'}}</td>
                                    <td>{{$purchase->purchaseProducts->count()}}</td>
                                    <td>{{$purchase->purchaseProducts->sum('sub_total')}}</td>
                                    <td>{{__('global.'.$purchase->status)}}</td>
                                    <td>{{date_format($purchase->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        @if($purchase->status === 'pending')
                                            @can('purchase_approve')
                                                <form action="{{route('admin.purchases.approve',['purchase'=>$purchase->id])}}" method="post" id="approveForm">
                                                    @csrf
                                                    <button id="approveFormBtn" class="btn btn-primary px-1 py-0 btn-sm"><i class="fa fa-thumbs-up"></i></button>
                                                </form>
                                            @endcan
                                        <form action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf

                                            @can('purchase_view')
                                                <a href="{{route('admin.purchases.show',['purchase'=>$purchase->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('purchase_update')
                                                <a href="{{route('admin.purchases.edit',['purchase'=>$purchase->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('purchase_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </form>

                                        @elseif($purchase->status === 'rejected')
                                            <span class="text-capitalize badge badge-danger">{{$purchase->status}}</span>
                                            @can('purchase_view')
                                                <a href="{{route('admin.purchases.show',['purchase'=>$purchase->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan

                                        @else
                                            <span class="text-capitalize badge badge-success">{{$purchase->status}}</span>
                                            @can('purchase_view')
                                                <a href="{{route('admin.purchases.show',['purchase'=>$purchase->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan

                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th >{{__('global.sl')}}</th>
                                <th width="200px">{{__('global.date')}}</th>
                                <th width="200px">{{__('global.invoice_no')}}</th>
                                <th width="200px">{{__('global.supplier')}}</th>
                                <th width="200px">{{__('global.farm')}}</th>
                                <th width="200px">{{__('global.products')}}</th>
                                <th width="200px">{{__('global.total')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th width="120px">{{__('global.updated_at')}}</th>
                                <th width="80px">{{__('global.action')}}</th>
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
