@extends('adminlte::page')

@section('title', __('global.stocks'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.stocks')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.stocks')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('stock_list')
                <div class="card">
                    <div class="card-header">
                        <form class="" action="" method="get">
                            <div class="row">
                                <div class="col-md-3 col-sm-5">
                                    <div class="form-group">
                                        <select class="form-control select2" name="farm_id">
                                            <option value="">All</option>
                                            @foreach(getFarms() as $farm)
                                                <option value="{{$farm->id}}"  @if($farm_id == $farm->id) selected @endif>{{$farm->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-5">
                                    <div class="form-group">
                                        <select class="form-control select2" name="product_id">
                                            <option value="">All</option>
                                            @foreach(getProductsForPurchase() as $product)
                                                <option value="{{$product->id}}" @if($product_id == $product->id) selected @endif >{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                       <input type="submit" value="Filter" class="form-control btn btn-info">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="btn btn-secondary" readonly value="{{__('global.total')}} : {{$totalBalance}} Taka">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="stockList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th >{{__('global.sl')}}</th>
                                <th width="200px">{{__('global.farm')}}</th>
                                <th width="200px">{{__('global.products')}}</th>
                                <th width="200px">{{__('global.qty')}}</th>
                                <th width="200px">{{__('global.unit_price')}}</th>
                                <th width="200px">{{__('global.balance')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $sl = 1; ?>
                            @foreach($stocks as $stock)
                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td>{{$stock->farm->name??'--'}}</td>
                                    <td>{{$stock->product->name??'--'}}</td>
                                    <td>{{$stock->quantity}} <sup>{{$stock->product->unit->name}}</sup></td>
                                    <td>{{$stock->unit_price}} </td>
                                    <td>{{$stock->unit_price * $stock->quantity}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th >{{__('global.sl')}}</th>
                                <th width="200px">{{__('global.farm')}}</th>
                                <th width="200px">{{__('global.products')}}</th>
                                <th width="200px">{{__('global.qty')}}</th>
                                <th width="200px">{{__('global.unit_price')}}</th>
                                <th width="200px">{{__('global.balance')}}</th>
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
@section('plugins.Select2', true)


@section('css')

@stop

@section('js')

    <script>

        $(document).ready(function() {
            $('.select2').select2({
                theme:'classic'
            });
            $("#stockList").DataTable({
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
                },
            });
        });


    </script>
@stop
