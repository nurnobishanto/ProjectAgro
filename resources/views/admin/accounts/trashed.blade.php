@extends('adminlte::page')

@section('title', __('global.accounts'). __('global.deleted'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.accounts'). __('global.deleted')}}</h1>
            @can('account_list')
                <a href="{{route('admin.accounts.index')}}" class="btn btn-primary mt-2">{{__('global.go_back')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.accounts')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('account_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="accountsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.admin')}}</th>
                                <th>{{__('global.bank_name')}}</th>
                                <th>{{__('global.account_name')}}</th>
                                <th>{{__('global.account_no')}}</th>
                                <th>{{__('global.account_type')}}</th>
                                <th>{{__('global.current_balance')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{$account->admin->name??'--'}}</td>
                                    <td>{{$account->bank_name}}</td>
                                    <td>{{$account->account_name}}</td>
                                    <td>{{$account->account_no}}</td>
                                    <td>{{__('global.'.$account->account_type)}}</td>
                                    <td>{{$account->current_balance}}</td>
                                    <td>{{__('global.'.$account->status)}}</td>
                                    <td class="text-center">
                                        @can('account_delete')
                                        <a href="{{route('admin.accounts.restore',['account'=>$account->id])}}"  class="btn btn-success btn-sm px-1 py-0"><i class="fa fa-arrow-left"></i></a>
                                        <a href="{{route('admin.accounts.force_delete',['account'=>$account->id])}}"  class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{__('global.admin')}}</th>
                                <th>{{__('global.bank_name')}}</th>
                                <th>{{__('global.account_name')}}</th>
                                <th>{{__('global.account_no')}}</th>
                                <th>{{__('global.account_type')}}</th>
                                <th>{{__('global.current_balance')}}</th>
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


        $(document).ready(function() {
            $("#accountsList").DataTable({
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
