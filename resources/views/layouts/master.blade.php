<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="SOFT-ITBD" name="author">
    <title>Sehrish Agro</title>

    <link href="{{asset('front')}}/libs/slick-carousel/slick/slick.css" rel="stylesheet" />
    <link href="{{asset('front')}}/libs/slick-carousel/slick/slick-theme.css" rel="stylesheet" />
    <link href="{{asset('front')}}/libs/tiny-slider/dist/tiny-slider.css" rel="stylesheet">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo.png') }}">


    <!-- Libs CSS -->
    <link href="{{asset('front')}}/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{asset('front')}}/libs/feather-webfont/dist/feather-icons.css" rel="stylesheet">
    <link href="{{asset('front')}}/libs/simplebar/dist/simplebar.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('front')}}/css/theme.min.css">


</head>

<body>

@include('includes.header')
<!-- Sign Up Modal -->
{{--@include('includes.sign_up_modal')--}}

<!-- Shop Cart Modal-->
{{--@include('includes.shop_cart_modal')--}}

<!-- Location Modal -->
{{--@include('includes.location_select_modal')--}}
<main>
    @yield('content')
</main>


<!-- Product Modal -->
{{--@include('includes.product_view_modal')--}}
<!-- footer -->

@include('includes.footer')

<!-- Javascript-->

<!-- Libs JS -->
<script src="{{asset('front')}}/libs/jquery/dist/jquery.min.js"></script>
<script src="{{asset('front')}}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('front')}}/libs/simplebar/dist/simplebar.min.js"></script>

<!-- Theme JS -->
<script src="{{asset('front')}}/js/theme.min.js"></script>
<script src="{{asset('front')}}/libs/jquery-countdown/dist/jquery.countdown.min.js"></script>
<script src="{{asset('front')}}/js/vendors/countdown.js"></script>
<script src="{{asset('front')}}/libs/slick-carousel/slick/slick.min.js"></script>
<script src="{{asset('front')}}/js/vendors/slick-slider.js"></script>
<script src="{{asset('front')}}/libs/tiny-slider/dist/min/tiny-slider.js"></script>
<script src="{{asset('front')}}/js/vendors/tns-slider.js"></script>
<script src="{{asset('front')}}/js/vendors/zoom.js"></script>
<script src="{{asset('front')}}/js/vendors/increment-value.js"></script>



</body>


<!-- Mirrored from freshcart.codescandy.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Sep 2023 19:01:38 GMT -->
</html>
