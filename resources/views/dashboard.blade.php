@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
   L {{app()->currentLocale()}}
   S {{session()->get('locale')}}
@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function() {
            toastr.now();
        });
    </script>
@stop
