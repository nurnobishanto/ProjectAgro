@extends('adminlte::page')

@section('title', __('global.dashboard'))

@section('content_header')
    <h1>{{__('global.dashboard')}}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hippo"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('global.total_cattle')}}</span>
                    <span class="info-box-number">{{$all_cattle_count->count()}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-hippo"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('global.active_cattle')}}</span>
                    <span class="info-box-number">{{$all_cattle_count->where('status','active')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hippo"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('global.death_cattle')}}</span>
                    <span class="info-box-number">{{$all_cattle_count->where('status','death')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hippo"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('global.sold_cattle')}}</span>
                    <span class="info-box-number">{{$all_cattle_count->where('status','sold')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-friends"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('global.active_suppliers')}}</span>
                    <span class="info-box-number">{{$suppliers->where('status','active')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('global.active_party')}}</span>
                    <span class="info-box-number">{{$parties->where('status','active')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-igloo"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('global.active_farms')}}</span>
                    <span class="info-box-number">{{$farms->where('status','active')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-wallet"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('global.active_accounts')}}</span>
                    <span class="info-box-number">{{$accounts->where('status','active')->count()}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Milk Production Bar Chart</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 359px;" width="1077" height="750" class="chartjs-render-monitor"></canvas>
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
@section('plugins.chartJs',true)
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

    <script>
        $(document).ready(function() {

            var chartData = @json($chartData['data']);
            var chartOptions = @json($chartData['options']);

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, chartData)
            var temp0 = chartData.datasets[1]
            var temp1 = chartData.datasets[0]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0
            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: chartOptions
            })



        });
    </script>
@stop
