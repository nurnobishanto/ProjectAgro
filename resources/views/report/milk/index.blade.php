@extends('adminlte::page')

@section('title', __('global.milk_productions'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.milk_productions')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.milk_productions')}}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('report.milk')}}" method="GET">
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
                                    <label for="farm_id">{{__('global.select_farm')}} </label>
                                    <select class="select2 form-control" name="farm_id" id="farm_id">
                                        <option value="">{{__('global.select_farm')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="cattle_type_id">{{ __('global.select_cattle_type')}}</label>
                                    <select name="cattle_type_id" id="cattle_type_id" class="form-control select2">
                                        <option value="">{{ __('global.select_cattle_type')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="tag_id">{{ __('global.select_tag_id')}}</label>
                                    <select name="tag_id" id="tag_id" class="form-control select2">
                                        <option value="">{{ __('global.select_tag_id')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4">
                                <div class="form-group">
                                    <label for="from_date">{{__('global.select_from_date')}}</label>
                                    <input readonly value="{{$from_date}}" class="form-control datepicker" name="from_date" id="from_date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4">
                                <div class="form-group">
                                    <label for="to_date">{{__('global.select_to_date')}}</label>
                                    <input readonly value="{{$to_date}}" class="form-control datepicker" name="to_date" id="to_date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="moment">{{__('global.select_moment')}}</label>
                                    <select name="moment" class="form-control" id="moment">
                                        <option value="">{{__('global.all')}}</option>
                                        <option value="morning" @if("morning" == $moment) selected @endif>{{__('global.morning')}}</option>
                                        <option value="evening" @if("evening" == $moment) selected @endif>{{__('global.evening')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3  col-sm-6">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="">{{__('global.all')}}</option>
                                        <option value="pending" @if("pending" == $status) selected @endif>{{__('global.pending')}}</option>
                                        <option value="success" @if("success" == $status) selected @endif>{{__('global.success')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <input type="submit" value="{{__('global.filter')}}" class="btn btn-primary form-control ">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            @can('milk_production_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <caption>

                            </caption>
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.name')}}</th>
                                <th>{{__('global.qty')}}</th>
                                <th>{{__('global.total')}}</th>


                            </thead>
                            <tbody>
                                <?php $sl = 1; ?>
                                <tr class="bg-success">
                                    <td>{{$sl++}}</td>
                                    <td>Total Milk Production ( Morning )</td>
                                    <td>{{$milk_productions->where('moment','morning')->sum('quantity')}} {{__('global.ltr')}}</td>
                                    <td></td>
                                </tr>
                                <tr class="bg-success">
                                    <td>{{$sl++}}</td>
                                    <td>Total Milk Production ( Evening )</td>
                                    <td>{{$milk_productions->where('moment','evening')->sum('quantity')}} {{__('global.ltr')}}</td>
                                    <td></td>
                                </tr>
                                <tr class="bg-success">
                                    <th>{{$sl++}}</th>
                                    <th>Total Milk Production</th>
                                    <th>{{$milk_productions->sum('quantity')}} {{__('global.ltr')}}</th>
                                    <th></th>
                                </tr>
                                <tr class="bg-primary">
                                    <td>{{$sl++}}</td>
                                    <td>Total Milk Sale (Success)</td>
                                    <td>{{$milk_sales->where('status','success')->sum('quantity')}} {{__('global.ltr')}}</td>
                                    <td>{{getSetting('currency')}} {{$milk_sales->where('status','success')->sum('total')}}</td>
                                </tr>
                                <tr class="bg-primary">
                                    <td>{{$sl++}}</td>
                                    <td>Total Milk Sale (Pending)</td>
                                    <td>{{$milk_sales->where('status','pending')->sum('quantity')}} {{__('global.ltr')}}</td>
                                    <td>{{getSetting('currency')}} {{$milk_sales->where('status','pending')->sum('total')}}</td>
                                </tr>
                                <tr class="bg-primary">
                                    <th>{{$sl++}}</th>
                                    <th>Total Milk Sale</th>
                                    <th>{{$milk_sales->sum('quantity')}} {{__('global.ltr')}}</th>
                                    <th>{{getSetting('currency')}} {{$milk_sales->sum('total')}}</th>
                                </tr>
                                <tr class="bg-danger">
                                    <td>{{$sl++}}</td>
                                    <td>Total Milk Waste (Success)</td>
                                    <td>{{$milk_wastes->where('status','success')->sum('quantity')}} {{__('global.ltr')}}</td>
                                    <td>{{getSetting('currency')}} {{$milk_wastes->where('status','success')->sum('total')}}</td>
                                </tr>
                                <tr class="bg-danger">
                                    <td>{{$sl++}}</td>
                                    <td>Total Milk Waste (Pending)</td>
                                    <td>{{$milk_wastes->where('status','pending')->sum('quantity')}} {{__('global.ltr')}}</td>
                                    <td>{{getSetting('currency')}} {{$milk_wastes->where('status','pending')->sum('total')}}</td>
                                </tr>
                                <tr class="bg-danger">
                                    <th>{{$sl++}}</th>
                                    <th>Total Milk Waste</th>
                                    <th>{{$milk_wastes->sum('quantity')}} {{__('global.ltr')}}</th>
                                    <th>{{getSetting('currency')}} {{$milk_wastes->sum('total')}}</th>
                                </tr>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.name')}}</th>
                                <th>{{__('global.value')}}</th>
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
                url: "{{ route('farm_dairy_cattle_list') }}",
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
