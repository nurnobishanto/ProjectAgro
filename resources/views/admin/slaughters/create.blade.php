@extends('adminlte::page')

@section('title', __('global.create_slaughter'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_slaughter')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughters.index')}}">{{ __('global.slaughters')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_slaughter')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="">
                        <li><strong>{{__('global.farm')}} :</strong> {{$cattle->farm->name}}</li>
                        <li><strong>{{__('global.cattle_type')}} :</strong> {{$cattle->cattle_type->title}}</li>
                        <li><strong>{{__('global.tag_id')}} :</strong> {{$cattle->tag_id}}</li>
                        <li><strong>{{__('global.amount')}} :</strong> {{$amount}}</li>
                    </ul>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.slaughters.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger"> *</span></label>
                                    <input name="unique_id" readonly value="{{generateInvoiceId('CSLI',\App\Models\Slaughter::class,'unique_id')}}" id="unique_id"  type="text" class="form-control">
                                    <input name="cattle_id" value="{{$cattle->id}}"  class="d-none">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                    <input name="date" readonly id="date" value="{{old('date')}}" type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="slaughter_store_id">{{ __('global.select_slaughter_store')}}<span class="text-danger"> *</span></label>
                                    <select id="slaughter_store_id" name="slaughter_store_id" class="form-control">
                                        <option value="">{{ __('global.select_slaughter_store')}}</option>
                                        @foreach(getSlaughterStore() as $store )
                                            <option value="{{$store->id}}">{{$store->name}} {{$store->phone}} {{$store->address}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea name="note" rows="1" id="note"  type="text" class="form-control">{{old('note')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="5%">{{__('global.sl')}}</th>
                                            <th width="50%">{{__('global.slaughter_item')}}</th>
                                            <th width="30%">{{__('global.quantity')}}</th>
                                            <th width="15%">{{__('global.unit')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $sl = 1 @endphp
                                        @foreach(getSlaughterItems() as $item)
                                            <tr>
                                                <td>{{$sl++}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>
                                                    <input name="items[]" value="{{$item->id}}" class="d-none" placeholder="{{__('global.enter_quantity')}}">
                                                    <input name="quantities[]" class="form-control" placeholder="{{__('global.enter_quantity')}}">
                                                </td>
                                                <td>{{$item->unit->name??'--'}} ({{$item->unit->code??'--'}})</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @can('slaughter_create')
                            <button class="btn btn-success" type="submit">{{ __('global.create')}}</button>
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
@section('css')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: black;
    }
</style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme:'classic',
            });
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false
            });
            priceCalculate();
            $('#amount,#paid').on('input',function () {
                priceCalculate();
            });

        });
        function priceCalculate(){
            var sale_price = parseFloat($('#amount').val());
            var paid = parseFloat($('#paid').val());

            sale_price = isNaN(sale_price) ? 0 : sale_price;
            paid = isNaN(paid) ? 0 : paid;

            $('#due').val(sale_price - paid);
        }
    </script>
@stop
