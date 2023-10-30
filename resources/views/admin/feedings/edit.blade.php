@extends('adminlte::page')

@section('title', __('global.update_feeding'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_feeding')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.feedings.index')}}">{{ __('global.feedings')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_feeding')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="">
                        <li><strong>{{__('global.farm')}} :</strong> {{$feeding_group->farm->name}}</li>
                        <li><strong>{{__('global.cattle_type')}} :</strong> {{$feeding_group->cattle_type->title}}</li>
                        <li><strong>{{__('global.feeding_category')}} :</strong> {{$feeding_group->feeding_category->name}}</li>
                        <li><strong>{{__('global.feeding_moment')}} :</strong> {{$feeding_group->feeding_moment->name}}</li>
                    </ul>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.feedings.update',['feeding'=>$feeding->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
                        @method('PUT')
                        @csrf
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
                            @foreach($items as $item)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>{{ $item->name }} ({{ (getStock($feeding_group->farm_id, $item->id)->quantity ?? 0) + (getFeedRecordProduct($feeding->id,$item->id)->quantity??0) }} {{ $item->unit->code }})</label>
                                                <input name="items[]" value="{{ $item->id }}" class="d-none">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <input
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
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="comment">{{ __('global.comment')}}</label>
                                            <textarea name="comment" id="comment"  type="text" class="form-control">{{$feeding->comment}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="cattle_list">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('global.cattle_list')}}</h5>
                                        <a href="#cattle_list" class="badge badge-success mx-2" id="toggleAllButton">Select All</a>
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
                                                        <td><input type="checkbox" name="cattles[]" @if ($feeding->cattles->contains($cattle->id)) checked @endif  value="{{$cattle->id}}" class="form-control form-check"></td>
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

                        @can('feeding_update')
                            <button class="btn btn-success" type="submit">{{ __('global.update')}}</button>
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
@section('plugins.Select2',true)
@section('plugins.Sweetalert2',true)
@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            color: black;
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme:'classic',
        });

        $('.quantity-input').on('input', function() {
            var quantity = parseFloat($(this).val());
            var min = parseFloat($(this).data('min'));
            var max = parseFloat($(this).data('max'));

            if (quantity < min) {
                Swal.fire('Error', 'Quantity must be greater than ' + min, 'error');
                $(this).val(min); // Reset to the minimum value
            } else if (quantity > max) {
                Swal.fire('Error', 'Quantity must be less than or equal to ' + max, 'error');
                $(this).val(max); // Reset to the maximum value
            }
        });
        var $checkboxes = $('input[type="checkbox"]');
        var $toggleAllButton = $('#toggleAllButton');

        $toggleAllButton.on('click', function() {
            $checkboxes.prop('checked', function(i, val) {
                return !val;
            });
            toggleButtonText();
        });

        function toggleButtonText() {
            if ($checkboxes.length === $checkboxes.filter(':checked').length) {
                $toggleAllButton.text('Uncheck All');
                $toggleAllButton.removeClass('badge-success')
                $toggleAllButton.addClass('badge-danger')
            } else {
                $toggleAllButton.text('Check All');
                $toggleAllButton.removeClass('badge-danger')
                $toggleAllButton.addClass('badge-success')
            }
        }

        toggleButtonText(); // Initialize button text

        $checkboxes.on('change', function() {
            toggleButtonText();
        });
    });
</script>
@stop
