@extends('Masters.index')
@section('contentSection')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-uppercase">Add Invoice</div>
                    <div class="card-body">
                        <button class="hidden btn m-1 pull-right" id="AddNewCustomer" data-toggle="modal" data-target="#addCustomer"><i class="fa fa-plus"></i>Add New</button>
                        <form method="post" action="InsertInvoice">
                            <input autocomplete="false" name="hidden" type="text" style="display:none;">
                            <input type="hidden" name="customerDb_id" value="" id="customerDb_id">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="row">
                                    <div class="column col-6">
                                        <div class="hidden" id="searchDivSection"></div>
                                        <label for="input-4">Customers</label>
                                        <input class="form-control" required type="text" id="customer" autocomplete="off" name="customer" placeholder="customer">

                                    </div>

                                </div>
                            </div>



                            <div class="form-group">

                                <div class="row">
                                    <div class="column col-4">
                                        <label for="input-4">First Name</label>
                                        <input required type="text" value="" class="form-control" name="firstname" id="firstname" placeholder="First Name" maxlength="200">
                                    </div>
                                    <div class="column col-4">
                                        <label for="input-4">Last Name</label>
                                        <input required type="text"  value="" class="form-control" name="lastname" id="lastname" placeholder="Last Name" maxlength="200">
                                    </div>

                                    <div class="column col-4">
                                        <div class="hidden" id="test"></div>
                                        <label for="input-4">Contact Person Email</label>
                                        <input class="form-control" required onkeyup="return emailAddress(this);"  type="text" id="Email" name="Email" placeholder="email">

                                    </div>

                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="column col-6">
                                        <label for="input-4">Address1</label>
                                        <input maxlength="400" required type="text" value="" class="form-control" id="add1" name="add1" placeholder="Enter Address1">
                                    </div>
                                    <div class="column col-6">
                                        <label for="input-5">Address2</label>
                                        <input maxlength="400" required type="text" class="form-control" value="" id="add2" name="add2" placeholder="Enter Address2">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="column col-4">
                                        <label for="input-4">State</label>
                                        <input maxlength="100" required type="text" value="" class="form-control" id="state" name="state" placeholder="Enter your State">
                                    </div>
                                    <div class="column col-4">
                                        <label for="input-5">City</label>
                                        <input maxlength="100" required type="text" class="form-control" value="" id="city" name="city" placeholder="Enter your City">
                                    </div>
                                    <div class="column col-4">
                                        <label for="input-5">Zipcode</label>
                                        <input maxlength="50" required type="text" class="form-control" value="" id="zip" name="zip" placeholder="Enter Zipcode">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="column col-6">
                                        <label for="input-4">Terms</label>
                                        <select required class="form-control" name="terms">
                                            @foreach($termsList as $term)
                                            <option id="{{$term->id}}">{{$term->discription}}</option>
                                            @endforeach
                                        </select>
                                        <!--<input maxlength="100" required type="text" value="" class="form-control" id="terms" name="terms" placeholder="Enter Terms">-->
                                    </div>
                                    <div class="column col-6">
                                        <label for="input-5">Memo</label>
                                        <input required  type="text" class="form-control" value="" id="memo" name="memo" placeholder="Memo">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="row">
                                    
                                    <div class="column col-6">
                                        <label>Invoice Date</label>
                                        <input required type="text" name="invoice_created_date" placeholder="Invoice Date" id="default-datepicker2" class="form-control">
                                    </div>
                                    <div class=" column col-6">
                                        <label>Due Date</label>
                                        <input required type="text" name="due_date" placeholder="Due Date" id="default-datepicker1" class="form-control">
                                    </div>


                                </div>

                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="column col-6">
                                        <label for="input-4">GUID</label>
                                        <input required type="text"  value="{{uniqid()}}" class="form-control" name="GUID" id="GUID" placeholder="GUID" maxlength="100">
                                    </div>
                                    <div class="column col-6">
                                        <label>Status</label>
                                        <input required  type="text" value="0" id="status" placeholder="status" name="status" class="form-control">
                                    </div>


                                </div>

                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-info waves-effect waves-light m-1 pull-right" name="submit"  value="Save and Continue"/>

                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->



    </div><!--End container-fluid-->
</div><!--End content-wrapper-->
@endsection


@section('scriptPageWiseSection')
<script src="{{asset('/js/invoice.js')}}"></script>
<!--<script src="{{asset('/js/customer.js')}}"></script>-->


<!--Bootstrap Datepicker Js-->
<script src="{{asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script>
                                        $('#default-datepicker1').datepicker({
                                            todayHighlight: true
                                            
                                        });
                                        $('#default-datepicker2').datepicker({
                                            todayHighlight: true
                                             
                                        });


</script>



@endsection

@section('cssPageWiseSection')
<!--Bootstrap Datepicker-->
<link href="{{asset('/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">

<!--Inputtags Js-->
<script src="{{asset('/plugins/inputtags/js/bootstrap-tagsinput.js')}}"></script>

@endsection

