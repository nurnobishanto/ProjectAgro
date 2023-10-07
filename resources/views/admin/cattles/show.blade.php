@extends('adminlte::page')

@section('title', __('global.view_cattle'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_cattle')}} - {{$cattle->tag_id}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.cattles.index')}}">{{__('global.cattles')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_cattle')}}</li>
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
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <tr>
                                <th>{{__('global.session_year')}}</th>
                                <td>{{$cattle->session_year->year}}</td>
                                <td colspan="2" rowspan="8"><img  style="max-height: 300px" src="{{asset('uploads/'.$cattle->image)}}" alt="Cattle Image"></td>
                            </tr>
                            <tr>
                                <th>{{__('global.farm')}}</th>
                                <td>{{$cattle->farm->name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.tag_id')}}</th>
                                <td>{{$cattle->tag_id}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.dob')}}</th>
                                <td>{{$cattle->dob}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.age')}}</th>
                                <td>{{calculateAgeInDaysFromDate($cattle->dob)}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.location_or_shade_no')}}</th>
                                <td>{{$cattle->shade_no}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.purchase_date')}}</th>
                                <td>{{$cattle->purchase_date}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.cattle_type')}}</th>
                                <td>{{$cattle->cattle_type->title}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.cattle_breed')}}</th>
                                <td>{{$cattle->breeds->name}}</td>
                                <th>{{ __('global.entry_or_buy')}}</th>
                                <td>{{$cattle->is_purchase?__('global.buy_from_another_farm'):__('global.house_production')}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.batch_no')}}</th>
                                <td>{{$cattle->batch->name}}</td>
                                <th>{{ __('global.entry_date')}}</th>
                                <td>{{$cattle->entry_date}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.mother_tag_id')}}</th>
                                <td>{{$cattle->parent->tag_id??'--'}}</td>
                                <th>{{ __('global.dairy_date')}}</th>
                                <td>{{$cattle->dairy_date??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.pregnant_date')}}</th>
                                <td>{{$cattle->pregnant_date??'--'}}</td>
                                <th>{{ __('global.pregnant_no')}}</th>
                                <td>{{$cattle->pregnant_no??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.delivery_date')}}</th>
                                <td>{{$cattle->delivery_date??'--'}}</td>
                                <th>{{ __('global.problem')}}</th>
                                <td>{{$cattle->problem??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.gender')}}</th>
                                <td>{{__('global.'.$cattle->gender)}}</td>
                                <th>{{ __('global.status')}}</th>
                                <td>{{__('global.'.$cattle->status)}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.death_date')}}</th>
                                <td>{{$cattle->death_date??'--'}}</td>
                                <th>{{ __('global.death_reason')}}</th>
                                <td>{{$cattle->death_reason??'--'}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.created_by')}}</th>
                                <td>{{$cattle->createdBy->name}}</td>
                                <th>{{ __('global.updated_by')}}</th>
                                <td>{{$cattle->updatedBy->name}}</td>
                            </tr>
                        </table>
                    </div>
                        <form action="{{ route('admin.cattles.destroy', $cattle->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.cattles.index')}}" class="btn btn-success" >Go Back</a>
                            @can('cattle_update')
                                <a href="{{route('admin.cattles.edit',['cattle'=>$cattle->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('cattle_delete')
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
