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
                                <th>Email</th>
                                <th>Facebook Profile</th>
                                <th>Facebook Price</th>
                                <th>Approved</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td style="text-align: right">
                                    <button type="button" class="btn btn-success">Price</button>
                                    <button type="button" class="btn btn-primary">Aprroved</button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@stop