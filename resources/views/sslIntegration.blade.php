<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
        <title>SSL Integration Form</title>
        <style>
            .order_form td{
/*                width:40%;*/
                text-align: right;
            }
            .width30{
                width:30%;
            }
            td {
                border: 1px solid black;
                /*width:40%;*/
                /*text-align: center;*/
            }
            .hidden{
                display: none;
            }
        </style> 
    </head>

    <body style="background-color: #dee2e6;">
        <div id="successMessage" class="card col-lg-8 pl-0 pr-0 mt-4 hidden " style="margin: auto;"> 
            <div class="card-body" style="color: green;">Your SHL order was successful!<br>
Your order details have been submitted to team.sprigstack@gmail.com successfully. </div>
        </div>
       <div id='headerShl' class="col-lg-9 h5  mt-2 mb-2 text-center" style="margin: auto;">SHL Order Form</div>
        <div id="ResellerFullForm" class="col-lg-9 card mt-1 mb-2 pt-1" style="margin: auto;">
            <!--<form action="{{ route('sslIntegration') }}" method="post" class="form-1">-->
            {{ csrf_field() }}
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden"  class="sslIntegration" value="{{url('sslIntegration1')}}">

            <div class="order_form">
<!--                <input type="hidden" name="reseller">
                <input type="hidden" name="order_date">
                <input type="hidden" name="com_name">
                <input type="hidden" name="add">
                <input type="hidden" name="country">
                <input type="hidden" name="contact">
                <input type="hidden" name="email_add">
                <input type="hidden" name="mob_no">
                <input type="hidden" name="exist">
                <input type="hidden" name="">-->
               <div class=" pt-1 h5"> Reseller Order Form </div>
                <table class="table-bordered" width='100%' style="">
                    <tbody>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Reseller :</label> </td>
                            <td style="text-align: left;"> <label for="reseller" name="reseller">Talevation</label> </td>
                        </tr>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Date :</label> </td>
                            <td> <input type="date" class="form-control" required id="order_date" name="order_date" placeholder="Click or tap here to enter text." value=""> </td>
                        </tr>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Company Name :</label> </td>
                            <td> <input type="text" class="form-control" required id="com_name" name="com_name" placeholder="Click or tap here to enter text." value="{{$com_name}}"> </td>
                        </tr>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Address :</label> </td>
                            <td>
                                <textarea class="form-control" required id="add" name="add" placeholder="Click or tap here to enter text." value="">{{$address}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Country/Time Zone :</label> </td>
                            <td> <input type="text" class="form-control" required id="country" name="country" placeholder="Click or tap here to enter text." value="{{$country}}"> </td>
                        </tr>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Contact Name :</label> </td>
                            <td> <input type="text" class="form-control" required id="contact" name="contact" placeholder="Click or tap here to enter text." value="{{$contactName}}"></td>
                        </tr>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Email :</label> </td>
                            <td> <input type="email" class="form-control" required id="email_add" name="email_add" placeholder="Click or tap here to enter text." value="{{$email_add}}"> </td>
                        </tr>
                        <tr>
                            <td class="pr-3 width30"> <label for="input-1">Telephone :</label> </td>
                            <td> <input type="text" class="form-control" required id="mob_no" name="mob_no" placeholder="Click or tap here to enter text." value="{{$mob_no}}"> </td>
                        </tr>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">New/Existing :</label> </td>
                            <td> <input type="text" class="form-control" required id="exist" name="exist" placeholder="Click or tap here to enter text." value=""> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="platform_info mt-4">
                <input type="hidden" class="platform_details_value" name="platform_details_value" value="">
                <input type="hidden" class="amount_value" name="amount_value" value="">
                <div class="h6">Platform Info</div>
                <table class="table-bordered" width='100%' style="">
                    <tbody>
                        <tr>
                            <td align="center" width="8%"> <label for="input-1"> Included </label> </td>
                            <td align="center" width="37%"> Platform </td>
                            <td class="" align="center" width="30%"> <label for="input-1"> Details </label> </td>
                            <td class="" align="center" width="15%"> <label for="input-1"> Amount($) </label> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Production Platform:</label> </td>
                            <td> <input type="text" class="form-control hidden platform_details" name="platform_details"> </td>
                            <td> <input type="text" class="form-control hidden amount" name="amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Demo Platform:</label> </td>
                            <td> <input type="text" class="form-control hidden platform_details" name="platform_details"> </td>
                            <td> <input type="text" class="form-control hidden amount" name="amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Applicant Tracking System Integration:</label> </td>
                            <td> <input type="text" class="form-control hidden platform_details" name="platform_details"> </td>
                            <td> <input type="text" class="form-control hidden amount" name="amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Proctoring Options:</label> </td>
                            <td> <input type="text" class="form-control hidden platform_details" name="platform_details"> </td>
                            <td> <input type="text" class="form-control hidden amount" name="amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Authoring Options:</label> </td>
                            <td> <input type="text" class="form-control hidden platform_details" name="platform_details"> </td>
                            <td> <input type="text" class="form-control hidden amount" name="amount"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="product_info mt-4">
                <table class="table-bordered" width='100%' style="">
                    <div class="h6">Product Info</div>
                    <tbody>
                        <tr>
                            <td align="center" width="8%"> <label for="input-1"> Included </label> </td>
                            <td align="center"  width="37%"> <label for="input-1"> Product </label> </td>
                            <td align="center"  width="15%"> <label for="input-1"> Site License # </label> </td>
                            <td align="center" width="15%"> <label for="input-1"> Block Size </label> </td>
                            <td align="center" width="15%"> <label for="input-1"> Amount($) </label> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Skills Block:</label> </td>
                            <td> <input type="text" class="form-control hidden product_site" name="product_site"> </td>
                            <td> <input type="text" class="form-control hidden block_size" name="block_size"> </td>
                            <td> <input type="text" class="form-control hidden pro_amount" name="pro_amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Skills & Behavioral Block:</label> </td>
                            <td> <input type="text" class="form-control hidden product_site" name="product_site"> </td>
                            <td> <input type="text" class="form-control hidden block_size" name="block_size"> </td>
                            <td> <input type="text" class="form-control hidden pro_amount" name="pro_amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Site License Skills:</label> </td>
                            <td> <input type="text" class="form-control hidden product_site" name="product_site"> </td>
                            <td> <input type="text" class="form-control hidden block_size" name="block_size"> </td>
                            <td> <input type="text" class="form-control hidden pro_amount" name="pro_amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Site License Hourly Behavioral:</label> </td>
                            <td> <input type="text" class="form-control hidden product_site" name="product_site"> </td>
                            <td> <input type="text" class="form-control hidden block_size" name="block_size"> </td>
                            <td> <input type="text" class="form-control hidden pro_amount" name="pro_amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Site License Managerial/Professional Behavioral:</label> </td>
                            <td> <input type="text" class="form-control hidden product_site" name="product_site"> </td>
                            <td> <input type="text" class="form-control hidden block_size" name="block_size"> </td>
                            <td> <input type="text" class="form-control hidden pro_amount" name="pro_amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Cybersecurity:</label> </td>
                            <td> <input type="text" class="form-control hidden product_site" name="product_site"> </td>
                            <td> <input type="text" class="form-control hidden block_size" name="block_size"> </td>
                            <td> <input type="text" class="form-control hidden pro_amount" name="pro_amount"> </td>
                        </tr>
                        <tr class="parent">
                            <td align="center"> <input type="checkbox" class="isChecked" onclick="checkBoxChecked(this);"> </td>
                            <td align="right" class="pr-3"> <label for="input-1">Executive/Leadership Behavioral Only:</label> </td>
                            <td> <input type="text" class="form-control hidden product_site" name="product_site"> </td>
                            <td> <input type="text" class="form-control hidden block_size" name="block_size"> </td>
                            <td> <input type="text" class="form-control hidden pro_amount" name="pro_amount"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group pt-4">
                <button type="submit" class="btn btn-info" onclick ="return saveForm();" style="float:right;">Submit</button>
            </div>
            <!--</form>-->
        </div>

        <script src="{{asset('/js/jquery.min.js')}}"></script>
        <script src="{{asset('/js/bootstrap.min.js')}}"></script>
        <script src="https://kit.fontawesome.com/5eb42b8eec.js"></script>
        <!--<script src="{{asset('/js/customer.js')}}"></script>-->
        <script type="text/javascript">

                    function findParent(element) {
                        var parentElement = $(element).parent();
                        if ($(parentElement).hasClass("parent"))
                            return parentElement;
                        else {
                            for (var i = 0; i < 12; i++) {
                                parentElement = $(parentElement).parent();
                                if ($(parentElement).hasClass("parent"))
                                    return parentElement;
                            }
                        }
                    }
                    function checkBoxChecked(element) {
                        var parent = findParent(element);
//                    var platform_details = $(parent).find(".platform_details").val();
//                    var amount = $(parent).find(".amount").val();
                        $(element).each(function () {
                            if ($(element).is(":checked")) {
                                $(parent).find(".form-control").removeClass("hidden");
//                            $(".platform_details_value").val(platform_details);
//                            $(".amount_value").val(amount);
                            } else {
                                $(parent).find(".form-control").addClass("hidden");
                            }
                        });
                    }

                    function saveForm(element) {
//                        var CSRF_TOKEN = $('input[name="_token"]').val();
                        var reseller = $("#reseller").val();
                        var order_date = $("#order_date").val();
                        var com_name = $("#com_name").val();
                        var add = $("#add").val();
                        var country = $("#country").val();
                        var contact = $("#contact").val();
                        var email_add = $("#email_add").val();
                        var mob_no = $("#mob_no").val();
                        var exist = $("#exist").val();
//                    var platform_data = $(".platform_details").val();
//                    var amount = $(".amount").val();

                        var platform_details = new Array();
                        var platform_detail;
                        $(".platform_info input[type=checkbox]").each(function () {
                            platform_detail = new Object();
//                            $('input[type=checkbox]').each(function () {
                                if ($(this).is(":checked")) {
                                    platform_detail.platform_data = $(this).parent().parent().find(".platform_details").val();
                                    platform_detail.amount = $(this).parent().parent().find(".amount").val();
                                    platform_detail.label = $(this).parent().parent().find('label').text();
                                    platform_details.push(platform_detail);
//                                $(".platform_details_value").val(platform_data);
//                                $(".amount_value").val(amount);
                                }
//                            });
                        });
                       // console.log(platform_details);
                        var product_details = new Array();
                        var product_detail;
                        $(".product_info input[type=checkbox]").each(function () {
                            product_detail = new Object();
//                            $('input[type=checkbox]').each(function () {
                                if ($(this).is(":checked")) {
                                    product_detail.product_site =  $(this).parent().parent().find(".product_site").val();
                                    product_detail.block_size =  $(this).parent().parent().find(".block_size").val();
                                    product_detail.pro_amount =  $(this).parent().parent().find(".pro_amount").val();
                                    product_detail.label = $(this).parent().parent().find('label').text();
                                    product_details.push(product_detail);
                                }
//                            });
                        });
//                        console.log(product_details);
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        var sslIntegration = $(".sslIntegration").val();
                        $.ajax({
                            url: sslIntegration,
                            type: "post",
                            data: {_token: CSRF_TOKEN, reseller: reseller, order_date: order_date, com_name: com_name, add: add, country: country, contact: contact, email_add: email_add, mob_no: mob_no, exist: exist, platform_details: platform_details, product_details: product_details},
                            success: function (response) {
                                $('#headerShl').addClass('hidden');
                                $('#ResellerFullForm').addClass('hidden');
                                $('#successMessage').removeClass('hidden');
                            },
                            error: function (e) {
//                                console.log(e.error);
                            }
                        });
                    }

        </script>
    </body>
</html>
