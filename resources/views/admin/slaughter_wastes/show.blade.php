@extends('adminlte::page')

@section('title', __('global.view_slaughter_waste'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.view_slaughter_waste')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughter_wastes.index')}}">{{ __('global.slaughter_wastes')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.view_slaughter_waste')}}</li>
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

                        <h3>{{__('global.slaughter_waste_products')}}</h3>
                        <table class="table table-bordered">
                            <tr>
                                <th>{{__('global.unique_id')}}</th>
                                <td>{{$slaughter_waste->unique_id}}</td>
                                <th class="text-right">{{__('global.date')}}</th>
                                <td>{{$slaughter_waste->date}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.slaughter_store')}}</th>
                                <td>{{$slaughter_waste->slaughter_store->name??'--'}} - {{$slaughter_waste->slaughter_store->company??'--'}}</td>
                                <th class="text-right">{{__('global.created_at')}} & {{__('global.updated_at')}}</th>
                                <td>{{$slaughter_waste->createdBy->name??'--'}} & {{$slaughter_waste->updatedBy->name??'--'}}</td>
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
                            @foreach($slaughter_waste->products as $product)
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
                                <th colspan="2" class="text-right">{{__('global.total_quantity')}}</th>
                                <td>{{$slaughter_waste->products->sum('pivot.quantity')}}</td>
                                <th  class="text-right">{{__('global.sub_total')}}</th>
                                <td>{{$slaughter_waste->products->sum('pivot.sub_total')}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <a href="{{route('admin.slaughter_wastes.index')}}" class="btn btn-success mr-2" >Go Back</a>
                        @if($slaughter_waste->status === 'pending')
                            @can('slaughter_waste_delete')
                                <form action="{{ route('admin.slaughter_wastes.destroy', $slaughter_waste->id) }}" method="POST" id="deleteForm">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                <button id="deleteBtn" class="btn btn-danger mx-2"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('slaughter_waste_update')
                                <a href="{{route('admin.slaughter_wastes.edit',['slaughter_waste'=>$slaughter_waste->id])}}" class="btn btn-warning mx-2"><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('slaughter_waste_approve')
                                <form action="{{route('admin.slaughter_wastes.approve',['slaughter_waste'=>$slaughter_waste->id])}}" method="post" id="approveForm">
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
