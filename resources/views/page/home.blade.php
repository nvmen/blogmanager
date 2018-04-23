@extends('layout.admin')
@section('pageTitle', 'Dashboard')
@section('mainTitle', 'Dashboard')
@section('content')
    <style>
        .social-box.zalo i {
            color: #fff;
            background: #e9f86b;
            height: 110px;
        }

        .fa-zalo {
            background: url(https://stc.sp.zdn.vn/share/logo_white_s.png);
        }
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('js/lib/themes/default.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('js/lib/themes/default.date.css') }}">

    <div class="animated fadeIn">
        <div class="col-sm-12">

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-1">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">

                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$active_user}}</span>
                        </h4>
                        <p class="text-light">Active users</p>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <canvas id="widgetChart1"></canvas>
                        </div>

                    </div>

                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">

                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$user_inactive}}</span>
                        </h4>
                        <p class="text-light">Inactive users</p>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <canvas id="widgetChart2"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-3">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">

                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$today_share}}</span>
                        </h4>
                        <p class="text-light">Today shares</p>

                    </div>

                    <div class="chart-wrapper px-0" style="height:70px;" height="70">
                        <canvas id="widgetChart3"></canvas>
                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-4">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$post_share_in_day}}</span>
                        </h4>
                        <p class="text-light">Today post shared</p>

                        <div class="chart-wrapper px-3" style="height:70px;" height="70">

                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-lg-3 col-md-6">
                <div class="social-box facebook">
                    <i class="fa fa-facebook"></i>
                    <ul>
                        <li>
                            <strong><span class="count">{{$facebook_share_total}}</span> </strong>
                            <span>Total</span>
                        </li>
                        <li>
                            <strong><span class="count">{{$facebook_share_in_day}}</span></strong>
                            <span>Today</span>
                        </li>
                    </ul>
                </div>
                <!--/social-box-->
            </div><!--/.col-->

            <div class="col-lg-3 col-md-6">
                <div class="social-box twitter">
                    <i class="fa fa-twitter"></i>
                    <ul>
                        <li>
                            <strong><span class="count">30</span> k</strong>
                            <span>Total</span>
                        </li>
                        <li>
                            <strong><span class="count">450</span></strong>
                            <span>Today</span>
                        </li>
                    </ul>
                </div>
                <!--/social-box-->
            </div><!--/.col-->


            <div class="col-lg-3 col-md-6">
                <div class="social-box linkedin">
                    <i class="fa fa-linkedin"></i>
                    <ul>
                        <li>
                            <strong><span class="count">40</span> +</strong>
                            <span>Total</span>
                        </li>
                        <li>
                            <strong><span class="count">250</span></strong>
                            <span>Today</span>
                        </li>
                    </ul>
                </div>
                <!--/social-box-->
            </div><!--/.col-->


            <div class="col-lg-3 col-md-6">
                <div class="social-box zalo">
                    <i class="fa fa-zalo">
                        <img src="http://vnbox.vn/profiles/vnboxvn/uploads/attach/post/images/zalo.png" width="40">
                    </i>
                    <ul>
                        <li>
                            <strong><span class="count">94</span> k</strong>
                            <span>Total</span>
                        </li>
                        <li>
                            <strong><span class="count">92</span></strong>
                            <span>Today</span>
                        </li>
                    </ul>
                </div>
                <!--/social-box-->
            </div><!--/.col-->
            <div class="col-lg-12 col-md-12">

                <form role="form">
                    <div class="row">
                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <div class="form-group">
                                <input type="text" name="date_from" id="date_from" class="form-control input-sm datepicker"
                                       placeholder="From"
                                       value="2014-08-08"
                                       data-valuee="2014-08-08"/>


                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <div class="form-group">
                                <input type="text" name="date_to" id="date_to" class="form-control input-sm datepicker"
                                       value="2014-08-08"
                                       data-valuee="2014-08-08"
                                       placeholder="To">
                            </div>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <input type="submit" value="View" class="btn btn-info btn-block">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 col-md-12">
                <div id="container"></div>
            </div>
        </div>
    </div><!-- .animated -->


    <script src="{{ URL::asset('js/lib/picker.js') }}"></script>
    <script src="{{ URL::asset('js/lib/picker.date.js') }}"></script>
    <script src="{{ URL::asset('js/lib/legacy.js') }}"></script>
    <script>

        var $input = $( '.datepicker' ).pickadate({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',
        })
        Highcharts.chart('container', {

            title: {
                text: 'Report Sharing in system'
            },

            subtitle: {
                text: 'Source Blog: letup.com.vn'
            },

            yAxis: {
                title: {
                    text: 'Sharing blog'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    pointStart: 2010
                }
            },

            series: [{
                name: 'User Sharing',
                data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
            }, {
                name: 'Blog Sharing',
                data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
            }, {
                name: 'Facebook Sharing',
                data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
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
    </script>
@stop