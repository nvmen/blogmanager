@extends('layout.admin')
@section('pageTitle', 'Profile')
@section('mainTitle', 'Profile')
@section('content')

    <div class="box-action text-left">
        <h4>My information</h4>
    </div>
    <div id="content-page">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12 personal-info">
                <form method="post" action="{{route('profile.user.update')}}">
                    <div class="">
                        <div id="content-message">
                            @if(Session::get('message')!='')
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{Session::get('message')}}
                                </div>
                            @endif
                        </div>

                        <div class="item-style">
                            <label>Full Name <span class="sys">*</span> {{Session::get('message')}}</label>
                            <div class="ipt-style">
                                <input type="type" placeholder="" class="form-control" name="full_name" name="full_name"
                                       value="{{$user->full_name}}">
                                <span class="note-erro">{{ $errors->first('full_name') }}</span>
                                <input type="hidden" name="_token" id="_token" value ="{{ csrf_token() }}">
                            </div>
                        </div>
                        <div class="item-style">
                            <label>Email </label>
                            <div class="ipt-style">

                                <input type="type" placeholder="" class="form-control" readonly="readonly" name="email"
                                       id="email" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="item-style">
                            <label>You are </label>
                            <div class="ipt-style">

                                <input type="type" placeholder="" class="form-control" readonly="readonly" name="user_type"
                                       id="user_type" value="{{$user->user_type}}">
                            </div>
                        </div>

                        <div class="item-style">
                            <label>Address </label>
                            <div class="ipt-style">
                                <input type="type" placeholder="" class="form-control" name="address" id="address"
                                       value="{{$user->address}}">
                            </div>
                        </div>


                        <div class="item-style">
                            <label>Phone </label>
                            <div class="ipt-style">
                                <input type="type" placeholder="" class="form-control" name="phone" id="phone"
                                       value="{{$user->phone}}">
                            </div>
                        </div>

                        <div class="item-style text-right">
                            <br/>
                            <button class="btn btn-secondary" type="button" onclick="reload_page();return;">cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="show_spinner()">Save</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
    <script>
        function reload_page() {
            window.location.href = "{{route('profile.user')}}";
        }
    </script>
@stop