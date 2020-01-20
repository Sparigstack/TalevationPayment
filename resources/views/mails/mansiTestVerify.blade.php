


<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <!--<link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet"/>-->
        <style>
            body {
                margin: 0;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-size: 1rem;
                /*                font-weight: 400;*/
                /*line-height: 1.5;*/
                color: #212529;
                text-align: left;
                background-color: #fff;
            }
            .h3, h3 {
                font-size: 1.75rem !important;
                font-weight: 500;
            }
            .container-fluid {
                width: 100% ;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
            p {
                margin-top: 0;
                margin-bottom: 1rem;
            }
            *, ::after, ::before {
                box-sizing: border-box;
            }

            .row {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                margin-right: -15px;
                margin-left: -15px;
            }
            img {
                vertical-align: middle;
                border-style: none;
            }
            .h5, h5 {
                font-size: 1.25rem !important;
            }
            h5 {
                display: block;
                font-size: 0.83em;
                margin-block-start: 1.67em;
                margin-block-end: 1.67em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
                font-weight: bold;
            }
            a {
                color: #007bff;
                text-decoration: none;
                background-color: transparent;
                -webkit-text-decoration-skip: objects;
            }

        </style>
    </head>
    <body>
        <div class="container-fluid" style="width: 70%;">
            <div class="wrapper">
                <div class="row" style="min-height: 200px;
                     margin: 0;
                     justify-content: center;
                     ">
                    <!--background-color: lightgray;-->
                    <!--                    <a style="display: flex;justify-content: center;align-items: center;height: 100px;" href="{{url('/')}}">
                                            <img src="{{asset('/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
                                            <h5 class="logo-text">GoCoWorq</h5>
                                        </a>-->
                </div>
            </div>
        </div>
        <div class="container-fluid" style="width: 50%;margin-top: -100px;min-height: 500px; background-color: white;
             display: flex; align-items: center;padding: 20px 1rem;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);flex-direction: column;">
            <h3 class="orangeFont">Welcome</h3>

            <p>Your ACH payment bank account is encrypted and saved securely with us. You need to verify your account by entering 2 micro deposits you got in your account
                statement.</p>
            <?php
            $utility = new \App\Utility;
            $Link = $utility->projectBaseUrl() . '/public' . "/previewInvoice?token=" . $mail_content->invoiceToken . "&p=verify";
//            $Link="http://localhost:8081/TalevationPayment/public/previewInvoice?token=".$mail_content->invoiceToken."p=verify";
            ?>
            <p>Please <a href="{{$Link}}">Click Here</a> To verify your account. </p>

            <div style="text-align: left;width: 100%">
<!--                <p style="margin-bottom: 0;">You will be able to login anytime after you generate password for your account and make modifications to your space or track reports for your space anytime!</p>-->
                <br>
                <br>
                <p style="margin-bottom: 0;">Cheers,</p>
                <p>Talevation Payment Team</p>
            </div>

        </div>
    </body>
</html>