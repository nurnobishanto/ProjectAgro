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
                <div class="card-header">
                    <ul class="list-group">
                        <li><strong>{{__('global.farm')}} :</strong> {{$cattle->farm->name}}</li>
                        <li><strong>{{__('global.cattle_type')}} :</strong> {{$cattle->cattle_type->title}}</li>
                        <li><strong>{{__('global.tag_id')}} :</strong> {{$cattle->tag_id}}</li>
                        <li><strong>{{__('global.amount')}} :</strong> {{$amount}}</li>
                    </ul>
                </div>
                <div class="card-body">
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
                                        <input name="unique_id" readonly value="{{$cattle_sale->unique_id}}" id="unique_id"  type="text" class="form-control">

                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                        <input name="date" readonly id="date" value="{{$cattle_sale->date}}" type="text" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="party_id">{{ __('global.select_party')}}<span class="text-danger"> *</span></label>
                                        <select id="party_id" name="party_id" class="form-control">
                                            <option value="">{{ __('global.select_party')}}</option>
                                            @foreach(getPartyList() as $party )
                                                <option value="{{$party->id}}"  @if($party->id == $cattle_sale->party_id) selected @endif>{{$party->name}} {{$party->phone}} {{$party->address}}</option>
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
                                                <option value="{{$account->id}}" @if($account->id == $cattle_sale->account_id) selected @endif>{{$account->account_name}} {{$account->account_no}} {{$account->admin->name??'--'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="amount">{{ __('global.sale_price')}}<span class="text-danger"> *</span></label>
                                        <input name="amount" value="{{$cattle_sale->amount}}" id="amount"  type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="paid">{{ __('global.paid')}}</label>
                                        <input name="paid" value="{{$cattle_sale->paid}}" id="paid"  type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="due">{{ __('global.due')}}</label>
                                        <input name="due" value="{{$cattle_sale->due}}" readonly id="due" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-9 col-sm-6">
                                    <div class="form-group">
                                        <label for="note">{{ __('global.note')}}</label>
                                        <textarea name="note" rows="1" id="note"  type="text" class="form-control">{{$cattle_sale->note}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="created_by">{{ __('global.created_by')}}<span class="text-danger"> *</span></label>
                                        <input name="created_by" readonly id="created_by" value="{{$cattle_sale->createdBy->name??'--'}}" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="updated_by">{{ __('global.updated_by')}}<span class="text-danger"> *</span></label>
                                        <input name="updated_by" readonly id="updated_by" value="{{$cattle_sale->updatedBy->name??'--'}}" type="text" class="form-control">
                                    </div>
                                </div>
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
