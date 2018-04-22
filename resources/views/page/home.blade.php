@extends('layout.admin')
@section('pageTitle', 'Dashboard')
@section('mainTitle', 'Dashboard')
@section('content')
    <style>
        .social-box.zalo i {
            color: #fff;
            background:#e9f86b;
            height: 110px;
        }
        .fa-zalo{
            background: url(https://stc.sp.zdn.vn/share/logo_white_s.png);
        }
    </style>
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


        </div>
    </div><!-- .animated -->
@stop