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
            /**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
            .StripeElement {
                box-sizing: border-box;

                height: 40px;

                padding: 10px 12px;

                border: 1px solid transparent;
                border-radius: 4px;
                background-color: white;

                box-shadow: 0 1px 3px 0 #e6ebf1;
                -webkit-transition: box-shadow 150ms ease;
                transition: box-shadow 150ms ease;
                border: 1px solid #ced4da!important;
                border-radius: .25rem!important;
            }

            .StripeElement--focus {
                box-shadow: 0 1px 3px 0 #cfd7df;
            }

            .StripeElement--invalid {
                border-color: #fa755a;
            }

            .StripeElement--webkit-autofill {
                background-color: #fefde5 !important;
            }





            .pade_none{
                padding: 0 !important;
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

                #pageloader-overlay .loader-wrapper-outer {
                    background-color: transparent;
                    z-index: 9999;
                    margin: auto;
                    width: 100%;
                    height: 100%;
                    overflow: hidden;
                    display: table;
                    text-align: center;
                    vertical-align: middle;
                }
                *, ::after, ::before {
                    box-sizing: border-box;
                }

                #pageloader-overlay .loader-wrapper-inner {
                    display: table-cell;
                    vertical-align: middle;
                }

                #pageloader-overlay .loader, #pageloader-overlay .loader:after {
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                }
                #pageloader-overlay .loader {
                    margin: auto;
                    font-size: 10px;
                    position: relative;
                    text-indent: -9999em;
                    border-top: 8px solid rgba(255, 255, 255, 0.5);
                    border-right: 8px solid rgba(255, 255, 255, 0.5);
                    border-bottom: 8px solid rgba(255, 255, 255, 0.5);
                    border-left: 8px solid #AAA;
                    -webkit-transform: translateZ(0);
                    -ms-transform: translateZ(0);
                    transform: translateZ(0);
                    -webkit-animation: pageloader 1.1s infinite linear;
                    animation: pageloader 1.1s infinite linear;
                }

                @-webkit-keyframes pageloader {
                    0% {
                        -webkit-transform: rotate(0deg);
                        transform: rotate(0deg); 
                    }

                    100% {
                        -webkit-transform: rotate(360deg);
                        transform: rotate(360deg); 
                    } 
                }

                @keyframes pageloader {
                    0% {
                        -webkit-transform: rotate(0deg);
                        transform: rotate(0deg); 
                    }

                    100% {
                        -webkit-transform: rotate(360deg);
                        transform: rotate(360deg); 
                    } 
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
                /*white-space: nowrap;*/
                white-space: normal;
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


            [class*="icheck-material"] {
                min-height: 22px;
                margin-top: 6px;
                margin-bottom: 6px 
                    padding-left: 0px; }
            [class*="icheck-material"] > label {
                padding-left: 29px !important;
                min-height: 22px;
                line-height: 22px;
                display: inline-block;
                position: relative;
                vertical-align: top;
                margin-bottom: 0;
                font-weight: normal;
                cursor: pointer; }
            [class*="icheck-material"] > input:first-child {
                position: absolute !important;
                opacity: 0;
                margin: 0;
                background-color: #787878;
                border-radius: 50%;
                appearance: none;
                -moz-appearance: none;
                -webkit-appearance: none;
                -ms-appearance: none;
                display: block;
                width: 22px;
                height: 22px;
                outline: none;
                transform: scale(2);
                -ms-transform: scale(2);
                transition: opacity 0.3s, transform 0.3s; }
            [class*="icheck-material"] > input:first-child:disabled {
                cursor: default; }
            [class*="icheck-material"] > input:first-child:disabled + label,
            [class*="icheck-material"] > input:first-child:disabled + input[type="hidden"] + label,
            [class*="icheck-material"] > input:first-child:disabled + label::before,
            [class*="icheck-material"] > input:first-child:disabled + input[type="hidden"] + label::before {
                pointer-events: none;
                cursor: default;
                filter: alpha(opacity=65);
                -webkit-box-shadow: none;
                box-shadow: none;
                opacity: .65; }
            [class*="icheck-material"] > input:first-child + label::before,
            [class*="icheck-material"] > input:first-child + input[type="hidden"] + label::before {
                content: "";
                display: inline-block;
                position: absolute;
                width: 20px;
                height: 20px;
                border: 2px solid rgba(0, 0, 0, 0.46);
                border-radius: .25rem;
                margin-left: -29px;
                box-sizing: border-box; }
            [class*="icheck-material"] > input:first-child:checked + label::after,
            [class*="icheck-material"] > input:first-child:checked + input[type="hidden"] + label::after {
                content: "";
                display: inline-block;
                position: absolute;
                top: 0;
                left: 0;
                width: 7px;
                height: 10px;
                border: solid 2px #fff;
                border-left: none;
                border-top: none;
                transform: translate(7.75px, 4.5px) rotate(45deg);
                -ms-transform: translate(7.75px, 4.5px) rotate(45deg);
                box-sizing: border-box; }
            [class*="icheck-material"] > input:first-child:not(:checked):not(:disabled):hover + label::before,
            [class*="icheck-material"] > input:first-child:not(:checked):not(:disabled):hover + input[type="hidden"] + label::before {
                border-width: 2px; }
            [class*="icheck-material"] > input:first-child::-ms-check {
                opacity: 0;
                border-radius: 50%; }
            [class*="icheck-material"] > input:first-child:active {
                transform: scale(0);
                -ms-transform: scale(0);
                opacity: 1;
                transition: opacity 0s, transform 0s; }
            [class*="icheck-material"] > input[type="radio"]:first-child + label::before,
            [class*="icheck-material"] > input[type="radio"]:first-child + input[type="hidden"] + label::before {
                border-radius: 50%; }
            [class*="icheck-material"] > input[type="radio"]:first-child:checked + label::before,
            [class*="icheck-material"] > input[type="radio"]:first-child:checked + input[type="hidden"] + label::before {
                background-color: transparent; }
            [class*="icheck-material"] > input[type="radio"]:first-child:checked + label::after,
            [class*="icheck-material"] > input[type="radio"]:first-child:checked + input[type="hidden"] + label::after {
                content: "";
                position: absolute;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                border: none;
                top: 5px;
                left: 5px;
                transform: none;
                -ms-transform: none; }
            [class*="icheck-material"] > input[type="checkbox"]:first-child:checked + label::after,
            [class*="icheck-material"] > input[type="checkbox"]:first-child:checked + input[type="hidden"] + label::after {
                width: 6px;
                height: 12px;
                transform: translate(7px, 2px) rotate(45deg);
                -ms-transform: translate(7px, 2px) rotate(45deg); }

            .icheck-inline {
                display: inline-block; }
            .icheck-inline + .icheck-inline {
                margin-left: .75rem;
                margin-top: 6px; }

            .icheck-material-primary > input:first-child {
                background-color: #14abef; }
            .icheck-material-primary > input:first-child::-ms-check {
                background-color: #14abef; }
            .icheck-material-primary > input:first-child:not(:checked):not(:disabled):hover + label::before,
            .icheck-material-primary > input:first-child:not(:checked):not(:disabled):hover + input[type="hidden"] + label::before {
                border-color: #14abef; }
            .icheck-material-primary > input:first-child:checked + label::before,
            .icheck-material-primary > input:first-child:checked + input[type="hidden"] + label::before {
                background-color: #14abef;
                border-color: #14abef; }
            .icheck-material-primary > input:first-child:checked + label::after,
            .icheck-material-primary > input:first-child:checked + input[type="hidden"] + label::after {
                border-bottom-color: #fff;
                border-right-color: #fff; }

            .icheck-material-primary > input[type="radio"]:first-child:checked + label::after,
            .icheck-material-primary > input[type="radio"]:first-child:checked + input[type="hidden"] + label::after {
                background-color: #14abef; }

            .paymentOptionUI{
                display: flex;
                justify-content: space-between;
                /*                align-items: center;
                                align-content: center;*/
                padding-bottom: 15px;
                /*                width: 40%;
                                margin: 0 auto;*/
            }

            .outcome {
                float: left;
                width: 100%;
                padding-top: 8px;
                min-height: 24px;
                text-align: center;
            }

            .success, .error {
                display: none;
                font-size: 13px;
            }

            .success.visible, .error.visible {
                display: inline;
            }

            .error {
                color: #E4584C;
            }

            .success {
                color: #666EE8;
            }

            .success .token {
                font-weight: 500;
                font-size: 13px;
            }
            #termsCheckCard{
                width: 18px;
                height: 18px;
            }
            #termsCheckBank{
                width: 18px;
                height: 18px;
            }
            .tooltiptext{
                    font-size: 12px;
    line-height: 17px;
    visibility: hidden;
    /*max-width: 300px;*/
    background-color: #242424;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 7px 20px;
/*    position: absolute;*/
    z-index: 1;
/*    bottom: 10%;
    left: 35%;
    margin-left: -60px;*/
    opacity: 0;
    transition: .3s;
    transform: translate3d(0px, 20px, 0px);
    visibility: visible;
    opacity: 1;
    transform: translate3d(0px, 0px, 0px);
    text-transform: initial;
    position: relative;
    margin-left: -65px;
            }
            .tooltiptext::after {
    content: "";
    position: absolute;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #242424 transparent transparent transparent;
    bottom: -10px;
    left:11%;
    
}
.tooltipSaveBank{
    /*left:25%;*/
    /*margin-right: 35px;*/
}
/*.tooltipSection{
    width: 60%;
    margin: 0 auto;
}*/
.showHideTooltip{
    text-align: center;
}

/*.showHideTooltipBank .tooltiptext::after{
    top: 92.5%;
    left:45%;
}*/


        </style>

        <!--Font awesome css-->
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    </head>
    <!--<script type="text/javascript" src="https://js.stripe.com/v2/"></script>-->

    <body>
        <?php
        $hiddenAchVerification = 'hidden';
        $hiddenInvoiceDetails = '';
        // var_dump($invoiceData);
//        return;
        ?>
        <!-- start loader -->
        <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>
        <!-- end loader -->


        <div id="wrapper" class="toggled">




            <div class="clearfix"></div>

            <div class="content-wrapper" style="padding-top: 10px;">
                <div class="container-fluid">
                    <!-- Breadcrumb-->
                    <div class="row">   </div>
                    <div class="panel-body">

                        <div class="col-md-12" style="">
                            <div class="col-lg-8 centerElement" style="margin: 0 auto;display: table;">

                                <?php
                                if (isset($_GET['p'])) {
                                    $hiddenAchVerification = '';
                                    $hiddenInvoiceDetails = 'hidden';
                                }
                                ?>
                                <div class="card {{$hiddenInvoiceDetails}}" id="generateInvoice">
                                    <div class="card-body">
                                        <!-- Content Header (Page header) -->
                                        <section class="content-header">
                                            <?php $uniqid = uniqid(); ?>

                                        </section>

                                        <!-- Main content -->
                                        <section class="invoice">
                                            <!-- title row -->
                                            <div class="row mt-3">
                                                <div class="col-lg-6">
                                                    <h6><i class="fa fa-globe"></i> {{$invoiceData->name}}</h6>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php
                                                    $date = date_create($invoiceData->invoice_date);
                                                    $invoice_date = date_format($date, 'm-d-Y');
                                                    ?>
                                                    <h5 class="float-sm-right">Date: {{$invoice_date}}</h5>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row invoice-info">
                                                <div class="col-sm-4 invoice-col">
                                                    From
                                                    <address>
                                                        <strong>Talevation Payment</strong><br>

                                                        Email: admin@talevation.com
                                                    </address>
                                                </div><!-- /.col -->
                                                <div class="col-sm-4 invoice-col">
                                                    To
                                                    <address>
                                                        <strong>{{$invoiceData->first_name}} {{$invoiceData->last_name}}</strong><br>
                                                        {{$invoiceData->address1}}<br>
                                                        <?php
                                                        if (isset($invoiceData->address2)) {
                                                            echo $invoiceData->address2 . '\n';
                                                        }
                                                        ?>
                                                        {{$invoiceData->city_name}} {{$invoiceData->state_name}}<br>

                                                        Email: {{$invoiceData->email}}
                                                    </address>
                                                </div><!-- /.col -->
                                                <div class="col-sm-4 invoice-col">
                                                    <b>Invoice No. #{{$invoiceData->id}}</b><br>
                                                    <br>
                                                    <?php
                                                    $date = date_create($invoiceData->due_date);
                                                    $dueDate = date_format($date, 'm-d-Y');
                                                    ?>
                                                    <b>Payment Due:{{$dueDate}} </b>  <br>
                                                    <?php if ($invoiceData->status == 1) { ?>
                                                        <b style="text-transform: uppercase;color: #ff0000b5;font-size: 16px;" class="">PAID</b>
                                                    <?php } ?>
                                                    <!--<b>Account:</b> 968-34567-->
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->

                                            <!-- Table row -->
                                            <div class="row">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>

                                                                <th>Invoice Item</th>
                                                                <th>Qty</th>
                                                                <th>Rate</th>
                                                                <th>Taxable?</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $subTotal = 0;
                                                            $TotalAmount = 0;
                                                            $totalTax = 0;
                                                            $totalDue = 0;
                                                            ?>
                                                            @foreach($invoiceData->invoice_items as $invoiceItems)
                                                            <?php
                                                            $subTotal = $invoiceItems->quantity * $invoiceItems->rate;
//                                                            + ($invoiceItems->quantity * $invoiceItems->rate * $invoiceItems->tax / 100);
                                                            $TotalAmount += $subTotal;

                                                            $tax = 0;

                                                            if ($invoiceItems->is_taxable == 1) {

                                                                $tax = ($subTotal * $stateTaxes->tax_rate) / 100;

                                                                $taxValue = str_replace(',', '', number_format($tax, 2));
                                                                $totalTax += $taxValue;
                                                            }
                                                            ?>
                                                            <tr class="row" style="display: table-row;">       

                                                                <td class="">{{$invoiceItems->discription}}</td>
                                                                <td>{{$invoiceItems->quantity}}</td>
                                                                <td>${{$invoiceItems->rate}}</td>
                                                                <td><?php
                                                                    if ($invoiceItems->is_taxable == 0)
                                                                        echo 'No';
                                                                    else
                                                                        echo 'Yes';
                                                                    ?>
                                                                </td>
                                                                <!--<td>El snort testosterone trophy driving gloves handsome</td>-->
                                                                <td>${{number_format($subTotal,2)}}</td>

                                                            </tr>
                                                            @endforeach
                                                            <?php $totalDue = $TotalAmount + $totalTax; ?>
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->

                                            <div class="row">
                                                <!-- accepted payments column -->
                                                <div class="col-lg-7 payment-icons mt-3">

                                                    <?php
                                                    if (!empty($invoiceData->memo)) {
                                                        $memo = $invoiceData->memo;
                                                        ?>
                                                        <b>Memo:</b></br>{{$memo}} </br>
                                                    <?php } ?>

<!--                                                    <p class="lead">Payment Methods:</p>
<img class="paymentIconCss" style="" src="{{asset('/payment-icons/visa-dark.png')}}" alt="Visa">
<img class="paymentIconCss" src="{{asset('/payment-icons/mastro-dark.png')}}" alt="Mastercard">
<img class="paymentIconCss" src="{{asset('/payment-icons/american-dark.png')}}" alt="American Express">
<img class="paymentIconCss" src="{{asset('/payment-icons/Mastercard-Download-PNG.png')}}" alt="Paypal">-->


                                                    </br>   <b> State Tax : </b>{{$stateTaxes->state_name}} ({{$stateTaxes->tax_rate}}% tax) </br> </br>
                                                    <?php
                                                    $showHide = "";
                                                    if($invoiceData->RecurringOption == "") 
                                                        $showHide = "hidden";
                                                    ?>
                                                    <div class="{{$showHide}}">
                                                    <p> Do you want to pay this invoice automatically with your saved payment method every 
                                                        <?php
                                                        if ($invoiceData->RecurringOption == 1)
                                                            echo 'month';
                                                        if ($invoiceData->RecurringOption == 2)
                                                            echo 'quarter';
                                                        if ($invoiceData->RecurringOption == 3)
                                                            echo 'year';
                                                        ?>?
                                                    </p>
                                                    <div class="icheck-material-primary float-left">
                                                        <input type="radio" class="" id="yesRecur" checked="" name="IsRecurringAgreed">
                                                        <label for="yesRecur">Yes</label>
                                                    </div>
                                                    <div class="icheck-material-primary pl-2 float-left">
                                                        <input type="radio" id="noRecur" name="IsRecurringAgreed">
                                                        <label for="noRecur">No</label>
                                                    </div>
                                                </div>
                                                </div><!-- /.col -->
                                                <div class="col-lg-5">
                                                    <!--<p class="lead">Amount Due ${{number_format($TotalAmount,2)}}</p>-->
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>

                                                                <?php
//                                                                $tax = 0;
//                                                                $totalTax = 0;
//                                                                $totalDue = 0;
//                                                                
//                                                                $tax = $TotalAmount + (($TotalAmount * $stateTaxes->tax_rate) / 100);
//                                                                
//                                                                $taxValue = str_replace(',', '', number_format($tax, 2));
//                                                                $totalTax += $taxValue;
//                                                                
//                                                                $totalDue = $TotalAmount + $totalTax;
                                                                ?>

                                                                <tr>
                                                                    <th style="width:56%">Subtotal:</th>
                                                                    <td class="invoice_Total">${{number_format($TotalAmount,2)}}</td>
                                                                </tr>
<!--                                                                <tr>
                                                                    <th>Tax (0%)</th>
                                                                    <td>-</td>
                                                                </tr>-->
                                                                <tr>
                                                                    <th>Total Tax:</th>
                                                                    <td>${{number_format($totalTax,2)}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total Due:</th>
                                                                    <td class="totalDue">${{number_format($totalDue,2)}}</td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->

                                            <!-- this row will not appear when printing -->
                                            <hr>
                                            <div class="row no-print">
                                                <div class="col-lg-3">
                                                    <a href="javascript:void();" target="_blank" onclick="printDiv('generateInvoice');" class="btn btn-dark m-1"><i class="fa fa-print"></i> Print</a>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="float-sm-right">
                                                        <button class="btn btn-success m-1" onclick="return invoicePayment(this, 'proceed');"><i class="fa fa-credit-card"></i> Proceed To Pay</button>

                                                    </div>
                                                </div>
                                                <?php // }          ?>
                                            </div>
                                        </section><!-- /.content -->
                                    </div>
                                </div>

                                <div class="modal fade" id="openPdf" style="display:none;" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pb-2 pt-2" style="font-size:25px;">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
      <div class="modal-body">
        <object type="application/pdf" data="{{url('SHL Terms and Conditions provided by Talevation.pdf')}}" width="100%" height="500" style="">No Support</object>
      </div>
  </div>
</div>
                                                        </div>


                                <div class="card {{$hiddenAchVerification}}" id="stripePaymentUI">
                                    <div class="card-body">

                                        <?php
                                        if ($invoiceData->customer->isAchVerified == "1" && $invoiceData->customer->stripe_customer_id !== '' && isset($_GET['p'])) {
                                            ?>
                                            <div class="paymentVerifyDiv">
                                                <div class="card-title mt-3">Bank Account Verification</div>
                                                <p> Hello {{$invoiceData->customer->first_name}}, <br> 
                                                    You have previously saved your bank account with account number ending with {{$PaymentMethodBank->last4}} for ACH payment. We sent two micro deposits to your account, please enter those exact two amounts below to verify your bank account.
                                                    <br> Routing number: {{$PaymentMethodBank->routing_number}}
                                                </p>
                                                <hr>
                                                <!--<form role="form" action=""  method="post">-->

                                                {{ csrf_field() }}
                                                <input type="hidden" name="invoiceToken" value="<?php echo $_GET['token']; ?>" />
                                                <input type="hidden" name="stripe_customer_id_verify"  id="stripe_customer_id_verify" value="{{$invoiceData->customer->stripe_customer_id}}" />
                                                <input type="hidden" name="stripe_source_id_verify" id="stripe_source_id_verify" value="{{$invoiceData->customer->stripe_source_id}}" />
                                                <input type="hidden" name="invoiceId" id="invoiceId" value="{{$invoiceData->id}}" />
                                                <input type="hidden" name="price" id="price" value="{{$totalDue}}" />
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="input-1">Amount 1(in cents)</label>
                                                            <input type="text" class="form-control" required id="amount1" name="amount1" placeholder="Enter Amount" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="input-1">Amount 2(in cents)</label>
                                                            <input type="text" class="form-control" required id="amount2" name="amount2" placeholder="Enter Amount" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>

                                                <div class='alert-danger alert p-2 hidden' id="amountVerify">
                                                    The amounts provided do not match the amounts that were sent to the bank account.
                                                </div> 
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info mr-1 px-5 pull-right" id="verification" onclick="achVerification();"><i class="icon-lock"></i>Verify & Pay Now</button>
                                                </div>
                                                <!--</form>-->
                                            </div> <?php } else {
                                            ?>
                                            <!--                                            <div class="col-md-12 col-lg-12 col-sm-12">
                                                                                            <div class="paymentOptionUI">
                                                                                                <div class="icheck-material-primary">
                                                                                                    <input type="radio" id="primary1" name="primaryname" checked="" onclick="changePaymentProcess(this);" data-payment="credit-card">
                                                                                                    <label for="primary1">Credit Card Payment</label>
                                                                                                </div>
                                                                                                <div class="icheck-material-primary">
                                                                                                    <input type="radio" id="primary2" name="primaryname" onclick="changePaymentProcess(this);" data-payment="bank-payment">
                                                                                                    <label for="primary2">Bank Payment</label>
                                                                                                </div> 
                                                                                            </div>
                                                                                        </div>-->

                                            <div class="card-title">Kindly pay your Talevation Invoice!</div>
                                            <hr>

                                            <div class="creditCardDiv">
                                                <form role="form" action="{{ route('stripe.post') }}"  method="post" class="require-validation form-active" data-cc-on-file="false" data-stripe-publishable-key="{{env('STRIPE_KEY')}}" id="payment-form" >
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="GUID" id="GUID" value="{{$_GET['token']}}">
                                                    <input type="hidden" value="{{$invoiceData->id}}" name="invoice_id">
                                                    <input type="hidden" class="recurValue" name="recurValue" id="recurValue" value="">
                                                    <input type="hidden" class="recurOption" name="recurOption" id="recurOption" value="{{$invoiceData->RecurringOption}}">
                                                    <div class="form-group">
                                                        <label for="input-1">Name on Card</label>
                                                        <input type="text" class="form-control" required id="name_on_card" name="name_on_card" placeholder="Enter Your Name" value="{{$invoiceData->first_name}} {{$invoiceData->last_name}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="input-1">Email</label>
                                                        <input type="text" class="form-control" required id="email" name="email" placeholder="Enter Your Email" value="{{$invoiceData->email}}">
                                                    </div>

                                                    <?php
                                                    $hideNewCard = '';
                                                    $ccType = '1';
                                                    $stripe_payment_id = $invoiceData->customer->stripe_customer_id;
                                                    $stripe_source_id = $invoiceData->customer->stripe_source_id;
                                                    if (isset($stripe_payment_id) && $stripe_payment_id != '' && (strpos($stripe_source_id, 'src_') !== false || strpos($stripe_source_id, 'card_') !== false)) {
                                                        $hideNewCard = 'hidden';
                                                        $ccType = '2';
                                                        ?>
                                                        <input value="{{$stripe_payment_id}}" id="stripe_customer_id" name="stripe_customer_id" type="hidden">
                                                        <div id="existingCreditCard" class="form-group">
                                                            <input type="hidden" value="" name="paymentMethodId" id="paymentMethodId">
                                                            <input type="hidden" value="" name="stripe_source_id" id="stripe_source_id">
                                                            <label class="col-lg-8 col-sm-12 col-md-8 pade_none" for="input-2">Payment Source</label>
                                                            <select onclick="setPaymentId(this);" id="paymentMethod" name="paymentMethod" class="form-control col-lg-4 col-sm-12 custom-select"  style="text-transform: lowercase;">
                                                                @for($i=0;$i<count($PaymentMethod['data']);$i++)
                                                                    <option id="{{$PaymentMethod['data'][$i]->id}}">{{$PaymentMethod['data'][$i]['card']->brand}} ending with {{ $PaymentMethod['data'][$i]['card']->last4}}</option>
                                                                    @endfor
                                                            </select>
                                                            <a data-shownew="1" class="m-2 mr-3" href="javascript:void(0);" onclick="return showHideNewCard(this);"><i class="icon-lock"></i> Use New Payment Method</a>
                                                        </div>
                                                    <?php } else { ?>



                                                        <!--                                                <div class='form-row row'>
                                                                                                            <div class="col-xs-12 col-md-4 form-group cvc required">
                                                                                                            <label for="input-2">Card Number</label>
                                                                                                            <input type="text" autocomplete='off' class="form-control card-number" value="" required name="card-number" size='20' id="card-number" placeholder="Enter Your Card Number">
                                                                                                        </div>
                                                                                                            <div class='col-xs-12 col-md-2 form-group cvc required'>
                                                                                                                <label class='control-label'>CVC</label>
                                                                                                                <input autocomplete='off' class='form-control required card-cvc' value="" name="card-cvc" id="card-cvc" placeholder='ex. 311' size='4' type='text'>
                                                                                                            </div>
                                                                                                            <div class='col-xs-12 col-md-3 form-group expiration required'>
                                                                                                                <label class='control-label'>Expiration Month</label> <input
                                                                                                                    class='form-control card-expiry-month' required name="card-expiry-month" value="" id="card-expiry-month" placeholder='MM' size='2'
                                                                                                                    type='text'>
                                                                                                            </div>
                                                                                                            <div class='col-xs-12 col-md-3 form-group expiration required'>
                                                                                                                <label class='control-label'>Expiration Year</label> <input
                                                                                                                    class='form-control card-expiry-year' required name="card-expiry-year" value="" id="card-expiry-year" placeholder='YYYY' size='4'
                                                                                                                    type='text'>
                                                                                                            </div>
                                                                                                        </div>-->



                                                    <?php } ?>
                                                    <div id="newCreditCard" class="{{$hideNewCard}}">
                                                        <div class="col-md-6 col-lg-6 col-sm-12 p-0">
                                                            <div class="paymentOptionUI mt-3">
                                                                <div class="icheck-material-primary">
                                                                    <input type="radio" id="primary1" name="primaryname" checked="" onclick="changePaymentProcess(this);" data-payment="credit-card">
                                                                    <label for="primary1">Credit Card Payment</label>
                                                                </div>
                                                                <div class="icheck-material-primary">
                                                                    <input type="radio" id="primary2" name="primaryname" onclick="changePaymentProcess(this);" data-payment="bank-payment">
                                                                    <label for="primary2">Bank Payment</label>
                                                                </div> 
                                                            </div>
                                                        </div>


                                                        <label for="card-element">
                                                            Credit or debit card
                                                        </label>
                                                        <div id="card-element">
                                                            <!-- A Stripe Element will be inserted here. -->
                                                        </div>

                                                        <!-- Used to display form errors. -->
                                                        <div id="card-errors" role="alert"></div>
                                                        <?php if (isset($stripe_payment_id) && $stripe_payment_id != '' && (strpos($stripe_source_id, 'src_') !== false || strpos($stripe_source_id, 'card_') !== false)) { ?>
                                                            <a data-shownew="0" class="m-2 mr-3" href="javascript:void(0);" onclick="return showHideNewCard(this);"><i class="icon-lock"></i> Select Existing Card</a>
                                                        <?php } ?>
                                                    </div>

                                                    <input type="hidden" value="{{$ccType}}" name="ccType" id="ccType" />

                                                    <div class='form-row row'>
                                                        <div class='col-md-12 error form-group hidden'>
                                                            <div class='alert-danger alert p-2'>Please correct the errors and try
                                                                again.</div>
                                                        </div>
                                                    </div>

                                                    <div class='form-row mb-3'>
                                                        <div class='col-md-12 mt-3 '>
                                                            <div class='row mt-3'>
                                                                <div class='centerElement'>
                                                                    <p>Billed to: {{$invoiceData->first_name}} {{$invoiceData->last_name}}({{$invoiceData->email}})</p>
                                                                </div>
                                                            </div>

                                                            <div class='row mt-3'>
                                                                <div class='col-md-12'>
                                                                    <div class='fr'>
                                                                        <input type="hidden" name="totalPrice" id="totalPrice" value="{{$totalDue}}">
                                                                        <h3 class="totalPrice">Total: $14.99/month</h3>
                                                                    </div>
                                                                </div>
                                                            </div>                                       
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    
                                                    
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3" style="">
                                                                <img src="https://dev.sprigstack.com/TalevationPayment/public/images/img_payment_secure_ssl.png" alt="ssl icon">SSL SECURE
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="row">
                                                                    <div class="col-md-7">                
                                                                        <div class="tooltipSection pull-right">
                                                                            <div class="form-group showHideTooltip mb-1 hidden">
                                                                                <span class="tooltiptext">Please Check Terms and Conditions </span>
                                                                            </div>

                                                                            <input type="checkbox" checked="" id="termsCheckCard" name="termsCheckName" class="mt-2 checkCard" onclick="checkTerms(this);" style="float: left;">  <label for="termsCheckCard" class="m-2 mr-3">I agree to the <a data-toggle="modal" data-target="#openPdf" href="">terms and conditions</a></label>
                                                       
                                                                        </div>    
                                                                    </div> 
                                                                    <div class="col-md-5"> 
                                                                        <div class="row pull-right" >
                                                                            <input type="hidden" name="paymentMethodCredit" id="paymentMethodCredit" value="credit">
                                                                            <a class="m-2 mr-3" href="javascript:void(0);" onclick="return invoicePayment(this, 'back');"><i class="icon-lock"></i> Back</a>
                                                                            <button type="submit" class="btn btn-info mr-1 px-5" id="buttonDisableCard"><i class="icon-lock"></i> Pay Now</button>
                                                        
                                                                        </div>
                                                                    </div>                                                        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
<!--                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <div class="col-md-4 pull-left" style="">
                                                                <img src="{{asset('images/img_payment_secure_ssl.png')}}" alt="ssl icon">SSL SECURE
                                                            </div>
                                                            
                                                        </div>

                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <input type="hidden" name="paymentMethodCredit" id="paymentMethodCredit" value="credit">
                                                        <button type="submit" class="btn btn-info mr-1 px-5 pull-right" id="buttonDisableCard" ><i class="icon-lock"></i> Pay Now</button>
                                                        <a class="pull-right m-2 mr-3" href="javascript:void(0);" onclick="return invoicePayment(this, 'back');"><i class="icon-lock"></i> Back</a>

                                                        <div class="tooltipSection">
                                                            <div class="form-group showHideTooltip mb-1 hidden">
                                                                    <span class="tooltiptext">Please Check Terms and Conditions </span>
                                                                </div>

                                                            <label for="termsCheckCard" class="pull-right m-2 mr-3">I agree to the <a data-toggle="modal" data-target="#openPdf" href="">terms and conditions</a></label>
                                                            <input type="checkbox" checked id="termsCheckCard" name="termsCheckName" class="pull-right mt-2 checkCard" onclick="checkTerms(this);">
                                                        </div>
                                                    </div>-->
                                                </form>
                                            </div>

                                            <div class="bankPaymentDiv hidden">
                                                <form action="{{ route('stripe.post1') }}" class="" method="post" data-cc-on-file="false" data-stripe-publishable-key="{{env('STRIPE_KEY')}}" id="payment-formbank">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="source" />
                                                    <input type="hidden" name="email" value="{{$invoiceData->email}}" />
                                                    <input type="hidden" class="recurValue" name="recurValue" id="recurValue" value="">
                                                    <input type="hidden" class="recurOption" name="recurOption" id="recurOption" value="{{$invoiceData->RecurringOption}}">
                                                    <input type="hidden" value="{{$invoiceData->id}}" name="invoice_id_verify" id="invoice_id_verify">
                                                    <input type="hidden" value="{{$invoiceData->customer->id}}" name="stripe_customer_id_verify" id="stripe_customer_id_verify">
                                                    <input type="hidden" name="invoiceToken" value="<?php echo $_GET['token']; ?>" />
                                                    <div class="form-group">
                                                        <label for="input-1">Name</label>
                                                        <input id="name" name="bankHolderName" class="form-control field" required value="{{$invoiceData->first_name}} {{$invoiceData->last_name}}" placeholder="Jenny Rosen" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="input-1">Email</label>
                                                        <input type="text" class="form-control" required id="email" name="email" placeholder="Enter Your Email" value="{{$invoiceData->email}}">
                                                    </div>



                                                    <?php
                                                    $stripe_payment_id = $invoiceData->customer->stripe_customer_id;
                                                    $stripe_source_id = $invoiceData->customer->stripe_source_id;
                                                    $isAchVerified = $invoiceData->customer->isAchVerified;
                                                    $hideNewCardBank = '';
                                                    $bType = '1';
                                                    if (isset($stripe_payment_id) && $stripe_payment_id != '' && strpos($stripe_source_id, 'ba_') !== false && $isAchVerified == 2) {
                                                        $hideNewCardBank = 'hidden';
                                                        $bType = '2';
                                                        ?>

                                                        <input value="{{$stripe_source_id}}" id="stripe_source_id" name="stripe_source_id" type="hidden">
                                                        <div id="existingBankDetails" class="form-group">
                                                            <input type="hidden" value="" name="paymentMethodIdBank" id="paymentMethodIdBank">
                                                            <input value="{{$stripe_payment_id}}" id="stripe_customer_id" name="stripe_customer_id" type="hidden">
                                                            <label class="col-lg-8 col-sm-12 col-md-8 pade_none" for="input-2">Payment Source</label>
                                                            <select onclick="setPaymentIdBank(this);" id="paymentMethodBank" name="paymentMethodBank" class="form-control col-lg-4 col-sm-12 custom-select"  style="text-transform: lowercase;">
                                                                <option id="{{$PaymentMethodBank['id']}}">ending with {{$PaymentMethodBank->last4}} </option>
                                                            </select>
                                                            <a class="m-2 mr-3" href="javascript:void(0);" onclick="return deleteBankAccount(this);"><i class="icon-lock"></i> Remove Bank Account</a>
                                                        </div> <?php } ?>

                                                    <div id="newBankDetails" class="{{$hideNewCardBank}}">
                                                        <div class="col-md-6 col-lg-6 col-sm-12 p-0">
                                                            <div class="paymentOptionUI mt-3">
                                                                <div class="icheck-material-primary">
                                                                    <input type="radio" id="primary1" name="primaryname" onclick="changePaymentProcess(this);" data-payment="credit-card">
                                                                    <label for="primary1">Credit Card Payment</label>
                                                                </div>
                                                                <div class="icheck-material-primary">
                                                                    <input type="radio" id="primary2" name="primaryname" checked="" onclick="changePaymentProcess(this);" data-payment="bank-payment">
                                                                    <label for="primary2">Bank Payment</label>
                                                                </div> 
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="input-1">Type</label>
                                                            <select id="type" class="form-control field" required name="type">
                                                                <option value="individual">Individual</option>
                                                                <option value="company">Company</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="input-1">Routing number</label>
                                                            <input id="routing-number" name="routing_number" class="form-control field" value="110000000" placeholder="110000000" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="input-1">Account number</label>
                                                            <input id="account-number" name="account_number" class="form-control field" value='000123456789' placeholder="000123456789" />
                                                        </div>

                                                    </div> 

                                                    <input type="hidden" value="{{$bType}}" name="bType" id="bType" />

                                                    <div class='form-row row'>
                                                        <div class='col-md-12 error form-group hidden'>
                                                            <div class='alert-danger alert p-2'>Please correct the errors and try
                                                                again.</div>
                                                        </div>
                                                    </div>

                                                    <div class='form-row mb-3'>
                                                        <div class='col-md-12 mt-3 '>
                                                            <div class='row'>
                                                                <div class='centerElement'>
                                                                    <p>Billed to: {{$invoiceData->first_name}} {{$invoiceData->last_name}}({{$invoiceData->email}})</p>
                                                                </div>
                                                            </div>
                                                            <div class='row mt-3'>
                                                                <div class='col-md-12'>
                                                                    <div class='fr'>
                                                                        <input type="hidden" name="totalPrice" id="totalPrice" value="{{$totalDue}}">
                                                                        <h3 class="totalPrice">Total: $14.99/month</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!-- <div class="form-row row ">
                                                        <div class="col-12">
                                                            <div class="form-group showHideTooltipBank fr mb-1 hidden">
                                                        <span class="tooltiptext tooltipSaveBank pull-right fr">Check Terms and Conditions </span>
                                                    </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <!--<a href="javascript:void(0);"><img style="width: 50%;float: left;" src="{{url('images/CC.png')}}" alt="payment icon"></a>-->

                                                            <div class="col-md-4 pull-left" style="">
                                                                <a href="javascript:void(0);"><img src="https://coworker.imgix.net/template/img/img_payment_secure_ssl.png" alt="ssl icon">SSL <span>secure</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <input type="hidden" name="paymentMethodBank" id="paymentMethodBank" value="bank">
                                                        <button type="submit" class="btn btn-info mr-1 px-5 pull-right" id="buttonDisableBank"><i class="icon-lock"></i>Save Bank Account</button>
                                                        <a class="pull-right m-2 mr-3" href="javascript:void(0);" onclick="return invoicePayment(this, 'back');"><i class="icon-lock"></i> Back</a>
                                                        <div class="tooltipSection">
                                                            <div class="form-group showHideTooltipBank mb-1 hidden text-center">
                                                        <span class="tooltiptext tooltipSaveBank">Please Check Terms and Conditions </span>
                                                        </div>
                                                        <label for="termsCheckBank" class="pull-right m-2 mr-3">I agree to the <a data-toggle="modal" data-target="#openPdf" href="">terms and conditions</a></label>
                                                        <input type="checkbox" checked id="termsCheckBank" name="termsCheckName" class="pull-right mt-2 checkBank"onclick="checkTerms(this);" >
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--End content-wrapper-->



            <!--Start footer-->
            <footer class="footer">
                <div class="container">
                    <?php
                    $utility = new \App\Utility;
                    $link = $utility->projectBaseUrl() . '/public/myInvoices/' . $invoiceData->customer->GUID;
                    ?>
                    <div class="text-center">You can check your other invoices at <a href="{{$link}}" class="" target="_blank"> <i class="fas fa-clipboard-list"></i> My Invoices</a></div>
                    <div class="text-center">
                        Copyright © <?php echo date("Y"); ?> Talevation Payments
                    </div>
                </div>
            </footer>
            <!--End footer-->

        </div><!--End wrapper-->

    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="{{asset('/js/popper.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
    <!-- <script src="{{asset('/js/popper.min.js')}}"></script> -->
    <script src="https://kit.fontawesome.com/5eb42b8eec.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

                                                        $(function () {
                                                            $(window).on('load', function () {
                                                                $('#pageloader-overlay').fadeOut(1000);

                                                            })


                                                            $(function () {
                                                                $('[data-toggle="popover"]').popover()
                                                            })


                                                            $(function () {
                                                                $('[data-toggle="tooltip"]').tooltip()
                                                            })
                                                            $("#paymentMethodId").val($("#paymentMethod option:first").attr('id'));
                                                            $("#paymentMethodIdBank").val($("#paymentMethodBank option:first").attr('id'));

                                                        });
                                                        function setPaymentId(element) {
                                                            var option = $('option:selected', element).attr('id');

                                                            $("#paymentMethodId").val(option);
                                                        }

                                                        function invoicePayment(element, fromWhere) {
                                                            $("#generateInvoice").addClass('hidden');
                                                            $("#stripePaymentUI").removeClass('hidden');
                                                            var invoice_Total = $(".totalDue").text();

                                                            $(".totalPrice").text("Total: " + invoice_Total);
                                                            if (fromWhere == 'back') {
                                                                $("#generateInvoice").removeClass('hidden');
                                                                $("#stripePaymentUI").addClass('hidden');
                                                            }
                                                            if ($("#yesRecur").is(':checked')) {
                                                                if($(".recurOption").val() != ""){
                                                                    if ($(".creditCardDiv").hasClass("hidden")) {
                                                                        $(".creditCardDiv").find(".recurValue").val('1');
                                                                        $(".bankPaymentDiv").find(".recurValue").val('1');
                                                                    } else {
                                                                        $(".bankPaymentDiv").find(".recurValue").val('1');
                                                                        $(".creditCardDiv").find(".recurValue").val('1');
                                                                    }
                                                                }
                                                            } else if($("#noRecur").is(':checked')){
                                                                if($(".recurOption").val() != ""){
                                                                    if ($(".creditCardDiv").hasClass("hidden")) {
                                                                        $(".creditCardDiv").find(".recurValue").val('');
                                                                        $(".bankPaymentDiv").find(".recurValue").val('');
                                                                    } else {
                                                                        $(".bankPaymentDiv").find(".recurValue").val('');
                                                                        $(".creditCardDiv").find(".recurValue").val('');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        function printDiv(divName) {
                                                            var printContents = document.getElementById(divName).innerHTML;
                                                            var originalContents = document.body.innerHTML;

                                                            document.body.innerHTML = printContents;

                                                            window.print();

                                                            document.body.innerHTML = originalContents;
                                                        }
                                                        function setPaymentId(element) {
                                                            var option = $('option:selected', element).attr('id');
                                                            $("#paymentMethodId").val(option);
                                                        }
                                                        function setPaymentIdBank(element) {
                                                            var optionBank = $('option:selected', element).attr('id');
                                                            $("#paymentMethodIdBank").val(optionBank);
                                                        }

    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
                                                        //Test UI JS
                                                        $(function () {
                                                            var paymentMethodIdBank = $("#paymentMethodIdBank").val();
                                                            var bType = $("#bType").val();
                                                            var paymentMethodId = $("#paymentMethodId").val();

                                                            if (paymentMethodIdBank != "") {
//                                                                $(".paymentOptionUI").addClass("hidden");
                                                                $('.bankPaymentDiv').removeClass("hidden");
                                                                $('.creditCardDiv').addClass("hidden");
                                                            }

                                                            if (paymentMethodId != "") {
//                                                                $(".paymentOptionUI").addClass("hidden");
                                                                $('.bankPaymentDiv').addClass("hidden");
                                                                $('.creditCardDiv').removeClass("hidden");
                                                            }

                                                            if (bType == 2) {
                                                                $(".paymentOptionUI").addClass("hidden");
                                                                $('.creditCardDiv').addClass("hidden");
                                                                $('.bankPaymentDiv').removeClass("hidden");
                                                                $("#newBankDetails").addClass('hidden');
                                                                $("#existingBankDetails").removeClass('hidden');
                                                            }

                                                            var stripe_customer_id = $("#stripe_customer_id").val();

//                                                            if ((stripe_customer_id == null || stripe_customer_id == "" || stripe_customer_id == undefined)) {
                                                            $(".paymentOptionUI").removeClass("hidden");

                                                            //card payment
                                                            cardPayment();

                                                            // bank payment
                                                            var stripe = Stripe('<?php echo env('STRIPE_KEY') ?>');
                                                            var form2 = document.getElementById('payment-formbank');

                                                            // Submit the form with the token ID.
                                                            form2.addEventListener('submit', function (event2) {
                                                                // if(!$("#buttonDisableBank").hasClass("disabled")){
                                                                //     return false;
                                                                // }
                                                                event2.preventDefault();
                                                                var bankAccountData = {
                                                                    country: 'us',
                                                                    currency: 'usd',
                                                                    routing_number: document.getElementById('routing-number').value,
                                                                    account_number: document.getElementById('account-number').value,
                                                                    account_holder_name: document.getElementById('name').value,
                                                                    account_holder_type: document.getElementById('type').value,
                                                                };
                                                                stripe.createToken('bank_account', bankAccountData).then(setOutcome);
                                                            });
//                                                            }


                                                        });

                                                        function cardPayment() {
                                                            var stripe = Stripe('<?php echo env('STRIPE_KEY') ?>');
                                                            //var stripe = Stripe('pk_live_4cNqjLaVcWD1P5twip4YHU0C00jAubT2Gb');
                                                            // Create an instance of Elements.
                                                            var elements = stripe.elements();
                                                            var style = {
                                                                base: {
                                                                    color: '#32325d',
                                                                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                                                    fontSmoothing: 'antialiased',
                                                                    fontSize: '16px',
                                                                    '::placeholder': {
                                                                        color: '#aab7c4'
                                                                    }
                                                                },
                                                                invalid: {
                                                                    color: '#fa755a',
                                                                    iconColor: '#fa755a'
                                                                }
                                                            };
                                                            // card payment
                                                            var form1 = document.getElementById('payment-form');
                                                            // Create an instance of the card Element.
                                                            var card = elements.create('card', {style: style});
                                                            // Add an instance of the card Element into the `card-element` <div>.
                                                            card.mount('#card-element');
                                                            // Handle real-time validation errors from the card Element.
                                                            card.addEventListener('change', function (event) {
                                                                var displayError = document.getElementById('card-errors');
                                                                if (event.error) {
                                                                    displayError.textContent = event.error.message;
                                                                } else {
                                                                    displayError.textContent = '';
                                                                }
                                                            });
                                                            // Handle form submission.

                                                            var ownerInfo = {
                                                                owner: {
                                                                    name: document.getElementById('name_on_card').value,
                                                                    email: document.getElementById('email').value
                                                                },
                                                            };

                                                            form1.addEventListener('submit', function (event) {
                                                                if ($("#ccType").val() == "1") {
                                                                    event.preventDefault();
                                                                    stripe.createSource(card, ownerInfo).then(function (result) {

                                                                        if (result.error) {
                                                                            // Inform the user if there was an error.
                                                                            var errorElement = document.getElementById('card-errors');
                                                                            errorElement.textContent = result.error.message;
                                                                            $("#buttonDisableCard").attr("disabled", false);
                                                                        } else {
                                                                            // Send the token to your server.
                                                                            //stripeTokenHandler(result.token);
                                                                            stripeSourceHandler(result.source);
                                                                        }
                                                                    });
                                                                } else {
                                                                    if($(".showHideTooltip").hasClass("hidden")){
                                                                        $("#buttonDisableCard").attr("disabled", true);
                                                                    }
                                                                    else{
                                                                        $("#buttonDisableCard").attr("disabled", false);
                                                                    }
                                                                    // $("#buttonDisableCard").attr("disabled", true);
                                                                }
                                                            });
                                                        }

                                                        function disableNewCardPayment() {
                                                            // card payment
                                                            var form1 = document.getElementById('payment-form');
                                                            form1.removeEventListener('submit', function (event) {

                                                            });
                                                        }

//                                                        function stripeTokenHandler(token) {
//                                                            // Insert the token ID into the form so it gets submitted to the server
//                                                            var form = document.getElementById('payment-form');
//                                                            var hiddenInput = document.createElement('input');
//                                                            hiddenInput.setAttribute('type', 'hidden');
//                                                            hiddenInput.setAttribute('name', 'stripeToken');
//                                                            hiddenInput.setAttribute('value', token.id);
//                                                            form.appendChild(hiddenInput);
//                                                            alert(token.id);
//                                                            // Submit the form
//                                                            form.submit();
//                                                        }
                                                        function stripeSourceHandler(source) {
                                                            // Insert the source ID into the form so it gets submitted to the server
                                                            var form = document.getElementById('payment-form');
                                                            var hiddenInput = document.createElement('input');
                                                            hiddenInput.setAttribute('type', 'hidden');
                                                            hiddenInput.setAttribute('name', 'stripeSource');
                                                            hiddenInput.setAttribute('value', source.id);
                                                            form.appendChild(hiddenInput);

                                                            // Submit the form
                                                            form.submit();
                                                            $("#buttonDisableCard").attr("disabled", true);
                                                        }
                                                        function setOutcome(result) {
//                                                                    var successElement = document.querySelector('.success');
//                                                                    var errorElement = document.querySelector('.error');
//                                                                    successElement.classList.remove('visible');
//                                                                    errorElement.classList.remove('visible');
                                                            // console.log(result.token.id);
                                                            if (result.token.id) {
                                                                // Use the token to create a charge or a customer
                                                                // https://stripe.com/docs/charges
//                                                                        successElement.querySelector('.token').textContent = result.token.id;
//                                                                        successElement.classList.add('visible');

                                                                var form3 = document.getElementById('payment-formbank');
                                                                var hiddenInput = document.createElement('input');
                                                                hiddenInput.setAttribute('type', 'hidden');
                                                                hiddenInput.setAttribute('name', 'stripeToken');
                                                                hiddenInput.setAttribute('value', result.token.id);
                                                                form3.appendChild(hiddenInput);
                                                                // Submit the form
                                                                form3.submit();
                                                                $("#buttonDisableBank").attr("disabled", true);
                                                            } else if (result.error) {
                                                                $("#buttonDisableBank").attr("disabled", false);
//                                                                        errorElement.textContent = result.error.message;
//                                                                        errorElement.classList.add('visible');
                                                            }
                                                        }
                                                        function changePaymentProcess(element) {
                                                            if ($(element).is(":checked"))
                                                            {
                                                                // it is checked
                                                                var paymentMethod = $(element).attr('data-payment');
                                                                if (paymentMethod == 'credit-card') {
                                                                    $('.creditCardDiv').removeClass("hidden");
                                                                    $('.bankPaymentDiv').addClass("hidden");
                                                                    $('.creditCardDiv').find('form').addClass("form-active");
                                                                    $('.bankPaymentDiv').find('form').removeClass("form-active");
                                                                    cardPayment();
                                                                } else {
                                                                    $('.creditCardDiv').addClass("hidden");
                                                                    $('.bankPaymentDiv').removeClass("hidden");
                                                                    $('.creditCardDiv').find('form').removeClass("form-active");
                                                                    $('.bankPaymentDiv').find('form').addClass("form-active");
                                                                }
//                                                                checkprocess();
                                                            }
                                                        }

                                                        function showHideNewCard(element) {
                                                            var isShowNew = $(element).attr('data-shownew');
                                                            if (isShowNew == "1") {
                                                                $("#newCreditCard").removeClass('hidden');
                                                                $("#existingCreditCard").addClass('hidden');
                                                                $(".paymentOptionUI").removeClass('hidden');
                                                                $("#ccType").val("1");
                                                                cardPayment();
                                                            } else {
                                                                $("#newCreditCard").addClass('hidden');
                                                                $("#existingCreditCard").removeClass('hidden');
                                                                $(".paymentOptionUI").addClass('hidden');
                                                                $("#ccType").val("2");
                                                                disableNewCardPayment();
                                                            }
                                                        }

                                                        function deleteBankAccount(element) {
                                                            var confirmDeleteBankAccount = confirm("Are you sure you want to delete bank account & use new payment method?");
                                                            if (!confirmDeleteBankAccount)
                                                                return;
                                                            var CSRF_TOKEN = $('input[name="_token"]').val();
                                                            var paymentMethodIdBank = $('#paymentMethodIdBank').val();
                                                            var stripe_customer_id = $('#stripe_customer_id').val();
                                                            var invoice_id_verify = $('#invoice_id_verify').val();
                                                            $.ajax({
                                                                url: 'deleteBankAccount',
                                                                type: 'post',
                                                                data: {_token: CSRF_TOKEN, paymentMethodIdBank: paymentMethodIdBank, stripe_customer_id: stripe_customer_id, invoice_id_verify: invoice_id_verify},
                                                                success: function (response) {
                                                                    $("#newBankDetails").removeClass('hidden');
                                                                    $("#existingBankDetails").addClass('hidden');
                                                                    $(".paymentOptionUI").removeClass("hidden");
                                                                    $("#primary2").prop('checked', true);
                                                                }
                                                            });
                                                        }

//                                                            function getBaseURL() {
//                                                                var urlString = window.location.host;
//                                                                var httpString = "http://";
//                                                                var domainString = "";
//                                                                if ((urlString.toLowerCase()).indexOf('127.0.0.1') !== -1 || (urlString.toLowerCase()).indexOf('dev') !== -1) {
//                                                                    if ((urlString.toLowerCase()).indexOf('dev') !== -1) {
//                                                                        domainString = "/TalevationPayment/public";
//                                                                        httpString = "https://";
//                                                                    }
//                                                                } else {
//                                                                    domainString = "/TalevationPayment/public";
//                                                                }
//                                                                var fullBaseURL = httpString + urlString + domainString;
//
//                                                                return fullBaseURL;
//                                                            }

                                                        function getBaseURL() {
                                                            var urlString = window.location.host;
                                                            var httpString = "http://";
                                                            var domainString = "";
                                                            if ((urlString.toLowerCase()).indexOf('talevation.com') !== -1) {
                                                                domainString = "/payments/public";
                                                                httpString = "https://";
                                                            } else {
                                                                domainString = "/TalevationPayment/public";
                                                            }
                                                            var fullBaseURL = httpString + urlString + domainString;

                                                            return fullBaseURL;
                                                        }

                                                        function achVerification(element) {
                                                            var CSRF_TOKEN = $('input[name="_token"]').val();
                                                            var amount1 = $("#amount1").val();
                                                            var amount2 = $("#amount2").val();
                                                            var stripe_customer_id_verify = $("#stripe_customer_id_verify").val();
                                                            var stripe_source_id_verify = $("#stripe_source_id_verify").val();
                                                            var invoiceId = $("#invoiceId").val();
                                                            var price = $("#price").val();
                                                            $.ajax({
                                                                url: 'achVerification',
                                                                type: 'post',
                                                                data: {_token: CSRF_TOKEN, amount1: amount1, amount2: amount2, stripe_customer_id_verify: stripe_customer_id_verify, stripe_source_id_verify: stripe_source_id_verify, invoiceId: invoiceId, price: price},
                                                                success: function (response) {
//                                                                        console.log(response);
                                                                    if (response == "error") {
                                                                        $('#amountVerify').removeClass('hidden');
                                                                    } else {
//                                                                            alert(response);
                                                                        $("#verification").attr("disabled", true);
                                                                        var base_url = getBaseURL();
                                                                        var data = response.split('~');
                                                                        window.location.href = base_url + "/invoiceReceipt/" + data[0] + "/" + data[1] + "/" + data[2];
                                                                    }

//                                                       
                                                                }
                                                            });
                                                        }

//        function checkTermsCheckbox(){
//            if ($("#termsCheckCard").is(':checked')) {
//                // $("#buttonDisableCard").attr("disabled",false);
//                $(".showHideTooltip").addClass("hidden");
//            }
//            else{
//                 $(".showHideTooltip").removeClass("hidden");
//                return false;
//            }
//        }
            
//        function checkTermsCheckboxBank(){
//            if($("#termsCheckBank").is(':checked')) {
//                $("#buttonDisableBank").attr("disabled",true);
//                $("#buttonDisableBank").addClass("disabled");
//                $(".showHideTooltipBank").addClass("hidden");
//            }
//            else{
//                $("#buttonDisableBank").attr("disabled",false);
//                $("#buttonDisableBank").removeClass("disabled");
//                $(".showHideTooltipBank").removeClass("hidden");
//                return false;
//            }
//        }
        function checkTerms(element){
            if($(element).is(':checked')){
                if($(element).hasClass("checkBank")){
                    // $(element).parent().find('#buttonDisableBank').removeAttr('disabled');
                    $('#buttonDisableBank').removeAttr('disabled');
                    $(".tooltipSaveBank").parent().addClass("hidden");
                }
                else{
                    // $(element).parent().find('#buttonDisableCard').removeAttr('disabled');
                    $('#buttonDisableCard').removeAttr('disabled');
                    $(".tooltiptext").parent().addClass("hidden");
                }
            }
            else{
                
                if($(element).hasClass("checkBank")){
                    // $(element).parent().find('#buttonDisableBank').attr('disabled', 'disabled');
                    $('#buttonDisableBank').attr('disabled', 'disabled');
                    $(".tooltipSaveBank").parent().removeClass("hidden");
                }
                else{
                    // $(element).parent().find('#buttonDisableCard').attr('disabled', 'disabled');
                    $('#buttonDisableCard').attr('disabled', 'disabled');
                    $(".tooltiptext").parent().removeClass("hidden");
                }
            }

        }
    </script>


</body>
</html>