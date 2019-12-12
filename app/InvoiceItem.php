<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table="invoice_items";
    public function invoice(){
        return $this->belongsTo('App\Invoice');
    }
    
    public function preset_line_item(){
        return $this->belongsTo('App\PresetLineItems');
    }
}
