@extends('Masters.index')
@section('contentSection')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-table"></i> List Of Invoices
                        <button  onclick="refreshModal();" class="btn m-1 pull-right" data-toggle="modal"  data-target="#addInvoice_form"><i class="fa fa-plus"></i>Add New</button>
                    </div>


                    <div class="card-body">

                        <div class="table-responsive">
                            <form method="post" action="invoice">
                                {{ csrf_field() }}
                                <?php
//                                $date = date('Y-m-d'); //your given date
//                                $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
//                                $first_date = date("m/d/Y", $first_date_find);
//
//                                $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
//                                $last_date = date("m/d/Y", $last_date_find);
                                ?>
                                <div class="row p-1">

                                    <!--        <div class="col-sm-12 col-lg-3 col-md-3">
                                                                                <label> Customer </label>
                                                                                <select class="form-control single-select" name="customer_Email" style="position: relative !important;">
                                                                                   
                                                                                </select>
                                                                            </div>-->

                                    <div class="col-sm-12 col-lg-2 col-md-2">
                                        <label>Due After</label>
                                        <input required type="text" name="start_date" placeholder="Start Date" value="{{$startDate}}" id="start_date" class="form-control">
                                    </div>
                                    <div class="col-sm-12 col-lg-2 col-md-2">
                                        <label>Due Before</label>
                                        <input required type="text" name="end_date" placeholder="End Date" value="{{$endDate}}" id="end_date" class="form-control">
                                    </div>

                                    <div class="col-sm-12 col-lg-2 col-md-2">
                                        <label>Search </label>
                                        <input type="text" class="form-control" placeholder="" value="{{$search}}" name="search" id="search">
                                    </div>

                                    <div class="col-sm-12 col-lg-4 col-md-4">
                                        <label class=""></label>
                                        <button type="submit" class="btn mt-4">Apply Filter</button>
                                    </div>
                                </div>
                            </form>
                            <!--role="grid" style="overflow-x: scroll; overflow-y: scroll; max-width: 90%; display: block; white-space: word-wrap: break-word;" cellspacing="0">-->



                            <table id="InvoiceDbList"  class="table table-bordered" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $statusString = "";
                                    $todayDate = date('m-d-Y');
                                    ?>
                                    <?php $icount = 0; //var_dump($invoiceList); return; ?>
                                    @foreach($invoiceList as $invoice)
                                    <?php
//                                    if ($icount >= 4) 
//                                        break;
                                    $icount++;
                                    $todayDate = date('m-d-Y');
                                    $body_line = " %0D%0A ";
//                                    $InvoiceLink = 'https://' . $_SERVER['HTTP_HOST'] . '/TalevationPayment/public' . "/payment?token=" . $invoice->GUID;
                                    $utility = new \App\Utility;
                                    $InvoiceLink = $utility->projectBaseUrl() . '/public' . "/payment?token=" . $invoice->GUID;
                                    $due_date = date("m-d-Y", strtotime($invoice->due_date));
                                    $invoice_date = date("m-d-Y", strtotime($invoice->invoice_date));
                                    $addBgColor = '';
                                    $iconColor = "";
                                    ?>
                                    <tr class="parent">

                                        <?php
//                                        $clickHere = "<a href='http://localhost:8080/TalevationPayment/public/payment?token=$invoice->GUID'> Click Here </a>";
                                        $clickHere = "Hello " . $invoice->first_name . " " . $invoice->last_name . $body_line . $body_line . "Please pay your pending invoice with Talevation." . $body_line . "You can pay it online with the link below." . $body_line . $InvoiceLink . $body_line . " " . $body_line . "If you are not able to click the link above, please copy and paste it in your browser." . $body_line . " " . $body_line . "Thanks," . $body_line . "Talevation";

                                        $clickHere = nl2br($clickHere);
                                        $status = $invoice->status;
                                        $Amount = 0;

                                        //for ($k = 0; $k < count($invoice->invoice_items); $k++) {

                                        foreach ($invoice->invoice_items as $it) {

                                            $valueWithoutTax = $it->rate * $it->quantity;
                                            $tax = 0;
                                            if (isset($it->tax) && $it->tax > 0)
                                                $tax += $valueWithoutTax * ($it->tax / 100);

                                            $Amount += str_replace(',', '', number_format($valueWithoutTax + $tax, 2));
//                                                
//                                            $Amount += number_format(floatval(str_replace(',','',($valueWithoutTax + $tax))), 2);
//                                            $Amount += $valueWithoutTax + $tax;
                                        }

                                        $showMarkPaid = false;
                                        if ($status == 0) {
                                            $statusString = "Unpaid";
                                            $showMarkPaid = true;
                                        } else if ($status == 1) {
                                            $statusString = "Paid";
                                        }

                                        if (($due_date < $todayDate) && $status == 0) {
                                            $addBgColor = 'redbgColor';
                                            $iconColor = "whiteicon";
                                        }
                                        ?>
                                <input type="hidden" class="hidden edit_Id" value="{{$invoice->id}}" />
                                <input type="hidden" class="hidden edit_customerDb_Id" value="{{$invoice->customer_id}}" />
                                <input type="hidden" class="hidden edit_add1" value="{{$invoice->address1}}" />
                                <input type="hidden" class="hidden edit_add2" value="{{$invoice->address2}}" />
                                <input type="hidden" class="hidden edit_fname" value="{{$invoice->first_name}}" />
                                <input type="hidden" class="hidden edit_lname" value="{{$invoice->last_name}}" />
                                <input type="hidden" class="hidden edit_state" value="{{$invoice->state_name}}" />
                                <input type="hidden" class="hidden edit_city" value="{{$invoice->city_name}}" />
                                <input type="hidden" class="hidden edit_zip" value="{{$invoice->zipcode}}" />
                                <input type="hidden" class="hidden edit_memo" value="{{$invoice->memo}}" />
                                <input type="hidden" class="hidden edit_invoice_date" value="{{date("m/d/Y",strtotime($invoice->invoice_date))}}" />
                                <input type="hidden" class="hidden edit_due_date" value="{{date("m/d/Y",strtotime($invoice->due_date))}}" />
                                <input type="hidden" class="hidden edit_terms" value="{{$invoice->terms}}">


                                <td class="edit_cName <?php echo $addBgColor; ?>">{{$invoice->name}}</td>
                                <td class="edit_fullName <?php echo $addBgColor; ?>">{{$invoice->first_name}} {{$invoice->last_name}}</td>
                                <td class="edit_Email <?php echo $addBgColor; ?>">{{$invoice->email}}</td>
                                <td class="edit_Amount <?php echo $addBgColor; ?>">{{$Amount}}</td>
                                <td class="edit_invoiceDate <?php echo $addBgColor; ?>">{{$invoice_date}}</td>
                                <td class="edit_dueDate <?php echo $addBgColor; ?>">{{$due_date}}</td>
                                <td class="edit_status <?php echo $addBgColor; ?>">{{$statusString}}

                                </td>

                                <?php $PreviewLink = "/previewInvoice?token=" . $invoice->GUID; ?>
                                <td style="display: flex;" class="<?php echo $addBgColor; ?>">
                                    <a title="Send Invoice to Customer" href="mailto:{{$invoice->email}}?subject=Talevation: Pay Invoice!&body={{$clickHere}}"><i class="fas fa-envelope-square"></i></a>
                                    <a title="Preview Invoice"  href="{{url($PreviewLink)}}" target="_blank"><i class="fas fa-eye"></i></a>
                                    <a title="Edit Invoice" style="color:#14abef;"  onclick="editInvoice(this,{{$invoice->invoice_items}});"><i class="fas fa-edit"></i></a>
                                    <?php if ($showMarkPaid) { ?>
                                        <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                        <a title="Mark Invoice Paid" style="color: green;" db-id="{{$invoice->id}}" onclick="markInvoicePaid(this);"><i class="fas fa-check"></i></a>        
                                        <?php } ?>
                                </td>
                                </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>                                        
                                    </tr>
                                </tfoot>
                            </table>
                        </div>




                    </div>
                </div>
            </div>
        </div><!-- End Row-->



    </div>    <!--End container-fluid-->
</div>   
@endsection


@section('scriptPageWiseSection')
<!-- simplebar js -->
<script src="{{asset('/plugins/simplebar/js/simplebar.js')}}"></script>
<!-- sidebar-menu js -->
<script src="{{asset('/js/sidebar-menu.js')}}"></script>

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
<script>
                                            function refreshModal(){
                                                $('#invoiceItemTable').addClass('NewItem');
                                            $("#customer").val('');
                                            $("#InvoiceDetails").addClass('hidden');
//                                            $("#InvoiceDetails").find('input').val('');
                                            $("#InvoiceDetails").find('input').each(function (e) {
                                            var id = $(this).attr('id');
                                            if (id != 'invoice-date' && id != 'due-date'){
                                            $(this).val('');
                                            }
                                            });
                                            $("#customer").removeClass("hidden");
                                            $(".saveInvoiceItems").addClass("hidden");
                                            $(".save_send").addClass("hidden");
                                            $(".saveInvoice").removeClass("hidden");
                                            $("#InvoiceItemsDetails").addClass("hidden");
                                            $("#contentToShow").text("Lookup  Customer by Email");
                                            $("#edit_customer").addClass("hidden");
                                            $("#saveCustomerBtn").addClass('hidden');
                                            $(".saveCreateInvoice").addClass('hidden');
                                            $(".saveInvoice").addClass('hidden');
//END To clear invoice Modal onclose event
//                                        });
                                            }
                                            $(document).ready(function () {

//                                        $(".modal").on("hidden.bs.modal", function() {
//START To clear invoice Modal onclose event

//Default data table
//$('#InvoiceDbList').DataTable();
//$('#staticTable').DataTable();
                                            var table = $('#InvoiceDbList').DataTable({
                                            lengthChange: false,
                                                    buttons: [{extend: 'copy',
                                                            exportOptions: {
                                                            columns: [0, 1, 2, 3, 4, 5, 6]
                                                            }}, {
                                                    extend: 'excel',
                                                            text: 'export to excel',
                                                            exportOptions: {
                                                            columns: [0, 1, 2, 3, 4, 5, 6]
                                                            }}, {
                                                    extend: 'csv',
                                                            text: 'export to csv',
                                                            exportOptions: {
                                                            columns: [0, 1, 2, 3, 4, 5, 6]
                                                            }}, {
                                                    extend: 'pdf',
                                                            text: 'export to pdf',
                                                            exportOptions: {
                                                            columns: [0, 1, 2, 3, 4, 5, 6]
                                                            }}, {
                                                    extend: 'print',
                                                            exportOptions: {
                                                            columns: [0, 1, 2, 3, 4, 5, 6]
                                                            }}],
                                                    aoColumnDefs: [
                                                    {
                                                    bSortable: false,
                                                            aTargets: [7]
                                                    }
                                                    ]
                                            });
                                            table.buttons().container()
                                                    .appendTo('#InvoiceDbList_wrapper .col-md-6:eq(0)');
                                            });
                                            $('#start_date').datepicker({
                                            todayHighlight: true,
                                            });
                                            $('#end_date').datepicker({
                                            todayHighlight: true,
                                            });



</script>

@endsection
