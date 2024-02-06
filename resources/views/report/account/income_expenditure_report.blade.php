@extends('adminlte::page')

@section('title', __('global.income_expenditure_report'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.income_expenditure_report')}}</h1>


        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.income_expenditure_report')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('report.account.income_expenditure_report')}}" method="GET">
                                <div class="row ">
                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label for="from_date">{{__('global.select_from_date')}}</label>
                                            <input readonly  class="form-control datepicker" name="from_date" id="from_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label for="to_date">{{__('global.select_to_date')}}</label>
                                            <input readonly class="form-control datepicker" name="to_date" id="to_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 align-self-end">
                                        <div class="form-group">
                                            <input type="submit" value="{{__('global.filter')}}" class="btn btn-primary form-control ">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        @if($filter)
        <div class="col-12">
            <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{__('global.income_expenditure_report')}} ( {{$from_date}} - {{$to_date}} )</h5>
                    </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered table-striped table-warning">
                                <thead>
                                <tr>
                                    <th colspan="3" class="text-center">{{__('global.income_expenditure_report')}}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">{{__('global.total')}} {{__('global.income')}}</th>
                                    <th>{{getSetting('currency')}}  {{$total_income}}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">{{__('global.total')}} {{__('global.expense')}}</th>
                                    <th>{{getSetting('currency')}} {{$total_expense}}</th>
                                </tr>
                                <tr>
                                    <th colspan="2"> @if($total_income > $total_expense) {{__('global.profit')}}@else {{__('global.loss')}} @endif </th>
                                    <th>{{getSetting('currency')}}  {{$total_income - $total_expense}}</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                        <div class="col-md-6 table-responsive">
                            <table class="table table-bordered table-striped table-success">
                                <thead>
                                <tr>
                                    <th colspan="3" class="text-center">{{__('global.income')}} {{__('global.report')}}</th>
                                </tr>
                                <tr>
                                    <th>{{__('global.title')}}</th>
                                    <th>{{__('global.date')}}</th>
                                    <th>{{__('global.amount')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($merged_sale as $sale)
                                    <tr>
                                        <td>
                                            @if($sale['milk_sale_amount']) Milk Sale
                                            @elseif($sale['cattle_sale_amount']) Cattle Sale
                                            @elseif($sale['slaughter_sale_amount']) Slaughter Sale
                                            @elseif($sale['bulk_cattle_sale_amount']) Bulk Cattle Sale
                                            @endif
                                        </td>
                                        <td>{{$sale['date']}}</td>
                                        <td>{{getSetting('currency')}}
                                            @if($sale['milk_sale_amount']) {{$sale['milk_sale_amount']}}
                                            @elseif($sale['cattle_sale_amount']) {{$sale['cattle_sale_amount']}}
                                            @elseif($sale['bulk_cattle_sale_amount']) {{$sale['bulk_cattle_sale_amount']}}
                                            @elseif($sale['slaughter_sale_amount']) {{$sale['slaughter_sale_amount']}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end">{{__('global.total')}} {{__('global.income')}}</th>
                                    <th>{{getSetting('currency')}} {{$total_income}}</th>
                                </tr>
                                </tfoot>

                            </table>
                        </div>
                        <div class="col-md-6 table-responsive">
                            <table class="table table-bordered table-striped table-danger">
                                <thead>
                                <tr>
                                    <th colspan="3" class="text-center">{{__('global.expense')}} {{__('global.report')}}</th>
                                </tr>
                                <tr>
                                    <th>{{__('global.title')}}</th>
                                    <th>{{__('global.date')}}</th>
                                    <th>{{__('global.amount')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($merged_expenses as $expense)
                                    <tr>
                                        <td>
                                            @if($expense['staff']) Staff Salary
                                            @elseif($expense['purchaseProducts']) Product Purchase
                                            @elseif($expense['category']) Cattle Purchase
                                            @elseif($expense['expense_category']) Expense @endif</td>
                                        <td>{{$expense['date']}}</td>
                                        <td>{{getSetting('currency')}}
                                            {{$expense['amount']}}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end">{{__('global.total')}} {{__('global.expense')}}</th>
                                    <th>{{getSetting('currency')}} {{$total_expense}}</th>
                                </tr>
                                </tfoot>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endif
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
@section('plugins.Select2', true)


@section('css')

@stop

@section('js')

    <script>



        $(document).ready(function() {
            $('.select2').select2({
                theme:'classic'
            })
            var fromDateInput = $("#from_date");
            var toDateInput = $("#to_date");

            fromDateInput.datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false,
                onSelect: function (selectedDate) {
                    // Set the minimum date for the "to" datepicker
                    toDateInput.datepicker("option", "minDate", selectedDate);

                    // Your additional logic if needed
                }
            });

            toDateInput.datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false,
                onSelect: function (selectedDate) {
                    // Set the maximum date for the "from" datepicker
                    fromDateInput.datepicker("option", "maxDate", selectedDate);

                    // Your additional logic if needed
                }
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

            loadFarms();
            loadCattleTypes();
            $('#farm_id').change(function() {
                var farm_id = $(this).val();
                var cattle_type_id = $('#cattle_type_id').val();
                if (farm_id || cattle_type_id) {
                    loadCattleList(farm_id,cattle_type_id);
                } else {
                    $('#tag_id').empty();
                }
            });
            $('#cattle_type_id').change(function() {
                var cattle_type_id = $(this).val();
                var farm_id = $('#farm_id').val();
                if (cattle_type_id || farm_id) {
                    loadCattleList(farm_id,cattle_type_id);

                } else {
                    $('#tag_id').empty();
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
        function loadCattleTypes() {
            $.ajax({
                url: '{{route('cattle_types')}}', // Replace with your server URL
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var cattle_type_id = $('#cattle_type_id');
                    cattle_type_id.empty();
                    cattle_type_id.append($('<option>', {
                        value: '',
                        text: '{{ __('global.select_cattle_type')}}'
                    }));
                    $.each(data, function(key, value) {
                        cattle_type_id.append($('<option>', {
                            value: value.id,
                            text: value.title
                        }));
                    });
                }
            });
        }
        function loadCattleList(farm_id,cattle_type_id) {
            $.ajax({
                url: "{{ route('farm_cattle_list') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}', // Add a CSRF token if needed
                    farm_id: farm_id ,// Send cattle_type_id as data
                    cattle_type_id: cattle_type_id ,// Send cattle_type_id as data
                },
                success: function(data) {
                    var tagSelect = $('#tag_id');
                    tagSelect.empty();
                    tagSelect.append($('<option>', {
                        value: '',
                        text: '{{__('global.select_tag_id')}}'
                    }));
                    $.each(data, function(key, value) {
                        tagSelect.append($('<option>', {
                            value: value.id,
                            text: value.tag_id
                        }));
                    });
                }
            });
        }

    </script>
@stop
