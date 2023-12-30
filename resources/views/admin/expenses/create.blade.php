@extends('adminlte::page')

@section('title', __('global.create_expense'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_expense')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.expenses.index')}}">{{ __('global.expenses')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_expense')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.expenses.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="date">{{ __('global.select_date')}} <span class="text-danger"> *</span></label>
                                    <input id="date" name="date" value="{{old('date')}}" type="text" readonly class="form-control datepicker" placeholder="{{ __('global.select_date')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_id">{{ __('global.select_account')}} <span class="text-danger"> *</span></label>
                                    <select id="account_id" name="account_id" class="form-control">
                                        <option value="">{{ __('global.select_account')}} </option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account->id}}">{{$account->bank_name}} - {{$account->account_name}} - {{$account->account_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expense_category_id">{{ __('global.select_expense_category')}} <span class="text-danger"> *</span></label>
                                    <select id="expense_category_id" name="expense_category_id" class="form-control">
                                        <option value="">{{ __('global.select_expense_category')}} </option>
                                        @foreach($expense_categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">{{ __('global.amount')}}<span class="text-danger"> *</span></label>
                                    <input id="amount" type="number" step="any" name="amount" class="form-control" placeholder="{{ __('global.amount')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="note">{{ __('global.note')}}</label>
                                    <textarea id="note"  name="note" class="form-control" placeholder="{{ __('global.enter_note')}}">{{old('note')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">{{__('global.select_photo')}}</label>
                                    <input name="photo" type="file" class="form-control" id="photo" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="" alt="Selected Image" id="selected-image" style="display: none;max-height: 150px">
                            </div>

                        </div>

                        @can('expense_create')
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
                theme : 'classic'
            });
            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const imageForm = document.getElementById('admin-form');
            const selectedImage = document.getElementById('selected-image');

            imageForm.addEventListener('change', function () {
                const fileInput = this.querySelector('input[type="file"]');
                const file = fileInput.files[0];

                if (file) {
                    const imageUrl = URL.createObjectURL(file);
                    selectedImage.src = imageUrl;
                    selectedImage.style.display = 'block';
                } else {
                    selectedImage.src = '';
                    selectedImage.style.display = 'none';
                }
            });
        });
    </script>
@stop
