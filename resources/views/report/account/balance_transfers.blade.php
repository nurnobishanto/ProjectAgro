@extends('adminlte::page')

@section('title', __('global.balance_transfer_report'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.balance_transfer_report')}}</h1>


        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.balance_transfer_report')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        {{--        <div class="col-md-12">--}}
        {{--            <div class="card">--}}
        {{--                <div class="card-body">--}}
        {{--                    <form action="{{route('report.cattle.balance_transfer_report')}}" method="GET">--}}

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
