@extends('admin-ancillary.layouts.app')
@section('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor mainTitle" id="title"></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Edit Profile</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    <div class="contentpanel">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="panel panel-title">
                                <div class="panel-heading">
                                    <h4> Edit Profile </h4>
                                </div>
                                <div class="panel-body">
                                    <form enctype="multipart/form-data" class="form-horizontal" method="POST"
                                          id="edit_profile"
                                          role='form' action="#"
                                          onsubmit="
                                                  javascript:updateFormExecution('edit_profile', this,'{{$user->id}}', null, null,null, null,null); return false;">
                                        @csrf()
                                        @method('PUT')
                                        <div class="media-body">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Name</label>
                                                            <input type="text" name="name" required
                                                                   value="@if(isset($user->name)){{$user->name}}@endif"
                                                                   class="form-control"/>
                                                            <div class="text-danger" id="_name"></div>
                                                        </div>
                                                        <!-- form-group -->
                                                    </div>
                                                </div>
                                                <!-- col-sm-6 -->
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Email</label>
                                                            <input type="email" required
                                                                   value="@if(isset($user->email)){{$user->email}}@endif"
                                                                   name="email" readonly class="form-control"/>
                                                        </div>
                                                        <!-- form-group -->
                                                    </div>
                                                    <!-- col-sm-6 -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- row -->


                                        <div class="text-right">
                                            <button type="submit" class="btn" id="edit-button-submit">Update
                                                Information
                                            </button>
                                        </div>
                                        <!-- panel-footer -->
                                    </form>
                                </div>
                                <!-- panel-body -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- contentpanel -->

@stop