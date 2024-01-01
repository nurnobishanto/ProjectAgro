@extends('adminlte::page')

@section('title', __('global.view_milk_sale'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.view_milk_sale')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.milk-sales.index')}}">{{ __('global.milk_sales')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.view_milk_sale')}}</li>
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

                            <tbody>

                            <tr>
                                <th>{{__('global.unique_id')}}</th>
                                <td>{{$milk_sale->unique_id}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.date')}}</th>
                                <td>{{$milk_sale->date}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.farm')}}</th>
                                <td>{{$milk_sale->farm->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.milk_sale_party')}}</th>
                                <td>{{$milk_sale->milkSaleParty->name??'--'}} - {{$milk_sale->milkSaleParty->company??'--'}} </td>
                            </tr>
                            <tr>
                                <th>{{__('global.account')}}</th>
                                <td>{{$milk_sale->account->bank_name??'--'}} - {{$milk_sale->account->account_name??'--'}} ({{$milk_sale->account->account_no??'--'}})</td>
                            </tr>
                            <tr>
                                <th>{{__('global.created_at')}}</th>
                                <td>{{$milk_sale->createdBy->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.updated_at')}}</th>
                                <td>{{$milk_sale->updatedBy->name??'--'}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="100px">{{__('global.quantity')}}</th>
                                <th width="100px">{{__('global.unit_price')}}</th>
                                <th width="100px">{{__('global.total')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <td>{{$milk_sale->quantity}}  {{__('global.ltr')}}</td>
                                <td>{{getSetting('currency')}} {{$milk_sale->unit_price}}</td>
                                <td>{{getSetting('currency')}} {{$milk_sale->sub_total}}</td>
                            </tr>
                            </tbody>
                            <tbody>
                            <tr class="text-info">
                                <th colspan="2" class="text-right">{{__('global.tax')}}</th>
                                @php $taxAmount = ($milk_sale->tax / 100) * $milk_sale->sub_total; @endphp
                                <td>+ {{getSetting('currency')}} {{$taxAmount}} ({{$milk_sale->tax}}%)</td>
                            </tr>
                            <tr class="text-danger">
                                <th colspan="2" class="text-right">{{__('global.discount')}}</th>
                                <td>- {{getSetting('currency')}} {{$milk_sale->discount}}</td>
                            </tr>
                            <tr class="text-primary">
                                <th colspan="2" class="text-right">{{__('global.total')}}</th>
                                <td>{{getSetting('currency')}} {{$milk_sale->total}}</td>
                            </tr>
                            <tr class="text-dark">
                                <th colspan="2" class="text-right">{{__('global.paid')}}</th>
                                <td>- {{getSetting('currency')}} {{$milk_sale->paid}}</td>
                            </tr>
                            <tr class="text-dark">
                                <th colspan="2" class="text-right">{{__('global.due')}}</th>
                                <td>{{getSetting('currency')}} {{$milk_sale->due}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <a href="{{route('admin.milk-sales.index')}}" class="btn btn-success mr-2" >Go Back</a>
                        @if($milk_sale->status === 'pending')
                            @can('milk_sale_delete')
                                <form action="{{ route('admin.milk-sales.destroy', $milk_sale->id) }}" method="POST" id="deleteForm">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                <button id="deleteBtn" class="btn btn-danger mx-2"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('milk_sale_update')
                                <a href="{{route('admin.milk-sales.edit',['milk_sale'=>$milk_sale->id])}}" class="btn btn-warning mx-2"><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('milk_sale_approve')
                                <form action="{{route('admin.milk-sales.approve',['milk_sale'=>$milk_sale->id])}}" method="post" id="approveForm">
                                    @csrf

                                </form>
                                <button id="approveFormBtn" class="btn btn-primary mx-2"><i class="fa fa-ar"></i> Approve</button>
                            @endcan
                        @endif
                        </div>
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
@section('plugins.Sweetalert2',true)
@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            color: black;
        }
        .select2{
            max-width: 100%!important;
        }
        .input-qty{
            width: 60px;
        }
        .input-price{
            width: 80px;
        }
    </style>
@stop

@section('js')

    <script>
        $(document).ready(function () {

            $('#approveFormBtn').click(function (){
                var form = $('#approveForm');
                Swal.fire({
                    title: '{{__('global.approveConfirmTitle')}}',
                    text: '{{__('global.approveConfirmText')}}',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: '{{__('global.approveConfirmButtonText') }}',
                    cancelButtonText: '{{__('global.approveCancelButton') }}',
                }).then((result) => {
                    console.log(result)
                    if (result.value) {
                        form.submit();
                    }
                });
            });
            $('#deleteBtn').click(function (){
                var form = $('#deleteForm');
                Swal.fire({
                    title: '{{__('global.deleteConfirmTitle')}}',
                    text: '{{__('global.deleteConfirmText')}}',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: '{{__('global.deleteConfirmButtonText') }}',
                    cancelButtonText: '{{__('global.deleteCancelButton') }}',
                }).then((result) => {
                    console.log(result)
                    if (result.value) {
                        form.submit();
                    }
                });
            });

        });
    </script>

@stop
