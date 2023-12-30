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
                    <div class="table-responsive">
                        <h4 class="text-center bg-primary text-white py-2">{{__('global.cattle_information')}}</h4>
                        <table class="table table-bordered">
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
                    <div class="table-responsive">
                        <h4 class="text-center bg-primary text-white py-2">{{__('global.latest_fattening_information').' - '.$fattening->date}}</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>{{__('global.weight')}}</th>
                                <td>{{$fattening->weight}} {{__('global.kg')}}</td>
                                <th>{{__('global.height')}}</th>
                                <td>{{$fattening->height}} {{__('global.inch')}}</td>
                                <th>{{__('global.width')}}</th>
                                <td>{{$fattening->width}} {{__('global.inch')}}</td>
                            </tr>
                            <tr>
                                <th>{{__('global.health')}}</th>
                                <td>{{$fattening->health}}</td>
                                <th>{{__('global.color')}}</th>
                                <td>{{$fattening->color}}</td>
                                <th>{{__('global.foot')}}</th>
                                <td>{{$fattening->foot}}</td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                        <div class="grid ">
                                            @foreach($fattening->images as $img)
                                            <a target="_blank" href="{{asset('uploads/'.$img)}}" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                                                <img src="{{asset('uploads/'.$img)}}" class="img-thumbnail img-lg">
                                            </a>
                                            @endforeach
                                        </div>

                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <h4 class="text-center bg-primary text-white py-2">{{__('global.fattening_information_update')}}</h4>
                        <form action="{{route('admin.fattenings.store',['id'=>$cattle->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="weight">{{ __('global.weight')}} ({{ __('global.kg')}})<span class="text-danger"> *</span></label>
                                        <input id="weight" value="{{old('weight')}}" name="weight" type="number" step="any"  class="form-control" placeholder="{{ __('global.weight')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="height">{{ __('global.height')}} ({{ __('global.inch')}})<span class="text-danger"> *</span></label>
                                        <input id="height" value="{{old('height')}}" name="height" type="number" step="any"  class="form-control" placeholder="{{ __('global.height')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="width">{{ __('global.width')}} ({{ __('global.inch')}})<span class="text-danger"> *</span></label>
                                        <input id="width" value="{{old('width')}}" name="width" type="number"  step="any" class="form-control" placeholder="{{ __('global.width')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="health">{{ __('global.health')}}<span class="text-danger"> *</span></label>
                                        <input id="health" value="{{old('health')}}" name="health" type="text"  class="form-control" placeholder="{{ __('global.health')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="foot">{{ __('global.foot')}}<span class="text-danger"> *</span></label>
                                        <input id="foot" value="{{old('foot')}}" name="foot" type="text"  class="form-control" placeholder="{{ __('global.foot')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="color">{{ __('global.color')}}<span class="text-danger"> *</span></label>
                                        <input id="color" value="{{old('color')}}" name="color" type="text"  class="form-control" placeholder="{{ __('global.color')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="gallery">{{__('global.select_gallery_images')}}</label>
                                        <input name="gallery[]" type="file" class="form-control" id="gallery" accept="image/*" multiple>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-12 mb-2">
                                    <div id="image-preview">
                                        <!-- Selected images will be displayed here -->
                                    </div>
                                </div>

                                <input class="btn btn-primary" type="submit" value="{{__('global.update')}}">

                            </div>
                        </form>
                    </div>


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
    </script>
    <script>
        // Function to display selected images as thumbnails
        function displaySelectedImages(input) {
            var imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = ''; // Clear previous images

            if (input.files && input.files.length > 0) {
                for (var i = 0; i < input.files.length; i++) {
                    var file = input.files[i];
                    if (file.type.match('image')) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var thumbnail = document.createElement('img');
                            thumbnail.src = e.target.result;
                            thumbnail.style.maxWidth = '150px';
                            thumbnail.style.maxHeight = '150px';
                            thumbnail.style.marginRight = '10px'; // Add some spacing
                            imagePreview.appendChild(thumbnail);
                        }

                        reader.readAsDataURL(file);
                    }
                }
            }
        }

        // Add an event listener to the file input
        var galleryInput = document.getElementById('gallery');
        galleryInput.addEventListener('change', function() {
            displaySelectedImages(this);
        });

    </script>
@stop
