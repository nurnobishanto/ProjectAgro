@extends('adminlte::page')

@section('title', __('global.milk_sales'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.milk_sales')}}</h1>
            @can('milk_sale_delete')
                <a href="{{route('admin.milk-sales.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.milk_sales')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('milk_sale_list')
                <div class="card">
                    <div class="card-header">
                        @can('milk_sale_create')
                        <form method="GET" action="{{route('admin.milk-sales.create')}}">
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
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <select name="farm_id" class="form-control">
                                            <option value="">{{__('global.select_milk_store')}}</option>
                                            @foreach(getFarms() as $farm)
                                                <option value="{{$farm->id}}">{{$farm->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <input class="btn-primary btn" type="submit" value="{{__('global.create')}}">
                                </div>
                            </div>
                        </form>
                        @endcan
                    </div>
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.invoice_no')}}</th>
                                <th>{{__('global.milk_sale_party')}}</th>
                                <th>{{__('global.farm')}}</th>
                                <th>{{__('global.quantity')}}</th>
                                <th>{{__('global.unit_price')}}</th>
                                <th>{{__('global.total')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $sl = 1; ?>
                            @foreach($milk_sales as $milk_sale)
                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td>{{$milk_sale->date}}</td>
                                    <td>{{$milk_sale->unique_id}}</td>
                                    <td>{{$milk_sale->milkSaleParty->name??'--'}}</td>
                                    <td>{{$milk_sale->farm->name??'--'}}</td>
                                    <td>{{$milk_sale->quantity}}</td>
                                    <td>{{$milk_sale->unit_price}}</td>
                                    <td>{{$milk_sale->total}}</td>
                                    <td>{{__('global.'.$milk_sale->status)}}</td>

                                    <td class="text-center">
                                        @if($milk_sale->status === 'pending')
                                        <form action="{{ route('admin.milk-sales.destroy', $milk_sale->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('milk_sale_view')
                                                <a href="{{route('admin.milk-sales.show',['milk_sale'=>$milk_sale->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('milk_sale_update')
                                                <a href="{{route('admin.milk-sales.edit',['milk_sale'=>$milk_sale->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('milk_sale_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                            @can('milk_sale_approve')
                                                <a href="{{route('admin.milk-sales.approve',['milk_sale'=>$milk_sale->id])}}" class="btn btn-primary px-1 py-0 btn-sm"><i class="fa fa-thumbs-up"></i></a>
                                            @endcan
                                        </form>
                                        @else
                                            <span class="text-capitalize badge badge-success">{{$milk_sale->status}}</span>
                                            @can('milk_sale_view')
                                                <a href="{{route('admin.milk-sales.show',['milk_sale'=>$milk_sale->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan

                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th >{{__('global.sl')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.invoice_no')}}</th>
                                <th>{{__('global.milk_sale_party')}}</th>
                                <th>{{__('global.farm')}}</th>
                                <th>{{__('global.quantity')}}</th>
                                <th>{{__('global.unit_price')}}</th>
                                <th>{{__('global.total')}}</th>
                                <th>{{__('global.status')}}</th>
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
