<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/png" sizes="16x16" href="{{url('public/admin-ancillary/css/images/favicon.png')}}">
        <title>{{ config('app.name', '') }}</title>


        <!-- ====================== External  Stylesheets ========================== -->

        @include('admin-ancillary.layouts.css')
        <!-- ====================== End External  Stylesheets ====================== -->
        <script>
            var public_path = "<?php echo url('/'); ?>";
            window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <!-- ====================== Header  script ================================= -->
        @yield('header_scripts')
        <!-- ======================= End header script  ============================ -->
    </head>

    <body class="fix-header fix-sidebar card-no-border">

    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    {{--<div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>--}}
    <!-- ============================================================== -->
    <div id="main-wrapper">
                <!-- ==================== Header ======================================== -->
                @include('admin-ancillary.layouts.header')
                <!-- =================== End Header ===================================== -->

                <!-- ===================== Flash Message ================================ -->
                <div class="flash_message"
                    style="position: absolute; top: 70px;left:0; text-align: center; z-index: 1500; width: 100%; padding: 0px 20%;">
                    @include('flash::message')
                </div>

                @if(Auth::check())
                    @include('admin-ancillary.layouts.left_sidebar')
                @endif

                        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <!-- Start Page Content -->
                <!-- ============================================================== -->

                    @yield('content')

                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

            <!-- footer -->
            @include('admin-ancillary.layouts.footer')

            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->

        <!-- ====================== All Scripts ======================================  -->
            <!-- ========== Footer  script ========================================== -->
            @include('admin-ancillary.layouts.js')
            <!-- For Flash -->
            <script>
            $('.flash_message div.alert').delay(2000).slideUp(500);
            $(document).find('a.active').parents('li').addClass('active');
            //   $(document).find('li.active').parents('li').addClass('active');
            //   $(document).find('li.sub-menu').find('li.active').addClass('collapse in');
            $(document).find('.nav-stacked li.active').parents('ul').css('display','block');
            $(document).find('.nav-stacked li.active').parents('li').addClass('open');
            $('ul.nav-stacked>li.open').addClass('active');
            </script>
            @yield('footer_scripts')
            <!-- ========== #footer script end ====================================== -->
    </div>
    </body>
</html>
