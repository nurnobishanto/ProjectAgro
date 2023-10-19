@extends('adminlte::page')

@section('title', __('global.treatments'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.treatments')}}</h1>


        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.treatments')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.treatments.create')}}" method="GET">

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
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="farm_id">{{__('global.select_farm')}} <span class="text-danger"> *</span></label>
                                    <select class="select2 form-control" name="farm_id" id="farm_id">
                                        <option value="">{{__('global.select_farm')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="cattle_type_id">{{ __('global.select_cattle_type')}}<span class="text-danger"> *</span></label>
                                    <select name="cattle_type_id" id="cattle_type_id" class="form-control select2">
                                        <option value="">{{ __('global.select_cattle_type')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="tag_id">{{ __('global.select_tag_id')}}<span class="text-danger"> *</span></label>
                                    <select name="tag_id" id="tag_id" class="form-control select2">
                                        <option value="">{{ __('global.select_tag_id')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-9 col-sm-12">
                                <div class="form-group">
                                    <label for="product_id">{{ __('global.select_product')}}<span class="text-danger"> *</span></label>
                                    <select name="products[]" id="product_id" class="form-control select2" multiple>
                                        <option value="">{{ __('global.select_product')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6">
                                <div class="form-group">
                                    @can('treatment_create')
                                        <input type="submit" value="{{__('global.add_new')}}" class="btn btn-primary form-control mt-md-4">
                                    @endcan
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            @can('treatment_list')
                <div class="card">
                    <div class="card-header">
                        @can('treatment_delete')
                            <a href="{{route('admin.treatments.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
                        @endcan
                    </div>

                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.farm')}}</th>
                                <th>{{__('global.tag_id')}}</th>
                                <th>{{__('global.medicine')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.updated_at')}}</th>
                                <th>{{__('global.action')}}</th>
                            </thead>
                            <tbody>
                            <?php $sl = 1; ?>
                            @foreach($treatments as $treatment)
                                <tr>

                                    <td>{{$sl++}}</td>
                                    <td>{{$treatment->date}}</td>
                                    <td>{{$treatment->farm->name??'--'}}</td>
                                    <td>{{$treatment->cattle->tag_id??'--'}}</td>
                                    <td>{{$treatment->products->count()??'--'}}</td>
                                    <td>{{__('global.'.$treatment->status)}}</td>
                                    <td>{{date_format($treatment->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        @can('treatment_view')
                                            <a href="{{route('admin.treatments.show',['treatment'=>$treatment->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                        @endcan
                                        @if($treatment->status == 'pending')
                                        <form action="{{ route('admin.treatments.destroy', $treatment->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf

                                            @can('treatment_update')
                                                <a href="{{route('admin.treatments.edit',['treatment'=>$treatment->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('treatment_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                            @can('treatment_approve')
                                                <a href="{{route('admin.treatments.approve',['treatment'=>$treatment->id])}}" class="btn btn-primary btn-sm px-1 py-0"><i class="fa fa-thumbs-up"></i></a>
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
                                <th>{{__('global.cattle_id')}}</th>
                                <th>{{__('global.medicine')}}</th>
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
                var cattle_type_id = $('#cattle_type_id').val();
                if (farm_id || cattle_type_id) {
                    loadCattleList(farm_id,cattle_type_id);
                    loadCattleProductList(farm_id,cattle_type_id);
                } else {
                    $('#tag_id').empty();
                    $('#product_id').empty();
                }
            });
            $('#cattle_type_id').change(function() {
                var cattle_type_id = $(this).val();
                var farm_id = $('#farm_id').val();
                if (cattle_type_id || farm_id) {
                    loadCattleList(farm_id,cattle_type_id);
                    loadCattleProductList(farm_id,cattle_type_id);
                } else {
                    $('#tag_id').empty();
                    $('#product_id').empty();
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
        function loadCattleProductList(farm_id,cattle_type_id) {
            $.ajax({
                url: "{{ route('farm_medicine_list') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}', // Add a CSRF token if needed
                    farm_id: farm_id ,// Send cattle_type_id as data
                    cattle_type_id: cattle_type_id ,// Send cattle_type_id as data
                },
                success: function(data) {
                    var productSelect = $('#product_id');
                    productSelect.empty();
                    productSelect.append($('<option>', {
                        value: '',
                        text: '{{__('global.select_product')}}'
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
