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
                            <h2>User Information</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class ="row">
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>UserName:</td>
                                    <td>{{$user_info->name}}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td> {{$user_info->email}}</td>
                                </tr>
                                <tr>
                                    <td>Phone:</td>
                                    <td> {{$user_info->phone}}</td>
                                </tr>
                                <tr>
                                    <td>Facebook URL:</td>
                                    <td> {{$user_info->facebook}}</td>
                                </tr>
                                <tr>
                                    <td>Is Fanpage:</td>
                                    <td>
                                        <input type="checkbox" value="" class="form-check" @if($user_info->is_fanpage)checked @endif onclick="do_action(this,'{{$user_info->user_id}}')"/>
                                    </td>
                                </tr>


                                <tr>
                                    <td>Price(VND):</td>
                                    <td>
                                       Facebook({{$user_info['facebook_price']}}) - Zalo({{$user_info['zalo_price']}})
                                        -  Twitter({{$user_info['twitter_price']}})
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td> @if($user_info->status) Approved @else Disapprove @endif</td>
                                </tr>
                                <tr>
                                    <td>Action:</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#smallmodal"
                                                onclick="approve_user('{{$user_info->user_id}}','{{$user_info->status==0?1:0}}')">{{$user_info->status==0?'Approve':'Disapprove'}}</button>
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
    function approve_user(user_id, status) {
        debugger;
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