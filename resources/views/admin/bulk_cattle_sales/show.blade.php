@extends('adminlte::page')

@section('title', __('global.view_bulk_cattle_sale'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_bulk_cattle_sale')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.bulk-cattle-sales.index')}}">{{__('global.bulk_cattle_sales')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_bulk_cattle_sale')}}</li>
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
                                <td>{{$bulk_cattle_sale->farm->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.cattle_type')}}</th>
                                <td>{{$bulk_cattle_sale->cattle_type->title??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.cattle')}}</th>
                                <td>{{$bulk_cattle_sale->cattles->count()??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.unique_id')}}</th>
                                <td>{{$bulk_cattle_sale->unique_id??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.date')}}</th>
                                <td>{{$bulk_cattle_sale->date}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.party')}}</th>
                                <td>{{$bulk_cattle_sale->party->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.total_cattle')}}</th>
                                <td>{{$bulk_cattle_sale->cattles->count()}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.feeding_expense')}}</th>
                                <td>{{$bulk_cattle_sale->feeding_expense}} {{getSetting('currency')}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.others_expense')}}</th>
                                <td>{{$bulk_cattle_sale->other_expense}} {{getSetting('currency')}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.expense')}}</th>
                                <td>{{$bulk_cattle_sale->expense}} {{getSetting('currency')}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.total_expense')}}</th>
                                <td>{{$bulk_cattle_sale->feeding_expense+$bulk_cattle_sale->other_expense+$bulk_cattle_sale->expense }} {{getSetting('currency')}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.sale_price')}}</th>
                                <td>{{$bulk_cattle_sale->amount}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.account')}}</th>
                                <td>{{$bulk_cattle_sale->account->account_name}} {{$bulk_cattle_sale->account->account_no}} {{$bulk_cattle_sale->account->admin->name??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.paid')}}</th>
                                <td>{{$bulk_cattle_sale->paid}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.due')}}</th>
                                <td>{{$bulk_cattle_sale->due}}</td>
                            </tr>

                            <tr>
                                <th>{{ __('global.note')}}</th>
                                <td>{{$bulk_cattle_sale->note}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.status')}}</th>
                                <td>{{__('global.'.$bulk_cattle_sale->status)}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.created_at')}}</th>
                                <td>{{$bulk_cattle_sale->createdBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($bulk_cattle_sale->created_at))}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('global.updated_at')}}</th>
                                <td>{{$bulk_cattle_sale->updatedBy->name??'--'}} - {{date('d/m/y h:i A',strtotime($bulk_cattle_sale->updated_at))}}</td>
                            </tr>
                        </table>
                        <div class="col-md-12" id="cattle_list">
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
                                                <th>{{__('global.status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($bulk_cattle_sale->cattles as $cattle)
                                                <tr>
                                                    <td><input type="checkbox" name="cattles[]" disabled checked value="{{$cattle->id}}" class="form-control form-check"></td>
                                                    <td>{{$cattle->tag_id}}</td>
                                                    <td>{{__('global.'.$cattle->gender)}}</td>
                                                    <td>{{$cattle->batch->name}}</td>
                                                    <td>{{$cattle->session_year->year}}</td>
                                                    <td>{{getLatestCattleStructure($cattle->id,'weight')}} <sup>{{__('global.kg')}}</sup></td>
                                                    <td>{{getLatestCattleStructure($cattle->id,'height')}} <sup>{{__('global.inch')}}</sup></td>
                                                    <td>{{getLatestCattleStructure($cattle->id,'width')}} <sup>{{__('global.inch')}}</sup></td>
                                                    <td>{{__('global.'.$cattle->status)}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                        <form action="{{ route('admin.bulk-cattle-sales.destroy', $bulk_cattle_sale->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.bulk-cattle-sales.index')}}" class="btn btn-success" >Go Back</a>
                            @if($bulk_cattle_sale->status == 'pending')
                                @can('bulk_cattle_sale_update')
                                    <a href="{{route('admin.bulk-cattle-sales.edit',['bulk_cattle_sale'=>$bulk_cattle_sale->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                                @endcan
                                @can('bulk_cattle_sale_delete')
                                    <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                @endcan
                                @can('bulk_cattle_sale_approve')
                                    <a href="{{route('admin.bulk-cattle-sales.approve',['bulk_cattle_sale'=>$bulk_cattle_sale->id])}}" class="btn btn-primary "><i class="fa fa-thumbs-up"></i> Approve</a>
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
