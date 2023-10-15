@extends('adminlte::page')

@section('title', __('global.update_feeding_group'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_feeding_group')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.feeding-groups.index')}}">{{ __('global.feeding_groups')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_feeding_group')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.feeding-groups.update',['feeding_group'=>$feeding_group->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
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

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="farm_id">{{ __('global.select_farm')}}<span class="text-danger"> *</span></label>
                                    <select name="farm_id" id="farm_id" class="form-control select2">
                                        <option value="">{{ __('global.select_farm')}}</option>
                                        @foreach(getFarms() as $farm)
                                            <option value="{{$farm->id}}" @if($farm->id == $feeding_group->farm_id) selected @endif>{{$farm->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="cattle_type_id">{{ __('global.select_cattle_type')}}<span class="text-danger"> *</span></label>
                                    <select name="cattle_type_id" id="cattle_type_id" class="form-control select2">
                                        <option value="">{{ __('global.select_cattle_type')}}</option>
                                        @foreach(getCattleTypes() as $ct)
                                            <option value="{{$ct->id}}" @if($ct->id == $feeding_group->cattle_type_id) selected @endif>{{$ct->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="feeding_category_id">{{ __('global.select_feeding_category')}}<span class="text-danger"> *</span></label>
                                    <select name="feeding_category_id" id="feeding_category_id" class="form-control select2">
                                        <option value="">{{ __('global.select_feeding_category')}}</option>
                                        @foreach(getAllData(\App\Models\FeedingCategory::class) as $fc)
                                            <option value="{{$fc->id}}" @if($fc->id == $feeding_group->feeding_category_id) selected @endif>{{$fc->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="feeding_moment_id">{{ __('global.select_feeding_moment')}}<span class="text-danger"> *</span></label>
                                    <select name="feeding_moment_id" id="feeding_moment_id" class="form-control select2">
                                        <option value="">{{ __('global.select_feeding_moment')}}</option>
                                        @foreach(getAllData(\App\Models\FeedingMoment::class) as $fm)
                                            <option value="{{$fm->id}}" @if($fm->id == $feeding_group->feeding_moment_id) selected @endif>{{$fm->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control select2" id="status">
                                        <option value="active" @if('active' == $feeding_group->status) selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate" @if('deactivate' == $feeding_group->status) selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('global.select_feeding_item')}}</h5>
                                        <a href="#" class="badge badge-success mx-2" id="toggleAllButton">Select All</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th width="80px">{{__('global.select')}}</th>
                                                    <th>{{__('global.item_name')}}</th>
                                                    <th>{{__('global.item_unit')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(getFeedItems() as $item)
                                                    <tr>
                                                        <td><input type="checkbox" @if ($feeding_group->products->contains($item->id)) checked @endif name="items[]"  value="{{$item->id}}" class="form-control form-check"></td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->unit->name??'--'}} ( {{$item->unit->code??'--'}} )</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @can('feeding_group_update')
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

        var $checkboxes = $('input[type="checkbox"]');
        var $toggleAllButton = $('#toggleAllButton');

        $toggleAllButton.on('click', function() {
            var allChecked = $checkboxes.length === $checkboxes.filter(':checked').length;

            if (allChecked) {
                // If all checkboxes are checked, uncheck all
                $checkboxes.prop('checked', false);
            } else {
                // If not all checkboxes are checked, check all
                $checkboxes.prop('checked', true);
            }

            toggleButtonText();
        });

        function toggleButtonText() {
            if ($checkboxes.length === $checkboxes.filter(':checked').length) {
                $toggleAllButton.text('Uncheck All');
                $toggleAllButton.removeClass('badge-success').addClass('badge-danger');
            } else {
                $toggleAllButton.text('Check All');
                $toggleAllButton.removeClass('badge-danger').addClass('badge-success');
            }
        }

        toggleButtonText(); // Initialize button text

        $checkboxes.on('change', function() {
            toggleButtonText();
        });
    });
</script>
@stop
