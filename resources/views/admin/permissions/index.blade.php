@extends('adminlte::page')

@section('title', __('menu.permissions'))

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{__('menu.permissions')}}</h1>
        @can('permission_create')
            <a href="{{route('admin.permissions.create')}}" class="btn btn-primary mt-2">{{__('global.add_new')}}</a>
        @endcan

    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('menu.permissions')}}</li>
        </ol>

    </div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('permission_list')
                <div class="card">

                    <div class="card-body table-responsive">

                        <table id="permissionsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>

                                <th>{{__('menu.permissions')}}</th>
                                <th>{{__('global.guard')}}</th>
                                <th>{{__('global.group')}}</th>
                                <th>{{__('menu.roles')}}</th>
                                <th width="80px">{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>

                                    <td class="text-capitalize">{{$permission->name}}</td>
                                    <td class="text-capitalize">{{$permission->guard_name}} </td>
                                    <td class="text-capitalize">{{$permission->group_name}} </td>
                                    <th>
                                        @foreach($permission->roles as $role)
                                            <span class="badge badge-secondary text-capitalize">{{$role->name}}</span>
                                        @endforeach
                                    </th>
                                    <td>
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('permission_view')
                                                <a href="{{route('admin.permissions.show',['permission'=>$permission->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('permission_update')
                                                <a href="{{route('admin.permissions.edit',['permission'=>$permission->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('permission_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>

                                <th>{{__('menu.permissions')}}</th>
                                <th>{{__('global.guard')}}</th>
                                <th>{{__('global.group')}}</th>
                                <th>{{__('menu.roles')}}</th>
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
            $("#permissionsList").DataTable({
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
