@extends('adminlte::page')

@section('title', __('global.slaughter_sales'). __('global.deleted'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.slaughter_sales'). __('global.deleted')}}</h1>
            @can('supplier_list')
                <a href="{{route('admin.slaughter_sales.index')}}" class="btn btn-primary mt-2">{{__('global.go_back')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.slaughter_sales')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('supplier_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="suppliersList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th >{{__('global.sl')}}</th>
                                <th width="200px">{{__('global.date')}}</th>
                                <th width="300px">{{__('global.invoice_no')}}</th>
                                <th width="200px">{{__('global.slaughter_customer')}}</th>
                                <th width="200px">{{__('global.slaughter_store')}}</th>
                                <th width="200px">{{__('global.products')}}</th>
                                <th width="200px">{{__('global.total')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th width="120px">{{__('global.updated_at')}}</th>
                                <th width="200px">{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = 1; ?>
                            @foreach($slaughter_sales as $slaughter_sale)
                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td>{{$slaughter_sale->date}}</td>
                                    <td>{{$slaughter_sale->unique_id}}</td>
                                    <td>{{$slaughter_sale->slaughter_customer->name??'--'}}</td>
                                    <td>{{$slaughter_sale->slaughter_store->name??'--'}}</td>
                                    <td>{{$slaughter_sale->products->count()}}</td>
                                    <td>{{$slaughter_sale->products->sum('pivot.sub_total')}}</td>
                                    <td>{{__('global.'.$slaughter_sale->status)}}</td>
                                    <td>{{date_format($slaughter_sale->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        @can('slaughter_sale_delete')
                                        <a href="{{route('admin.slaughter_sales.restore',['slaughter_sale'=>$slaughter_sale->id])}}"  class="btn btn-success btn-sm px-1 py-0"><i class="fa fa-arrow-left"></i></a>
                                        <a href="{{route('admin.slaughter_sales.force_delete',['slaughter_sale'=>$slaughter_sale->id])}}"  class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th >{{__('global.sl')}}</th>
                                <th width="200px">{{__('global.date')}}</th>
                                <th width="200px">{{__('global.invoice_no')}}</th>
                                <th width="200px">{{__('global.slaughter_customer')}}</th>
                                <th width="200px">{{__('global.slaughter_store')}}</th>
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
            $("#suppliersList").DataTable({
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
