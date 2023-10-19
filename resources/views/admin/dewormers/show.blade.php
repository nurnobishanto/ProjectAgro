@extends('adminlte::page')

@section('title', __('global.view_dewormer'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_dewormer')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.dewormers.index')}}">{{__('global.dewormers')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_dewormer')}}</li>
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
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.farm')}} :</strong> {{$dewormer->farm->name}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.date')}} :</strong> {{$dewormer->date}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.end_date')}} :</strong> {{$dewormer->end_date}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.dewormer')}} :</strong> {{$dewormer->product->name}} {{$dewormer->quantity}} {{$dewormer->product->unit->code}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.unit_price')}} :</strong> {{$dewormer->unit_price}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.total_cost')}} :</strong> {{$dewormer->total_cost}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.cattles')}} :</strong> {{$dewormer->cattles->count()}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.cattle_type')}} :</strong> {{$dewormer->cattle_type->title??'--'}}</div>
                        <div class="col-lg-4 col-md-4 col-sm-6 border p-2"><strong>{{__('global.average')}} :</strong> {{$dewormer->avg_cost}}</div>
                        <div class="col-lg-12 col-md-12 col-sm-6 border p-2"><strong>{{__('global.comment')}} :</strong> {{$dewormer->comment}}</div>
                    </div>
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
                                <div class="col-12" id="cattle_list">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">{{__('global.cattle_list')}}</h5>
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
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($cattles as $cattle)
                                                        <tr>
                                                            <td><input disabled type="checkbox" name="cattles[]" @if ($dewormer->cattles->contains($cattle->id)) checked @endif  value="{{$cattle->id}}" class="form-control form-check"></td>
                                                            <td>{{$cattle->tag_id}}</td>
                                                            <td>{{__('global.'.$cattle->gender)}}</td>
                                                            <td>{{$cattle->batch->name}}</td>
                                                            <td>{{$cattle->session_year->year}}</td>
                                                            <td>{{getLatestCattleStructure($cattle->id,'weight')}} <sup>{{__('global.kg')}}</sup></td>
                                                            <td>{{getLatestCattleStructure($cattle->id,'height')}} <sup>{{__('global.inch')}}</sup></td>
                                                            <td>{{getLatestCattleStructure($cattle->id,'width')}} <sup>{{__('global.inch')}}</sup></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>



                        <form action="{{ route('admin.dewormers.destroy', $dewormer->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.dewormers.index')}}" class="btn btn-success" >Go Back</a>
                            @if($dewormer->status == 'pending')
                                @can('dewormer_update')
                                    <a href="{{route('admin.dewormers.edit',['dewormer'=>$dewormer->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                                @can('dewormer_delete')
                                    <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                @endcan
                                @can('dewormer_approve')
                                    <a href="{{route('admin.dewormers.approve',['dewormer'=>$dewormer->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
