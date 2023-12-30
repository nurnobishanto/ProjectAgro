@extends('adminlte::page')

@section('title', __('global.view_milk_production'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_milk_production')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.milk-productions.index')}}">{{__('global.milk_productions')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_milk_production')}}</li>
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
                                <th width="250px">{{ __('global.farm')}}</th>
                                <td>{{$cattle->farm->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th width="250px">{{ __('global.cattle_type')}}</th>
                                <td>{{$cattle->cattle_type->title??'--'}}</td>
                            </tr>
                            <tr>
                                <th width="250px">{{ __('global.tag_id')}}</th>
                                <td>{{$milk_production->cattle->tag_id??'--'}}</td>
                            </tr>
                            <tr>
                                <th width="250px">{{ __('global.unique_id')}}</th>
                                <td>{{$milk_production->unique_id??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.date')}}</th>
                                <td>{{$milk_production->date}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.quantity')}}</th>
                                <td>{{$milk_production->quantity}} ({{__('global.ltr')}})</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.moment')}}</th>
                                <td>{{__('global.'.$milk_production->moment)}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.note')}}</th>
                                <td>{{$milk_production->note}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.status')}}</th>
                                <td>{{__('global.'.$milk_production->status)}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.created_at')}}</th>
                                <td>{{$milk_production->createdBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($milk_production->created_at))}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.updated_at')}}</th>
                                <td>{{$milk_production->updatedBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($milk_production->updated_at))}}</td>
                            </tr>
                        </table>

                    </div>
                        <form action="{{ route('admin.milk-productions.destroy', $milk_production->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.milk-productions.index')}}" class="btn btn-success" >Go Back</a>
                            @if($milk_production->status == 'pending')
                                @can('milk_production_update')
                                    <a href="{{route('admin.milk-productions.edit',['milk_production'=>$milk_production->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                                @can('milk_production_delete')
                                    <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                @endcan
                                @can('milk_production_approve')
                                    <a href="{{route('admin.milk-productions.approve',['milk_production'=>$milk_production->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
