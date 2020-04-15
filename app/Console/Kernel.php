<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\DemoTable;
use DB;
use App\Invoice;
use App\InvoiceItem;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        // Commands\DemoCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // $schedule->call(function () {
        //     $demoTable = new DemoTable();
        //     $demoTable->name = 'mansi';
        //     $demoTable->role = 'php developer';
        //     $demoTable->save();
        // })->everyMinute();

        $schedule->call(function () {
            $invoiceDetails = "SELECT * FROM `invoices` 
            WHERE (invoice_date = date_sub(curdate(),INTERVAL 30 day) AND RecurringOption= 1)
            OR
            (invoice_date = date_sub(curdate(),INTERVAL 90 day) AND RecurringOption= 2)
            OR
            (invoice_date = date_sub(curdate(),INTERVAL 365 day) AND RecurringOption= 3)";
            $invoiceResults = DB::select(DB::raw($invoiceDetails));

            foreach ($invoiceResults as $invoiceResult) {
                $invoice = new Invoice();
                // $invoice->id = $invoiceResult->id;
                $invoice->customer_id = $invoiceResult->customer_id;
                $invoice->name = $invoiceResult->name;
                $invoice->first_name = $invoiceResult->first_name;
                $invoice->last_name = $invoiceResult->last_name;
                $invoice->email = $invoiceResult->email;
                $invoice->address1 = $invoiceResult->address1;
                $invoice->address2 = $invoiceResult->address2;
                $invoice->city_name = $invoiceResult->city_name;
                $invoice->state_name = $invoiceResult->state_name;
                $invoice->zipcode = $invoiceResult->zipcode;
                $terms = $invoiceResult->terms;
                if ($terms == "Net10")
                    $invoice->due_date = Date('Y-m-d', strtotime("+10 days"));
                if ($terms == "Net30")
                    $invoice->due_date = Date('Y-m-d', strtotime("+30 days"));
                if ($terms == "Net90")
                    $invoice->due_date = Date('Y-m-d', strtotime("+90 days"));
                if ($terms == "Due On Receipt") {
                    $invoice->due_date = "";
                }
                if ($terms == "Due On or Before") {
                    $invoice->due_date = $invoiceResult->due_date;
                }
                // $invoice->due_date = $invoiceResult->due_date;
                $invoice_created_date = date("Y-m-d", strtotime(date('Y-m-d')));
                $invoice->invoice_date = date("Y-m-d", strtotime(date('Y-m-d')));
                $invoice->terms = $invoiceResult->terms;
                $invoice->state_tax_id = $invoiceResult->state_tax_id;
                $invoice->RecurringOption = $invoiceResult->RecurringOption;
                $invoice->GUID = $invoiceResult->GUID;
                $invoice->memo = $invoiceResult->memo;
                $invoice->status = $invoiceResult->status;
                $invoice->customer_id = $invoiceResult->customer_id;
                $invoice->save();

                $invoiceItemDetails = "SELECT * FROM invoice_items where invoice_id = ".$invoiceResult->id."";
                $invoiceItemResults = DB::select(DB::raw($invoiceItemDetails));
                // var_dump($invoiceItemResults);
                foreach ($invoiceItemResults as $invoiceItemResult) {
                    $InvoiceItem = new InvoiceItem();
                    $InvoiceItem->invoice_id = $invoice->id;
                    $InvoiceItem->preset_line_item_id = $invoiceItemResult->preset_line_item_id;
                    $InvoiceItem->part_number = $invoiceItemResult->part_number;
                    $InvoiceItem->discription = $invoiceItemResult->discription;
                    $InvoiceItem->quantity = $invoiceItemResult->quantity;
                    $InvoiceItem->rate = $invoiceItemResult->rate;
                    $InvoiceItem->is_taxable= $invoiceItemResult->is_taxable;
                    $InvoiceItem->save();
                }
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
