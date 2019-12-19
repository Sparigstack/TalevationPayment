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
        </style>

        <!--Font awesome css-->
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    </head>
    <!--<script type="text/javascript" src="https://js.stripe.com/v2/"></script>-->

    <body>

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
//                                echo $stripePaymentId . " " . $invoiceData->status . " " . $currentPath;
//                                if ($stripePaymentId == "Blank") {
                                ?>
                                <div class="card" id="generateInvoice">
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
                                                                <th>isTaxable</th>
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
                                                        <b>Memo:</b></br>{{$memo}}
                                                    <?php } ?>

<!--                                                    <p class="lead">Payment Methods:</p>
<img class="paymentIconCss" style="" src="{{asset('/payment-icons/visa-dark.png')}}" alt="Visa">
<img class="paymentIconCss" src="{{asset('/payment-icons/mastro-dark.png')}}" alt="Mastercard">
<img class="paymentIconCss" src="{{asset('/payment-icons/american-dark.png')}}" alt="American Express">
<img class="paymentIconCss" src="{{asset('/payment-icons/Mastercard-Download-PNG.png')}}" alt="Paypal">-->


                                                    <b> State Tax : </b>{{$stateTaxes->state_name}} ({{$stateTaxes->tax_rate}}% tax)
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
                                                <?php // }      ?>
                                            </div>
                                        </section><!-- /.content -->
                                    </div>
                                </div>



                                <div class="card hidden" id="stripePaymentUI">
                                    <div class="card-body">
                                        <div class="card-title">Kindly pay your Talevation Invoice!</div>
                                        <hr>

                                        <form role="form" action="{{ route('stripe.post') }}"  method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{env('STRIPE_KEY')}}" id="payment-form">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="GUID" id="GUID" value="{{$_GET['token']}}">
                                            <input type="hidden" value="{{$invoiceData->id}}" name="invoice_id">
                                            <div class="form-group">
                                                <label for="input-1">Name on Card</label>
                                                <input type="text" class="form-control" required id="name_on_card" name="name_on_card" placeholder="Enter Your Name" value="{{$invoiceData->first_name}} {{$invoiceData->last_name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="input-1">Email</label>
                                                <input type="text" class="form-control" required id="email" name="email" placeholder="Enter Your Email" value="{{$invoiceData->email}}">
                                            </div>

                                            <?php
                                            $stripe_payment_id = $invoiceData->customer->stripe_customer_id;

                                            if (isset($stripe_payment_id)) {
                                                ?>
                                                <input value="{{$invoiceData->customer->stripe_customer_id}}" id="stripe_customer_id" name="stripe_customer_id" type="hidden">
                                                <div class="form-group">
                                                    <input type="hidden" value="" name="paymentMethodId" id="paymentMethodId">
                                                    <label class="col-lg-8 col-sm-12 col-md-8 pade_none" for="input-2">Payment Source</label>
                                                    <select onclick="setPaymentId(this);" id="paymentMethod" name="paymentMethod" class="form-control col-lg-4 col-sm-12 custom-select"  style="text-transform: lowercase;">
                                                        @for($i=0;$i<count($PaymentMethod['data']);$i++)
                                                            <option id="{{$PaymentMethod['data'][$i]->id}}">{{$PaymentMethod['data'][$i]['card']->brand}} ending with {{ $PaymentMethod['data'][$i]['card']->last4}}</option>
                                                            @endfor
                                                    </select>
                                                </div>
                                            <?php } else { ?>


                                                <div class="">
                                                    <label for="card-element">
                                                        Credit or debit card
                                                    </label>
                                                    <div id="card-element">
                                                        <!-- A Stripe Element will be inserted here. -->
                                                    </div>

                                                    <!-- Used to display form errors. -->
                                                    <div id="card-errors" role="alert"></div>
                                                </div>





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
                                                <div class="col-md-8">
                                                    <!--<a href="javascript:void(0);"><img style="width: 50%;float: left;" src="{{url('images/CC.png')}}" alt="payment icon"></a>-->

                                                    <div class="col-md-4 pull-left" style="">
                                                        <a href="javascript:void(0);"><img src="https://coworker.imgix.net/template/img/img_payment_secure_ssl.png" alt="ssl icon">SSL <span>secure</span></a>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <?php if (isset($stripe_payment_id)) { ?>
                                                        <button type="submit" class="btn btn-info mr-1 px-5 pull-right">Pay</button>
                                                    <?php } else { ?>
                                                        <button type="submit" class="btn btn-info mr-1 px-5 pull-right"><i class="icon-lock"></i> Pay Now</button>
                                                    <?php } ?>
                                                    <a class="pull-right m-2 mr-3" href="javascript:void(0);" onclick="return invoicePayment(this, 'back');"><i class="icon-lock"></i> Back</a>

                                                </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                            <?php // }         ?>




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
        <script src="{{asset('/js/bootstrap.min.js')}}"></script>
        <script src="https://kit.fontawesome.com/5eb42b8eec.js"></script>
        <script type="text/javascript">
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
//                                                            var stripe_customer_id = $("#stripe_customer_id").val();
//                                                            if (stripe_customer_id == null || stripe_customer_id == "" || stripe_customer_id == undefined) {

//                                                                var $form = $(".require-validation");
//                                                                $('form.require-validation').bind('submit', function (e) {
//                                                                    var $form = $(".require-validation"),
//                                                                            inputSelector = ['input[type=email]', 'input[type=password]',
//                                                                                'input[type=text]', 'input[type=file]',
//                                                                                'textarea'].join(', '),
//                                                                            $inputs = $form.find('.required').find(inputSelector),
//                                                                            $errorMessage = $form.find('div.error'),
//                                                                            valid = true;
//                                                                    $errorMessage.addClass('hidden');
//
//                                                                    $('.has-error').removeClass('has-error');
//                                                                    $inputs.each(function (i, el) {
//                                                                        var $input = $(el);
//                                                                        if ($input.val() === '') {
//                                                                            $input.parent().addClass('has-error');
//                                                                            $errorMessage.removeClass('hidden');
//                                                                            e.preventDefault();
//                                                                        }
//                                                                    });
//
//                                                                    if (!$form.data('cc-on-file')) {
//
//                                                                        e.preventDefault();
//                                                                        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
//                                                                        Stripe.createToken({
//                                                                            number: $('.card-number').val(),
//                                                                            cvc: $('.card-cvc').val(),
//                                                                            exp_month: $('.card-expiry-month').val(),
//                                                                            exp_year: $('.card-expiry-year').val()
//                                                                        }, stripeResponseHandler);
//                                                                    }
//
//                                                                });

//                                                                function stripeResponseHandler(status, response) {
//                                                                    if (response.error) {
//                                                                        $('.error')
//                                                                                .removeClass('hidden')
//                                                                                .find('.alert')
//                                                                                .text(response.error.message);
//                                                                    } else {
//                                                                        // token contains id, last4, and card type
//                                                                        var token = response['id'];
//                                                                        // insert the token into the form so it gets submitted to the server
//                                                                        $form.find('input[type=text]').empty();
//                                                                        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
//                                                                        $form.get(0).submit();
//                                                                    }
//                                                                }
//                                                            }

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

        </script>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
                                                        //Test UI JS
                                                        $(function () {
                                                            var stripe_customer_id = $("#stripe_customer_id").val();
                                                            if (stripe_customer_id == null || stripe_customer_id == "" || stripe_customer_id == undefined) {

                                                                var stripe = Stripe('pk_test_r8hQgZhHiSDMnMFn9Apy5aAk');
//var stripe = Stripe('pk_live_4cNqjLaVcWD1P5twip4YHU0C00jAubT2Gb');
// Create an instance of Elements.
                                                                var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
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
                                                                var form = document.getElementById('payment-form');
                                                                form.addEventListener('submit', function (event) {
                                                                    event.preventDefault();

                                                                    stripe.createToken(card).then(function (result) {
                                                                        if (result.error) {
                                                                            // Inform the user if there was an error.
                                                                            var errorElement = document.getElementById('card-errors');
                                                                            errorElement.textContent = result.error.message;
                                                                        } else {
                                                                            // Send the token to your server.
                                                                            stripeTokenHandler(result.token);
                                                                        }
                                                                    });
                                                                });

// Submit the form with the token ID.
                                                                function stripeTokenHandler(token) {
                                                                    // Insert the token ID into the form so it gets submitted to the server
                                                                    var form = document.getElementById('payment-form');
                                                                    var hiddenInput = document.createElement('input');
                                                                    hiddenInput.setAttribute('type', 'hidden');
                                                                    hiddenInput.setAttribute('name', 'stripeToken');
                                                                    hiddenInput.setAttribute('value', token.id);
                                                                    form.appendChild(hiddenInput);

                                                                    // Submit the form
                                                                    form.submit();
                                                                }

                                                            }
                                                        });
        </script>


    </body>
</html>




