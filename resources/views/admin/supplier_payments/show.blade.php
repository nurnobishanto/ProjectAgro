@extends('adminlte::page')

@section('title', __('global.view_supplier_payment'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_supplier_payment')}} - {{$supplier_payment->unique_id}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.supplier-payments.index')}}">{{__('global.supplier_payments')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_supplier_payment')}}</li>
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
                            <tr>
                                <th>{{ __('global.unique_id')}}</th>
                                <td>{{$supplier_payment->unique_id}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.date')}}</th>
                                <td>{{$supplier_payment->date}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.supplier')}}</th>
                                <td>{{$supplier_payment->supplier->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.account')}}</th>
                                <td>{{$supplier_payment->account->account_name??'--'}} ({{$supplier_payment->account->account_no??'--'}}) {{$supplier_payment->account->admin->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.type')}}</th>
                                <td>{{__('global.'.$supplier_payment->type)}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.amount')}}</th>
                                <td>{{$supplier_payment->amount}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.note')}}</th>
                                <td>{{$supplier_payment->note}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.created_by')}}</th>
                                <td>{{$supplier_payment->createdBy->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.updated_by')}}</th>
                                <td>{{$supplier_payment->updatedBy->name??'--'}}</td>
                            </tr>
                        </table>
                    </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger"> *</span></label>
                                        <input name="unique_id" disabled value="{{$supplier_payment->unique_id}}" id="unique_id"  type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                        <input name="date" value="{{$supplier_payment->date}}" disabled id="date"  type="text" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="supplier_id">{{__('global.select_supplier')}}<span class="text-danger"> *</span></label>
                                        <select disabled name="supplier_id" class=" form-control" id="account_id">
                                            <option value="">{{__('global.select_supplier')}}</option>
                                            @foreach(getSuppliers() as $supplier)
                                                <option value="{{$supplier->id}}" @if($supplier->id == $supplier_payment->supplier_id) selected @endif>{{$supplier->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="account_id">{{__('global.select_account')}}<span class="text-danger"> *</span></label>
                                        <select disabled name="account_id" class=" form-control" id="account_id">
                                            <option value="">{{__('global.select_account')}}</option>
                                            @foreach(getAccountList() as $account)
                                                <option value="{{$account->id}}" @if($account->id == $supplier_payment->account_id) selected @endif>{{$account->account_name}} ({{$account->account_no}}) {{$account->admin->name??'--'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="amount">{{ __('global.supplier_payment')}}<span class="text-danger"> *</span></label>
                                        <input id="amount" disabled name="amount" value="{{$supplier_payment->amount}}" type="number" class="form-control" placeholder="{{ __('global.enter_supplier_payment')}}">
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-md-12">
                                    <div class="form-group">
                                        <label for="note">{{ __('global.note')}}</label>
                                        <textarea id="note" disabled name="note" rows="1" class="form-control">{{$supplier_payment->note}}</textarea>
                                    </div>
                                </div>

                            </div>


                        <form action="{{ route('admin.supplier-payments.destroy', $supplier_payment->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.supplier-payments.index')}}" class="btn btn-success" >Go Back</a>
                            @if($supplier_payment->status == 'pending')
                            @can('supplier_payment_update')
                                <a href="{{route('admin.supplier-payments.edit',['supplier_payment'=>$supplier_payment->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('supplier_payment_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('supplier_payment_approve')
                                <a href="{{route('admin.supplier-payments.approve',['supplier_payment'=>$supplier_payment->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
        function checkSinglePermission(idName, className,inGroupCount,total,groupCount) {
            if($('.'+className+' input:checked').length === inGroupCount){
                $('#'+idName).prop('checked',true);
            }else {
                $('#'+idName).prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        function checkPermissionByGroup(idName, className,total,groupCount) {
            if($('#'+idName).is(':checked')){
                $('.'+className+' input').prop('checked',true);
            }else {
                $('.'+className+' input').prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        $('#select_all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@stop
