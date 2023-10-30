@extends('adminlte::page')

@section('title', __('global.view_cattle_sale'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_cattle_sale')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.cattle-sales.index')}}">{{__('global.cattle_sales')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_cattle_sale')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="250px">{{ __('global.farm')}}</th>
                                <td>{{$cattle->farm->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th width="250px">{{ __('global.cattle_type')}}</th>
                                <td>{{$cattle->cattle_type->title??'--'}}</td>
                            </tr>
                            <tr>
                                <th width="250px">{{ __('global.tag_id')}}</th>
                                <td>{{$cattle_sale->cattle->tag_id??'--'}}</td>
                            </tr>
                            <tr>
                                <th width="250px">{{ __('global.unique_id')}}</th>
                                <td>{{$cattle_sale->unique_id??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.date')}}</th>
                                <td>{{__('global.'.$cattle_sale->date)}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.party')}}</th>
                                <td>{{$cattle_sale->party->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.amount')}}</th>
                                <td>{{$cattle_sale->amount}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.account')}}</th>
                                <td>{{$cattle_sale->account->account_name}} {{$cattle_sale->account->account_no}} {{$cattle_sale->account->admin->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.paid')}}</th>
                                <td>{{$cattle_sale->paid}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.due')}}</th>
                                <td>{{$cattle_sale->due}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.expense')}}</th>
                                <td>{{$cattle_sale->expense}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.note')}}</th>
                                <td>{{$cattle_sale->note}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.status')}}</th>
                                <td>{{$cattle_sale->status}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.created_at')}}</th>
                                <td>{{$cattle_sale->createdBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($cattle_sale->created_at))}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.updated_at')}}</th>
                                <td>{{$cattle_sale->updatedBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($cattle_sale->updated_at))}}</td>
                            </tr>
                        </table>
                    </div>
                        <form action="{{ route('admin.cattle-sales.destroy', $cattle_sale->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.cattle-sales.index')}}" class="btn btn-success" >Go Back</a>
                            @if($cattle_sale->status == 'pending')
                                @can('cattle_sale_update')
                                    <a href="{{route('admin.cattle-sales.edit',['cattle_sale'=>$cattle_sale->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                                @can('cattle_sale_delete')
                                    <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                @endcan
                                @can('cattle_sale_approve')
                                    <a href="{{route('admin.cattle-sales.approve',['cattle_sale'=>$cattle_sale->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
                                @endcan
                            @endif
                        </form>

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
@section('plugins.toastr',true)
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

        });
    </script>
@stop
