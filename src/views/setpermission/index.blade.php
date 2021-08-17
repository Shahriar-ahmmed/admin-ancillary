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
            <h3 class="text-themecolor mainTitle" id="title" >Set Rolewise permission</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Setpermission</li>
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
                                    <div class="col-md-12 space20">
                                        <div id="action">
                                            <a class="btn btn-wide btn-success"
                                               onclick="javascript:showAlert('cba','Are you sure want to update menu?');"
                                               data-token="{{ csrf_token() }}">
                                                <i class="fa fa-save"></i> Update Permission
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @if(count($roles)>0)
                                    <div style="margin: 25px 0; margin-left: -15px;">
                                        <div class="col-sm-12">
                                            <select id="role" name="is_active" >
                                                @foreach($roles AS $role)
                                                    <option  value="{{$role->id}}">{{$role->role}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Select role wise <span class="text-bold">Permission</span></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tree-demo jstree jstree-2 jstree-default jstree-checkbox-selection" id="tree_2" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_1" aria-busy="false" aria-selected="false">

                                        </div>
                                        <div  id="tree-output" style="display: none;"></div>
                                    </div>
                                </div>
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

                var selected = $('#role option:selected').val();
                var v = $('#tree_2').jstree(true).get_json('#', {flat: true});
                var mytext = JSON.stringify(v);
                //syncAjaxCaller('setpermission/save',mytext);
                $.ajax({
                    method: 'POST', // Type of response and matches what we said in the route
                    url: 'setpermission', // This is the url we gave in the route
                    data: {'value': mytext, 'role': selected}, // a JSON object to send back
                    success: function (response) { // What to do if we succeed
                        var status = $.parseJSON(response);
                        if (status.success) {
                            customAlert(status.message, status.success);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
//                        console.log(JSON.stringify(jqXHR));
//                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
        }
        function initiate(value){
//            console.log(value);
            UITreeview.init(value);
            //$('#tree_2').jstree("refresh");
        }

        // get the data according to role

        function getPermission(role){
            $.ajax({
                method: 'get', // Type of response and matches what we said in the route
                url: 'setpermission/'+ role, // This is the url we gave in the route
//                data: {'role': selected}, // a JSON object to send back
                success: function(response){ // What to do if we succeed
                    var v = JSON.parse(response);
//                    console.log(v);
                    //$('#tree_2').jstree('destroy');
                    initiate(v);
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    customAlert(textStatus,false);
                }
            });
        }
        jQuery(document).ready(function() {
            //Main.init();
            var value = syncAjaxCaller('setpermission/json');
            //var value = "";
            initiate(value);
            var selected = $('#role option:selected').val();
            getPermission(selected);
            $('#role').on('change', function(){
                var selected = $(this).find("option:selected").attr("value");
                getPermission(selected);
            });



        });
    </script>
@stop