<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected  $table="invoices";
    
    public  function customer(){
         return $this->belongsTo('App\Customer');
    }
     public  function invoice_items(){
         return $this->hasMany('App\InvoiceItem');
    }
    public  function state_tax(){
         return $this->belongsTo('App\StateTax');
    }
}
