@extends('Masters.index')
@section('contentSection')
<?php $utility = new \App\Utility; ?>
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-table"></i> My Invoices

                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <!--                                        <form method="post" action="home">
                                                                        {{ csrf_field() }}
                            <?php
                            $date = date('Y-m-d'); //your given date
                            $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
                            $first_date = date("m/d/Y", $first_date_find);

                            $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
                            $last_date = date("m/d/Y", $last_date_find);
                            ?>
                                                                        <div class="row p-1">
                                                                            <div class="col-sm-12 col-lg-2 col-md-2">
                                                                                <label>Start Date</label>
                                                                                <input required type="text" name="start_date" placeholder="Start Date" value="{{$first_date}}" id="start_date" class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-12 col-lg-2 col-md-2">
                                                                                <label>End Date</label>
                                                                                <input required type="text" name="end_date" placeholder="End Date" value="{{$last_date}}" id="end_date" class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-12 col-lg-4 col-md-4">
                                                                                <label class=""></label>
                                                                                <button type="submit" class="btn mt-4">Apply Filter</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>-->
                            <!--role="grid" style="overflow-x: scroll; overflow-y: scroll; max-width: 90%; display: block; white-space: word-wrap: break-word;" cellspacing="0">-->

                            <table id="invoiceDbList"  class="table table-bordered" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Preview</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $statusString = ""; ?>
                                    @foreach($Invoices as $invoiceData)
                                    <tr>

                                        <?php
                                        $body_line = " %0D%0A ";
//                                      $invoiceDataLink = 'https://' . $_SERVER['HTTP_HOST'] . '/TalevationPayment/public' . "/payment?token=" . $invoiceData->GUID;
                                        $invoiceDataLink = $utility->projectBaseUrl() . '/public' . "/payment?token=" . $invoiceData->GUID;

                                        $due_date = date("m-d-Y", strtotime($invoiceData->due_date));
                                        $invoice_date = date("m-d-Y", strtotime($invoiceData->invoice_date));
//                                        $clickHere = "<a href='http://localhost:8080/TalevationPayment/public/payment?token=$invoiceData->GUID'> Click Here </a>";
                                        $clickHere = "Hello " . $invoiceData->first_name . " " . $invoiceData->last_name . $body_line . $body_line . "Please pay your pending invoice with Talevation." . $body_line . "You can pay it online with the link below." . $body_line . $invoiceDataLink . $body_line . " " . $body_line . "If you are not able to click the link above, please copy and paste it in your browser." . $body_line . " " . $body_line . "Thanks," . $body_line . "Talevation";

                                        $clickHere = nl2br($clickHere);
                                        $status = $invoiceData->status;
                                        $Amount = 0;

                                        for ($k = 0; $k < count($invoiceData->invoice_items); $k++) {
                                            $Amount += $invoiceData->invoice_items[$k]->rate * $invoiceData->invoice_items[$k]->quantity;
                                        }

                                        if ($status == 0) {
                                            $statusString = "Unpaid";
                                        } else if ($status == 1) {
                                            $statusString = "Paid";
                                        }
                                        ?>
                                        <td>{{$invoiceData->name}}</td>
                                        <td>{{$invoiceData->first_name}} {{$invoiceData->last_name}}</td>

                                        <td>{{$Amount}}</td>
                                        <td>{{$invoice_date}}</td>
                                        <td>{{$due_date}}</td>
                                        <td>{{$statusString}}</td>
                                        <?php $PreviewLink = "/previewInvoice?token=" . $invoiceData->GUID; ?>
                                        <td class=""><a class="" href="{{url($PreviewLink)}}" target="_blank"><i style="margin: 0 auto;display: table;font-size: 15px;"  class="fas fa-eye"></i></a></td>
                                        <td>
                                            <?php if ($status == 0) { ?>
                                                <?php
                                                // $link = 'https://' . $_SERVER['HTTP_HOST'] . '/TalevationPayment/public/previewInvoice?token=' . $invoiceData->GUID;
                                                $link = $utility->projectBaseUrl() . '/public/previewInvoice?token=' . $invoiceData->GUID;
                                                ?>
                                                <a href="{{$link}}" target="_blank"> <button class="btn btn-success m-1"><i class="fa fa-credit-card" aria-hidden="true"></i>Pay Now</button></a>
                                                <?php
                                            } else {
                                                echo '-';
                                            }
                                            ?>

                                        </td>

                                    </tr>

                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Name</th>

                                        <th>Amount</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Preview</th>
                                        <th></th>
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
$(document).ready(function () {
//Default data table
    $('#invoiceDbList').DataTable();
});
</script>
@endsection

@section('cssPageWiseSection')
<!--Data Tables -->
<link href="{{asset('/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
@endsection






