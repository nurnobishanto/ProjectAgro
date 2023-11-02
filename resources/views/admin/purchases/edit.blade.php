@extends('adminlte::page')

@section('title', __('global.update_purchase'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_purchase')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.purchases.index')}}">{{ __('global.purchases')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_purchase')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.purchases.update',['purchase'=>$purchase->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                            <label for="invoice_no">{{ __('global.invoice_no')}}<span class="text-danger">*</span></label>
                                            <input id="invoice_no" name="invoice_no" value="{{$purchase->invoice_no}}" class="form-control" placeholder="{{ __('global.invoice_no')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="purchase_date">{{ __('global.purchase_date')}}<span class="text-danger">*</span></label>
                                            <input id="purchase_date" name="purchase_date" value="{{$purchase->purchase_date}}" type="text" class="datepicker form-control" placeholder="{{ __('global.purchase_date')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="supplier_id">{{ __('global.select_supplier')}}<span class="text-danger">*</span></label>
                                            <select name="supplier_id" class="select2 form-control" id="supplier_id">
                                                <option value="">{{__('global.select_supplier')}}</option>
                                                @foreach(getSuppliers() as $supplier)
                                                    <option value="{{ $supplier->id }}" @if($supplier->id === $purchase->supplier_id) selected @endif>{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="farm_id">{{ __('global.select_farm')}}<span class="text-danger">*</span></label>
                                            <select name="farm_id" class="select2 form-control" id="farm_id">
                                                <option value="">{{__('global.select_farm')}}</option>
                                                @foreach(getFarms() as $farm)
                                                    <option value="{{ $farm->id }}" @if($farm->id === $purchase->farm_id) selected @endif>{{ $farm->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                      <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="tax">{{ __('global.tax')}}<span class="text-danger">*</span></label>
                                            <select name="tax" class="select2 form-control" id="tax">
                                                <option value="0" @if(0 === $purchase->tax) selected @endif>{{__('global.no_tax')}} 0</option>
                                                @foreach(getTax() as $tax)
                                                    <option value="{{ $tax->tax }}" @if($tax->tax  === $purchase->tax) selected @endif>{{ $tax->name }} ({{$tax->tax}} %)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="account_id">{{ __('global.select_account')}}<span class="text-danger"> *</span></label>
                                            <select id="account_id" name="account_id" class="select2 form-control">
                                                <option value="">{{ __('global.select_account')}}</option>
                                                @foreach(getAccountList() as $account)
                                                    <option value="{{$account->id}}" @if($account->id  === $purchase->account_id) selected @endif>{{$account->account_name}} {{$account->account_no}} {{$account->admin->name??'--'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="paid_amount" class="form-label">{{__('global.paid_amount')}}</label>
                                            <input  id="paid_amount" value="{{$purchase->paid}}" type="number"  class="form-control" name="paid_amount" placeholder="{{__('global.paid_amount')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="discount" class="form-label">{{__('global.discount')}}</label>
                                            <input  id="discount" value="{{$purchase->discount}}" type="number"  class="form-control" name="discount" placeholder="{{__('global.discount')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="shipping_cost" class="form-label">{{__('global.shipping_cost')}}</label>
                                            <input  id="shipping_cost" value="{{$purchase->shipping_cost}}" type="number" class="form-control" name="shipping_cost" placeholder="{{__('global.shipping_cost')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="labor_cost" class="form-label">{{__('global.labor_cost')}}</label>
                                            <input  id="labor_cost" value="{{$purchase->labor_cost}}" type="number"  class="form-control" name="labor_cost" placeholder="{{__('global.labor_cost')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="other_cost" class="form-label">{{__('global.other_cost')}}</label>
                                            <input  id="other_cost" value="{{$purchase->other_cost}}" type="number" class="form-control" name="other_cost" placeholder="{{__('global.other_cost')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="image" class="form-label">{{__('global.image')}} <button type="button" class="btn badge badge-info" data-toggle="modal" data-target="#previewModal"> <i class="fas fa-eye"> </i> </button></label>
                                            <input id="image" type="file" class="form-control" name="image">

                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewModalLabel">{{__('global.see_image')}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="{{asset('uploads/'.$purchase->image)}}" class="img-fluid" >
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="purchase_note">{{ __('global.purchase_note')}}</label>
                                            <textarea id="purchase_note" name="purchase_note" class="form-control" placeholder="{{ __('global.enter_purchase_note')}}">{{$purchase->purchase_note}}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="product">{{__('global.select_products')}}<span class="text-danger">*</span></label>
                                    <select name="" class="select2 form-control" id="product">
                                        <option value="">{{__('global.select_products')}}</option>
                                        @foreach(getProductsForPurchase() as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}"  data-img="{{ asset('uploads/'.$product->image) }}">
                                                {{ $product->name }} - {{ __('global.'.$product->type) }}
                                        @endforeach
                                    </select>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped"  id="selected-products">
                                        <thead>
                                        <tr>
                                            <th width="50px">{{__('global.image')}}</th>
                                            <th>{{__('global.product')}}</th>
                                            <th width="60px">{{__('global.qty')}}</th>
                                            <th width="80px">{{__('global.price')}}</th>
                                            <th width="70px">{{__('global.total')}}</th>
                                            <th width="50px">{{__('global.action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.sub_total')}}</h5>
                                                <input type="text" class="form-control" disabled  id="sub_total" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.tax')}}</h5>
                                                <input type="text" class="form-control" disabled  id="vat" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.total_cost')}}</h5>
                                                <input type="text" class="form-control" disabled  id="cost" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.discount')}}</h5>
                                                <input type="text" class="form-control" disabled  id="dis" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.total')}}</h5>
                                                <input type="text" class="form-control" disabled  id="total" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h5 class=" text-center">{{__('global.paid')}}</h5>
                                                <input type="text" class="form-control" disabled  id="paid" value="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
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

                        @can('purchase_update')
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
            $('#discount, #paid_amount, #labor_cost, #shipping_cost, #tax_id, #other_cost').on('input', function () {
                updateTotal();
            });
            $('#tax').change(function (){
                updateTotal();
            });

            // Initialize an array to store selected products
            var selectedProducts = [];

            @foreach($purchase->purchaseProducts as $product)
                var selectedProduct = {
                    id: {{$product->product->id}},
                    name: '{{$product->product->name}}',
                    price: {{$product->unit_price}},
                    img: '{{asset('uploads/'.$product->product->image)}}',
                    quantity: {{$product->quantity}}, // Default quantity
                    subtotal: {{$product->sub_total}} // Initial subtotal
                };
                // Add the selected product to the array
                selectedProducts.push(selectedProduct);
                // Add the selected product to the table
                addToTable(selectedProduct);
                // Update the total
                updateTotal();
            @endforeach
            // Listen for changes in the product dropdown
            $('#product').change(function () {
                var selectedProductId = $(this).val();
                if (selectedProductId !== '') {
                    // Retrieve product details (you may have to fetch these from your backend)

                    var productName = $(this).find('option:selected').text();
                    var productPrice = parseFloat($(this).find('option:selected').data('price'));
                    var img = $(this).find('option:selected').data('img');
                    // Check if the product is not already in the selected products array
                    if (!selectedProducts.some(product => product['id'] === selectedProductId)) {

                        // Create a new object to represent the selected product
                        var selectedProduct = {
                            id: selectedProductId,
                            name: productName,
                            price: productPrice,
                            img: img,
                            quantity: 1, // Default quantity
                            subtotal: productPrice // Initial subtotal
                        };
                        // Add the selected product to the array
                        selectedProducts.push(selectedProduct);
                        // Add the selected product to the table
                        addToTable(selectedProduct);
                        // Update the total
                        updateTotal();
                    }
                }
            });

            // Event listener for changes in quantity and price inputs
            $('#selected-products').on('input', '.product-quantity, .product-price', function () {
                var selectedProductId = $(this).closest('tr').data('product-id');
                var quantity = parseInt($(this).closest('tr').find('.product-quantity').val());
                var price = parseFloat($(this).closest('tr').find('.product-price').val());

                for (var i = 0; i < selectedProducts.length; i++) {
                    if (selectedProducts[i]['id'] == selectedProductId) {
                        var selectedProduct = selectedProducts[i];
                        break;
                    }
                }

                // Update the quantity, price, and subtotal
                selectedProduct['quantity'] = quantity;
                selectedProduct['price'] = price;
                selectedProduct['subtotal'] = price * quantity;

                // Update the table and total
                updateTable(selectedProduct);
                updateTotal();
            });


            // Listen for clicks on remove buttons
            $('#selected-products').on('click', '.remove-product', function () {
                var selectedProductId = $(this).closest('tr').data('product-id');
                selectedProducts = selectedProducts.filter(function(el) { return el.id != selectedProductId; });
                $(this).closest('tr').remove();
                updateTotal();
            });

            // Function to add a selected product to the table
            function addToTable(product) {
                $('#selected-products tbody').append(`
            <tr data-product-id="${product.id}">
                <td><img src="${product.img}" class="img-thumbnail" style="max-width: 50px; max-height: 50px"></td>

                <td>${product.name} <input type="hidden" name="product_ids[]" value="${product.id}"></td>
                <td><input type="number" name="product_quantities[]"  class="input-qty product-quantity" value="${product.quantity}"></td>
                <td><input class="input-price product-price" type="number" name="product_prices[]" value="${product.price}"/> </td>
                <td class="product-subtotal">${product.subtotal}</td>
                <td><button class="btn btn-danger btn-sm remove-product"><i class="fas fa-trash"></button></td>
            </tr>
        `);
            }

            // Function to update a selected product in the table
            function updateTable(product) {
                var row = $(`#selected-products tr[data-product-id="${product.id}"]`);
                row.find('.product-quantity').val(product.quantity);
                row.find('.product-price').val(product.price);
                row.find('.product-subtotal').text(product.subtotal);
            }


            function updateTotal() {
                var $shippingCost = $('#shipping_cost');
                var $otherCost = $('#other_cost');
                var $tax = $('#tax');
                var $laborCost = $('#labor_cost');
                var $paidAmount = $('#paid_amount');
                var $discount = $('#discount');
                var $subTotal = $('#sub_total');
                var $cost = $('#cost');
                var $dis = $('#dis');
                var $paid = $('#paid');
                var $total = $('#total');
                var $due = $('#due');
                var $vat = $('#vat');

                var subTotal = selectedProducts.reduce((acc, product) => acc + product.subtotal, 0);
                $subTotal.val(subTotal);

                var shippingCostValue = parseFloat($shippingCost.val());
                var otherCostValue = parseFloat($otherCost.val());
                var taxValue = parseFloat($tax.val());
                var laborCostValue = parseFloat($laborCost.val());
                var discountValue = parseFloat($discount.val());
                var paidAmountValue = parseFloat($paidAmount.val());

                // Check if values are NaN and replace with 0 if necessary
                shippingCostValue = isNaN(shippingCostValue) ? 0 : shippingCostValue;
                otherCostValue = isNaN(otherCostValue) ? 0 : otherCostValue;
                taxValue = isNaN(taxValue) ? 0 : taxValue;
                laborCostValue = isNaN(laborCostValue) ? 0 : laborCostValue;
                discountValue = isNaN(discountValue) ? 0 : discountValue;
                paidAmountValue = isNaN(paidAmountValue) ? 0 : paidAmountValue;
                var taxAmount = subTotal*(taxValue/100);

                $cost.val(shippingCostValue + laborCostValue + otherCostValue);
                $dis.val(discountValue);
                $paid.val(paidAmountValue);

                var totalValue = subTotal + shippingCostValue + laborCostValue + otherCostValue + taxAmount - discountValue;
                $total.val(totalValue);

                var dueValue = totalValue - paidAmountValue;
                $due.val(dueValue);
                $vat.val(taxAmount);
            }
        });
    </script>

@stop
