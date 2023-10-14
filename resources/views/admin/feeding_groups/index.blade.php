@extends('adminlte::page')

@section('title', __('global.feeding_groups'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.feeding_groups')}}</h1>
            @can('feeding_group_create')
                <a href="{{route('admin.feeding-groups.create')}}" class="btn btn-primary mt-2">{{__('global.add_new')}}</a>
            @endcan
            @can('feeding_group_delete')
                <a href="{{route('admin.feeding-groups.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.feeding_groups')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('feeding_group_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.farm')}}</th>
                                <th>{{__('global.cattle_type')}}</th>
                                <th>{{__('global.feeding_category')}}</th>
                                <th>{{__('global.feeding_moment')}}</th>
                                <th>{{__('global.items')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.updated_at')}}</th>
                                <th>{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = 1; ?>
                            @foreach($feeding_groups as $feeding_group)
                                <tr>

                                    <td>{{$sl++}}</td>
                                    <td>{{$feeding_group->farm->name??'--'}}</td>
                                    <td>{{$feeding_group->cattle_type->title??'--'}}</td>
                                    <td>{{$feeding_group->feeding_category->name??'--'}}</td>
                                    <td>{{$feeding_group->feeding_moment->name??'--'}}</td>
                                    <td>{{$feeding_group->products->count()??'--'}}</td>
                                    <td>{{__('global.'.$feeding_group->status)}}</td>
                                    <td>{{date_format($feeding_group->updated_at,'d M y h:i A') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.feeding-groups.destroy', $feeding_group->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('feeding_group_view')
                                                <a href="{{route('admin.feeding-groups.show',['feeding_group'=>$feeding_group->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('feeding_group_update')
                                                <a href="{{route('admin.feeding-groups.edit',['feeding_group'=>$feeding_group->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('feeding_group_delete')
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
                                <th>{{__('global.farm')}}</th>
                                <th>{{__('global.cattle_type')}}</th>
                                <th>{{__('global.feeding_category')}}</th>
                                <th>{{__('global.feeding_moment')}}</th>
                                <th>{{__('global.items')}}</th>
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
