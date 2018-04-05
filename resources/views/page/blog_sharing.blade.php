@extends('layout.admin')
@section('pageTitle', 'Spending Users')
@section('mainTitle', 'Spending Users')
@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form action="{{route('user.blog')}}" method="get">
                            <div class="col-sm-6">
                                <div id="imaginary_container">
                                    <div class="input-group stylish-input-group">

                                        <input type="text" class="form-control" placeholder="Search" name="search"
                                               id="search">
                                        <span class="input-group-addon">
                                            <button type="submit">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </span>


                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>PostLink</th>
                                <th>Balance</th>
                                <th>Total Pay</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                            $index =1;
                            @endphp
                            @foreach($blogs as $blog)
                                <tr>
                                    <td>{{$index}}</td>
                                    <td>
                                        <a href="{{route('blog.user.share.details',['id'=>$blog->id])}}" class="btn">
                                            {{$blog->post_link}}
                                        </a>
                                    </td>
                                    <td>{{$blog->balance}}</td>
                                    <td>{{$blog->total_pay}}</td>
                                    <td>view</td>
                                    <td>Stop</td>
                                </tr>
                                @php
                                $index = $index+ 1;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                        <div class="navigation paging-navigation" role="navigation">

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->




@stop