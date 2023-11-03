@extends('adminlte::page')

@section('title', __('global.view_slaughter_sale'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.view_slaughter_sale')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughter_sales.index')}}">{{ __('global.slaughter_sales')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.view_slaughter_sale')}}</li>
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
                                <th>{{__('global.created_at')}}</th>
                                <td>{{$slaughter_sale->createdBy->name??'--'}}</td>
                                <th>{{__('global.updated_at')}}</th>
                                <td>{{$slaughter_sale->updatedBy->name??'--'}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <h3>{{__('global.slaughter_sale_products')}}</h3>
                        <table class="table table-bordered">
                            <tr>
                                <th>{{__('global.unique_id')}}</th>
                                <td>{{$slaughter_sale->unique_id}}</td>
                                <th class="text-right">{{__('global.date')}}</th>
                                <td>{{$slaughter_sale->date}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.slaughter_store')}}</th>
                                <td>{{$slaughter_sale->slaughter_store->name??'--'}} - {{$slaughter_sale->slaughter_store->company??'--'}}</td>
                                <th class="text-right">{{__('global.slaughter_customer')}}</th>
                                <td>{{$slaughter_sale->slaughter_customer->name??'--'}} - {{$slaughter_sale->slaughter_customer->company??'--'}} </td>
                            </tr>
                        </table>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="50px">{{__('global.sl')}}</th>
                                <th>{{__('global.product')}}</th>
                                <th width="100px">{{__('global.quantity')}}</th>
                                <th width="100px">{{__('global.unit_price')}}</th>
                                <th width="100px">{{__('global.total')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $sl = 1 @endphp
                            @foreach($slaughter_sale->products as $product)
                            <tr>
                                <td>{{$sl++}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->pivot->quantity}} <sup> {{$product->unit->code??'--'}} </sup></td>
                                <td>{{$product->pivot->unit_price}}</td>
                                <td>{{$product->pivot->sub_total}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tbody>
                            <tr>
                                <th colspan="4" class="text-right">{{__('global.sub_total')}}</th>
                                <td>{{$slaughter_sale->total}}</td>
                            </tr>
                            <tr class="text-info">
                                <th colspan="4" class="text-right">{{__('global.tax')}}</th>
                                @php $taxAmount = ($slaughter_sale->tax / 100) * $slaughter_sale->total; @endphp
                                <td>+ {{$taxAmount}} ({{$slaughter_sale->tax}}%)</td>
                            </tr>
                            <tr class="text-danger">
                                <th colspan="4" class="text-right">{{__('global.discount')}}</th>
                                <td>- {{$slaughter_sale->discount}}</td>
                            </tr>
                            <tr class="text-primary">
                                <th colspan="4" class="text-right">{{__('global.grand_total')}}</th>
                                <td>{{$slaughter_sale->grand_total}}</td>
                            </tr>
                            <tr class="text-dark">
                                <th colspan="4" class="text-right">{{__('global.paid')}}</th>
                                <td>- {{$slaughter_sale->paid}}</td>
                            </tr>
                            <tr class="text-dark">
                                <th colspan="4" class="text-right">{{__('global.due')}}</th>
                                <td>{{$slaughter_sale->due}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <a href="{{route('admin.slaughter_sales.index')}}" class="btn btn-success mr-2" >Go Back</a>
                        @if($slaughter_sale->status === 'pending')
                            @can('slaughter_sale_delete')
                                <form action="{{ route('admin.slaughter_sales.destroy', $slaughter_sale->id) }}" method="POST" id="deleteForm">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                <button id="deleteBtn" class="btn btn-danger mx-2"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('slaughter_sale_update')
                                <a href="{{route('admin.slaughter_sales.edit',['slaughter_sale'=>$slaughter_sale->id])}}" class="btn btn-warning mx-2"><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('slaughter_sale_approve')
                                <form action="{{route('admin.slaughter_sales.approve',['slaughter_sale'=>$slaughter_sale->id])}}" method="post" id="approveForm">
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
