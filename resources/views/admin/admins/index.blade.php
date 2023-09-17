@extends('adminlte::page')

@section('title', __('global.admins'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.admins')}}</h1>
            @can('admin_create')
                <a href="{{route('admin.admins.create')}}" class="btn btn-primary mt-2">{{__('global.add_new')}}</a>
            @endcan
            @can('admin_delete')
                <a href="{{route('admin.admins.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.admins')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('admin_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="18%">{{__('global.photo')}}</th>
                                <th width="25%">{{__('global.name')}}</th>
                                <th width="20%">{{__('global.email')}}</th>
                                <th width="15%">{{__('menu.roles')}}</th>
                                <th width="7%">{{__('global.status')}}</th>
                                <th width="15%">{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>

                                    <td>
                                        <img class="rounded border" width="100px" src="{{asset('uploads/'.$admin->photo)}}" alt="{{$admin->name}}">
                                    </td>
                                    <td>{{$admin->name}}</td>
                                    <td>{{$admin->email}}</td>
                                    <td>
                                        @foreach($admin->roles as $role)
                                            <a class="badge badge-success text-capitalize">{{$role->name}}</a>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($admin->status=='active') <span class="badge-success badge">Active</span>
                                        @else <span class="badge-danger badge">Deactivate</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('admin_view')
                                                <a href="{{route('admin.admins.show',['admin'=>$admin->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('admin_update')
                                                <a href="{{route('admin.admins.edit',['admin'=>$admin->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('admin_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan

                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{__('global.photo')}}</th>
                                <th>{{__('global.name')}}</th>
                                <th>{{__('global.email')}}</th>
                                <th>{{__('menu.roles')}}</th>
                                <th>{{__('global.status')}}</th>
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
