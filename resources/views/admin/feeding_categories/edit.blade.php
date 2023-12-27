@extends('adminlte::page')

@section('title', __('global.update_feeding_category'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_feeding_category')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.feeding-categories.index')}}">{{ __('global.feeding_categories')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_feeding_category')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.feeding-categories.update',['feeding_category'=>$feeding_category->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('global.name')}}<span class="text-danger"> *</span></label>
                                    <input id="name" value="{{$feeding_category->name}}" name="name" class="form-control" placeholder="{{ __('global.enter_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ __('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($feeding_category->status == 'active') selected @endif>{{ __('global.active')}}</option>
                                        <option value="deactivate" @if($feeding_category->status == 'deactivate') selected @endif>{{ __('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12" id="cattle_list">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('global.cattle_list')}}</h5>
                                        <a href="#" class="badge badge-success mx-2" id="toggleAllButton">Select All</a>
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
                                                        <td><input type="checkbox" name="cattles[]" @if ($feeding_category->cattle->contains($cattle->id)) checked @endif  value="{{$cattle->id}}" class="form-control form-check"></td>
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

                        @can('feeding_category_update')
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
