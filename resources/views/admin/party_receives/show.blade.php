@extends('adminlte::page')

@section('title', __('global.view_party_receive'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_party_receive')}} - {{$party_receive->unique_id}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.party-receives.index')}}">{{__('global.party_receives')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_party_receive')}}</li>
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
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="unique_id">{{ __('global.unique_id')}}<span class="text-danger"> *</span></label>
                                        <input name="unique_id" disabled value="{{$party_receive->unique_id}}" id="unique_id"  type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                        <input name="date" value="{{$party_receive->date}}" disabled id="date"  type="text" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="party_id">{{__('global.select_party')}}<span class="text-danger"> *</span></label>
                                        <select disabled name="party_id" class=" form-control" id="account_id">
                                            <option value="">{{__('global.select_party')}}</option>
                                            @foreach(getSuppliers() as $party)
                                                <option value="{{$party->id}}" @if($party->id == $party_receive->party_id) selected @endif>{{$party->name}} </option>
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
                                                <option value="{{$account->id}}" @if($account->id == $party_receive->account_id) selected @endif>{{$account->account_name}} ({{$account->account_no}}) {{$account->admin->name??'--'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="amount">{{ __('global.party_receive')}}<span class="text-danger"> *</span></label>
                                        <input id="amount" disabled name="amount" value="{{$party_receive->amount}}" type="number" class="form-control" placeholder="{{ __('global.enter_party_receive')}}">
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-md-12">
                                    <div class="form-group">
                                        <label for="note">{{ __('global.note')}}</label>
                                        <textarea id="note" disabled name="note" rows="1" class="form-control">{{$party_receive->note}}</textarea>
                                    </div>
                                </div>

                            </div>


                        <form action="{{ route('admin.party-receives.destroy', $party_receive->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.party-receives.index')}}" class="btn btn-success" >Go Back</a>
                            @if($party_receive->status == 'pending')
                            @can('party_receive_update')
                                <a href="{{route('admin.party-receives.edit',['party_receife'=>$party_receive->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('party_receive_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('party_receive_approve')
                                <a href="{{route('admin.party-receives.approve',['party_receive'=>$party_receive->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
