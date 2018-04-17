@extends('layout.admin')
@section('pageTitle', 'Post From Blog')
@section('mainTitle', 'Post From Blog')
@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form action="{{route('blog.posts')}}" method="get">
                            <div class="col-sm-6">
                                <div id="imaginary_container">
                                    <div class="input-group stylish-input-group">

                                        <input type="text" class="form-control" placeholder="Search" name="search" value="{{$search}}"
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
                                <th>ID</th>
                                <th>Post Title</th>
                                <th>Post Link</th>
                                <th>Balance<br/>(VND)</th>
                                <th>Total Pay</th>

                                <th>In Campaign</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($posts as $post)
                                <tr>
                                    <td>{{$post->id}}</td>
                                    <td>{{$post->post_title}}</td>
                                    <td><a target="_blank" href="{{$post->link}}">{{$post->link}}</a></td>
                                    <td>{{$post->budget==null ||$post->budget==0? "Free": number_format($post->budget,0)}}</td>
                                    <td>{{number_format($post->total_pay,0)}}</td>
                                    <td>
                                      @if($post->campaign==true)
                                            <span style="color:#1a12bc;font-weight: bold"> Yes</span>
                                            @else
                                            <span > No</span>
                                        @endif
                                    </td>
                                </tr>
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