<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Talevation Payments</title>
        <!--favicon-->
        <link href="{{asset('/css/animate.css')}}" rel="stylesheet" type="text/css"/>

        <!-- Bootstrap core CSS-->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
        <!-- animate CSS-->
        <!--<link href="{{asset('css/animate.css')}}" rel="stylesheet" type="text/css"/>-->
        <!-- Icons CSS-->
        <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Sidebar CSS-->
        <link href="{{asset('css/sidebar-menu.css')}}" rel="stylesheet"/>
        <!-- app Style-->
        <link href="{{asset('/css/app-style.css')}}" rel="stylesheet"/>
        <!--Data Tables -->
        <link href="{{asset('/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
        <!--Bootstrap Datepicker-->
        <link href="{{asset('/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">

        <!--Font awesome css-->
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        @yield('cssPageWiseSection')

    </head>


    <body>

        <!-- start loader -->
        <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>
        <!-- end loader -->


        <div id="wrapper" class="toggled">



            <!--Start topbar header-->
            <header class="topbar-nav">

                <nav class="navbar navbar-expand fixed-top">
                    <ul class="navbar-nav mr-auto align-items-center">
                        <li class="nav-item">
                            <a href=<?php $_SERVER['HTTP_HOST'] ?>"/TalevationPayment/public/invoice">
                                <img src="{{url('logo/TalevationLogo.png')}}" class="logo-icon" alt="logo icon">
                                <!--<h5 class="logo-text"></h5>-->
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-center right-nav-link">
                        <!--                        <li class="nav-item">
                                                    <a class="font15 nav-link" href="{{url('addInvoice')}}">
                                                        Add Invoice
                                                    </a>
                                                </li>-->
                        <li class="nav-item">
                            <a class="font15 nav-link" href="{{url('invoice')}}">
                                Invoices
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="font15 nav-link" href="{{url('customer')}}">
                                Customers
                            </a>
                        </li>



                    </ul>

                    <ul class="navbar-nav align-items-center right-nav-link">


                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                                <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span>
                            </a>
                            @guest
                            <ul class="dropdown-menu dropdown-menu-right">

                                <li class="dropdown-item"><i class="fas fa-sign-in-alt mr-2"></i><a data-toggle="modal" data-target="#modal-signup" class='clickFind' data-tabindex="1"> Login</a></li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item"><i class="fas fa-user mr-2"></i><a data-toggle="modal" data-target="#modal-signup" data-tabindex="2"> Sign-up</a></li>                                

                            </ul>
                            @else
                            <ul id="ulSignup" class="dropdown-menu dropdown-menu-right dd-signup">

                                <li class="dropdown-item user-details">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar"></div>
                                            <div class="media-body">
                                                <h6 class="mt-2 user-title">{{ Auth::user()->name }}</h6>
                                                <p class="user-subtitle">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item">
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                        <i class="icon-power mr-2"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>




                            </ul>
                            @endguest
                        </li>
                    </ul>

                </nav>
            </header>
            <!--End topbar header-->


            <div class="clearfix"></div>
            @yield('contentSection')

            <!--Start Modal-->
            <div class="modal fade" id="addCustomer">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="addCustomer" class="parent">
                                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                                {{ csrf_field() }}


                                <div class="form-group">
                                    <div class="row">


                                        <div class="col-md-5 col-lg-5 col-sm-12 parent">
                                            <div class="hidden" id="searchDivSection"></div>
                                            <?php $uniqid_cus = uniqid(); ?>
                                            <input type="hidden" name="cus_GUID" id="cus_GUID" value="{{$uniqid_cus}}">
                                            <input type="hidden" name="a2_accountId" value="" id="a2_accountId">

                                            <input type="hidden" name="anniversary_Date" value="" id="anniversary_Date">
                                            <input type="hidden" name="siteNumber" value="" id="siteNumber">
                                            <input type="hidden" name="a2_contactId" value="" id="a2_contactId">
                                            <input type="hidden" name="qb_customerId" value="" id="qb_customerId">
                                            <label for="input-4">Lookup AddressTwo Customer by Email</label>
                                            <input type="text" required name="a2Email" id="a2Email" class="form-control" placeholder="Enter Email" />
                                            <div id="EmailList">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-sm-12 parent"><label style="margin: 1.5rem !important;font-size: medium;" for="" class="m-3">OR</label></div>
                                        <div class="col-md-5 col-lg-5 col-sm-12">

                                            <label for="input-4"></label>
                                            <input type="button" id="btna2Customer" onclick="return showHideCustomerDetails();" class="btn btn-info btn-inverse-primary btn-primary  m-3  pb-2" value="Add New Customer"/>
                                            <!--<input class="form-control" required  type="button" id="add_customer" name="add_customer" placeholder="customer">-->

                                        </div>

                                    </div>
                                </div>

                                <div class="hidden" id="CustomerDetails">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <label for="input-4">Company Name</label>
                                                <input required class="form-control required"   type="text" id="companyName" name="companyName" placeholder="Company Name">
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <label for="input-4">Email</label>
                                                <input required type="email"  value="" class="required form-control" name="emailAddress" id="emailAddress" placeholder="Email Address" maxlength="400">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <label for="input-4">First Name</label>
                                                <input required type="text" value="" class="required form-control" name="first_name" id="first_name" placeholder="First Name" maxlength="200">
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <label for="input-4">Last Name</label>
                                                <input required type="text"  value="" class="required form-control" name="last_name" id="last_name" placeholder="Last Name" maxlength="200">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <label for="input-4">Address1</label>
                                                <input maxlength="400" required type="text" value="" class="required form-control" id="add1" name="add1" placeholder="Address1">
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <label for="input-5">Address2</label>
                                                <input maxlength="400" type="text" class="form-control" value="" id="add2" name="add2" placeholder="Address2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4 col-sm-12">
                                                <label for="input-4">State</label>
                                                <input maxlength="100" required type="text" value="" class="required form-control" id="state" name="state" placeholder="State">
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-sm-12">
                                                <label for="input-5">City</label>
                                                <input maxlength="100" required type="text" class="required form-control" value="" id="city" name="city" placeholder="City">
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-sm-12">
                                                <label for="input-5">Zipcode</label>
                                                <input maxlength="50" required type="text" class="required form-control" value="" id="zipcode" name="zipcode" placeholder="Zipcode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!--<input type="button" data-dismiss="modal" class="btn  btn-inverse-primary  m-1 pull-right pb-2" value="Close"/>-->
                                    <input type="submit" class="btn btn-primary btn-info waves-effect waves-light m-1 pull-right pb-2 hidden" name="submit" id="saveCustomerBtn"  value="Save Customer"/>
                                    <input type="button" class="btn btn-info btn-inverse-primary  m-1 pull-right pb-2 hidden saveCreateInvoice"  onclick="return saveCreateInvoice(this);"   value="Save & Create Invoice"/>

                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!--End Modal-->




            <!--Start Modal-->
            <button class="btn m-1 pull-right hidden" id="addInvoice_saveCreateInvoice" data-toggle="modal" data-target="#addInvoice_form"><i class="fa fa-plus" aria-hidden="true"></i>Add New</button>
            <!--Start Modal-->

            <div class="modal fade"  id="addInvoice_form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Invoice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body parent">

                            <button id="AddNewCustomer" class="btn m-1 pull-right hidden" data-toggle="modal" data-target="#addCustomer"><i class="fa fa-plus" aria-hidden="true"></i>Add New</button>
                            <input autocomplete="false" name="hidden" type="text" style="display:none;">
                            <input type="hidden" name="customerDb_id" id="customerDb_id">
                            <input type="hidden" id="Inv_id_fromEditIcon" name="Inv_id_fromEditIcon">
                            <input type="hidden" id="customerId_fromcreateInvoice" name="customerId_fromcreateInvoice">
                            {{ csrf_field() }}

                            <input type="hidden" name="companyName_Invoice" id="companyName_Invoice">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-lg-6">
                                        <div class="hidden" id="searchDivSection_Invoice"></div>
                                        <label id="contentToShow" class="mb-0" for="input-4">Lookup  Customer by Email</label>
                                        <i class="user-pointer fas fa-edit hidden" onclick="return editCustomer(this);" id="edit_customer" style="font-size: 20px;"></i>
                                        <!--<button class="btn btn-info hidden" onclick="return editCustomer(this);" id="edit_customer">Edit Customer</button>-->
                                        <input class="form-control col-6" required type="text" id="customer" autocomplete="off" name="customer" placeholder="customer">

                                    </div>


                                </div>
                            </div>
                            <hr>
                            <!--Start Step 1-->
                            <div class="hidden" id="InvoiceDetails">
                                <div class="form-group pt-2">

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-lg-6">
                                            <label class="mb-0" for="input-4">First Name</label>
                                            <input required type="text" value="" class="required form-control" name="inv_firstname" id="inv_firstname" placeholder="First Name" maxlength="200">
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-lg-6">
                                            <label class="mb-0" for="input-4">Last Name</label>
                                            <input required type="text"  value="" class="required form-control" name="inv_lastname" id="inv_lastname" placeholder="Last Name" maxlength="200">
                                        </div>



                                    </div>

                                </div>


                                <div class="form-group pt-2">

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-lg-6">
                                            <div class="hidden" id="test"></div>
                                            <label class="mb-0" for="input-4">CompanyName</label>
                                            <input class="required form-control" required  type="CompanyName_Invoices" id="CompanyName_Invoices" name="CompanyName_Invoices" placeholder="CompanyName" maxlength="500">

                                        </div>
                                        <div class="col-md-6 col-sm-12 col-lg-6">
                                            <div class="hidden" id="test"></div>
                                            <label class="mb-0" for="input-4">Contact Person Email</label>
                                            <input class="required form-control" required onkeyup="return emailAddress(this);"  type="email" id="Email" name="Email" placeholder="email" maxlength="500">

                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-lg-6">
                                            <label class="mb-0" for="input-4">Address1</label>
                                            <input maxlength="400" required type="text" value="" class="form-control" id="inv_add1" name="inv_add1" placeholder="Enter Address1">
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-lg-6">
                                            <label class="mb-0" for="input-5">Address2</label>
                                            <input maxlength="400"  type="text" class="form-control" value="" id="inv_add2" name="inv_add2" placeholder="Enter Address2">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-lg-4">
                                            <label class="mb-0" for="input-4">State</label>
                                            <input maxlength="100" required type="text" value="" class="form-control" id="inv_state" name="inv_state" placeholder="Enter your State">
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-lg-4">
                                            <label class="mb-0" for="input-5">City</label>
                                            <input maxlength="100" required type="text" class="form-control" value="" id="inv_city" name="inv_city" placeholder="Enter your City">
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-lg-4">
                                            <label class="mb-0" for="input-5">Zipcode</label>
                                            <input maxlength="50" required type="text" class="form-control" value="" id="inv_zip" name="inv_zip" placeholder="Enter Zipcode">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group pt-2">

                                    <div class="row">

                                        <div class="col-md-4 col-sm-12 col-lg-4">
                                            <label class="mb-0">Invoice Date</label>
                                            <?php $todayDate1 = date("m/d/Y", strtotime(date('m/d/Y'))); ?>

                                            <input onchange="datesByTerms();" required type="text" name="invoice_created_date" placeholder="Invoice Date" value="{{$todayDate1}}" id="invoice-date" class="form-control">
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-lg-4">
                                            <label class="mb-0" for="input-4">Terms</label>
                                            <select required class="form-control" id="inv_terms" name="inv_terms" onchange="return datesByTerms(this);">
                                                @foreach($termsList as $term)
                                                <option id="{{$term->id}}" value="{{$term->discription}}">{{$term->discription}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-md-4 col-sm-12 col-lg-4">
                                            <label class="mb-0">Due Date</label>
                                            <?php
                                            $due_Date = date('m/d/Y');
                                            $due_Date = date('m/d/Y', strtotime($due_Date . ' + 10 days'));
                                            ?>
                                            <input type="text" value="{{$due_Date}}" name="inv_due_date" placeholder="Due Date" id="due-date" class="required form-control">
                                        </div>


                                    </div>

                                </div>


                            </div>
                            <!--End Step 1-->
                            <!--Start Step 2-->
                            <div id="InvoiceItemsDetails" class="hidden">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Invoice Items</h5>
                                        <div class="table-responsive">
                                            <?php $uniqid = uniqid(); ?>
                                            <input type="hidden" name="inv_GUID" id="inv_GUID" value="{{$uniqid}}">
                                            <input type="hidden" name="inv_siteNumber" id="inv_siteNumber">
                                            <input type="hidden" name="inv_anniversary_Date" id="inv_anniversary_Date">

                                            <meta name="csrf-token" content="{{ csrf_token() }}">
                                            <table class="table table-sm" id="invoiceItemTable">

                                                <thead>
                                                    <tr>
                                                        <th scope="col">Preset Line Items</th>
                                                        <th scope="col">Discription</th>
                                                        <th scope="col">QTY</th>
                                                        <th scope="col">Rate</th>
                                                        <th scope="col">Is Taxable?</th>
                                                        <!--<th scope="col">Tax</th>-->
                                                        <th scope="col" class="text-right">Total($)</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr class="hidden" id="hiddenTrTag">
                                                        <td>
                                                            <select onchange='setInvoiceDetails(this);' class="form-control preset_line_items">
                                                                <option></option> 
                                                            </select>
                                                        </td>
                                                        <td class=""><input onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" type="text" class="form-control descValue"></td>
                                                        <td class="w8"><input min="0" type="number" onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" class="form-control qtyValue"></td>

                                                        <td class="w10">

                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                                </div>
                                                                <input min="0" onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" type="number" class="form-control rateValue">
                                                            </div>
                                                        </td>
                                                        
<!--                                                        <td class="w10">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                                                </div>
                                                                <input min="0" onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" type="number" class="form-control taxValue"> 
                                                            </div>
                                                        </td>-->
                                                        
                                                        <td class="w8"><input type="checkbox" onkeyup="return SetTaxableValue(this);" onchange="return SetTaxableValue(this);" class="form-control isTaxable ml-4" style="max-width: 20px !important;"></td>
                                                        <td class="w7 text-right"><label  readonly="readonly"  class="totalValue">$0<label></label></label></td>
                                                        <td class="text-right" onclick="DeleteElement(this)"><i class="fas fa-trash mt-8"></i></td>

                                                    </tr>
                                                <input type="hidden" name="deleted_invoiceId" id="deleted_invoiceId">                                            
                                                <tr class="parent firstChild BlankData">
                                                    <td class="w13">
                                                        <select onchange='setInvoiceDetails(this);' class="form-control preset_line_items" id="preset_line_items" style="width: auto !important;">
                                                            <option></option> 
                                                        </select>
                                                    </td>
                                                    <td class=""><input type="text" onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" class="form-control descValue"></td>
                                                    <td class="w8"><input min="0" onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" type="number" class="form-control qtyValue"></td>
                                                    <td class="w10">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                            </div>
                                                            <input min="0" onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" type="number" class="form-control rateValue">
                                                        </div>
                                                    </td>
<!--                                                    <td class="w10">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                                            </div>
                                                            <input min="0" onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" type="number" class="form-control taxValue"> 
                                                        </div>
                                                    </td>-->
                                                    
                                                    <td class="w8"><input type="checkbox" onkeyup="return SetTaxableValue(this);"  onchange="return SetTaxableValue(this);" class="form-control isTaxable ml-4" style="max-width: 20px !important;"></td>
                                                    <td class="w7 text-right"><label readonly="readonly" class="totalValue">$0<label></td>
                                                                <td class="text-right" onclick="DeleteElement(this)"><i class="user-pointer fas fa-trash mt-8"></i></td>
                                                                </tr>

                                                                </tbody>

                                                                </table> 
                                                                <!--                                                                <div class="">  
                                                                                                                                    <button class="pull-left btn mt-4" onclick="CloneElement(this);"><i class="fas fa-plus"></i> Add New Item</button>
                                                                                                                                    <textarea  id="memo" class="form-control col-md-6 pull-left mt-3 ml-1" placeholder="memo" style="width:45%;"></textarea>
                                                                                                                                    <div class="pull-right gridTable" style="">
                                                                                                                                                                                                        <div class="totalTable">
                                                                                                                                                                                                        <p class="mt-4"> Subtotal <label readonly="readonly" class="totalTable pl-5">$1<label></label></label>  </p>
                                                                                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>-->


                                                                <div class="row">  
                                                                    <div class="col-7 pr-0">     
                                                                        <button class="pull-left btn mt-4" onclick="CloneElement(this);">
                                                                            <i class="fas fa-plus" aria-hidden="true"></i> Add New Item</button>
                                                                        <textarea id="memo" class="form-control col-md-6 pull-left mt-3 ml-1" placeholder="memo" style="/* width: 93%; */max-width: 78%;"></textarea>
                                                                    </div>

                                                                    <div class="pull-right col-5 row" style="">
                                                                        <div class="col-9 mt-3 totalTable " style="text-align: right;">Total Amount </div>
                                                                        <div class="col-3 invoiceTotalPrice totalTable totalTablesData  mt-3 totalTable">$0</div>
                                                                        <div class="col-9 mt-2 totalTable " style="text-align: right;">Total Tax </div>
                                                                        <div class="col-3 invoiceTotalTax totalTable totalTablesData  mt-2 totalTable">$0</div>
                                                                        <div class="col-9 mt-2 totalTable totalTablesData" style="text-align: right;"> Balance Due </div>
                                                                        <div class="col-3 invoiceTotalBalance totalTable totalTablesData  mt-2 totalTable">$0</div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">  
                                                                    <div class="col-9 pr-0">       </div>

                                                                    <div class="col-3 row pt-3" style="">
                                                                        <div class="col-10 " style="">
                                                                            <select class="form-control state_name" style="" name="state_taxes" id="state_taxes" onchange="return SetTaxableValue(this);">
                                                                                <option selected=""></option>
                                                                                <option></option>
                                                                            </select>   
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                </div>
                                                                </div>
                                                                </div>

                                                                </div>
                                                                <!--End Step 2-->
                                                                <?php
//                            $clickHere = "<a href='http://localhost:8080/TalevationPayment/public/payment?token=$uniqid'> Click Here </a>";
                                                                ?>
                                                                <div class="form-group">
                                                                    <input type="button" onclick="return showHideInvoiceDetails(this);" class="hidden btn btn-info saveInvoice  m-1 pull-right"   value="Next"/>
                                                                    <input type="button" onclick="return InsertInvoiceItems(this);" class="btn btn-info hidden saveInvoiceItems  m-1 pull-right"   value="Save"/>

                                                                    <a class="save_send_href" href="JavaScript:Void(0);"><input type="button" onclick="return InsertInvoiceItems(this);" class="btn btn-info hidden save_send  m-1 pull-right"   value="Save & Send"/></a>

                                                                    <input type="hidden" class="LastInsertedInvoiceId" value="LastInsertedInvoiceId">
                                                                </div>




                                                                </div>

                                                                </div>
                                                                </div>
                                                                </div>
                                                                <!--End Modal-->



                                                                <!--Start footer-->
                                                                <footer class="footer">
                                                                    <div class="container">
                                                                        <div class="text-center">
                                                                            Copyright © <?php echo date("Y"); ?> Talevation Payments
                                                                        </div>
                                                                    </div>
                                                                </footer>
                                                                <!--End footer-->

                                                                </div><!--End wrapper-->



                                                                <!-- Bootstrap core JavaScrip        t-->
                                                                <script src="{{asset('/js/jquery.min.js')}}"></script>
                                                                <script src="{{asset('/js/popper.min.js')}}"></script>
                                                                <script src="{{asset('/js/bootstrap.min.js')}}"></script>

                                                                <!-- sidebar-menu js -->
                                                                <script src="{{asset('/js/sidebar-menu.js')}}"></script>
                                                                <!-- Custom scripts -->
                                                                <script src="{{asset('/js/app-script.js')}}"></script>
                                                                <!-- Vector map JavaScript -->
                                                                <script src="{{asset('/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
                                                                <script src="{{asset('/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

                                                                <!-- Index js -->
                                                                <script src="{{asset('/js/index.js')}}"></script>
                                                                <script src="https://kit.fontawesome.com/5eb42b8eec.js"></script>



                                                                <script src="{{asset('/js/customer.js')}}"></script>
                                                                <!--Bootstrap Datepicker Js-->
                                                                <script src="{{asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
                                                                <script src="{{asset('/js/invoice.js')}}"></script>
                                                                @yield('scriptPageWiseSection')
                                                                </body>
                                                                </html>

