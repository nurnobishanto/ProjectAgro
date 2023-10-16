@extends('adminlte::page')

@section('title', __('global.fattenings'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.fattenings')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.fattenings')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('fattening_create')
                <div class=" card card-body">
                    <form action="{{route('admin.fattenings.create')}}" method="get">
                        @csrf
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
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group ">
                                    <label for="farm_id">{{ __('global.select_farm')}}<span class="text-danger"> *</span></label>
                                    <select id="farm_id" name="farm_id" class="form-control">
                                        <option value="">{{ __('global.select_farm')}}</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="cattle_type_id">{{ __('global.select_cattle_type')}}<span class="text-danger"> *</span></label>
                                    <select id="cattle_type_id" name="cattle_type_id" class="form-control">
                                        <option value="">{{ __('global.select_cattle_type')}}</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="tag_id">{{ __('global.select_tag_id')}}<span class="text-danger"> *</span></label>
                                    <select id="tag_id" name="tag_id" class="form-control">
                                        <option value="">{{ __('global.select_tag_id')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <input type="submit" value="Submit" class="btn btn-primary mt-4">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endcan
        </div>
        <div class="col-12">
            @can('fattening_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="fatteningsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="10px">{{__('global.sl')}}</th>
                                <th width="20px">{{__('global.date')}}</th>
                                <th width="100px">{{__('global.photo')}}</th>
                                <th width="50px">{{__('global.tag_id')}}</th>
                                <th>{{__('global.information')}}</th>
                                <th width="20px">{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php $sl = 1 @endphp
                            @foreach($fattenings as $fattening)
                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td>{{$fattening->date}}</td>
                                    <td><img src="{{asset('uploads/'.$fattening->cattle->image)}}" class="img-thumbnail" style="max-height: 100px"></td>
                                    <td>{{$fattening->cattle->tag_id}}</td>
                                    <td>
                                        {{__('global.weight').' : '.$fattening->weight.' '.__('global.kg')}} | {{__('global.health').' : '.$fattening->health}}<br>
                                        {{__('global.height').' : '.$fattening->height.' '.__('global.inch')}} | {{__('global.width').' : '.$fattening->width.' '.__('global.inch')}} INCH<br>
                                        {{__('global.color').' : '.$fattening->color}} | {{__('global.foot').' : '.$fattening->foot}}<br>
                                    </td>

                                    <td class="text-center">
                                        <form action="{{ route('admin.fattenings.destroy', $fattening->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('fattening_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan

                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.photo')}}</th>
                                <th>{{__('global.tag_id')}}</th>
                                <th>{{__('global.information')}}</th>
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
@section('plugins.Select2', true)
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
            $('select').select2({
                theme:'classic',
            });
            $("#fatteningsList").DataTable({
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
