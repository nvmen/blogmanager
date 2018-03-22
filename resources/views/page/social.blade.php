@extends('layout.admin')
@section('pageTitle', 'Social Network')
@section('mainTitle', 'Social Network')
@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($socials as $social)
                                <tr>
                                    <td>{{$social->name}}</td>
                                    <td><input type="checkbox" value="" class="form-check" @if($social->status)checked @endif onclick="do_action(this,'{{$social->id}}')"/></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
    <script>
        var token = '{{ csrf_token() }}';
        function do_action(e,id){
            var url ='{{route('social.network.update')}}';
          let status = 0;
            if (e.checked) {
                status =1;
            }
            $.post(url, {
                        _token: token,
                        id: id,
                         status:status
                    })
                    .done(function (data) {
                       alert('Update Ok');
                    });
        }
    </script>
@stop