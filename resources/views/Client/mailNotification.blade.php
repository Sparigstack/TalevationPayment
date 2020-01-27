<html lang="en">
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


    </head>
    <body>
        <div class="col-lg-12 centerElement" style="margin: 0 auto;display: table;">



            <div class="panel-body">

                <div class="col-md-12" style="margin-top: 5%;">
                    <div class="col-lg-8 centerElement" id="receiptSection" style="margin: 0 auto;display: table;">
                        <div class="card">
                            <div class="card-body clientUpgradationSection">
                                <div class="row">
                                    <div class="col-md-12 secondSection">
                                    <p> Thank you for your time! <br>
                                        Your bank details is successfully registered with us. We will make two micro deposits to your given account and that will reflect within 3 to 5 business days. <br>
                                        You will get a confirmation email with next step link inside it. Once you receive the micro deposits in your bank account, kindly click the link provided in mail and verify your account. <br>
                                        Your invoice will be paid only after verification done from your end. <br> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>


                    </div>
                </div>



                <div class="hidden alert alert-success text-center col-lg-4 centerElement">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <!--        <p class="user-checkbox5 p-1">{{ Session::get('fail_message') }}</p>-->
                </div>

            </div>
            <!-- Bootstrap core JavaScript-->
            <script src="{{asset('/js/jquery.min.js')}}"></script>
            <script src="{{asset('/js/bootstrap.min.js')}}"></script>

    </body>
</html>

