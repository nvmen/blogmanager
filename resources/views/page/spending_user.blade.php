@extends('layout.admin')
@section('pageTitle', 'Spending Users')
@section('mainTitle', 'Spending Users')
@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data Table</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Login Name</th>
                                <th>Email</th>
                                <th>Facebook Profile</th>
                                <th>Facebook Price</th>
                                <th>Approved</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user['login_name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>
                                    <a target="_blank" href="{{$user['facebook']}}">{{htmlspecialchars($user['facebook'])}}</a>
                                </td>
                                <td>0</td>
                                <td style="text-align: right">
                                    <button type="button" class="btn btn-success">Price</button>
                                    <button type="button" class="btn btn-primary">Aprroved</button>
                                </td>
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