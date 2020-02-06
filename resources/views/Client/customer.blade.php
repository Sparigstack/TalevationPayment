@extends('Masters.index')
@section('contentSection')
<?php
//echo env('QB_API_URL');
//echo env('A2_BASE_URL');
?>
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div><i class="fa fa-table"></i> List Of Customers
                            <button onclick="return refreshModal();" class="btn m-1 pull-right" data-toggle="modal" data-target="#addCustomer"><i class="fa fa-plus"></i>Add New</button>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Location</th>
                                        <th>No. Of Invoices</th>
                                        <th>Create Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                    <tr class="parent">
                                <input type="hidden" class="hidden fname_customer" value="{{$customer->first_name}}">
                                <input type="hidden" class="hidden lname_customer" value="{{$customer->last_name}}">
                                <input type="hidden" class="hidden add1_customer" value="{{$customer->address1}}">
                                <input type="hidden" class="hidden add2_customer" value="{{$customer->address2}}">
                                <input type="hidden" class="hidden add2_customer" value="{{$customer->address2}}">
                                <input type="hidden" class="hidden add2_customer" value="{{$customer->address2}}">
                                <input type="hidden" class="hidden add2_anniversary_date" value="{{$customer->anniversary_date}}">
                                <input type="hidden" class="hidden add2_site_number" value="{{$customer->site_number}}">
                                <input type="hidden" class="hidden terms" value="{{$customer->terms}}">
                                <input type="hidden" class="hidden fromInv_customerId" value="{{$customer->id}}">


                                <td class="cName_customer">{{$customer->name}}</td>
                                <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                                <td class="email_customer">{{$customer->email}}</td>
                                <?php
                                $city_name = $customer->city_name;
                                if (!empty($city_name) && isset($city_name) && !is_null($city_name)) {
                                    $city_name = $city_name;
                                }
                                ?>



                                <?php
                                $stateName = $customer->state_name;
                                if (!empty($stateName) && isset($stateName) && !is_null($stateName)) {
                                    $stateName = $stateName;
                                }
                                ?>
                                <input type="hidden" class="hidden state_customer" value="{{$stateName}}">
                                <input type="hidden" class="hidden city_customer" value="{{$city_name}}">
                                <input type="hidden" class="hidden zipcode_customer" value="{{$customer->zipcode}}">
                                <td>{{$city_name}} {{$stateName}}</td>
                                <?php //$link = 'http://' . $_SERVER['HTTP_HOST'] . '/TalevationPayment/public/InvoiceByCustomer?id=' . $customer->GUID; ?>
                                <?php
                                $utility = new \App\Utility;
                                $link = $utility->projectBaseUrl() . '/public/InvoiceByCustomer/' . $customer->GUID;
                                ?>
                                <td class="" style="text-align: center;">
                                    <?php
                                    $count = count($customer->customer_has_invoices);
                                    if ($count == 0) {
                                        ?>
                                        {{count($customer->customer_has_invoices)}}
                                    <?php } else { ?>
                                        <a target="_blank" href="{{$link}}" class="">{{count($customer->customer_has_invoices)}}</a>
                                    <?php } ?>


                                    <!--<a target="_blank" href="{{$link}}" class="">{{count($customer->customer_has_invoices)}}</a>-->
                                </td>
                                <td><i data-toggle="modal" data-target="#addInvoice_form" onclick="return createCustomer(this);" title="Create Invoice" class="far fa-plus-square" style="cursor: pointer;font-size: 18px;margin: 0 auto;display: table;"></i></td>

                                </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Location</th>
                                        <th>No. Of Invoices</th>
                                        <th>Create Invoice</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->



    </div><!--End container-fluid-->
</div><!--End content-wrapper-->
@endsection


@section('scriptPageWiseSection')
<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script src="{{asset('/plugins/inputtags/js/bootstrap-tagsinput.js')}}"></script>

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
                                    function refreshModal() {
                                        $("#a2Email").val('');
                                        $("#CustomerDetails").addClass('hidden');
                                        $("#CustomerDetails").find('input').val('');
                                        $("#CustomerDetails").find('textarea').val('');
                                        $("#saveCustomerBtn").addClass('hidden');
                                        $(".saveCreateInvoice").addClass('hidden');
                                    }
                                    $(document).ready(function () {
                                        //Default data table
                                        $('#default-datatable').DataTable();

                                    });
</script>
@endsection

@section('cssPageWiseSection')
<!--Data Tables -->
<link href="{{asset('/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
@endsection

