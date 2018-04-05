@extends('layout.admin')
@section('pageTitle', 'Spending Users')
@section('mainTitle', 'Spending Users')
@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form action="{{route('user.blog')}}" method="get" >
                        <div class="col-sm-6">
                            <div id="imaginary_container">
                                <div class="input-group stylish-input-group">

                                        <input type="text" class="form-control" placeholder="Search" name ="search" id ="search">
                                        <span class="input-group-addon">
                                            <button type="submit">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </span>


                                </div>
                            </div>
                        </div>
                        </form>
                        <a href="{{ route('user.blog', ['fetch_user' => 'true']) }}" class="btn btn-info pull-right">Fetch
                            User From Blog</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Login Name</th>
                                <th>Email</th>
                                <th>Facebook Profile</th>
                                <th>Fanpage</th>
                                <th>Facebook - Zalo - twitter - Price</th>
                                <th>Approved</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user['name']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td>
                                        <a onclick="show_facebook_view('{{$user['facebook']}}')"
                                           href="javascript:void(0)">{{htmlspecialchars($user['facebook'])}}</a>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="" class="form-check" @if($user->is_fanpage)checked @endif onclick="do_action(this,'{{$user->user_id}}')"/>
                                    </td>
                                    <td>{{$user['facebook_price']}} - {{$user['zalo_price']}}
                                        - {{$user['twitter_price']}} </td>
                                    <td style="text-align: right">
                                        <button type="button" class="btn btn-success"
                                                onclick="show_price('{{route('user.blog.detail',['user_id'=>$user->user_id])}}')">
                                            Price
                                        </button>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#smallmodal"
                                                onclick="approve_user('{{$user->user_id}}','{{$user->status==0?1:0}}')">{{$user->status==0?'Approve':'Disapprove'}}</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="navigation paging-navigation" role="navigation">
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

    <div class="modal fade" id="pricemodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabe">Set Price for User</h5>
                    <button type="button" class="close" data-dismliss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="facebook_price" class="control-label">Facebook Price(VND)</label>
                            <input type="number" class="form-control" id="facebook_price" name="facebook_price" value=""
                                   required="true" placeholder="2000 vnd">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="zalo_price" class="control-label">Zalo Price(VND)</label>
                            <input type="number" class="form-control" id="zalo_price" name="zalo_price" value=""
                                   required="" title="2000 vnd">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="twitter_price" class="control-label">Twitter Price(VND)</label>
                            <input type="number" class="form-control" id="twitter_price" name="twitter_price" value=""
                                   required="" title="2000 vnd">
                            <span class="help-block"></span>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="save_price()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Change Status User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> Do you wan to <span id='status-approve'></span> for this user? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="save_status()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var token = '{{ csrf_token() }}';
        var currentUser = null;
        function show_price(link) {
            jQuery.get(link, function (result) {
                currentUser = result.data;
                jQuery('#facebook_price').val(currentUser.facebook_price);
                jQuery('#twitter_price').val(currentUser.twitter_price);
                jQuery('#zalo_price').val(currentUser.zalo_price);
                jQuery('#pricemodal').modal('show');
            });

        }
        function approve_user(user_id, status) {
            if (currentUser == null) currentUser = new Object();
            currentUser.user_id = user_id;
            currentUser.status = status;
            if (status == 1) {
                jQuery('#status-approve').html('approve');
            } else {
                jQuery('#status-approve').html('disapprove');
            }
            jQuery('#approveModal').modal('show');
        }
        function save_status() {
            var url = '{{route('user.blog.detail.approve')}}';
            show_spinner();
            $.post(url, {
                        _token: token,
                        user_id: currentUser.user_id,
                        status: currentUser.status
                    })
                    .done(function (data) {
                        hide_spinner();
                        window.location.reload();
                    });
        }
        function save_price() {
            var url = '{{route('user.blog.detail.update')}}';
            show_spinner();
            $.post(url, {
                        _token: token,
                        user_id: currentUser.user_id,
                        facebook_price: jQuery('#facebook_price').val(),
                        twitter_price: jQuery('#twitter_price').val(),
                        zalo_price: jQuery('#zalo_price').val(),
                    })
                    .done(function (data) {
                        hide_spinner();
                        window.location.reload();
                    });
        }
        function show_facebook_view(url) {
            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;
            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
            var w = width * 0.8;
            var h = height * 0.8;
            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
            var top = ((height / 2) - (h / 2)) + dualScreenTop;
            // window.open (url, "Facebook Window","location=1,status=1,scrollbars=1, width=500,height=500");
            var title = "Facebook viewer";
            var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

            // Puts focus on the newWindow
            if (window.focus) {
                newWindow.focus();
            }
        }

        function do_action(e,id){
            var url ='{{route('user.blog.fanpage.update')}}';
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
                      //  alert('Update Ok');
                    });
        }
    </script>



@stop