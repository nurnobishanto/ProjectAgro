@extends('adminlte::page')

@section('title', __('global.dewormers'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.dewormers')}}</h1>


        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.dewormers')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('dewormer_create')
                    <form action="{{route('admin.dewormers.create')}}" method="GET">

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
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="farm_id">{{__('global.select_farm')}} <span class="text-danger"> *</span></label>
                                    <select class="select2 form-control" name="farm_id" id="farm_id">
                                        <option value="">{{__('global.select_farm')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="cattle_type_id">{{ __('global.select_cattle_type')}}<span class="text-danger"> *</span></label>
                                    <select name="cattle_type_id" id="cattle_type_id" class="form-control select2">
                                        <option value="">{{ __('global.select_cattle_type')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="product_id">{{ __('global.select_medicine')}}<span class="text-danger"> *</span></label>
                                    <select name="product_id" id="product_id" class="form-control select2 ">
                                        <option value="">{{ __('global.select_medicine')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 align-self-end">
                                <div class="form-group">
                                    <input type="submit" value="{{__('global.add_new')}}" class="btn btn-primary form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-12">
            @can('dewormer_list')
                <div class="card">
                    <div class="card-header">
                        @can('dewormer_delete')
                            <a href="{{route('admin.dewormers.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
                        @endcan
                    </div>

                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.farm')}}</th>
                                <th>{{__('global.dewormer')}}</th>
                                <th>{{__('global.cattles')}}</th>
                                <th>{{__('global.average')}}</th>
                                <th>{{__('global.total_cost')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.updated_at')}}</th>
                                <th>{{__('global.action')}}</th>
                            </thead>
                            <tbody>
                            <?php $sl = 1; ?>
                            @foreach($dewormers as $dewormer)
                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td>{{$dewormer->date}}</td>
                                    <td>{{$dewormer->farm->name??'--'}}</td>
                                    <td>{{$dewormer->product->name??'--'}}</td>
                                    <td>{{$dewormer->cattles->count()??'--'}}</td>
                                    <td>{{$dewormer->avg_cost??'--'}}</td>
                                    <td>{{$dewormer->total_cost??'--'}}</td>
                                    <td>{{__('global.'.$dewormer->status)}}</td>
                                    <td>{{date_format($dewormer->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        @can('dewormer_view')
                                            <a href="{{route('admin.dewormers.show',['dewormer'=>$dewormer->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                        @endcan
                                        @if($dewormer->status == 'pending')
                                        <form action="{{ route('admin.dewormers.destroy', $dewormer->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf

                                            @can('dewormer_update')
                                                <a href="{{route('admin.dewormers.edit',['dewormer'=>$dewormer->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('dewormer_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                            @can('dewormer_approve')
                                                <a href="{{route('admin.dewormers.approve',['dewormer'=>$dewormer->id])}}" class="btn btn-primary btn-sm px-1 py-0"><i class="fa fa-thumbs-up"></i></a>
                                            @endcan
                                        </form>
                                        @else
                                            <span class="btn btn-info px-1 py-0 btn-sm">Success</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.farm')}}</th>
                                <th>{{__('global.dewormer')}}</th>
                                <th>{{__('global.cattles')}}</th>
                                <th>{{__('global.average')}}</th>
                                <th>{{__('global.total_cost')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.updated_at')}}</th>
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
@section('plugins.Select2', true)


@section('css')

@stop

@section('js')

    <script>
        $(document).ready(function() {
            $('select').select2({
                theme:'classic',
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
                if (farm_id ) {
                    loadCattleProductList(farm_id);
                } else {
                    $('#tag_id').empty();
                    $('#product_id').empty();
                    $('#product_id').append($('<option>', {
                        value: '',
                        text: '{{ __('global.select_farm')}}'
                    }));
                }
            });
            $('#cattle_type_id').change(function() {
                var farm_id = $('#farm_id').val();
                if ( farm_id) {

                    loadCattleProductList(farm_id);
                } else {
                    $('#tag_id').empty();
                    $('#product_id').empty();
                    $('#product_id').append($('<option>', {
                        value: '',
                        text: '{{ __('global.select_farm')}}'
                    }));
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

        function loadCattleProductList(farm_id) {
            $.ajax({
                url: "{{ route('farm_dewormer_list') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}', // Add a CSRF token if needed
                    farm_id: farm_id ,// Send cattle_type_id as data
                },
                success: function(data) {
                    var productSelect = $('#product_id');
                    productSelect.empty();
                    productSelect.append($('<option>', {
                        value: '',
                        text: '{{__('global.select_medicine')}}'
                    }));
                    $.each(data, function(key, value) {
                        productSelect.append($('<option>', {
                            value: value.id,
                            text: value.name,
                        }));
                    });
                }
            });
        }

    </script>
@stop
