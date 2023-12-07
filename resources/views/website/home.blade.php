@extends('layouts.master')
@section('content')
    <section class="">
        <div class="container">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://c4.wallpaperflare.com/wallpaper/264/666/478/3-316-16-9-aspect-ratio-s-sfw-wallpaper-preview.jpg" class="d-block w-100" alt="..." style="max-height: 450px">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://c4.wallpaperflare.com/wallpaper/900/92/1002/3-316-16-9-aspect-ratio-s-sfw-wallpaper-preview.jpg" class="d-block w-100" alt="..." style="max-height: 450px">
                    </div>
                    <div class="carousel-item">
                        <img src="https://i.pinimg.com/564x/e4/a4/5c/e4a45cb6f4902f67710f69e57f38b847.jpg" class="d-block w-100" alt="..." style="max-height: 450px">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

@endsection
