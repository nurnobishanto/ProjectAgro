@extends('adminlte::page')

@section('title', __('global.sales'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.sales')}}</h1>

                <form action="{{route('admin.sales.create')}}" method="GET">
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
                        @can('sale_create')
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="farm_id">{{__('global.select_farm')}} <span class="text-danger"> *</span></label>
                                <select class="select2 form-control" name="farm_id" id="farm_id">
                                    <option value="">{{__('global.select_farm')}}</option>
                                    @foreach(getFarms() as $farm)
                                        <option value="{{$farm->id}}">{{$farm->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 align-self-end">
                            <div class="form-group">
                                <input type="submit" value="{{__('global.add_new')}}" class="btn btn-primary form-control">
                            </div>
                        </div>
                        @endcan
                        @can('sale_delete')
                        <div class="col-lg-2 col-md-3 col-sm-6 align-self-center">
                            <a href="{{route('admin.sales.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
                        </div>
                        @endcan
                    </div>
                </form>



        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.sales')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('sale_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th >{{__('global.sl')}}</th>
                                <th width="200px">{{__('global.date')}}</th>
                                <th width="300px">{{__('global.invoice_no')}}</th>
                                <th width="200px">{{__('global.party')}}</th>
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
                            @foreach($sales as $sale)
                                <tr>

                                    <td>{{$sl++}}</td>
                                    <td>{{$sale->sale_date}}</td>
                                    <td>{{$sale->invoice_no}}</td>
                                    <td>{{$sale->party->name??'--'}}</td>
                                    <td>{{$sale->farm->name??'--'}}</td>
                                    <td>{{$sale->saleProducts->count()}}</td>
                                    @php
                                       $totalPurchasePrice = $sale->saleProducts->sum('sub_total');
                                       $taxAmount =round($totalPurchasePrice * ($sale->tax /100 ),2) ;
                                       $cost = ($totalPurchasePrice + $sale->shipping_cost + $sale->labor_cost + $sale->other_cost + $taxAmount) - $sale->discount;
                                    @endphp
                                    <td>{{$cost}}</td>
                                    <td>{{__('global.'.$sale->status)}}</td>
                                    <td>{{date_format($sale->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        @if($sale->status === 'pending')
                                            @can('sale_approve')
                                                <form action="{{route('admin.sales.approve',['sale'=>$sale->id])}}" method="post" id="approveForm">
                                                    @csrf
                                                    <button id="approveFormBtn" class="btn btn-primary px-1 py-0 btn-sm"><i class="fa fa-thumbs-up"></i></button>
                                                </form>
                                            @endcan
                                        <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf

                                            @can('sale_view')
                                                <a href="{{route('admin.sales.show',['sale'=>$sale->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('sale_update')
                                                <a href="{{route('admin.sales.edit',['sale'=>$sale->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('sale_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </form>

                                        @elseif($sale->status === 'rejected')
                                            <span class="text-capitalize badge badge-danger">{{$sale->status}}</span>
                                            @can('sale_view')
                                                <a href="{{route('admin.sales.show',['sale'=>$sale->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan

                                        @else
                                            <span class="text-capitalize badge badge-success">{{$sale->status}}</span>
                                            @can('sale_view')
                                                <a href="{{route('admin.sales.show',['sale'=>$sale->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
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
                                <th width="200px">{{__('global.party')}}</th>
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
