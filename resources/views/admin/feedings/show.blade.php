@extends('adminlte::page')

@section('title', __('global.view_feeding'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_feeding')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.feedings.index')}}">{{__('global.feedings')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_feeding')}}</li>
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
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <strong>{{__('global.farm')}} :</strong> {{$feeding_group->farm->name}}
                                    <strong>{{__('global.cattle_type')}} :</strong> {{$feeding_group->cattle_type->title}}
                                </li>
                                <li class="list-group-item">
                                    <strong>{{__('global.feeding')}} :</strong> {{$feeding_group->feeding_category->name}} {{$feeding_group->feeding_moment->name}}
                                </li>
                                <li class="list-group-item">
                                    <strong>{{__('global.total_cost')}}</strong> {{$feeding->total_cost}} /
                                    <strong>{{__('global.cattles')}} :</strong> {{$feeding->cattles->count()}}  =
                                    <strong>{{__('global.average')}} :</strong> {{round($feeding->total_cost/$feeding->cattles->count(),2)}}
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                        <input name="date" id="date" value="{{$feeding->date}}" disabled type="text" class="form-control datepicker">
                                        <input name="feeding_group_id" value="{{$feeding_group->id}}"  class="d-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="comment">{{ __('global.comment')}}</label>
                                        <textarea rows="1" name="comment" id="comment" disabled type="text" class="form-control">{{$feeding->comment}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                                @foreach($items as $item)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>{{ $item->name }} ({{ (getStock($feeding_group->farm_id, $item->id)->quantity ?? 0) + (getFeedRecordProduct($feeding->id,$item->id)->quantity??0) }} {{ $item->unit->code }})</label>
                                                    <input name="items[]" value="{{ $item->id }}" class="d-none">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <input
                                                                    disabled
                                                                    name="qty[]"
                                                                    type="number"
                                                                    value="{{(getFeedRecordProduct($feeding->id,$item->id)->quantity??0)}}"
                                                                    placeholder="{{ __('global.quantity') }}"
                                                                    class="form-control quantity-input"
                                                                    data-min="0"
                                                                    data-max="{{(getStock($feeding_group->farm_id, $item->id)->quantity ?? 0) + (getFeedRecordProduct($feeding->id,$item->id)->quantity??0) }}"
                                                                >
                                                            </td>
                                                            <td>{{ $item->unit->code }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-12" id="cattle_list">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">{{__('global.select_feeding_item')}}</h5>
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
                                                            <td><input disabled type="checkbox" name="cattles[]" @if ($feeding->cattles->contains($cattle->id)) checked @endif  value="{{$cattle->id}}" class="form-control form-check"></td>
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



                        <form action="{{ route('admin.feedings.destroy', $feeding->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.feedings.index')}}" class="btn btn-success" >Go Back</a>
                            @if($feeding->status == 'pending')
                                @can('feeding_update')
                                    <a href="{{route('admin.feedings.edit',['feeding'=>$feeding->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                                @can('feeding_delete')
                                    <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                @endcan
                                @can('feeding_approve')
                                    <a href="{{route('admin.feedings.approve',['feeding'=>$feeding->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
