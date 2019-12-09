<html lang="en">
    <?php $utility = new \App\Utility; ?>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Talevation Payments</title>
        <!-- Bootstrap core CSS-->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>


        <style>
            .page-item.active .page-link {
                z-index: 1;
                color: #fff !important;
                background-color: #14abef;
                border-color: #14abef;
            }
            .btn-info {
                color: #fff;
                background-color: #14abef;
                border-color: #14abef;
            }
            .btn-info:hover {
                color: #fff;
                background-color: #14abef;
                border-color: #14abef;
            }
            a {
                color: #14abef !important;
            }
            .hidden{
                display: none !important;
            }
            body {
                background-color: #e9eaec;
                font-family: 'Poppins', sans-serif;
                font-size: 14px;
                color: rgba(0, 0, 0, 0.72);
                letter-spacing: .5px;
            }
            #pageloader-overlay.visible {
                opacity: 1;
            }
            #pageloader-overlay {
                opacity: 0;
                top: 0px;
                left: 0px;
                position: fixed;
                background-color: rgba(0, 0, 0);
                height: 100%;
                width: 100%;
                z-index: 9998;
                -webkit-transition: opacity 0.2s linear;
                -moz-transition: opacity 0.2s linear;
                transition: opacity 0.2s linear;
            }
            #wrapper {
                width: 100%;
                position: relative;
            }
            #wrapper.toggled .content-wrapper {
                margin-left: 0;
            }
            .content-wrapper {
                margin-left: 240px;
                padding-top: 70px;
                padding-left: 10px;
                padding-right: 10px;
                padding-bottom: 70px;
                overflow-x: hidden;
                -webkit-transition: all 0.3s ease;
                -moz-transition: all 0.3s ease;
                -o-transition: all 0.3s ease;
                transition: all 0.3s ease;
            }
            .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
                padding-right: 12.5px;
                padding-left: 12.5px;
            }
            .card {
                margin-bottom: 25px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                border: none;
                background-color: #ffffff;
            }
            .h3, h3 {
                font-size: 30px;
                line-height: 34px;
            }
            .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
                font-weight: 600;
                color: #000;
            }
            .small, small {
                font-size: 75%;
                font-weight: 400;
            }
            hr {
                border-top: 1px solid rgba(0, 0, 0, 0.1);
            }
            hr {
                box-sizing: content-box;
                height: 0;
                overflow: visible;
                margin-top: 1rem;
                border: 0;
                border-top: 1px solid rgba(0, 0, 0, .1);
            }
            .table {
                width: 100%;
                margin-bottom: 1rem;
                background-color: transparent;
            }
            .table-responsive {
                white-space: nowrap;
            }
            .card .table {
                margin-bottom: 0px;
            }
            .card .table td, .card .table th {
                padding-right: 1.5rem;
                padding-left: 1.5rem;
            }
            .profile-card-2 h5 {
                font-weight: 600;
            }
            .card-title {
                margin-bottom: .75rem;
                font-weight: 600;
                font-size: 16px;
                color: #000000;
            }
            .table thead th, .table tfoot th {
                font-weight: 800;
                font-size: .72rem;
                padding-top: .75rem;
                padding-bottom: .75rem;
                letter-spacing: 1px;
                text-transform: uppercase;
                border-bottom: 1px solid rgba(0, 0, 0, 0.15);
            }
            .table th {
                font-weight: 600;
            }
            .table td, .table th {
                white-space: nowrap;
                border-top: 1px solid #dee2e6;
            }
            .paymentIconCss{
                width: 70px !important;
            }            p {
                margin-bottom: .65rem;
            }
            .payment-icons img {
                width: 100px;
            }
            .bg-light {
                background-color: rgba(255,255,255,.125)!important;
            }
            .btn-success {
                color: #fff;
                background-color: #02ba5a;
                border-color: #02ba5a;
            }
            .btn {
                font-size: .70rem;
                font-weight: 500;
                letter-spacing: 1px;
                padding: 9px 19px;
                border-radius: .25rem;
                text-transform: uppercase;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
            }

            .centerElement{
                margin: 0 auto;
                display: table;
            }
            .fr{
                float: right;
            }
            .badge-warning{
                color: black!important;
                background-color: #fba540!important
            }
            .logo-icon{
                width: 30%;
                margin-right: 5px;
            }
            .firstSection h5,.firstSection span{
                color: #fff !important;
            }
            .whiteFont{
                color: #fff !important;
            }
        </style>

        <!--Font awesome css-->
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!--Data Tables -->
        <link href="{{asset('/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
        <!--Bootstrap Datepicker-->
        <link href="{{asset('/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">

    </head>


    <body>

        <!-- start loader -->
        <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>
        <!-- end loader -->
        <div id="wrapper" class="toggled">
            <div class="clearfix"></div>

            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-table"></i> My Invoices

                                </div>


                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!--                                        <form method="post" action="home">
                                                                                    {{ csrf_field() }}
                                        <?php
                                        $date = date('Y-m-d'); //your given date
                                        $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
                                        $first_date = date("m/d/Y", $first_date_find);

                                        $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
                                        $last_date = date("m/d/Y", $last_date_find);
                                        ?>
                                                                                    <div class="row p-1">
                                                                                        <div class="col-sm-12 col-lg-2 col-md-2">
                                                                                            <label>Start Date</label>
                                                                                            <input required type="text" name="start_date" placeholder="Start Date" value="{{$first_date}}" id="start_date" class="form-control">
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-2 col-md-2">
                                                                                            <label>End Date</label>
                                                                                            <input required type="text" name="end_date" placeholder="End Date" value="{{$last_date}}" id="end_date" class="form-control">
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-4 col-md-4">
                                                                                            <label class=""></label>
                                                                                            <button type="submit" class="btn mt-4">Apply Filter</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>-->
                                        <!--role="grid" style="overflow-x: scroll; overflow-y: scroll; max-width: 90%; display: block; white-space: word-wrap: break-word;" cellspacing="0">-->

                                        <table id="invoiceDbList"  class="table table-bordered" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>
                                                    <th>Invoice Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Preview</th>
                                                    <th></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $statusString = ""; ?>
                                                @foreach($Invoices as $invoiceData)
                                                <tr>

                                                    <?php
                                                    $body_line = " %0D%0A ";
//                                                    $invoiceDataLink = 'https://' . $_SERVER['HTTP_HOST'] . '/TalevationPayment/public' . "/payment?token=" . $invoiceData->GUID;
                                                    $invoiceDataLink = $utility->projectBaseUrl() . '/public' . "/payment?token=" . $invoiceData->GUID;
                                                    $due_date = date("m-d-Y", strtotime($invoiceData->due_date));
                                                    $invoice_date = date("m-d-Y", strtotime($invoiceData->invoice_date));
//                                        $clickHere = "<a href='http://localhost:8080/TalevationPayment/public/payment?token=$invoiceData->GUID'> Click Here </a>";
                                                    $clickHere = "Hello " . $invoiceData->first_name . " " . $invoiceData->last_name . $body_line . $body_line . "Please pay your pending invoice with Talevation." . $body_line . "You can pay it online with the link below." . $body_line . $invoiceDataLink . $body_line . " " . $body_line . "If you are not able to click the link above, please copy and paste it in your browser." . $body_line . " " . $body_line . "Thanks," . $body_line . "Talevation";

                                                    $clickHere = nl2br($clickHere);
                                                    $status = $invoiceData->status;
                                                    $Amount = 0;

                                                    for ($k = 0; $k < count($invoiceData->invoice_items); $k++) {
                                                        $Amount += $invoiceData->invoice_items[$k]->rate * $invoiceData->invoice_items[$k]->quantity;
                                                    }

                                                    if ($status == 0) {
                                                        $statusString = "Unpaid";
                                                    } else if ($status == 1) {
                                                        $statusString = "Paid";
                                                    }
                                                    ?>
                                                    <td>{{$invoiceData->name}}</td>
                                                    <td>{{$invoiceData->first_name}} {{$invoiceData->last_name}}</td>

                                                    <td>{{$Amount}}</td>
                                                    <td>{{$invoice_date}}</td>
                                                    <td>{{$due_date}}</td>
                                                    <td>{{$statusString}}</td>
                                                    <?php $PreviewLink = "/previewInvoice?token=" . $invoiceData->GUID; ?>
                                                    <td class=""><a class="" href="{{url($PreviewLink)}}" target="_blank"><i style="margin: 0 auto;display: table;font-size: 15px;"  class="fas fa-eye"></i></a></td>
                                                    <td>
                                                        <?php if ($status == 0) { ?>
                                                            <?php // $link = 'https://' . $_SERVER['HTTP_HOST'] . '/TalevationPayment/public/previewInvoice?token=' . $invoiceData->GUID;
                                                            $link = $utility->projectBaseUrl() . '/public/previewInvoice?token=' . $invoiceData->GUID;
                                                            ?>
                                                            <a href="{{$link}}" target="_blank"> <button class="btn btn-success m-1"><i class="fa fa-credit-card" aria-hidden="true"></i>Pay Now</button></a>
                                                            <?php
                                                        } else {
                                                            echo '-';
                                                        }
                                                        ?>

                                                    </td>

                                                </tr>

                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Name</th>

                                                    <th>Amount</th>
                                                    <th>Invoice Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Preview</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Row-->



                </div>    <!--End container-fluid-->
            </div>      



            <!-- Bootstrap core JavaScript-->
            <script src="{{asset('/js/jquery.min.js')}}"></script>
            <script src="{{asset('/js/bootstrap.min.js')}}"></script>

            <script>




$(function () {
    "use strict";


    //sidebar menu js
    //$.sidebarMenu($('.sidebar-menu'));

    // === toggle-menu js
    $(".toggle-menu").on("click", function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    // === sidebar menu activation js

    $(function () {
        for (var i = window.location, o = $(".sidebar-menu a").filter(function () {
            return this.href == i;
        }).addClass("active").parent().addClass("active"); ; ) {
            if (!o.is("li"))
                break;
            o = o.parent().addClass("in").parent().addClass("active");
        }
    }),
            /* Back To Top */

            $(document).ready(function () {
        $(window).on("scroll", function () {
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').fadeIn();
            } else {
                $('.back-to-top').fadeOut();
            }
        });

        $('.back-to-top').on("click", function () {
            $("html, body").animate({scrollTop: 0}, 600);
            return false;
        });
    });


    // page loader

    $(window).on('load', function () {
        $('#pageloader-overlay').fadeOut(1000);

    })


    $(function () {
        $('[data-toggle="popover"]').popover()
    })


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    //                                                               




});
            </script>        
            <script src="https://kit.fontawesome.com/5eb42b8eec.js"></script>
            <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

            <!--Data Tables js-->
            <script src="{{asset('/plugins/bootstrap-datatable/js/jquery.dataTables.min.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/dataTables.buttons.min.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/jszip.min.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/pdfmake.min.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/buttons.html5.min.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/buttons.print.min.js')}}"></script>
            <script src="{{asset('/plugins/bootstrap-datatable/js/buttons.colVis.min.js')}}"></script>
            <!--Bootstrap Datepicker Js-->
            <script src="{{asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
            <script>

$(document).ready(function () {
//Default data table
    $('#invoiceDbList').DataTable();


});
            </script>
    </body>
</html>




