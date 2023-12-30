@extends('adminlte::page')

@section('title', __('global.create_cattle_sale'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_cattle_sale')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.bulk-cattle-sales.index')}}">{{ __('global.cattle_sales')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_cattle_sale')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <table class="table table-bordered">
                        <tr><th width="30%">{{__('global.farm')}}</th><td>{{$farm->name}}</td></tr>
                        <tr><th>{{__('global.cattle_type')}}</th><td>{{$type->title}}</td></tr>
                        <tr><th>{{__('global.feeding_expense')}}</th><td><span id="totalFeedingCost"></span> {{getSetting('currency')}}</td></tr>
                        <tr><th>{{__('global.others_expense')}}</th><td><span id="otherCost"></span>{{getSetting('currency')}}</td></tr>
                        <tr><th>{{__('global.total_expense')}}</th><th><span id="totalCost"></span> {{getSetting('currency')}}</th></tr>

                    </table>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.bulk-cattle-sales.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger"> *</span></label>
                                    <input name="unique_id" readonly value="{{generateInvoiceId('BCSI',\App\Models\BulkCattleSale::class,'unique_id')}}" id="unique_id"  type="text" class="form-control">
                                    <input name="farm_id" value="{{$farm->id}}"  class="d-none">
                                    <input name="cattle_type_id" value="{{$type->id}}"  class="d-none">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                    <input name="date" readonly id="date" value="{{old('date')}}" type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="party_id">{{ __('global.select_party')}}<span class="text-danger"> *</span></label>
                                    <select id="party_id" name="party_id" class="form-control">
                                        <option value="">{{ __('global.select_party')}}</option>
                                        @foreach(getPartyList() as $party )
                                            <option value="{{$party->id}}" @if($party->id ==old('party_id')) selected @endif>{{$party->name}} {{$party->phone}} {{$party->address}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="account_id">{{ __('global.select_account')}}<span class="text-danger"> *</span></label>
                                    <select id="account_id" name="account_id" class="form-control">
                                        <option value="">{{ __('global.select_account')}}</option>
                                        @foreach(getAccountList() as $account)
                                            <option value="{{$account->id}}"  @if($account->id ==old('account_id')) selected @endif>{{$account->account_name}} {{$account->account_no}} {{$account->admin->name??'--'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="amount">{{ __('global.sale_price')}}<span class="text-danger"> *</span></label>
                                    <input name="amount" value="{{old('amount')}}" id="amount"  type="number" step="any" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="paid">{{ __('global.paid')}}</label>
                                    <input name="paid"  id="paid" value="{{old('paid')}}"  type="number" step="any" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="due">{{ __('global.due')}}</label>
                                    <input name="due" readonly id="due" value="{{old('due')}}"  type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="expense">{{ __('global.expense')}}</label>
                                    <input name="expense" id="expense" value="{{old('expense')}}" type="number" step="any" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea name="note" rows="1" id="note"  type="text" class="form-control">{{old('note')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12" id="cattle_list">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('global.cattle_list')}}</h5>
                                        <a href="#cattle_list" class="badge badge-success mx-2" id="toggleAllButton">Select All</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th width="80px">{{__('global.select')}}</th>
                                                    <th>{{__('global.tag_id')}}</th>
                                                    <th>{{__('global.gender')}}</th>
                                                    <th>{{__('global.batch_no')}}</th>
                                                    <th>{{__('global.session_year')}}</th>
                                                    <th>{{__('global.weight')}}</th>
                                                    <th>{{__('global.height')}}</th>
                                                    <th>{{__('global.width')}}</th>
                                                    <th>{{__('global.status')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($cattles as $cattle)
                                                    <tr>
                                                        <td><input type="checkbox" name="cattles[]"  value="{{$cattle->id}}" data-feeding-cost="{{ getCattleTotalCost($cattle)['total'] }}"  class="form-control form-check"></td>
                                                        <td>{{$cattle->tag_id}}</td>
                                                        <td>{{__('global.'.$cattle->gender)}}</td>
                                                        <td>{{$cattle->batch->name}}</td>
                                                        <td>{{$cattle->session_year->year}}</td>
                                                        <td>{{getLatestCattleStructure($cattle->id,'weight')}} <sup>{{__('global.kg')}}</sup></td>
                                                        <td>{{getLatestCattleStructure($cattle->id,'height')}} <sup>{{__('global.inch')}}</sup></td>
                                                        <td>{{getLatestCattleStructure($cattle->id,'width')}} <sup>{{__('global.inch')}}</sup></td>
                                                        <td>{{__('global.'.$cattle->status)}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @can('cattle_sale_create')
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
            $('input[name="cattles[]"]').on('change', function() {
                calculateTotalCost();
            });


        });
        function calculateTotalCost() {
            var selectedCount = $('input[name="cattles[]"]:checked').length;
            var otherAvgCost = {{getTotalAvgExpenseCost()['avg_cost']}};
            var totalFeedCost = 0;

            $('input[name="cattles[]"]:checked').each(function() {
                var feedingCost = parseFloat($(this).data('feeding-cost'));
                if (!isNaN(feedingCost)) {
                    totalFeedCost += feedingCost;
                }
            });
            var otherCost = selectedCount * otherAvgCost;
            var totalCost = totalFeedCost + otherCost;
            // Display total cost
            $('#totalFeedingCost').text(totalFeedCost.toFixed(2));
            $('#otherCost').text(otherCost.toFixed(2));
            $('#totalCost').text(totalCost.toFixed(2));
        }
        function priceCalculate(){
            var sale_price = parseFloat($('#amount').val());
            var paid = parseFloat($('#paid').val());

            sale_price = isNaN(sale_price) ? 0 : sale_price;
            paid = isNaN(paid) ? 0 : paid;

            $('#due').val(sale_price - paid);
        }
        var $checkboxes = $('input[type="checkbox"]');
        var $toggleAllButton = $('#toggleAllButton');

        $toggleAllButton.on('click', function() {
            var allChecked = $checkboxes.length === $checkboxes.filter(':checked').length;

            if (allChecked) {
                // If all checkboxes are checked, uncheck all
                $checkboxes.prop('checked', false);
            } else {
                // If not all checkboxes are checked, check all
                $checkboxes.prop('checked', true);
            }

            toggleButtonText();
        });

        function toggleButtonText() {
            if ($checkboxes.length === $checkboxes.filter(':checked').length) {
                $toggleAllButton.text('Uncheck All');
                $toggleAllButton.removeClass('badge-success').addClass('badge-danger');
            } else {
                $toggleAllButton.text('Check All');
                $toggleAllButton.removeClass('badge-danger').addClass('badge-success');
            }
        }

        toggleButtonText(); // Initialize button text

        $checkboxes.on('change', function() {
            toggleButtonText();
        });
    </script>
@stop
