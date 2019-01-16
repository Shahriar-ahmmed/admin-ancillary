@extends('admin-ancillary.layouts.app')
@section('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor mainTitle" id="title" ></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Home</a></li>
                <li class="breadcrumb-item active">App Settings</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="{{url('/admin/app_settings_edit')}}" class="btn btn-success pull-right"><i class="fa fa-edit"></i> Edit</a>
                            <h4><i class="ti ti-direction-alt"></i> App Information</h4>
                        </div>

                        <div class="panel-body">
                            <div class="list-group contact-group">
                                <a href="#" class="list-group-item">

                                    <div class="media">
                                        <div class="pull-left">
                                            <img class="img-thumbnail img-online img-rounded" width="100px" height="100px"
                                                 src="{{url('public/'.getenv('DEFAULT_LOGO'))}}"
                                                 alt="logo">
                                            <div class="clearfix"></div>
                                            <img class="img-thumbnail img-online img-circle" width="45px" height="45px"
                                                 src="{{url('public/'.getenv('DEFAULT_FAVICON'))}}"
                                                 alt="logo">
                                        </div>
                                        <div class="media-body">
                                            <blockquote>
                                                <h4><i class="ti ti-direction-alt"></i> App Name</h4>
                                                <small><cite title="Source Title" class="app-font"> {{getenv('APP_NAME')}}</cite></small>
                                            </blockquote>

                                        </div>
                                    </div><!-- media -->
                                </a><!-- list-group -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

@stop