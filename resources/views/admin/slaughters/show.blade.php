@extends('adminlte::page')

@section('title', __('global.view_slaughter'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_slaughter')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.slaughters.index')}}">{{__('global.slaughters')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_slaughter')}}</li>
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
                                <td>{{$slaughter->cattle->tag_id??'--'}}</td>
                            </tr>
                            <tr>
                                <th width="250px">{{ __('global.unique_id')}}</th>
                                <td>{{$slaughter->unique_id??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.date')}}</th>
                                <td>{{$slaughter->date}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.slaughter_store')}}</th>
                                <td>{{$slaughter->slaughter_store->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.feeding_expense')}}</th>
                                <td>{{$slaughter->feeding_expense}} {{getSetting('currency')}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.others_expense')}}</th>
                                <td>{{$slaughter->other_expense}} {{getSetting('currency')}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.total_expense')}}</th>
                                <th>{{$slaughter->feeding_expense+$slaughter->other_expense}} {{getSetting('currency')}}</th>
                            </tr>
                            <tr>
                                <th>{{ __('global.note')}}</th>
                                <td>{{$slaughter->note}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.status')}}</th>
                                <td>{{__('global.'.$slaughter->status)}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.created_at')}}</th>
                                <td>{{$slaughter->createdBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($slaughter->created_at))}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.updated_at')}}</th>
                                <td>{{$slaughter->updatedBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($slaughter->updated_at))}}</td>
                            </tr>
                        </table>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="10%">{{__('global.sl')}}</th>
                                        <th width="50%">{{__('global.slaughter_item')}}</th>
                                        <th width="20%">{{__('global.quantity')}}</th>
                                        <th width="20%">{{__('global.unit')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $sl = 1 @endphp
                                    @foreach(getSlaughterItems() as $item)
                                        <tr>
                                            <td>{{$sl++}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{ $slaughter->products->find($item->id)->pivot->quantity }}</td>
                                            <td>{{$item->unit->name??'--'}} ({{$item->unit->code??'--'}})</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                        <form action="{{ route('admin.slaughters.destroy', $slaughter->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.slaughters.index')}}" class="btn btn-success" >Go Back</a>
                            @if($slaughter->status == 'pending')
                                @can('slaughter_update')
                                    <a href="{{route('admin.slaughters.edit',['slaughter'=>$slaughter->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                                @can('slaughter_delete')
                                    <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                @endcan
                                @can('slaughter_approve')
                                    <a href="{{route('admin.slaughters.approve',['slaughter'=>$slaughter->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
