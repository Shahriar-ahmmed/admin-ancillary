@extends('admin-ancillary.layouts.app')
@section('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor mainTitle" id="title"></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Home</a></li>
                <li class="breadcrumb-item active">App Settings Edit</li>
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
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4><i class="ti ti-direction-alt"></i> Update App Settings</h4>
                                </div>
                                <div class="panel-body">
                                    <form enctype="multipart/form-data" class="" method="POST" id="" role='form'
                                          action="#"
                                          onsubmit="javascript:updateFormExecutionWithUpload('app_settings',this,1,{'logo':'logoUpload','favicon':'faviconUpload'},null,null,null,null,null,null); return false;">

                                        {{ csrf_field() }}

                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">App Name</label>
                                                    <input type="text" name="app_name" required
                                                           value="{{getenv('APP_NAME')}}"
                                                           class="form-control"/>
                                                </div>
                                                <!-- form-group -->
                                            </div>
                                            <!-- col-sm-6 -->
                                        </div>
                                        <!-- row -->

                                        <!-- bootstrap-imageupload. -->
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="imageupload panel panel-default">
                                                    <div class="panel-heading clearfix">
                                                        <h3 class="panel-title pull-left">Upload App Logo</h3>
                                                    </div>

                                                    <div class="file-tab panel-body">
                                                        <div class="pull-left">
                                                                <img src="{{url('public/'.getenv('DEFAULT_LOGO'))}}"
                                                                     id="logoPreview"
                                                                     class="avatar  img-thumbnail img-rounded"
                                                                     width="100px" height="100px"
                                                                     alt="logo">
                                                        </div>
                                                        <label class="btn btn-default btn-file pull-right">
                                                            <span>Browse</span>
                                                            <!-- The file is appd here. -->

                                                            <input type="file"
                                                                   onchange="javascript:ImagePreview(this,'logoPreview');"
                                                                   style="padding:0;"
                                                                   id="logoUpload" class="form-control" accept="image/*"
                                                                   value="{{getenv('DEFAULT_LOGO')}}"
                                                                   name="logo">

                                                            <div class="text-danger" id="_logo">

                                                            </div>

                                                        </label>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="imageupload panel panel-default">
                                                    <div class="panel-heading clearfix">
                                                        <h3 class="panel-title pull-left">Upload App Fav Icon</h3>
                                                    </div>

                                                    <div class="file-tab panel-body">
                                                        <div class="pull-left">
                                                                <img src="{{url('public/'.getenv('DEFAULT_FAVICON'))}}"
                                                                     width="45px"
                                                                     height="45px"
                                                                     id="faviconPreview"
                                                                     class="avatar img-circle img-thumbnail "
                                                                     alt="favicon">
                                                        </div>
                                                        <label class="btn btn-default btn-file pull-right">
                                                            <span>Browse</span>
                                                            <!-- The file is appd here. -->

                                                            <input type="file"
                                                                   onchange="javascript:ImagePreview(this,'faviconPreview');"
                                                                   style="padding:0;"
                                                                   id="faviconUpload" class="form-control"
                                                                   accept="image/*"
                                                                   value="{{getenv('DEFAULT_FAVICON')}}"
                                                                   name="favicon">

                                                            <div class="text-danger" id="_favicon"></div>

                                                        </label>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- bootstrap-imageupload. -->

                                        <button type="submit" class="btn btn-success"><i class="ti ti-clipboard"></i>
                                            Update
                                            Information
                                        </button>

                                        <!-- panel-footer -->
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop