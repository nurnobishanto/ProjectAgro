@extends('adminlte::page')

@section('title', __('global.update_milk_sale'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_milk_sale')}}</h1>
            <p>{{__('global.milk_store')}} : {{$milk_sale->milk_store->name??'--'}} {{$milk_sale->milk_store->company??'--'}}</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.milk-sales.index')}}">{{ __('global.milk_sales')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_milk_sale')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.milk-sales.update',['milk_sale'=>$milk_sale->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger">*</span></label>
                                            <input id="unique_id" name="unique_id" value="{{$milk_sale->unique_id}}" class="form-control" placeholder="{{ __('global.unique_id')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="date">{{ __('global.date')}}<span class="text-danger">*</span></label>
                                            <input id="date" name="date" value="{{$milk_sale->date}}" type="text" class="datepicker form-control" placeholder="{{ __('global.date')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="tax">{{ __('global.tax')}}<span class="text-danger">*</span></label>
                                            <select name="tax" class="select2 form-control" id="tax">
                                                <option value="0" @if(0 == $milk_sale->tax) selected @endif>{{__('global.no_tax')}} 0</option>
                                                @foreach(getTax() as $tax)
                                                    <option value="{{ $tax->tax }}" @if($tax->tax  == $milk_sale->tax) selected @endif>{{ $tax->name }} ({{$tax->tax}} %)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="milk_sale_party_id">{{ __('global.select_milk_sale_party')}}<span class="text-danger">*</span></label>
                                            <select name="milk_sale_party_id" class="select2 form-control" id="milk_sale_party_id">
                                                <option value="">{{__('global.select_milk_sale_party')}}</option>
                                                @foreach(getMilkSaleParty() as $customer)
                                                    <option value="{{ $customer->id }}" @if($customer->id == $milk_sale->milk_sale_party_id) selected @endif>{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="account_id">{{ __('global.select_account')}}<span class="text-danger"> *</span></label>
                                            <select id="account_id" name="account_id" class="select2 form-control">
                                                <option value="">{{ __('global.select_account')}}</option>
                                                @foreach(getAccountList() as $account)
                                                    <option value="{{$account->id}}" @if($account->id  == $milk_sale->account_id) selected @endif>{{$account->account_name}} {{$account->account_no}} {{$account->admin->name??'--'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="quantity" class="form-label">{{__('global.milk_quantity')}} ({{__('global.ltr')}})<span class="text-danger"> *</span></label>
                                            <input  id="quantity" type="number" value="{{$milk_sale->quantity}}" step="any" max="{{$stock->quantity??0}}" min="0.0001"  class="form-control" name="quantity" placeholder="{{__('global.milk_quantity')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="unit_price" class="form-label">{{__('global.unit_price')}}<span class="text-danger"> *</span></label>
                                            <input  id="unit_price" value="{{$milk_sale->unit_price}}" type="number" step="any" class="form-control" name="unit_price" placeholder="{{__('global.unit_price')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="paid_amount" class="form-label">{{__('global.paid_amount')}}</label>
                                            <input  id="paid_amount" value="{{$milk_sale->paid}}" type="number" step="any"  class="form-control" name="paid_amount" placeholder="{{__('global.paid_amount')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="discount" class="form-label">{{__('global.discount')}}</label>
                                            <input  id="discount" value="{{$milk_sale->discount}}" type="number"  class="form-control" name="discount" placeholder="{{__('global.discount')}}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="note">{{ __('global.note')}}</label>
                                            <textarea id="note" name="note" class="form-control" placeholder="{{ __('global.enter_note')}}">{{$milk_sale->note}}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.sub_total')}}</h5>
                                                <input type="text" class="form-control" disabled  id="sub_total" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.tax')}}</h5>
                                                <input type="text" class="form-control" disabled  id="vat" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.discount')}}</h5>
                                                <input type="text" class="form-control" disabled  id="dis" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.total')}}</h5>
                                                <input type="text" class="form-control" disabled  id="total" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.paid')}}</h5>
                                                <input type="text" class="form-control" disabled  id="paid" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card card-danger">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.due_amount')}}</h5>
                                                <input type="text" class="form-control" disabled  id="due" value="0">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                        @can('milk_sale_update')
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
@section('plugins.Sweetalert2',true)
@section('plugins.Summernote',true)
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
            $('#discount, #paid_amount, #labor_cost, #shipping_cost, #tax_id, #other_cost, #quantity, #unit_price').on('input', function () {
                updateTotal();
            });
            $('#tax').change(function (){
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

                var $tax = $('#tax');
                var $paidAmount = $('#paid_amount');
                var $discount = $('#discount');
                var $subTotal = $('#sub_total');
                var $qty = $('#quantity');
                var $unit_price = $('#unit_price');
                var $paid = $('#paid');
                var $dis = $('#dis');
                var $total = $('#total');
                var $due = $('#due');
                var $vat = $('#vat');
                var qtyValue = parseFloat($qty.val());
                var upValue = parseFloat($unit_price.val());

                qtyValue = isNaN(qtyValue) ? 0 : qtyValue;
                upValue = isNaN(upValue) ? 0 : upValue;
                var subTotal = qtyValue * upValue;
                $subTotal.val(subTotal);

                var taxValue = parseFloat($tax.val());
                var discountValue = parseFloat($discount.val());
                var paidAmountValue = parseFloat($paidAmount.val());

                // Check if values are NaN and replace with 0 if necessary

                taxValue = isNaN(taxValue) ? 0 : taxValue;
                discountValue = isNaN(discountValue) ? 0 : discountValue;
                paidAmountValue = isNaN(paidAmountValue) ? 0 : paidAmountValue;
                var taxAmount = subTotal*(taxValue/100);


                $dis.val(discountValue);
                $paid.val(paidAmountValue);

                var totalValue = subTotal  + taxAmount - discountValue;
                $total.val(totalValue);

                var dueValue = totalValue - paidAmountValue;
                $due.val(dueValue);
                $vat.val(taxAmount);
            }
        });
    </script>

@stop
