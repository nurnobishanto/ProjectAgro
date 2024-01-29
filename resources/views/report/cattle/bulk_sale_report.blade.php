@extends('adminlte::page')

@section('title', __('global.cattle_bulk_sale_report'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.cattle_bulk_sale_report')}}</h1>


        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.cattle_bulk_sale_report')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
{{--        <div class="col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <form action="{{route('report.cattle.expense_report')}}" method="GET">--}}

{{--                        <div class="row">--}}
{{--                            <div class=" col-md-3 col-sm-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="farm_id">{{__('global.select_farm')}} <span class="text-danger"> *</span></label>--}}
{{--                                    <select class="select2 form-control" name="farm_id" id="farm_id">--}}
{{--                                        <option value="">{{__('global.select_farm')}}</option>--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3 col-sm-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="cattle_type_id">{{ __('global.select_cattle_type')}}<span class="text-danger"> *</span></label>--}}
{{--                                    <select name="cattle_type_id" id="cattle_type_id" class="form-control select2">--}}
{{--                                        <option value="">{{ __('global.select_cattle_type')}}</option>--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class=" col-md-3 col-sm-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="tag_id">{{ __('global.select_tag_id')}}<span class="text-danger"> *</span></label>--}}
{{--                                    <select name="tag_id" id="tag_id" class="form-control select2">--}}
{{--                                        <option value="">{{ __('global.select_tag_id')}}</option>--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class=" col-md-3 col-sm-6 align-self-end">--}}
{{--                                <div class="form-group">--}}
{{--                                    @can('cattle_create')--}}
{{--                                        <input type="submit" value="{{__('global.filter')}}" class="btn btn-primary form-control ">--}}
{{--                                    @endcan--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-12">
            @can('cattle_bulk_sale_report')
                <div class="card">

                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.cattles')}}</th>
                                <th>{{__('global.party')}}</th>
                                <th>{{__('global.account')}}</th>
                                <th>{{__('global.feeding_expense')}}</th>
                                <th>{{__('global.avg_other_cost')}}</th>
                                <th>{{__('global.expense')}}</th>
                                <th>{{__('global.total_expense')}}</th>
                                <th>{{__('global.sale_price')}}</th>
                                <th>{{__('global.loss_profit')}}</th>
                            </thead>
                            <tbody>
                            @foreach($bulk_cattle_sales as $cattle_sale)

                                <tr>
                                    <td>{{$cattle_sale->date??'--'}} </td>
                                    <td>{{$cattle_sale->cattles->count()??'--'}} </td>
                                    <td>{{$cattle_sale->party->name??'--'}} </td>
                                    <td>{{$cattle_sale->account->account_name??'--'}} </td>

                                    <td>{{getSetting('currency')}} {{$cattle_sale->feeding_expense??'--'}}</td>
                                    <td>{{getSetting('currency')}} {{$cattle_sale->other_expense??'--'}}</td>
                                    <td>{{getSetting('currency')}} {{$cattle_sale->expense??'--'}}</td>
                                    @php $total_expense = ($cattle_sale->feeding_expense + $cattle_sale->other_expense + $cattle_sale->expense) @endphp
                                    <td>{{getSetting('currency')}} {{$total_expense}}</td>
                                    <td>{{getSetting('currency')}} {{$cattle_sale->amount??'--'}}</td>
                                    @php $loss_profit = ($cattle_sale->amount - $total_expense ) @endphp
                                    <td class="@if($loss_profit>0) text-success @else text-danger @endif">{{getSetting('currency')}} {{$loss_profit}}</td>

                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.tag_id')}}</th>
                                <th>{{__('global.party')}}</th>
                                <th>{{__('global.account')}}</th>
                                <th>{{__('global.feeding_expense')}}</th>
                                <th>{{__('global.avg_other_cost')}}</th>
                                <th>{{__('global.expense')}}</th>
                                <th>{{__('global.total_expense')}}</th>
                                <th>{{__('global.sale_price')}}</th>
                                <th>{{__('global.loss_profit')}}</th>
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
@section('plugins.Select2', true)


@section('css')

@stop

@section('js')

    <script>



        $(document).ready(function() {
            $('.select2').select2({
                theme:'classic'
            })

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
