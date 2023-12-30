@extends('adminlte::page')

@section('title', __('global.view_opening_balance'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_opening_balance')}} - {{$opening_balance->unique_id}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.opening-balances.index')}}">{{__('global.opening_balances')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_opening_balance')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger"> *</span></label>
                                        <input name="unique_id" disabled value="{{$opening_balance->unique_id}}" id="unique_id"  type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                        <input name="date" value="{{$opening_balance->date}}" disabled id="date"  type="text" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="account_id">{{__('global.select_account')}}<span class="text-danger"> *</span></label>
                                        <select disabled name="account_id" class=" form-control" id="account_id">
                                            <option value="">{{__('global.select_account')}}</option>
                                            @foreach(getAccountList() as $account)
                                                <option value="{{$account->id}}" @if($account->id == $opening_balance->account_id) selected @endif>{{$account->account_name}} ({{$account->account_no}}) {{$account->admin->name??'--'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3  col-sm-6">
                                    <div class="form-group">
                                        <label for="amount">{{ __('global.opening_balance')}}<span class="text-danger"> *</span></label>
                                        <input id="amount" disabled name="amount" value="{{$opening_balance->amount}}" type="number" step="any" class="form-control" placeholder="{{ __('global.enter_opening_balance')}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note">{{ __('global.note')}}</label>
                                        <textarea id="note" disabled name="note" rows="1" class="form-control">{{$opening_balance->note}}</textarea>
                                    </div>
                                </div>

                            </div>


                        <form action="{{ route('admin.opening-balances.destroy', $opening_balance->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.opening-balances.index')}}" class="btn btn-success" >Go Back</a>
                            @if($opening_balance->status == 'pending')
                            @can('opening_balance_update')
                                <a href="{{route('admin.opening-balances.edit',['opening_balance'=>$opening_balance->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('opening_balance_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('opening_balance_approve')
                                <a href="{{route('admin.opening-balances.approve',['opening_balance'=>$opening_balance->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
