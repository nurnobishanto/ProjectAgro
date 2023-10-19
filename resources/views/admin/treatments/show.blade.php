@extends('adminlte::page')

@section('title', __('global.view_treatment'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.view_treatment')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.treatments.index')}}">{{ __('global.treatments')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.view_treatment')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.date')}} :</strong> {{$treatment->date}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.farm')}} :</strong> {{$treatment->farm->name}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.cattle_type')}} :</strong> {{$treatment->cattle->cattle_type->title??'--'}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.tag_id')}} :</strong> {{$treatment->cattle->tag_id}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.doctor')}} :</strong> {{$treatment->doctor}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.total_cost')}} :</strong> {{$treatment->cost}}</div>
                        <div class="col-sm-12 border p-2"><strong>{{__('global.disease')}} :</strong> {{$treatment->disease}}</div>
                        <div class="col-sm-12 border p-2"><strong>{{__('global.comment')}} :</strong> {{$treatment->comment}}</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <td>{{__('global.sl')}}</td>
                                <td>{{__('global.medicine')}}</td>
                                <td>{{__('global.quantity')}}</td>

                            </tr>
                            </thead>
                            <tbody>
                            @php $sl = 1;@endphp
                            @foreach($treatment->products as $item)
                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td>{{ $item->name??'--' }}</td>
                                    <td>{{$item->pivot->quantity}}{{ $item->unit->code }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.treatments.destroy', $treatment->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{route('admin.treatments.index')}}" class="btn btn-success" >Go Back</a>
                        @if($treatment->status == 'pending')
                            @can('treatment_update')
                                <a href="{{route('admin.treatments.edit',['treatment'=>$treatment->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('treatment_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @can('treatment_approve')
                                <a href="{{route('admin.treatments.approve',['treatment'=>$treatment->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
@section('plugins.Select2',true)
@section('plugins.Sweetalert2',true)
@section('css')

@stop

@section('js')

@stop
