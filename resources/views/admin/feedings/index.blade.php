@extends('adminlte::page')

@section('title', __('global.feedings'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.feedings')}}</h1>


        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.feedings')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.feedings.create')}}" method="GET">

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
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="feeding_group_id">{{ __('global.select_feeding_group')}}<span class="text-danger"> *</span></label>
                                    <select name="feeding_group_id" id="feeding_group_id" class="form-control select2">
                                        <option value="">{{ __('global.select_feeding_group')}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 align-self-end">
                                <div class="form-group">
                                    @can('feeding_create')
                                        <input type="submit" value="{{__('global.add_new')}}" class="btn btn-primary form-control">
                                    @endcan
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            @can('feeding_list')
                <div class="card">
                    <div class="card-header">
                        @can('feeding_delete')
                            <a href="{{route('admin.feedings.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
                        @endcan
                    </div>

                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.date')}}</th>
                                <th>{{__('global.farm')}}</th>
                                <th>{{__('global.feeding_group')}}</th>
                                <th>{{__('global.cattles')}}</th>
                                <th>{{__('global.items')}}</th>
                                <th>{{__('global.average')}}</th>
                                <th>{{__('global.total')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.updated_at')}}</th>
                                <th>{{__('global.action')}}</th>
                            </thead>
                            <tbody>
                            <?php $sl = 1; ?>
                            @foreach($feedings as $feeding)
                                <tr>

                                    <td>{{$sl++}}</td>
                                    <td>{{$feeding->date}}</td>
                                    <td>{{$feeding->feedingGroup->farm->name??'--'}}</td>
                                    <td>{{$feeding->feedingGroup->feeding_category->name??'--'}} {{$feeding->feedingGroup->feeding_moment->name??'--'}}</td>
                                    <td>{{$feeding->cattles->count()??'--'}}</td>
                                    <td>{{$feeding->products->count()??'--'}}</td>
                                    <td>{{$feeding->per_cattle_cost??0}}</td>
                                    <td>{{$feeding->total_cost??0}}</td>
                                    <td>{{__('global.'.$feeding->status)}}</td>
{{--                                    <td>{{date_format($feeding->updated_at,'d M y h:i A') }}</td>--}}
                                    <td class="text-center">
                                        @can('feeding_view')
                                            <a href="{{route('admin.feedings.show',['feeding'=>$feeding->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                        @endcan
                                        @if($feeding->status == 'pending')
                                        <form action="{{ route('admin.feedings.destroy', $feeding->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf

                                            @can('feeding_update')
                                                <a href="{{route('admin.feedings.edit',['feeding'=>$feeding->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('feeding_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                            @can('feeding_approve')
                                                <a href="{{route('admin.feedings.approve',['feeding'=>$feeding->id])}}" class="btn btn-primary btn-sm px-1 py-0"><i class="fa fa-thumbs-up"></i></a>
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
                                <th>{{__('global.feeding_group')}}</th>
                                <th>{{__('global.cattles')}}</th>
                                <th>{{__('global.items')}}</th>
                                <th>{{__('global.average')}}</th>
                                <th>{{__('global.total')}}</th>
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

            $.ajax({
                type: 'GET',
                url: '{{route('get_feeding_farms')}}', // Replace with your API URL
                dataType: 'json',
                success: function(data) {
                    // Clear and populate the second select with options
                    var farm = $('#farm_id');
                    farm.empty();
                    farm.append($('<option value="">{{__('global.select_farm')}}</option>'));
                    $.each(data, function(index, option) {
                        farm.append($('<option></option>').attr('value', option.farm_id).text(option.name));
                    });
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error(xhr.responseText);
                }
            });
            $('#farm_id').change(function() {
                var farm_id = $(this).val();
                if (farm_id) {
                    $.ajax({
                        type: 'GET',
                        url: '{{route('get_feeding_farms_cattle_types')}}', // Replace with your API URL
                        dataType: 'json',
                        data:{
                            farm_id : farm_id,
                        },
                        success: function(data) {
                            // Clear and populate the second select with options
                            var cattle_type = $('#cattle_type_id');
                            cattle_type.empty();
                            cattle_type.append($('<option value="">{{__('global.select_cattle_type')}}</option>'));
                            $.each(data, function(index, option) {
                                cattle_type.append($('<option></option>').attr('value', option.cattle_type_id).text(option.name));
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
            $('#cattle_type_id').change(function() {
                var farm_id = $('#farm_id').val();
                var cattle_type_id = $(this).val();
                if (cattle_type_id) {
                    $.ajax({
                        type: 'GET',
                        url: '{{route('get_feeding_group_period')}}', // Replace with your API URL
                        dataType: 'json',
                        data:{
                            farm_id : farm_id,
                            cattle_type_id : cattle_type_id,
                        },
                        success: function(data) {
                            // Clear and populate the second select with options
                            var cattle_type = $('#feeding_group_id');
                            cattle_type.empty();
                            cattle_type.append($('<option value="">{{__('global.select_feeding_group')}}</option>'));
                            $.each(data, function(index, option) {
                                cattle_type.append($('<option></option>').attr('value', option.id).text(option.name));
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            console.error(xhr.responseText);
                        }
                    });
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

        });

    </script>
@stop
