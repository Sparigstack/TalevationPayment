<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
        <title>Sample Cronejob Form</title>
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
        <div class="col-lg-9 card mt-1 mb-2 pt-1" style="margin: auto;">
            <form action="{{ route('croneJob') }}" method="post" class="form-1">
            {{ csrf_field() }}
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden"  class="" value="{{url('croneJob')}}">

            <div class="order_form">
               <div class=" pt-1 h5"> Sample Form </div>
                <table class="table-bordered" width='100%' style="">
                    <tbody>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Name :</label> </td>
                            <td> <input type="text" class="form-control" required id="full_name" name="full_name" placeholder="Click or tap here to enter text." value=""> </td>
                        </tr>
                        <tr>
                            <td class='pr-3 width30'> <label for="input-1">Role :</label> </td>
                            <td> <input type="text" class="form-control" required id="role" name="role" placeholder="Click or tap here to enter text." value=""> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group pt-4">
                <button type="submit" class="btn btn-info" style="float:right;">Submit</button>
            </div>
            </form>
        </div>

        <script src="{{asset('/js/jquery.min.js')}}"></script>
        <script src="{{asset('/js/bootstrap.min.js')}}"></script>
        <script src="https://kit.fontawesome.com/5eb42b8eec.js"></script>
    </body>
</html>
