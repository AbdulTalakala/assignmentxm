<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>XM - Task </title>
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

    </head>
    <body>
        <div>         
            <div id="layoutSidenav_content">
                <main>


    @yield('content')


<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/validate.js') }}"></script>
<script src="{{ asset('js/charts.js') }}"></script>

<script type="text/javascript">
    <?php 
       if(isset($response["openPrices"]) && isset($response["closePrices"])) { ?>
         var openPrices =  <?php echo json_encode($response["openPrices"]) ?>;
         var closePrices =  <?php echo json_encode($response["closePrices"])  ?>;
          

        Highcharts.chart('openPriceChart', {
            title: {
                text: 'Open Price'
            },
            subtitle: {
                text: 'Open price Line Chart'
            },
            credits: {
                enabled: false
            }, 
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true
                }
            },
            series: [{
                name: 'Open prices',
                data: openPrices
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });

        Highcharts.chart('closePriceChart', {
            title: {
                text: 'Close Price'
            },
            subtitle: {
                text: 'Close Price Line Chart'
            },
            credits: {
                enabled: false
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true
                }
            },
            series: [{
                name: 'close prices',
                data: closePrices
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });

    <?php } ?>      

</script>

@yield('script')

</body>
</html>
