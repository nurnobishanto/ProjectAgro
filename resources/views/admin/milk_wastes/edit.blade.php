@extends('adminlte::page')

@section('title', __('global.update_milk_waste'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_milk_waste')}}</h1>
            <p>{{__('global.milk_store')}} : {{$milk_waste->farm->name??'--'}} </p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.milk-wastes.index')}}">{{ __('global.milk_wastes')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_milk_waste')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.milk-wastes.update',['milk_waste'=>$milk_waste->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @method('PUT')
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
                            <div class="col-md-8 col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger">*</span></label>
                                            <input id="unique_id" name="unique_id" value="{{$milk_waste->unique_id}}" class="form-control" placeholder="{{ __('global.unique_id')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="date">{{ __('global.date')}}<span class="text-danger">*</span></label>
                                            <input id="date" name="date" value="{{$milk_waste->date}}" type="text" class="datepicker form-control" placeholder="{{ __('global.date')}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="quantity" class="form-label">{{__('global.milk_quantity')}} ({{__('global.ltr')}})<span class="text-danger"> *</span></label>
                                            <input  id="quantity" type="number" value="{{$milk_waste->quantity}}" step="any" max="{{$stock->quantity??0}}" min="0.0001"  class="form-control" name="quantity" placeholder="{{__('global.milk_quantity')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="unit_price" class="form-label">{{__('global.unit_price')}}<span class="text-danger"> *</span></label>
                                            <input  id="unit_price" value="{{$milk_waste->unit_price}}" type="number" step="any" class="form-control" name="unit_price" placeholder="{{__('global.unit_price')}}">
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="note">{{ __('global.note')}}</label>
                                            <textarea id="note" name="note" class="form-control" placeholder="{{ __('global.enter_note')}}">{{$milk_waste->note}}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.total')}}</h5>
                                                <input type="text" class="form-control" disabled  id="total" value="0">
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>

                        @can('milk_waste_update')
                            <button class="btn btn-success" type="submit">{{ __('global.update')}}</button>
                        @endcan
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
@section('plugins.Select2',true)
@section('plugins.Summernote',true)
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
            $('.select2').select2({
                theme:'classic'
            });
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false
            });
            $(' #quantity, #unit_price').on('input', function () {
                updateTotal();
            });

            updateTotal();
            $('#quantity').on('input', function () {
                // Check if the entered value exceeds the maximum allowed value
                var enteredValue = parseFloat($(this).val());
                var maxValue = parseFloat($(this).attr('max'));
                if (enteredValue > maxValue) {
                    $(this).val(maxValue);
                    showMaxQuantityAlert(maxValue);
                }
            });
            function showMaxQuantityAlert(max) {
                Swal.fire({
                    icon: 'warning',
                    title: '{{__('global.quantity_exceeds_maximum')}}',
                    text: `{{__('global.maximum_allowed_quantity_is')}} ${max}.`,
                    confirmButtonText: '{{__('global.ok')}}',
                });
            }
            function updateTotal() {

                var $qty = $('#quantity');
                var $unit_price = $('#unit_price');
                var $total = $('#total');

                var qtyValue = parseFloat($qty.val());
                var upValue = parseFloat($unit_price.val());

                qtyValue = isNaN(qtyValue) ? 0 : qtyValue;
                upValue = isNaN(upValue) ? 0 : upValue;
                var totalValue = qtyValue * upValue;

                $total.val(totalValue);

            }
        });
    </script>

@stop
