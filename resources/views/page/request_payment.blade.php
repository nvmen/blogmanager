@extends('layout.admin')
@section('pageTitle', 'Request payment')
@section('mainTitle', 'Request payment')
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
                                <th>User Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Money</th>
                                <th>Type</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($request_pay as $pay)
                            <tr>
                                <td>{{$pay->user_id}}</td>
                                <td>{{$pay->name}}</td>
                                <td>{{$pay->email}}</td>
                                <td>{{$pay->phone}}</td>
                                <td>{{number_format($pay->money,0)}}</td>
                                <td>{{$pay->payment_type}}</td>
                                <td>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#detailNoteModal{{$pay->id}}">{{\App\Helper::read_more($pay->note)}} </a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning" onclick="reject_request('{{$pay->id}}')">Reject</button>
                                    <button type="button" class="btn btn-primary"  onclick="accept_request('{{$pay->id}}')" >Accept</button>
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
    @foreach($request_pay as $pay)
        <div id="detailNoteModal{{$pay->id}}" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">User Send Note</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>{{$pay->note}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>

            </div>
        </div>
     @endforeach
    <!-- Modal -->
    <div id="rejectModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Reject Payment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Reason <span style="color:red; padding-left:4px">*</span>
                        <input type="text" class="form-control" id="re_note" name="re_note" placeholder="Input reason reject this request."></p>
                    <p style="color:red" id="reason-reject-msg"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"  onclick="submit_reject()">Submit</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="acceptModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Accept Payment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure payment for this request?</p>
                    <p>Security Code
                        <input type="password" class="form-control" id="security_code" style="width: 120px"  name="security_code" placeholder="Input security code for payment.">
                    </p>
                    <p style="color:red" id="code-msg"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary"  onclick="submit_accept()">Yes</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        var token = '{{ csrf_token() }}';
        var request_obj = {id:0,note:'',code:'',_token:token};

        $('#rejectModal').on('hidden.bs.modal', function () {
            jQuery('#reason-reject-msg').html('');
        })
        function reject_request(request_id){
            request_obj.id = request_id;
            jQuery('#rejectModal').modal('show');
        }

        function accept_request(request_id){
            request_obj.id = request_id;
            jQuery('#acceptModal').modal('show');
        }

        function submit_reject(){
            var url ='{{route('payment.reject.request')}}';
            var note = jQuery('#re_note').val();
            if(note.trim().length == 0){
                jQuery('#reason-reject-msg').html('Please input reason reject request.');
            }else{
                jQuery('#reason-reject-msg').html('');
                //
                request_obj.note = note;
                show_spinner();
                $.post(url, request_obj)
                        .done(function (data) {
                            hide_spinner();

                            console.log(data);
                            if(data.success){
                                alert('Reject successfully');
                                window.location.reload();
                            }else{
                                alert(data.message);
                            }
                        });
            }

        }
        function submit_accept(){
            var url ='{{route('payment.accept.request')}}';
            var note = jQuery('#security_code').val();
            if(note.trim().length == 0){
                jQuery('#code-msg').html('Please input security code for request.');
            }else{
                jQuery('#code-msg').html('');
                //
                request_obj.code = note;
                show_spinner();
                $.post(url, request_obj)
                        .done(function (data) {
                            hide_spinner();

                            console.log(data);
                            if(data.success){
                                alert('Reject successfully');
                                window.location.reload();
                            }else{
                                alert(data.message);
                            }
                        });
            }
        }
    </script>
@stop