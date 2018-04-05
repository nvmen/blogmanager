@extends('layout.admin')
@section('pageTitle', 'Post Information')
@section('mainTitle', 'Post Information')
@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class ="col-md-12">
                        <div class="page-title">
                            <h2>Post Information</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class ="row">
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>Post Link:</td>
                                    <td>www.google.com.vn</td>
                                </tr>
                                <tr>
                                    <td>Balance:</td>
                                    <td>{{number_format($post_info->budget,0)}} VND</td>
                                </tr>
                                <tr>
                                    <td>Total Pay:</td>
                                    <td>{{number_format($total_pay,0)}} VND</td>
                                </tr>

                                <tr>

                                    <td>Status:</td>
                                    <td> @if($post_info->is_campaign)In Campaign @else Stop Campaign @endif</td>
                                </tr>

                                <tr>
                                    <td>Start Date:</td>
                                    <td>20/12/2018</td>
                                </tr>

                                <tr>
                                    <td>Action:</td>
                                    <td>
                                        <button type="button" class="btn btn-success">Stop Campaign</button>
                                    </td>
                                </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>
                    <div class ="col-md-12">
                        <div class="page-title">
                            <h2>Details</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>User Id</th>
                                <th>Price</th>
                                <th>Platform</th>
                                <th>Paid</th>
                                <th>Verify</th>
                                <th>Created</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{$post->user_id}}</td>
                                    <td>{{number_format($post->price)}}</td>
                                    <td>{{$post->platform}}</td>
                                    <td>{{App\Helper::get_text_pay($post->paid)}}</td>
                                    <td>{{App\Helper::get_text_verify($post->verify)}}</td>
                                    <td>{{$post->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@stop