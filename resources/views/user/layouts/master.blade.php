<!DOCTYPE html>
<html lang="{{ get_default_language_code() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ (isset($page_title) ? __($page_title) : __("Dashboard")) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @include('partials.header-asset')
    
    @stack("css")
</head>
<body>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
{{-- <div id="preloader"></div> --}}
{{-- @include('frontend.partials.preloader') --}}
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Dashboard
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="page-wrapper bg-overlay-base bg_img" data-background="{{ asset('public/frontend/images/element/banner-bg.jpg') }}">

    @include('user.partials.side-nav')

    <div class="main-wrapper">
        <div class="main-body-wrapper">
            @include('user.partials.top-nav')
            <div class="body-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Dashboard
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


@include('partials.footer-asset')
<script src="{{ asset('public/frontend/js/apexcharts.min.js') }}"></script>

@stack("script")

<script>
    var options = {
          series: [{
          name: 'series1',
          color: "#8358ff",
          data: [31, 50, 70, 81, 42, 109, 100]
        }, {
          name: 'series2',
          data: [11, 32, 95, 32, 34, 52, 41]
        }],
          chart: {
          height: 350,
          type: 'area',
          toolbar: {
              show: false
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
        },
        };

    var chart = new ApexCharts(document.querySelector("#chart1"), options);
    chart.render();

    var options = {
          series: [{
          data: [44, 55, 41, 64, 22, 43, 21],
          color: "#8358ff"
        }, {
          data: [53, 32, 33, 52, 13, 44, 32]
        }],
          chart: {
          type: 'bar',
          toolbar: {
              show: false
          },
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: true,
            dataLabels: {
              position: 'top',
            },
          }
        },
        dataLabels: {
          enabled: true,
          offsetX: -6,
          style: {
            fontSize: '12px',
            colors: ['#fff']
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        tooltip: {
          shared: true,
          intersect: false
        },
        xaxis: {
          categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
        },
        };

    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();
</script>

</body>
</html>