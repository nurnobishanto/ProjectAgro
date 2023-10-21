@extends('adminlte::page')

@section('title', __('global.view_cattle_death'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_cattle_death')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.cattle-deaths.index')}}">{{__('global.cattle_deaths')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_cattle_death')}}</li>
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
                                        <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                        <input name="date" readonly disabled id="date" value="{{$cattle_death->date}}"  type="text" class="form-control datepicker">
                                        <input name="cattle_id" value="{{$cattle->id}}"  class="d-none">
                                        <input name="amount" value="{{$amount}}"  class="d-none">
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-8 col-sm-6">
                                    <div class="form-group">
                                        <label for="note">{{ __('global.note')}}</label>
                                        <textarea name="note" disabled rows="1" id="note"  type="text" class="form-control">{{$cattle_death->note}}</textarea>
                                    </div>
                                </div>
                            </div>



                        <form action="{{ route('admin.cattle-deaths.destroy', $cattle_death->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.cattle-deaths.index')}}" class="btn btn-success" >Go Back</a>
                            @if($cattle_death->status == 'pending')
                                @can('cattle_death_update')
                                    <a href="{{route('admin.cattle-deaths.edit',['cattle_death'=>$cattle_death->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                                @can('cattle_death_delete')
                                    <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                @endcan
                                @can('cattle_death_approve')
                                    <a href="{{route('admin.cattle-deaths.approve',['cattle_death'=>$cattle_death->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
