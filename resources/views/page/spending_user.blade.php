@extends('layout.admin')
@section('pageTitle', 'Spending Users')
@section('mainTitle', 'Spending Users')
@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Users Blog</strong>
                        <a href="{{ route('user.blog', ['fetch_user' => 'true']) }}" class="btn btn-info pull-right">Fetch User From Blog</a>
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
                                <td>{{$user['name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>
                                    <a target="_blank" href="{{$user['facebook']}}">{{htmlspecialchars($user['facebook'])}}</a>
                                </td>
                                <td>0</td>
                                <td style="text-align: right">
                                    <button type="button" class="btn btn-success" onclick="show_price('{{$user['user_id']}}')">Price</button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#smallmodal">Aprroved</button>
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

    <div class="modal fade" id="pricemodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Set Price for User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="facebook_price" class="control-label">Facebook Price(VND)</label>
                            <input type="number" class="form-control" id="username" name="facebook_price" value="" required="true"  placeholder="2000 vnd">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="zalo_price" class="control-label">Zalo Price(VND)</label>
                            <input type="number" class="form-control" id="zalo_price" name="zalo_price" value="" required="" title="Please enter your password">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="twitter_price" class="control-label">Twitter Price(VND)</label>
                            <input type="number" class="form-control" id="twitter_price" name="twitter_price" value="" required="" title="">
                            <span class="help-block"></span>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Approve User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> Do you wan to approved for this user? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>

<script>
    function show_price(user_id){
        // alert(user_id);


        jQuery('#pricemodal').modal('show');

    }


</script>
@stop