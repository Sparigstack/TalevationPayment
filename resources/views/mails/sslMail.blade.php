<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
        <title>SSL Integration Form</title>
    </head>
    <body>
        <div class="order_form">
            <h4 align="center"> Reseller Order Details </h4>
            <table class="table table-bordered" width='55%' align="center" style="border: 1px solid #dee2e6;">
                <tbody>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">Reseller: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="reseller" name="reseller">Talevation</label> </td>
                    </tr>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">Date: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="order_date" name="order_date">{{$mail_content->order_date}}</label> </td>
                    </tr>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">Company Name: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="com_name" name="com_name">{{$mail_content->com_name}}</label> </td>
                    </tr>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">Address: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="add" name="add">{{$mail_content->add}}</label> </td>
                    </tr>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">Country/Time Zone: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="country" name="country">{{$mail_content->country}}</label> </td>
                    </tr>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">Contact Name: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="contact" name="contact">{{$mail_content->contact}}</label> </td>
                    </tr>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">Email: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="email_add" name="email_add">{{$mail_content->email_add}}</label> </td>
                    </tr>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">Telephone: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="mob_no" name="mob_no">{{$mail_content->mob_no}}</label> </td>
                    </tr>
                    <tr style="">
                        <td style="text-align: right;" width='30%'> <label for="input-1">New/Existing: </label> </td>
                        <td style="padding-left: 10px;" width='70%'> <label for="exist" name="exist">{{$mail_content->exist}}</label> </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="platform_info mt-4">
            <h4 align="center">Platform Info </h4>
            <table class="table-bordered" width='55%' style="border: 1px solid #dee2e6;" align="center">
                <tbody>
                    <tr>
                        <!--<td align="center" width="30%"> <label for="input-1">  </label> </td>-->
                        <td align='center' style="font-weight:bold;" width="30%"> <label for="input-1"> Platform </label> </td>
                        <!--<td> <label for="input-1"> Included </label> </td>-->
                        <!--<td> </td>-->
                        <td align='center' style="font-weight:bold;" width="45%"> Details  </td>
                        <td align='center' style="font-weight:bold;" width="32%"> Amount($) </td>
                    </tr>                    
                <div class="">
                    <?php echo $mail_content->platform_details; ?>
                </div>
<!--            <tr class="parent">
                        <td> <label for="input-1"><?php // echo $test[$i]['0']->label;   ?></label> </td>
                        <td> <label for="platform_details" name="platform_details"> <?php //echo $test[$i]['platform_data'];   ?> </label> </td>
                        <td> <label for="amount" name="amount"> <?php //echo $test[$i]['amount'];   ?> </label> </td>
                    </tr>-->
                <?php // }      ?>


<!--                    <tr class="parent">
    <td> <label for="input-1">Demo Platform</label> </td>
    <td> <label for="platform_details" name="platform_details"> {{$mail_content->platform_details}} </label> </td>
    <td> <label for="amount" name="amount"> {{$mail_content->amount}} </label> </td>
</tr>
<tr class="parent">
    <td> <label for="input-1">Applicant Tracking System Integration</label> </td>
    <td> <label for="platform_details" name="platform_details"> {{$mail_content->platform_details}} </label> </td>
    <td> <label for="amount" name="amount"> {{$mail_content->amount}} </label> </td>
</tr>
<tr class="parent">
    <td> <label for="input-1">Proctoring Options</label> </td>
    <td> <label for="platform_details" name="platform_details"> {{$mail_content->platform_details}} </label> </td>
    <td> <label for="amount" name="amount"> {{$mail_content->amount}} </label> </td>
</tr>
<tr class="parent">
    <td> <label for="input-1">Authoring Options</label> </td>
    <td> <label for="platform_details" name="platform_details"> {{$mail_content->platform_details}} </label> </td>
    <td> <label for="amount" name="amount"> {{$mail_content->amount}} </label> </td>
</tr>-->
                </tbody>
            </table>
        </div>

        <div class="product_info mt-4">
            <h4 align="center">Product Info </h4>
            <table class="table-bordered" width='55%' style="border: 1px solid #dee2e6;" align="center">
                <tbody>
                    <tr>
                        <!--<td align="center" width="8%"> <label for="input-1">  </label> </td>-->
<!--                        <td> <label for="input-1"> Included </label> </td>-->
                        <td align='center' style="font-weight:bold;" width='30%'> <label for="input-1"> Product </label> </td>
                        <td align='center' style="font-weight:bold;" width='20%'> Site License # </td>
                        <td align='center' style="font-weight:bold;" width='26%'> Block Size </td>
                        <td align='center' style="font-weight:bold;" width='30%'> Amount($) </td>
                    </tr>
                    <?php echo $mail_content->product_details; ?>
                    <!--                    <tr class="parent">
                                            <td> <label for="input-1">Skills Block</label> </td>
                                            <td> <label for="product_site" name="product_site"> {{$mail_content->product_site}} </label> </td>
                                            <td> <label for="block_size" name="block_size"> {{$mail_content->block_size}} </label> </td>
                                            <td> <label for="pro_amount" name="pro_amount"> {{$mail_content->pro_amount}} </label> </td>
                                            <td> <input type="text" class="form-control hidden product_site" name="product_site"> </td>
                                            <td> <input type="text" class="form-control hidden block_size" name="block_size"> </td>
                                            <td> <input type="text" class="form-control hidden pro_amount" name="pro_amount"> </td>
                                        </tr>-->
                    <!--                    <tr class="parent">
                                            <td> <label for="input-1">Skills & Behavioral Block</label> </td>
                                            <td> <label for="product_site" name="product_site"> {{$mail_content->product_site}} </label> </td>
                                            <td> <label for="block_size" name="block_size"> {{$mail_content->block_size}} </label> </td>
                                            <td> <label for="pro_amount" name="pro_amount"> {{$mail_content->pro_amount}} </label> </td>
                                        </tr>
                                        <tr class="parent">
                                            <td> <label for="input-1">Site License Skills</label> </td>
                                            <td> <label for="product_site" name="product_site"> {{$mail_content->product_site}} </label> </td>
                                            <td> <label for="block_size" name="block_size"> {{$mail_content->block_size}} </label> </td>
                                            <td> <label for="pro_amount" name="pro_amount"> {{$mail_content->pro_amount}} </label> </td>
                                        </tr>
                                        <tr class="parent">
                                            <td> <label for="input-1">Site License Hourly Behavioral</label> </td>
                                            <td> <label for="product_site" name="product_site"> {{$mail_content->product_site}} </label> </td>
                                            <td> <label for="block_size" name="block_size"> {{$mail_content->block_size}} </label> </td>
                                            <td> <label for="pro_amount" name="pro_amount"> {{$mail_content->pro_amount}} </label> </td>
                                        </tr>
                                        <tr class="parent">
                                            <td> <label for="input-1">Site License Managerial/Professional Behavioral</label> </td>
                                            <td> <label for="product_site" name="product_site"> {{$mail_content->product_site}} </label> </td>
                                            <td> <label for="block_size" name="block_size"> {{$mail_content->block_size}} </label> </td>
                                            <td> <label for="pro_amount" name="pro_amount"> {{$mail_content->pro_amount}} </label> </td>
                                        </tr>
                                        <tr class="parent">
                                            <td> <label for="input-1">Cybersecurity</label> </td>
                                            <td> <label for="product_site" name="product_site"> {{$mail_content->product_site}} </label> </td>
                                            <td> <label for="block_size" name="block_size"> {{$mail_content->block_size}} </label> </td>
                                            <td> <label for="pro_amount" name="pro_amount"> {{$mail_content->pro_amount}} </label> </td>
                                        </tr>
                                        <tr class="parent">
                                            <td> <label for="input-1">Executive/Leadership Behavioral Only</label> </td>
                                            <td> <label for="product_site" name="product_site"> {{$mail_content->product_site}} </label> </td>
                                            <td> <label for="block_size" name="block_size"> {{$mail_content->block_size}} </label> </td>
                                            <td> <label for="pro_amount" name="pro_amount"> {{$mail_content->pro_amount}} </label> </td>
                                        </tr>-->
                </tbody>
            </table>
        </div>
    </body>
</html>
