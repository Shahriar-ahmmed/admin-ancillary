@inject('commonLibInstance', 'Ahmmed\AdminAncillary\CommonLib')
@extends('admin-ancillary.layouts.app')
@section('header_scripts')
    {{-- Start: Adding CSS for MenuOrder & tree view and datatable --}}

    <link href="{{ asset('public/admin-ancillary/nestable/jquery.nestable.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('public/admin-ancillary/jstree/themes/default/style.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('public/admin-ancillary/plugins.css') }}" rel="stylesheet"/>
    {{-- End: Adding CSS for MenuOrder & tree view --}}
@stop
@section('content')
        <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor mainTitle" id="title" >Update Admin Menu Order </h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Menu Order</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <!-- start: NESTABLE LIST -->
                <div class="container-fluid container-fullw bg-white">
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 space20" style="margin-bottom: 20px">
                                        <div id="action">
                                            <a class="btn btn-wide btn-success" onclick="javascript:showAlert('cba','Are you sure want to update menu?');" data-token="{{ csrf_token() }}">
                                                <i class="fa fa-save"></i> Update Menu
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- start: DRAGGABLE HANDLES 1 -->
                                <div class="dd" id="nestable">
                                    <ol class="dd-list">
                                        {!! $commonLibInstance->adminMenuListing() !!}
                                    </ol>
                                </div>
                                <div  id="nestable-output" style="display: none;"></div>
                                <!-- end: DRAGGABLE HANDLES 1 -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: NESTABLE LIST -->
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footer_scripts')
    {{--/*      Start: Adding CSS for MenuOrder & tree view */--}}
    <script type="text/javascript" src="{{ asset('public/admin-ancillary/jstree/jstree.min.js')}}" ></script>
    <script type="text/javascript" src="{{ asset('public/admin-ancillary/ui-treeview.js')}}" ></script>
    <script type="text/javascript" src="{{ asset('public/admin-ancillary/nestable/jquery.nestable.js')}}" ></script>
    <script type="text/javascript" src="{{ asset('public/admin-ancillary/ui-nestable.js')}}" ></script>

    {{--/* End: Adding CSS for MenuOrder & tree view */--}}
    <script>
        function abc(dataInfo){
            alert("Calling ABC"+dataInfo.param1);
        }
        function cba(dataInfo){
            alert("Calling CBA"+dataInfo.param1);
        }
        function showAlert(functionName,masg){
            var dataSet = {};
            dataSet['param1'] = "value01";
            dataSet['param2'] = "value02";
            dataSet['param3'] = "value03";
            var sorted = $('#nestable-output').html();
            if(sorted.length>4){
                confirmationBox("menuUpdateExecution",sorted, masg);
            }else{
                customAlert('Change Order before Submit', true);
            }

        }
        jQuery(document).ready(function() {
            //Main.init();
            UINestable.init();
        });
    </script>

@stop

