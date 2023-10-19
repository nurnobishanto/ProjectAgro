@extends('adminlte::page')

@section('title', __('global.update_treatment'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_treatment')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.treatments.index')}}">{{ __('global.treatments')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_treatment')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item list-group-item-info"><strong>{{__('global.farm')}} :</strong> {{$cattle->farm->name}}</li>
                        <li class="list-group-item"><strong>{{__('global.cattle_type')}} :</strong> {{$cattle->cattle_type->title}}</li>
                        <li class="list-group-item"><strong>{{__('global.tag_id')}} :</strong> {{$cattle->tag_id}}</li>
                    </ul>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.treatments.update',['treatment'=> $treatment->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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

                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="date">{{ __('global.select_date')}}<span class="text-danger"> *</span></label>
                                            <input disabled name="date" id="date" value="{{$treatment->date}}" type="text" class="form-control datepicker">
                                            <input name="tag_id" value="{{$cattle->id}}"  class="d-none">
                                            <input name="farm_id" value="{{$cattle->farm_id}}"  class="d-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="doctor">{{ __('global.doctor')}}<span class="text-danger"> *</span></label>
                                            <input  name="doctor" value="{{$treatment->doctor}}" id="doctor"  type="text" class="form-control">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="disease">{{ __('global.disease')}}<span class="text-danger"> *</span></label>
                                            <textarea name="disease" id="disease" rows="1" type="text" class="form-control">{{$treatment->disease}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="comment">{{ __('global.comment')}}</label>
                                            <textarea name="comment" id="comment"  rows="1" type="text" class="form-control">{{$treatment->comment}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach($products as $item)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form">
                                                <label>{{ $item->name }} ({{ (getStock($cattle->farm_id, $item->id)->quantity ?? 0) + $item->pivot->quantity }} {{ $item->unit->code }})<span class="text-danger"> *</span></label>
                                                <input name="items[]" value="{{ $item->id }}" class="d-none">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <input
                                                                name="qty[]"
                                                                type="number"
                                                                value="{{$item->pivot->quantity}}"
                                                                placeholder="{{ __('global.quantity') }}"
                                                                class="form-control quantity-input"
                                                                data-min="0"
                                                                data-max="{{ getStock($cattle->farm_id, $item->id)->quantity ?? 0 }}"
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

                        </div>

                        @can('treatment_update')
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
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false
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
