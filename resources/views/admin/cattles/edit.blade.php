@extends('adminlte::page')

@section('title', __('global.update_cattle'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_cattle')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.cattles.index')}}">{{ __('global.cattles')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_cattle')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.cattles.update',['cattle'=>$cattle->id])}}" method="POST" enctype="multipart/form-data" id="supplier-form">
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
                                    <label for="session_year_id">{{ __('global.select_session_year')}}<span class="text-danger"> *</span></label>
                                    <select id="session_year_id" name="session_year_id" class="form-control">
                                        <option value="">{{ __('global.select_session_year')}}</option>
                                        @foreach($session_years as $sy)
                                            <option value="{{$sy->id}}" @if($cattle->session_year_id == $sy->id) selected @endif>{{$sy->year}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="farm_id">{{ __('global.select_farm')}}<span class="text-danger"> *</span></label>
                                    <select id="farm_id" name="farm_id" class="form-control">
                                        <option value="">{{ __('global.select_farm')}}</option>
                                        @foreach($farms as $farm)
                                            <option value="{{$farm->id}}" @if($cattle->farm_id == $farm->id) selected @endif>{{$farm->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tag_id">{{ __('global.tag_id')}}<span class="text-danger"> *</span></label>
                                    <input id="tag_id" name="tag_id" value="{{$cattle->tag_id}}" class="form-control" placeholder="{{ __('global.enter_tag_id')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="entry_date">{{ __('global.entry_date')}}<span class="text-danger"> *</span></label>
                                    <input id="entry_date" name="entry_date" value="{{$cattle->entry_date}}" placeholder="{{ __('global.entry_date')}}" type="text" readonly  class="datepicker form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shade_no">{{ __('global.location_or_shade_no')}}<span class="text-danger"> *</span></label>
                                    <input id="shade_no" name="shade_no" value="{{$cattle->shade_no}}" class="form-control" placeholder="{{ __('global.enter_location_or_shade_no')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_purchase">{{ __('global.entry_or_buy')}}<span class="text-danger"> *</span></label>
                                    <select id="is_purchase" name="is_purchase" class="form-control">
                                        <option value="">{{ __('global.entry_or_buy')}}</option>
                                        <option value="0"  @if($cattle->is_purchase == 0) selected @endif>{{ __('global.house_production')}}</option>
                                        <option value="1"  @if($cattle->is_purchase == 1) selected @endif>{{ __('global.buy_from_another_farm')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier_id">{{ __('global.select_supplier')}}<span class="text-danger"> *</span></label>
                                    <select id="supplier_id" name="supplier_id" class="form-control">
                                        <option value="">{{ __('global.select_supplier')}}</option>
                                        @foreach(getSuppliers() as $supplier)
                                            <option value="{{$supplier->id}}" @if($cattle->supplier_id == $supplier->id) selected @endif>{{$supplier->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purchase_price">{{ __('global.purchase_price')}}<span class="text-danger"> *</span></label>
                                    <input id="purchase_price" type="number" step="any" name="purchase_price" value="{{$cattle->purchase_price}}"  placeholder="{{ __('global.enter_purchase_price')}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purchase_date">{{ __('global.entry_or_buy_date')}}<span class="text-danger"> *</span></label>
                                    <input id="purchase_date" name="purchase_date" value="{{$cattle->purchase_date}}" type="text" placeholder="{{ __('global.entry_or_buy_date')}}" class="datepicker form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">{{ __('global.dob')}}<span class="text-danger"> *</span></label>
                                    <input id="dob" name="dob" type="text" value="{{$cattle->dob}}" class="datepicker form-control" placeholder="{{ __('global.select_dob')}}">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_id">{{ __('global.batch_no')}}<span class="text-danger"> *</span></label>
                                    <select id="batch_id" name="batch_id" class="form-control">
                                        <option value="">{{ __('global.select_batch_no')}}</option>
                                        @foreach($batches as $batch)
                                            <option value="{{$batch->id}}" @if($cattle->batch_id == $batch->id) selected @endif>{{$batch->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            @if($cattle->status ==='active' || $cattle->status ==='deactivate')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($cattle->status == "active") selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate" @if($cattle->status == "deactivate") selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cattle_type_id">{{ __('global.select_cattle_type')}}<span class="text-danger"> *</span></label>
                                    <select id="cattle_type_id" name="cattle_type_id" class="form-control">
                                        <option value="">{{ __('global.select_cattle_type')}}</option>
                                        @foreach($cattle_types as $cattle_type)
                                            <option value="{{$cattle_type->id}}" @if($cattle->cattle_type_id === $cattle_type->id) selected @endif>{{$cattle_type->title}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="breed_id">{{ __('global.select_breed')}}<span class="text-danger"> *</span></label>
                                    <select id="breed_id" name="breed_id" class="form-control">
                                        <option value="">{{ __('global.select_breed')}}</option>
                                        @foreach($breeds as $breed)
                                            <option value="{{$breed->id}}" @if($cattle->breed_id === $breed->id) selected @endif>{{$breed->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">{{ __('global.select_gender')}}<span class="text-danger"> *</span></label>
                                    <select id="gender" name="gender" class="form-control">
                                        <option value="">{{ __('global.select_gender')}}</option>
                                        <option value="male" @if($cattle->gender == "male") selected @endif>{{ __('global.male')}}</option>
                                        <option value="female" @if($cattle->gender == "female") selected @endif>{{ __('global.female')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">{{ __('global.select_cattle_category')}}<span class="text-danger"> *</span></label>
                                    <select id="category" name="category" class="form-control">
                                        <option value="{{$cattle->category}}" selected>{{ __('global.'.$cattle->category)}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="parent">
                                <div class="form-group">
                                    <label for="parent_id">{{ __('global.mother_tag_id')}}</label>
                                    <select id="parent_id" name="parent_id" class="form-control">
                                        <option value="">{{ __('global.mother_tag_id')}}</option>
                                        @foreach($mother_cattle as $mcattle)
                                            <option value="{{$mcattle->id}}" @if($cattle->parent_id == $mcattle->id) selected @endif>{{$mcattle->tag_id}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="dairy_date">
                                <div class="form-group">
                                    <label for="dairy_date">{{ __('global.dairy_date')}}</label>
                                    <input  name="dairy_date" value="{{$cattle->dairy_date}}" type="text"  readonly class="datepicker form-control" placeholder="{{ __('global.dairy_date')}}">
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="last_dairy_date">
                                <div class="form-group">
                                    <label for="last_dairy_date">{{ __('global.last_dairy_date')}}</label>
                                    <input name="last_dairy_date" value="{{$cattle->last_dairy_date}}" class="form-control" placeholder="{{ __('global.last_dairy_date')}}">
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="total_child">
                                <div class="form-group">
                                    <label for="total_child">{{ __('global.total_child')}}</label>
                                    <input  name="total_child" value="{{$cattle->total_child}}" type="number" step="any" class="form-control" placeholder="{{ __('global.total_child')}}">
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="pregnant_date">
                                <div class="form-group">
                                    <label for="pregnant_date">{{ __('global.pregnant_date')}}</label>
                                    <input  name="pregnant_date" value="{{$cattle->pregnant_date}}" type="text" readonly  class="datepicker form-control" placeholder="{{ __('global.pregnant_date')}}">
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="pregnant_no">
                                <div class="form-group">
                                    <label for="pregnant_no">{{ __('global.pregnant_no')}}</label>
                                    <input  name="pregnant_no" value="{{$cattle->pregnant_no}}" type="number" step="any" class="form-control" placeholder="{{ __('global.pregnant_no')}}">
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="delivery_date">
                                <div class="form-group">
                                    <label for="delivery_date">{{ __('global.delivery_date')}}</label>
                                    <input  name="delivery_date" value="{{$cattle->delivery_date}}" type="text" readonly  class="datepicker form-control" placeholder="{{ __('global.delivery_date')}}">
                                </div>
                            </div>
                        </div>
                        @can('cattle_update')
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

            $('.select2').select2();
            var cat = $('#category').val();
            if (cat=== 'sheep'|| cat === 'calf') {
                $('#parent').removeClass('d-none');

                $('#last_dairy_date').addClass('d-none');
                $('#dairy_date').addClass('d-none');
                $('#total_child').addClass('d-none');
                $('#pregnant_date').addClass('d-none');
                $('#pregnant_no').addClass('d-none');
                $('#delivery_date').addClass('d-none');
            }else if(cat === 'dairy' ){
                $('#parent').addClass('d-none');
                $('#last_dairy_date').addClass('d-none');
                $('#pregnant_date').addClass('d-none');
                $('#pregnant_no').addClass('d-none');
                $('#delivery_date').addClass('d-none');

                $('#dairy_date').removeClass('d-none');
                $('#total_child').removeClass('d-none');
            }else if(cat === 'dry'){
                $('#parent').addClass('d-none');
                $('#dairy_date').addClass('d-none');
                $('#pregnant_date').addClass('d-none');
                $('#pregnant_no').addClass('d-none');
                $('#delivery_date').addClass('d-none');

                $('#last_dairy_date').removeClass('d-none');
                $('#total_child').removeClass('d-none');
            }else if(cat === 'pregnant'){
                $('#parent').addClass('d-none');
                $('#total_child').addClass('d-none');
                $('#dairy_date').addClass('d-none');
                $('#last_dairy_date').addClass('d-none');

                $('#pregnant_date').removeClass('d-none');
                $('#pregnant_no').removeClass('d-none');
                $('#delivery_date').removeClass('d-none');
            }
            else{
                $('#parent').addClass('d-none');
                $('#total_child').addClass('d-none');
                $('#dairy_date').addClass('d-none');
                $('#last_dairy_date').addClass('d-none');
                $('#pregnant_date').addClass('d-none');
                $('#pregnant_no').addClass('d-none');
                $('#delivery_date').addClass('d-none');
            }

            //loadCattleTypes();
            $('#cattle_type_id').change(function() {
                var cattle_type_id = $(this).val();
                if (cattle_type_id) {
                    loadBreeds(cattle_type_id);
                } else {
                    $('#breed_id').empty();
                }
            });

            $('#gender').change(function() {
                $('#parent').addClass('d-none');
                $('#total_child').addClass('d-none');
                $('#dairy_date').addClass('d-none');
                $('#last_dairy_date').addClass('d-none');
                $('#pregnant_date').addClass('d-none');
                $('#pregnant_no').addClass('d-none');
                $('#delivery_date').addClass('d-none');
                var gender = $(this).val();
                if (gender) {
                    loadCategories(gender);
                } else {
                    $('#category').empty();
                }
            });
            $('#category').change(function() {
                var cat = $(this).val();
                if (cat === 'sheep'|| cat === 'calf') {
                    $('#parent').removeClass('d-none');

                    $('#last_dairy_date').addClass('d-none');
                    $('#dairy_date').addClass('d-none');
                    $('#total_child').addClass('d-none');
                    $('#pregnant_date').addClass('d-none');
                    $('#pregnant_no').addClass('d-none');
                    $('#delivery_date').addClass('d-none');
                }else if(cat === 'dairy' ){
                    $('#parent').addClass('d-none');
                    $('#last_dairy_date').addClass('d-none');
                    $('#pregnant_date').addClass('d-none');
                    $('#pregnant_no').addClass('d-none');
                    $('#delivery_date').addClass('d-none');

                    $('#dairy_date').removeClass('d-none');
                    $('#total_child').removeClass('d-none');
                }else if(cat === 'dry'){
                    $('#parent').addClass('d-none');
                    $('#dairy_date').addClass('d-none');
                    $('#pregnant_date').addClass('d-none');
                    $('#pregnant_no').addClass('d-none');
                    $('#delivery_date').addClass('d-none');

                    $('#last_dairy_date').removeClass('d-none');
                    $('#total_child').removeClass('d-none');
                }else if(cat === 'pregnant'){
                    $('#parent').addClass('d-none');
                    $('#total_child').addClass('d-none');
                    $('#dairy_date').addClass('d-none');
                    $('#last_dairy_date').addClass('d-none');

                    $('#pregnant_date').removeClass('d-none');
                    $('#pregnant_no').removeClass('d-none');
                    $('#delivery_date').removeClass('d-none');
                }
                else{
                    $('#parent').addClass('d-none');
                    $('#total_child').addClass('d-none');
                    $('#dairy_date').addClass('d-none');
                    $('#last_dairy_date').addClass('d-none');
                    $('#pregnant_date').addClass('d-none');
                    $('#pregnant_no').addClass('d-none');
                    $('#delivery_date').addClass('d-none');
                }
            });

            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: false
            });

        });

    </script>
    <script>
        // Function to load categories from your server
        function loadCattleTypes() {
            $.ajax({
                url: '{{route('cattle_types')}}', // Replace with your server URL
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var cattle_type_id = $('#cattle_type_id');
                    cattle_type_id.empty();
                    cattle_type_id.append($('<option>', {
                        value: '',
                        text: '{{ __('global.select_cattle_type')}}'
                    }));
                    $.each(data, function(key, value) {
                        cattle_type_id.append($('<option>', {
                            value: value.id,
                            text: value.title
                        }));
                    });
                }
            });
        }

        // Function to load items based on selected category
        function loadBreeds(cattle_type_id) {
            $.ajax({
                url: "{{ route('cattle_type') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}', // Add a CSRF token if needed
                    cattle_type_id: cattle_type_id // Send cattle_type_id as data
                },
                success: function(data) {
                    var breedsSelect = $('#breed_id');
                    breedsSelect.empty();
                    breedsSelect.append($('<option>', {
                        value: '',
                        text: '{{__('global.select_breed')}}'
                    }));
                    $.each(data, function(key, value) {
                        breedsSelect.append($('<option>', {
                            value: value.id,
                            text: value.name
                        }));
                    });
                }
            });
        }
        function loadCategories(gender) {
            $.ajax({
                url: "{{ route('category') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}', // Add a CSRF token if needed
                    gender: gender // Send cattle_type_id as data
                },
                success: function(data) {
                    var breedsSelect = $('#category');
                    breedsSelect.empty();
                    breedsSelect.append($('<option>', {
                        value: '',
                        text: '{{__('global.select_cattle_category')}}'
                    }));
                    $.each(data, function(key, value) {
                        breedsSelect.append($('<option>', {
                            value: key,
                            text: value
                        }));
                    });
                }
            });
        }
    </script>
@stop
