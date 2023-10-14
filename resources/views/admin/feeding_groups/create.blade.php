@extends('adminlte::page')

@section('title', __('global.create_feeding_group'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_feeding_group')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.feeding-groups.index')}}">{{ __('global.feeding_groups')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_feeding_group')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.feeding-groups.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                            <option value="{{$farm->id}}">{{$farm->name}}</option>
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
                                            <option value="{{$ct->id}}">{{$ct->title}}</option>
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
                                            <option value="{{$fc->id}}">{{$fc->name}}</option>
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
                                            <option value="{{$fm->id}}">{{$fm->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control select2" id="status">
                                        <option value="active">{{__('global.active')}}</option>
                                        <option value="deactivate">{{__('global.deactivate')}}</option>
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
                                                        <td><input type="checkbox" name="items[]"  value="{{$item->id}}" class="form-control form-check"></td>
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

                        @can('feeding_group_create')
                            <button class="btn btn-success" type="submit">{{ __('global.create')}}</button>
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
