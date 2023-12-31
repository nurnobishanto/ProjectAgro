@extends('adminlte::page')

@section('title', __('global.view_feeding_category'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_feeding_category')}} - {{$feeding_category->name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.feeding-categories.index')}}">{{__('global.feeding_categories')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_feeding_category')}}</li>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('global.name')}}</label>
                                        <input id="name" class="form-control" disabled value="{{$feeding_category->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('global.status')}}</label>
                                        <input id="status" class="form-control" disabled value="{{ __('global.'.$feeding_category->status)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updated_at">{{ __('global.updated_at')}}</label>
                                        <input id="updated_at" class="form-control" disabled value="{{date_format($feeding_category->updated_at,'d M y h:i A') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="created_by">{{ __('global.created_by')}}</label>
                                        <input id="created_by" class="form-control" disabled value="{{$feeding_category->createdBy->name}}">
                                    </div>
                                </div>
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
                                                    @foreach($feeding_category->cattle as $cattle)
                                                        <tr>
                                                            <td><input type="checkbox"  checked disabled class="form-control form-check"></td>
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



                        <form action="{{ route('admin.feeding-categories.destroy', $feeding_category->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.feeding-categories.index')}}" class="btn btn-success" >Go Back</a>
                            @can('feeding_category_update')
                                <a href="{{route('admin.feeding-categories.edit',['feeding_category'=>$feeding_category->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('feeding_category_delete')
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
