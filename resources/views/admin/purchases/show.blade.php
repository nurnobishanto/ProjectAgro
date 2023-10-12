@extends('adminlte::page')

@section('title', __('global.view_purchase'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_purchase')}} - {{$purchase->invoice_no}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.purchases.index')}}">{{__('global.purchases')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_purchase')}}</li>
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

                                
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="updated_at">{{ __('global.updated_at')}}</label>
                                        <input id="updated_at" class="form-control" disabled value="{{date_format($purchase->updated_at,'d M y h:i A') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="created_by">{{ __('global.created_by')}}</label>
                                        <input id="created_by" class="form-control" disabled value="{{$purchase->createdBy->name}}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <textarea class="form-control">{{$purchase->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <img src="{{asset('uploads/'.$purchase->image)}}" class="img-thumbnail">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>{{__('global.image')}}</th>
                                                <th>{{__('global.product')}}</th>
                                                <th>{{__('global.type')}}</th>
                                                <th>{{__('global.qty')}}</th>
                                                <th>{{__('global.price')}}</th>
                                                <th>{{__('global.total')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(getPurchaseProducts($purchase->id) as $p)
                                                <tr>
                                                    <td><img src="{{asset('uploads/'.$p->product->image)}}" class="img-thumbnail" style="max-width: 100px"></td>
                                                    <td>{{$p->product->name}}</td>
                                                    <td>{{__('global.'.$p->product->type)}}</td>
                                                    <td>{{$p->quantity}}</td>
                                                    <td>{{$p->unit_price}}</td>
                                                    <td>{{$p->sub_total}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>



                        <form action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.purchases.index')}}" class="btn btn-success" >Go Back</a>
                            @can('purchase_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
