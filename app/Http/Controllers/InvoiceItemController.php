<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvoiceItem;
use Redirect;
use DB;

class InvoiceItemController extends Controller {

    public function saveInvoiceItems(Request $request) {

        $invoice_Items = $request->invoiceItems;
        //return $invoice_Items[0]['rate'];
        //return $invoice_Items[0]['quantity'] . " " . $invoice_Items[0]['quantity'] . " " . $invoice_Items[0]['rate'];
//return $request->deletedInvoiceId;
        $ids = rtrim($request->deletedInvoiceId, ',');
        $ids = preg_split("/\,/", $ids);


        DB::table('invoice_items')->whereIn('id', $ids)->delete();



        for ($i = 0; $i < count($invoice_Items); $i++) {
            $InvoiceItem = new InvoiceItem();
            if (isset($invoice_Items[$i]['dbinvoice_itemid'])) {
                $InvoiceItem->exists = true;
                $InvoiceItem->id = $invoice_Items[$i]['dbinvoice_itemid'];
            }
            $InvoiceItem->invoice_id = $invoice_Items[$i]['invoice_id'];
            $InvoiceItem->preset_line_item_id = $invoice_Items[$i]['preset_line_item_id'];
            $InvoiceItem->part_number = $invoice_Items[$i]['part_number'];
            $InvoiceItem->discription = $invoice_Items[$i]['discription'];
            $InvoiceItem->quantity = (float) $invoice_Items[$i]['quantity'];
            $InvoiceItem->rate = (float) $invoice_Items[$i]['rate'];
            $InvoiceItem->is_taxable= $invoice_Items[$i]['is_taxable'];
            $InvoiceItem->save();
        }
        return 'success';
        //return redirect()->route('invoice');
    }

}
