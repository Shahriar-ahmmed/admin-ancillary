@extends('admin-ancillary.layouts.app')
@section('content')
        <!-- Bread crumb and right sidebar toggle -->
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor mainTitle" id="title"></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="panel panel-primary-head">
                    <div class="panel-heading clearfix">
                        <div class="col-md-3" id="action">

                            {{--<div id="action"></div>--}}
                        </div>
                        <div class="col-md-3"></div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- panel-heading -->
                    <br/>

                    <div class="table-responsive">
                        <div id="PageLoader">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Worker Modal | Star -->
<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!-- Add Worker Modal | End -->


@endsection
@section('footer_scripts')
    <script>
        $(document).ready(function () {
            listInitializer('users', 'PageLoader', 'title', 'action');


            $(document).on('click', '.verified-status', function () {

                var rowid = $(this).attr('data-id');
//                    console.log(rowid);
                var dataSet = syncAjaxCaller(public_path + '/status/' + rowid, null);
                if (dataSet.success) {
                    $(this).find('.btn').toggleClass('active');
                    if ($(this).find('.btn-primary').size() > 0) {
                        $(this).find('.btn').toggleClass('btn-primary');
                    }
                    $(this).find('.btn').toggleClass('btn-default');
                    customAlert(dataSet.message, dataSet.success);
                } else {
                    customAlert(dataSet.message, dataSet.success);
                }


            });
        });
    </script>
@stop