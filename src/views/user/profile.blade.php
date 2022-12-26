@extends('admin-ancillary.layouts.app')
@section('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor mainTitle" id="title"></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="media-body">
                        <div class="panel-body">
                            <div class="row">
                                <div class=" col-md-12 col-lg-12 hidden-xs hidden-sm">

                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td width="50%"><h5><i class="fa fa-user"></i> User Name </h5></td>
                                            <td width="50%"><h5>{{$user->name}}</h5></td>
                                        </tr>
                                        <tr>
                                            <td><h5><i class="fa fa-envelope"></i> Email </h5></td>
                                            <td><h5>{{$user->email}}</h5></td>
                                        </tr>
                                        <tr>
                                            <td><h5><i class="fa fa-user-plus"></i> Role </h5></td>
                                            <td><h5>{{$user->role->role}}</h5></td>
                                        </tr>
                                        <tr></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop