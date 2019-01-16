@extends('admin-ancillary.layouts.app')

@section('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor mainTitle" id="title"></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="contentpanel">
                        <div class="col-md-12">
                            <div class="panel  panel-title">
                                <div class="panel-heading">
                                    <h4>Change Password</h4>
                                </div>
                                <div class="panel-body top-padding">

                                    <form class="form-horizontal col-md-10" method="POST" id="change_password_form"
                                          role='form' action="#"
                                          onsubmit="javascript:updateFormExecution('change_password',this,{{Auth::user()->id}},null,null,null,null,null); return false;">
                                        @csrf()
                                        @method('PUT')
                                        <div class="row form-group ">
                                            <div class="col-md-4 text-right">
                                                <label for="current_password">Current Password:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="password" class="form-control" id="password"
                                                       name="current_password"
                                                       placeholder="Your current password" required>
                                                <div class="text-danger" id="_current_password"></div>
                                            </div>
                                        </div><!--/.row -->

                                        <div class="row form-group">
                                            <div class="col-md-4 text-right">
                                                <label for="new_password">New Password:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="password" class="form-control" id="newpassword"
                                                       name="new_password"
                                                       placeholder="New password" required>
                                                <div class="text-danger" id="_new_password"></div>
                                            </div>
                                        </div><!--/.row -->

                                        <div class="row form-group">
                                            <div class="col-md-4 text-right">
                                                <label for="confirm_password">Confirm New Password:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="password" class="form-control" id="againnewpassword"
                                                       name="confirm_password"
                                                       placeholder="Enter Your New password Again" required>
                                                <div class="text-danger" id="_confirm_password"></div>
                                            </div>
                                        </div><!--/.row -->


                                        <div class="col-md-10">
                                            <div class=" pull-right">
                                                <a href="{{url('profile/'.$user->id)}}"
                                                   class="cancel_change_password btn btn-danger red-font">Cancel</a>
                                                &nbsp; &nbsp;
                                                <button type="submit" class="submit_btn btn btn-primary">Change
                                                    Password
                                                </button>
                                            </div>
                                            <br><br>
                                        </div>
                                    </form>
                                    {{--{!! Form::close() !!}--}}
                                </div><!-- panel-body -->

                            </div><!-- panel -->

                        </div><!-- col-md-6 -->


                    </div><!-- contentpanel -->
                </div>
            </div>
        </div>
    </div>
@stop