@extends('adminlte::page')

@section('title', __('global.view_feeding_group'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_feeding_group')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.feeding-groups.index')}}">{{__('global.feeding_groups')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_feeding_group')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="farm_id">{{ __('global.select_farm')}}<span class="text-danger"> *</span></label>
                                        <select disabled name="farm_id" id="farm_id" class="form-control select2">
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
                                        <select disabled name="cattle_type_id" id="cattle_type_id" class="form-control select2">
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
                                        <select disabled name="feeding_category_id" id="feeding_category_id" class="form-control select2">
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
                                        <select disabled name="feeding_moment_id" id="feeding_moment_id" class="form-control select2">
                                            <option value="">{{ __('global.select_feeding_moment')}}</option>
                                            @foreach(getAllData(\App\Models\FeedingMoment::class) as $fm)
                                                <option value="{{$fm->id}}" @if($fm->id == $feeding_group->feeding_moment_id) selected @endif>{{$fm->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('global.status')}}</label>
                                        <input id="status" class="form-control" disabled value="{{ __('global.'.$feeding_group->status)}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="updated_at">{{ __('global.updated_at')}}</label>
                                        <input id="updated_at" class="form-control" disabled value="{{date_format($feeding_group->updated_at,'d M y h:i A') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="updated_by">{{ __('global.updated_by')}}</label>
                                        <input id="updated_by" class="form-control" disabled value="{{$feeding_group->updatedBy->name}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="updated_at">{{ __('global.created_at')}}</label>
                                        <input id="updated_at" class="form-control" disabled value="{{date_format($feeding_group->created_at,'d M y h:i A') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="created_by">{{ __('global.created_by')}}</label>
                                        <input id="created_by" class="form-control" disabled value="{{$feeding_group->createdBy->name}}">
                                    </div>
                                </div>
                                <div class="col-12">
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
                                                        <th>{{__('global.item_name')}}</th>
                                                        <th>{{__('global.item_unit')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($feeding_group->products as $item)
                                                        <tr>
                                                            <td><input type="checkbox" disabled @if ($feeding_group->products->contains($item->id)) checked @endif name="items[]"  value="{{$item->id}}" class="form-control form-check"></td>
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



                        <form action="{{ route('admin.feeding-groups.destroy', $feeding_group->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.feeding-groups.index')}}" class="btn btn-success" >Go Back</a>
                            @can('feeding_group_update')
                                <a href="{{route('admin.feeding-groups.edit',['feeding_group'=>$feeding_group->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('feeding_group_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
        function checkSinglePermission(idName, className,inGroupCount,total,groupCount) {
            if($('.'+className+' input:checked').length === inGroupCount){
                $('#'+idName).prop('checked',true);
            }else {
                $('#'+idName).prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        function checkPermissionByGroup(idName, className,total,groupCount) {
            if($('#'+idName).is(':checked')){
                $('.'+className+' input').prop('checked',true);
            }else {
                $('.'+className+' input').prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        $('#select_all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@stop
