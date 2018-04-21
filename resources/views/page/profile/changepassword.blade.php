@extends('layout.admin')
@section('pageTitle', 'Change Password')
@section('mainTitle', 'Change Password')
@section('content')

    <div class="box-action text-left">
        <h4>Change password</h4>
    </div>
    <div id="content-page">

            <div class="form-style">
                <div id ="content-message">
                    @if(Session::get('message')!='')
                        <div class="alert alert-success">
                            <strong>Success!</strong> {{Session::get('message')}}
                        </div>
                    @endif
                </div>

                <div class="item-style">
                    <label>Current password <span class="sys">*</span>  {{Session::get('message')}}</label>
                    <div class="ipt-style">
                        <input type="password" placeholder="" class="form-control" name="current_pwd" id="current_pwd" value="">
                        <span class="note-erro">{{ $errors->first('current_pwd') }}</span>
                    </div>
                </div>
                <div class="item-style">
                    <label>New password <span class="sys">*</span></label>
                    <div class="ipt-style">
                        <input type="password" placeholder="" class="form-control"  name="new_pwd" id="new_pwd" value="">
                        <span class="note-erro">{{ $errors->first('new_pwd') }}</span>
                    </div>
                </div>
                <div class="item-style">
                    <label>Confirm password <span class="sys">*</span></label>
                    <div class="ipt-style">
                        <input type="password" placeholder="" class="form-control"  name="confirm_new_pwd" id="confirm_new_pwd" value="">
                        <span class="note-erro">{{ $errors->first('confirm_new_pwd') }}</span>
                    </div>
                </div>
                <div class="item-style text-right">
                    <br/>
                    <button type="button" class="btn btn-success" onclick="do_change_password()">Change</button>
                </div>

            </div>

    </div>
    <script>
        function check_password(pwd) {
            var regex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
            if (regex.test(pwd)) {
                return true;
            } else {
                return false;
            }
        }
         var url_change_password ='{{route('profile.do.change.password')}}';
         function do_change_password(){
             var current_password =jQuery('#current_pwd').val();
             var confirm_password =jQuery('#confirm_new_pwd').val();
             var new_password =$('#new_pwd').val();
             if(current_password.trim().length==0){
                 jQuery('#current_pwd').notify(
                         'Current password not empty.',
                         {position: "top"}
                 );
                 return;
             }
             if(new_password.trim().length==0){
                 jQuery('#new_pwd').notify(
                         'New password not empty.',
                         {position: "top"}
                 );
                 return;
             }
             if(confirm_password.trim().length==0){
                 jQuery('#confirm_new_pwd').notify(
                         'Confirm password not empty.',
                         {position: "top"}
                 );
                 return;
             }
             if (!check_password(new_password)) {
                 jQuery('#new_pwd').notify(
                         'Minimum 7 characters and contains number, letter, upper letter and special character.',
                         {position: "top"}
                 );
                 return;
             }
             if (new_password != confirm_password) {
                 jQuery('#confirm_new_pwd').notify(
                         'Confirm new password does not match.',
                         {position: "top"}
                 );
                 return;
             }

             var obj = {
                 _token: get_token(),
                 current_password: current_password,
                 new_password: new_password,
                 confirm_new_password: confirm_password,
             };
             show_spinner();
             jQuery.post(url_change_password, obj)
                     .done(function (data) {
                         hide_spinner();
                         if (data.success == true) {
                             $.notify("Change password successful", "success");
                         } else {
                             $.notify(data.message, "error")
                         }

                     });
         }


    </script>
@stop