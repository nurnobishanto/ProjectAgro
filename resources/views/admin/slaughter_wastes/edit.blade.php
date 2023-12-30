@extends('adminlte::page')

@section('title', __('global.update_slaughter_waste'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_slaughter_waste')}}</h1>
            <p>{{__('global.slaughter_store')}} : {{$slaughter_waste->slaughter_store->name??'--'}} {{$slaughter_waste->slaughter_store->company??'--'}}</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughter_wastes.index')}}">{{ __('global.slaughter_wastes')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_slaughter_waste')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.slaughter_wastes.update',['slaughter_waste'=>$slaughter_waste->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger">*</span></label>
                                            <input id="unique_id" name="unique_id" value="{{$slaughter_waste->unique_id}}" class="form-control" placeholder="{{ __('global.unique_id')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="date">{{ __('global.date')}}<span class="text-danger">*</span></label>
                                            <input id="date" name="date" value="{{$slaughter_waste->date}}" type="text" class="datepicker form-control" placeholder="{{ __('global.date')}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="note">{{ __('global.note')}}</label>
                                            <textarea id="note" name="note" class="form-control" placeholder="{{ __('global.enter_note')}}">{{$slaughter_waste->note}}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="product">{{__('global.select_products')}}<span class="text-danger">*</span></label>
                                    <select name="" class="select2 form-control" id="product">
                                        <option value="">{{__('global.select_products')}}</option>
                                        @foreach(getSlaughterProductsForSale($slaughter_waste->slaughter_store_id) as $stock)
                                            <option value="{{ $stock->product->id }}" data-price="{{ $stock->product->sale_price }}"  data-img="{{ asset('uploads/'.$stock->product->image) }}">
                                                {{ $stock->product->name }} - ({{ $stock->quantity}})
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

                        </div>

                        @can('slaughter_waste_update')
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


            // Initialize an array to store selected products
            var selectedProducts = [];

            @foreach($slaughter_waste->products as $product)
                var selectedProduct = {
                    id: '{{$product->id}}',
                    name: '{{$product->name}}',
                    price: {{$product->pivot->unit_price}},
                    img: '{{asset('uploads/'.$product->image)}}',
                    quantity: {{$product->pivot->quantity}}, // Default quantity
                    subtotal: {{$product->pivot->sub_total}} // Initial subtotal
                };
                // Add the selected product to the array
                selectedProducts.push(selectedProduct);
                // Add the selected product to the table
                addToTable(selectedProduct);
                // Update the total

                console.log(selectedProducts);
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

                        console.log(selectedProducts);
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

            });


            // Listen for clicks on remove buttons
            $('#selected-products').on('click', '.remove-product', function () {
                var selectedProductId = $(this).closest('tr').data('product-id');
                selectedProducts = selectedProducts.filter(function(el) { return el.id != selectedProductId; });
                $(this).closest('tr').remove();

            });

            // Function to add a selected product to the table
            function addToTable(product) {
                $('#selected-products tbody').append(`
            <tr data-product-id="${product.id}">
                <td><img src="${product.img}" class="img-thumbnail" style="max-width: 50px; max-height: 50px"></td>

                <td>${product.name} <input type="hidden" name="product_ids[]" value="${product.id}"></td>
                <td><input type="number" step="any" name="product_quantities[]"  class="input-qty product-quantity" value="${product.quantity}"></td>
                <td><input class="input-price product-price" type="number" step="any" name="product_prices[]" value="${product.price}"/> </td>
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



        });
    </script>

@stop
