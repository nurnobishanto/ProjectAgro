@extends('adminlte::page')

@section('title', __('global.milk_sale_report'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.milk_sale_report')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.milk_sale_report')}}</li>
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
                        <form method="GET" action="{{route('report.milk.sale')}}">
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
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="farm_id">{{__('global.select_milk_store')}}</label>
                                        <select name="farm_id" class="form-control" id="farm_id">
                                            <option value="">{{__('global.select_milk_store')}}</option>
                                            @foreach(getFarms() as $farm)
                                                <option value="{{$farm->id}}" @if( $farm_id == $farm->id) selected @endif>{{$farm->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="milk_sale_party_id">{{__('global.select_milk_sale_party')}}</label>
                                        <select name="milk_sale_party_id" class="form-control" id="farm_id">
                                            <option value="">{{__('global.select_milk_sale_party')}}</option>
                                            @foreach(getMilkSaleParty() as $party)
                                                <option value="{{$party->id}}" @if( $milk_sale_party_id == $party->id) selected @endif>{{$party->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="from_date">{{__('global.select_from_date')}}</label>
                                        <input readonly value="{{$from_date}}" class="form-control datepicker" name="from_date" id="from_date">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="to_date">{{__('global.select_to_date')}}</label>
                                        <input readonly value="{{$to_date}}" class="form-control datepicker" name="to_date" id="to_date">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="status">{{__('global.select_status')}}</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="">{{__('global.all')}}</option>
                                            <option value="pending" @if("pending" == $status) selected @endif>{{__('global.pending')}}</option>
                                            <option value="success" @if("success" == $status) selected @endif>{{__('global.success')}}</option>
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
                                </tr>
                            @endforeach
                                <tr>
                                    <th class="text-success">X------X</th>
                                    <th class="text-success">{{__('global.success')}} {{__('global.qty')}}</th>
                                    <th class="text-success">{{$milk_sales->where('status','success')->sum('quantity')}} {{__('global.ltr')}}</th>
                                    <th class="text-success"></th>
                                    <th class="text-success"></th>
                                    <th class="text-success"></th>
                                    <th class="text-primary">{{__('global.pending')}} {{__('global.qty')}}</th>
                                    <th class="text-primary">{{$milk_sales->where('status','pending')->sum('quantity')}} {{__('global.ltr')}}</th>

                                </tr>
                                <tr>
                                    <th class="text-success">X------X</th>
                                    <th class="text-success">{{__('global.success')}}  {{__('global.total')}}</th>
                                    <th class="text-success">{{getSetting('currency')}} {{$milk_sales->where('status','success')->sum('total')}}</th>
                                    <th class="text-success"></th>
                                    <th class="text-success"></th>
                                    <th class="text-success"></th>
                                    <th class="text-primary">{{__('global.pending')}} {{__('global.total')}}</th>
                                    <th class="text-primary">{{getSetting('currency')}} {{$milk_sales->where('status','pending')->sum('total')}}</th>
                                </tr>
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

        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false
            });
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
